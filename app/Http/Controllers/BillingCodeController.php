<?php

namespace App\Http\Controllers;

use App\Models\BillingCode;
use App\Models\IATAChargeItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingCodeController extends Controller
{
    public function index()
    {
        $codes = BillingCode::orderBy('code')->get();
        $iataItems = IATAChargeItem::orderBy('code')->get();
        $freightCodes = BillingCode::where('is_active', true)->orderBy('code')->get();
        
        return view('accounting.billing-code-list', [
            'codes' => $codes,
            'iataItems' => $iataItems,
            'freightCodes' => $freightCodes
        ]);
    }

    public function print(Request $request)
    {
        $query = BillingCode::orderBy('code');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name_eng', 'like', "%{$search}%")
                  ->orWhere('name_local', 'like', "%{$search}%");
            });
        }
        
        $codes = $query->get();
        
        return view('accounting.billing-code-list-print', compact('codes'));
    }

    public function getCodes()
    {
        $codes = BillingCode::orderBy('code')->get();
        return response()->json(['codes' => $codes]);
    }

    public function bulkSave(Request $request)
    {
        try {
            $codes = $request->input('codes', []);
            $savedCodes = [];

            foreach ($codes as $codeData) {
                if (isset($codeData['id']) && $codeData['id']) {
                    $code = BillingCode::find($codeData['id']);
                    if ($code) {
                        $code->update($codeData);
                        $savedCodes[] = $code;
                    }
                } else {
                    $code = BillingCode::create($codeData);
                    $savedCodes[] = $code;
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($savedCodes) . ' billing code(s) saved successfully',
                'codes' => $savedCodes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->isCodeInUse([$id])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete: Billing code is linked to active invoices, charges, or settings. Please mark as inactive instead.'
                ], 422);
            }

            $code = BillingCode::findOrFail($id);
            $code->delete();

            return response()->json([
                'success' => true,
                'message' => 'Billing code deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if ($this->isCodeInUse($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete: One or more selected billing codes are linked to active invoices, charges, or settings. Please mark them as inactive instead.'
                ], 422);
            }

            BillingCode::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' billing code(s) deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }

    private function isCodeInUse(array $ids): bool
    {
        if (empty($ids)) return false;

        // Tables and columns to check for relations
        $checks = [
            ['table' => 'invoice_lines', 'column' => 'charge_code_id'],
            ['table' => 'charges', 'column' => 'charge_code_id'],
            ['table' => 'ocean_import_charges', 'column' => 'charge_code_id'],
            ['table' => 'iata_charge_items', 'column' => 'freight_code_id'],
            ['table' => 'trade_partner_default_freights', 'column' => 'freight_code_id'],
            ['table' => 'freight_default_values', 'column' => 'freight_code_id'],
        ];

        foreach ($checks as $check) {
            if (\Illuminate\Support\Facades\Schema::hasTable($check['table'])) {
                if (\Illuminate\Support\Facades\Schema::hasColumn($check['table'], $check['column'])) {
                    $exists = DB::table($check['table'])->whereIn($check['column'], $ids)->exists();
                    if ($exists) {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }

    public function export()
    {
        $codes = BillingCode::orderBy('code')->get();
        
        $csv = "Billing Code,Name (Eng),Name (Local),Revenue,Cost,Credit,Debit,Department,A/R,A/P,D/C,B&A,Payroll,OHW,OIM,AIM,AIE,OEM,OEW,Aerial,Alog,TK,Misc,WH,Active\n";
        
        foreach ($codes as $code) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $code->code ?? '',
                $code->name_eng ?? '',
                $code->name_local ?? '',
                $code->revenue ?? '',
                $code->cost ?? '',
                $code->credit ?? '',
                $code->debit ?? '',
                $code->department ?? '',
                $code->ar ? 'Yes' : 'No',
                $code->ap ? 'Yes' : 'No',
                $code->dc ? 'Yes' : 'No',
                $code->ba ? 'Yes' : 'No',
                $code->payroll ? 'Yes' : 'No',
                $code->ohw ? 'Yes' : 'No',
                $code->oim ? 'Yes' : 'No',
                $code->aim ? 'Yes' : 'No',
                $code->aie ? 'Yes' : 'No',
                $code->oem ? 'Yes' : 'No',
                $code->oew ? 'Yes' : 'No',
                $code->aerial ? 'Yes' : 'No',
                $code->alog ? 'Yes' : 'No',
                $code->tk ? 'Yes' : 'No',
                $code->misc ? 'Yes' : 'No',
                $code->wh ? 'Yes' : 'No',
                $code->is_active ? 'Yes' : 'No'
            );
        }
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="billing-codes.csv"');
    }

    public function getMappingData()
    {
        $iataItems = IATAChargeItem::with('freightCode')->orderBy('code')->get();
        $freightCodes = BillingCode::where('is_active', true)->orderBy('code')->get();
        
        return response()->json([
            'iata_items' => $iataItems,
            'freight_codes' => $freightCodes
        ]);
    }

    public function saveMappings(Request $request)
    {
        try {
            $mappings = $request->input('mappings', []);
            
            DB::beginTransaction();
            
            foreach ($mappings as $mapping) {
                IATAChargeItem::where('code', $mapping['iata_code'])
                    ->update(['freight_code_id' => $mapping['freight_code_id']]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => count($mappings) . ' mapping(s) saved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save mappings: ' . $e->getMessage()
            ], 500);
        }
    }
}
