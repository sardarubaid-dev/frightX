<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BankService
{
    /**
     * Get next check number for a bank based on office and currency
     */
    public function getNextCheckNumber($bankId, $officeId = null, $currency = 'CAD')
    {
        $bank = DB::table('banks')->where('id', $bankId)->first();
        
        if (!$bank || !$bank->check_sequences) {
            return null;
        }

        $sequences = json_decode($bank->check_sequences, true);
        
        if (empty($sequences)) {
            return null;
        }

        // Find matching sequence (office + currency, or default)
        $matchedSeq = null;
        $defaultSeq = null;

        foreach ($sequences as $seq) {
            // Check for exact match (office + prefix)
            if ($seq['office'] == $officeId && $seq['prefix'] == $currency) {
                $matchedSeq = $seq;
                break;
            }
            // Store default (empty office) as fallback
            if (empty($seq['office']) && $seq['prefix'] == $currency) {
                $defaultSeq = $seq;
            }
        }

        $sequence = $matchedSeq ?? $defaultSeq;

        if (!$sequence) {
            return null;
        }

        // Get last used check number from database
        $lastCheck = DB::table('checks')
            ->where('bank_id', $bankId)
            ->where('office_id', $officeId)
            ->where('currency', $currency)
            ->orderBy('check_number', 'desc')
            ->first();

        if ($lastCheck) {
            // Extract numeric part from check number (e.g., "CAD-1001" -> 1001)
            $lastNumber = (int) preg_replace('/[^0-9]/', '', $lastCheck->check_number);
            $nextNumber = $lastNumber + 1;
        } else {
            // Start from configured start number
            $nextNumber = (int) $sequence['start_no'];
        }

        // Check if we've exceeded the end number
        if ($nextNumber > (int) $sequence['end_no']) {
            return null; // Sequence exhausted
        }

        // Format: PREFIX-NUMBER (e.g., "CAD-1001")
        $checkNumber = $sequence['prefix'] . '-' . $nextNumber;

        return [
            'check_number' => $checkNumber,
            'sequence' => $sequence,
            'next_number' => $nextNumber
        ];
    }

    /**
     * Get bank display information for invoices
     */
    public function getBankDisplayInfo($bankId)
    {
        $bank = DB::table('banks')->where('id', $bankId)->first();
        
        if (!$bank) {
            return null;
        }

        return $bank->display_information ?? null;
    }

    /**
     * Get default invoice bank
     */
    public function getDefaultInvoiceBank()
    {
        $bank = DB::table('banks')
            ->where('is_default_invoice_bank', true)
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        if ($bank && $bank->invoice_settings) {
            $bank->invoice_settings = json_decode($bank->invoice_settings, true);
        }

        return $bank;
    }

    /**
     * Get default revenue bank (for A/R)
     */
    public function getDefaultRevenueBank()
    {
        return DB::table('banks')
            ->where('revenue_default', true)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get default cost bank (for A/P)
     */
    public function getDefaultCostBank()
    {
        return DB::table('banks')
            ->where('cost_default', true)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Import and clear checks from Excel based on bank config
     */
    public function importCheckClearing($bankId, $filePath)
    {
        $bank = DB::table('banks')->where('id', $bankId)->first();
        
        if (!$bank || !$bank->clear_check_config) {
            return [
                'success' => false,
                'message' => 'Bank check clearing configuration not found'
            ];
        }

        $config = json_decode($bank->clear_check_config, true);
        
        // Load Excel file
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            $startRow = (int) $config['startRow'];
            $dateCol = $config['dateColumn'];
            $checkNoCol = $config['checkNoColumn'];
            $amountCol = $config['amountColumn'];
            $conditionCol = $config['conditionColumn'] ?? null;
            $condition = $config['condition'] ?? null;
            $exclude = $config['exclude'] ?? null;
            
            $clearedCount = 0;
            $skippedCount = 0;
            $row = $startRow;
            
            while (true) {
                $checkNo = $worksheet->getCell($checkNoCol . $row)->getValue();
                
                // Stop if no more data
                if (empty($checkNo)) {
                    break;
                }
                
                // Check condition if specified
                if ($conditionCol && $condition) {
                    $conditionValue = $worksheet->getCell($conditionCol . $row)->getValue();
                    if ($conditionValue != $condition) {
                        $row++;
                        $skippedCount++;
                        continue;
                    }
                }
                
                // Check exclude pattern
                if ($exclude && strpos($checkNo, $exclude) !== false) {
                    $row++;
                    $skippedCount++;
                    continue;
                }
                
                // Get date and amount
                $clearDate = $worksheet->getCell($dateCol . $row)->getValue();
                $amount = $worksheet->getCell($amountCol . $row)->getValue();
                
                // Mark check as cleared in database
                $updated = DB::table('checks')
                    ->where('bank_id', $bankId)
                    ->where('check_number', $checkNo)
                    ->update([
                        'is_cleared' => true,
                        'cleared_date' => $clearDate,
                        'cleared_amount' => $amount,
                        'updated_at' => now()
                    ]);
                
                if ($updated) {
                    $clearedCount++;
                }
                
                $row++;
            }
            
            return [
                'success' => true,
                'message' => "Cleared {$clearedCount} check(s), skipped {$skippedCount}",
                'cleared' => $clearedCount,
                'skipped' => $skippedCount
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to import Excel: ' . $e->getMessage()
            ];
        }
    }
}
