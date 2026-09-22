<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OceanImport;
use App\Models\OceanExport;
use App\Models\AirImport;
use App\Models\AirExport;
use App\Models\TruckShipment;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\TradePartner;
use App\Models\WarehouseReceipt;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));
        $module = trim($request->get('module', 'All'));

        if (strlen($query) < 1) {
            return response()->json(['records' => []]);
        }

        $records = [];
        $limit = 5;

        // 1. Ocean Import
        if ($module === 'All' || $module === 'Ocean Import') {
            try {
                $oiResults = OceanImport::with('customer')
                    ->where(function($q) use ($query) {
                        $q->where('file_no', 'like', "%{$query}%")
                          ->orWhere('mbl_no', 'like', "%{$query}%")
                          ->orWhere('hbl_no', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->get();
                foreach ($oiResults as $item) {
                    $records[] = [
                        'category' => 'Ocean Import',
                        'icon' => 'fa-ship',
                        'badge_color' => '#2563eb',
                        'title' => $item->file_no,
                        'subtitle' => 'MBL: ' . ($item->mbl_no ?: 'N/A') . ' | HBL: ' . ($item->hbl_no ?: 'N/A') . ($item->customer ? ' | ' . $item->customer->name : ''),
                        'url' => url('/ocean-import/' . $item->id . '/edit'),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 2. Ocean Export
        if ($module === 'All' || $module === 'Ocean Export') {
            try {
                $oeResults = OceanExport::with('customer')
                    ->where(function($q) use ($query) {
                        $q->where('file_no', 'like', "%{$query}%")
                          ->orWhere('mbl_no', 'like', "%{$query}%")
                          ->orWhere('hbl_no', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->get();
                foreach ($oeResults as $item) {
                    $records[] = [
                        'category' => 'Ocean Export',
                        'icon' => 'fa-ship',
                        'badge_color' => '#059669',
                        'title' => $item->file_no,
                        'subtitle' => 'MBL: ' . ($item->mbl_no ?: 'N/A') . ' | HBL: ' . ($item->hbl_no ?: 'N/A') . ($item->customer ? ' | ' . $item->customer->name : ''),
                        'url' => url('/ocean-export/' . $item->id . '/edit'),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 3. Air Import
        if ($module === 'All' || $module === 'Air Import') {
            try {
                $aiResults = AirImport::with('customer')
                    ->where(function($q) use ($query) {
                        $q->where('file_no', 'like', "%{$query}%")
                          ->orWhere('mawb_no', 'like', "%{$query}%")
                          ->orWhere('hawb_no', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->get();
                foreach ($aiResults as $item) {
                    $records[] = [
                        'category' => 'Air Import',
                        'icon' => 'fa-plane',
                        'badge_color' => '#7c3aed',
                        'title' => $item->file_no,
                        'subtitle' => 'MAWB: ' . ($item->mawb_no ?: 'N/A') . ' | HAWB: ' . ($item->hawb_no ?: 'N/A') . ($item->customer ? ' | ' . $item->customer->name : ''),
                        'url' => url('/air-import/' . $item->id . '/edit'),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 4. Air Export
        if ($module === 'All' || $module === 'Air Export') {
            try {
                $aeResults = AirExport::with('customer')
                    ->where(function($q) use ($query) {
                        $q->where('file_no', 'like', "%{$query}%")
                          ->orWhere('mawb_no', 'like', "%{$query}%")
                          ->orWhere('hawb_no', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->get();
                foreach ($aeResults as $item) {
                    $records[] = [
                        'category' => 'Air Export',
                        'icon' => 'fa-plane',
                        'badge_color' => '#d97706',
                        'title' => $item->file_no,
                        'subtitle' => 'MAWB: ' . ($item->mawb_no ?: 'N/A') . ' | HAWB: ' . ($item->hawb_no ?: 'N/A') . ($item->customer ? ' | ' . $item->customer->name : ''),
                        'url' => url('/air-export/' . $item->id . '/edit'),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 5. Truck Shipment
        if ($module === 'All' || $module === 'Trucking') {
            try {
                $truckResults = TruckShipment::with('customer')
                    ->where(function($q) use ($query) {
                        $q->where('file_no', 'like', "%{$query}%")
                          ->orWhere('mbl_no', 'like', "%{$query}%")
                          ->orWhere('hbl_no', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->get();
                foreach ($truckResults as $item) {
                    $records[] = [
                        'category' => 'Trucking',
                        'icon' => 'fa-truck',
                        'badge_color' => '#dc2626',
                        'title' => $item->file_no,
                        'subtitle' => 'MBL: ' . ($item->mbl_no ?: 'N/A') . ' | HBL: ' . ($item->hbl_no ?: 'N/A') . ($item->customer ? ' | ' . $item->customer->name : ''),
                        'url' => url('/truck/' . $item->id . '/edit'),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 6. Invoices
        if ($module === 'All' || $module === 'Accounting') {
            try {
                $invResults = Invoice::where(function($q) use ($query) {
                        $q->where('invoice_no', 'like', "%{$query}%")
                          ->orWhere('file_no', 'like', "%{$query}%")
                          ->orWhere('bill_to_name', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->get();
                foreach ($invResults as $item) {
                    $records[] = [
                        'category' => 'Invoice',
                        'icon' => 'fa-file-text-o',
                        'badge_color' => '#0284c7',
                        'title' => $item->invoice_no ?: ('Invoice #' . $item->id),
                        'subtitle' => 'File: ' . ($item->file_no ?: 'N/A') . ' | Bill To: ' . ($item->bill_to_name ?: 'N/A') . ' | Amount: $' . number_format($item->total_amount ?? 0, 2),
                        'url' => url('/accounting/invoice/' . $item->id),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 7. Quotations
        if ($module === 'All' || $module === 'Sales') {
            try {
                $quoteResults = Quotation::with('customer')
                    ->where('quote_no', 'like', "%{$query}%")
                    ->limit($limit)
                    ->get();
                foreach ($quoteResults as $item) {
                    $records[] = [
                        'category' => 'Quotation',
                        'icon' => 'fa-file-text',
                        'badge_color' => '#4f46e5',
                        'title' => $item->quote_no,
                        'subtitle' => 'Customer: ' . ($item->customer ? $item->customer->name : 'N/A') . ' | Module: ' . ($item->module ?: 'N/A'),
                        'url' => url('/sales/quotation/' . $item->id . '/edit'),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 8. Trade Partners
        if ($module === 'All' || $module === 'Trade Partners') {
            try {
                $tpResults = TradePartner::where(function($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                          ->orWhere('code', 'like', "%{$query}%")
                          ->orWhere('email', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->get();
                foreach ($tpResults as $item) {
                    $records[] = [
                        'category' => 'Trade Partner',
                        'icon' => 'fa-building',
                        'badge_color' => '#0891b2',
                        'title' => $item->name,
                        'subtitle' => 'Code: ' . ($item->code ?: 'N/A') . ' | Type: ' . ($item->type ?: 'N/A'),
                        'url' => url('/trade-partner/' . $item->id . '/edit'),
                    ];
                }
            } catch (\Exception $e) {}
        }

        // 9. Warehouse Receipts
        if ($module === 'All' || $module === 'Warehouse') {
            try {
                $wrResults = WarehouseReceipt::with('customer')
                    ->where('receipt_no', 'like', "%{$query}%")
                    ->limit($limit)
                    ->get();
                foreach ($wrResults as $item) {
                    $records[] = [
                        'category' => 'Warehouse Receipt',
                        'icon' => 'fa-cubes',
                        'badge_color' => '#ca8a04',
                        'title' => $item->receipt_no ?: ('WR #' . $item->id),
                        'subtitle' => 'Customer: ' . ($item->customer ? $item->customer->name : 'N/A') . ' | Status: ' . ($item->status ?: 'N/A'),
                        'url' => url('/warehouse/receipts/' . $item->id),
                    ];
                }
            } catch (\Exception $e) {}
        }

        return response()->json([
            'records' => array_slice($records, 0, 15),
        ]);
    }
}
