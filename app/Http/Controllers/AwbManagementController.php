<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AwbNumber;
use App\Models\TradePartner;
use Carbon\Carbon;

class AwbManagementController extends Controller
{
    public function index(Request $request)
    {
        // Get all carriers for the dropdown
        $carriers = TradePartner::whereNotNull('name')
            ->where(function($q) { 
                $q->where('type', 'carrier')
                  ->orWhere('type', 'AIR_CARRIER')
                  ->orWhere('type', 'AC')
                  ->orWhere('type', 'CR')
                  ->orWhereNull('type'); 
            })
            ->orderBy('name')
            ->get(['id', 'name', 'code', 'iata_code', 'cbsa_carrier_code']);
            
        return view('settings.awb-management.index', compact('carriers'));
    }

    public function getBlocks(Request $request)
    {
        $query = AwbNumber::with('carrier')->orderBy('id', 'desc');
        
        // Dynamic search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prefix', 'like', "%{$search}%")
                  ->orWhere('begin_no', 'like', "%{$search}%")
                  ->orWhere('end_no', 'like', "%{$search}%")
                  ->orWhere('remark', 'like', "%{$search}%")
                  ->orWhereHas('carrier', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Dynamic filters
        if ($request->has('filter_prefix') && $request->filter_prefix) {
            $query->where('prefix', 'like', "%{$request->filter_prefix}%");
        }
        if ($request->has('filter_begin_no') && $request->filter_begin_no) {
            $query->where('begin_no', 'like', "%{$request->filter_begin_no}%");
        }
        if ($request->has('filter_end_no') && $request->filter_end_no) {
            $query->where('end_no', 'like', "%{$request->filter_end_no}%");
        }
        if ($request->has('filter_carrier_id') && $request->filter_carrier_id) {
            $query->where('carrier_id', $request->filter_carrier_id);
        }

        $blocks = $query->get();
        return response()->json(['blocks' => $blocks]);
    }

    public function getAvailableByCarrier($carrierId)
    {
        $blocks = AwbNumber::with('carrier')
            ->where('carrier_id', $carrierId)
            ->where('available_count', '>', 0)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'blocks' => $blocks
        ]);
    }

    public function bulkSave(Request $request)
    {
        try {
            $blocks = $request->input('blocks', []);
            $savedBlocks = [];

            foreach ($blocks as $block) {
                $data = [
                    'created_date' => $block['created_date'] ?? now()->toDateString(),
                    'carrier_id' => $block['carrier_id'] ?? null,
                    'prefix' => $block['prefix'] ?? null,
                    'begin_no' => $block['begin_no'] ?? null,
                    'end_no' => $block['end_no'] ?? null,
                    'total_count' => $block['total_count'] ?? 0,
                    'available_count' => $block['available_count'] ?? 0,
                    'reserved_count' => $block['reserved_count'] ?? 0,
                    'assigned_count' => $block['assigned_count'] ?? 0,
                    'latest_assigned_no' => $block['latest_assigned_no'] ?? null,
                    'remark' => $block['remark'] ?? null,
                ];

                if (!empty($block['id'])) {
                    $awb = AwbNumber::find($block['id']);
                    if ($awb) {
                        $awb->update($data);
                        $savedBlocks[] = $awb->load('carrier');
                    }
                } else {
                    $awb = AwbNumber::create($data);
                    $savedBlocks[] = $awb->load('carrier');
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($savedBlocks) . ' AWB block(s) saved successfully',
                'blocks' => $savedBlocks
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
            $awb = AwbNumber::findOrFail($id);
            $awb->delete();
            return response()->json([
                'success' => true,
                'message' => 'AWB block deleted successfully'
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
            if (!empty($ids)) {
                AwbNumber::whereIn('id', $ids)->delete();
            }
            return response()->json([
                'success' => true,
                'message' => count($ids) . ' AWB block(s) deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }

    public function print(Request $request)
    {
        $query = AwbNumber::with('carrier')->orderBy('id', 'desc');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prefix', 'like', "%{$search}%")
                  ->orWhere('begin_no', 'like', "%{$search}%")
                  ->orWhere('end_no', 'like', "%{$search}%")
                  ->orWhere('remark', 'like', "%{$search}%")
                  ->orWhereHas('carrier', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('filter_prefix') && $request->filter_prefix) {
            $query->where('prefix', 'like', "%{$request->filter_prefix}%");
        }
        if ($request->has('filter_begin_no') && $request->filter_begin_no) {
            $query->where('begin_no', 'like', "%{$request->filter_begin_no}%");
        }
        if ($request->has('filter_end_no') && $request->filter_end_no) {
            $query->where('end_no', 'like', "%{$request->filter_end_no}%");
        }
        if ($request->has('filter_carrier_id') && $request->filter_carrier_id) {
            $query->where('carrier_id', $request->filter_carrier_id);
        }

        $blocks = $query->get();
        return view('settings.awb-management.print', compact('blocks'));
    }

    public function export(Request $request)
    {
        $query = AwbNumber::with('carrier')->orderBy('id', 'desc');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prefix', 'like', "%{$search}%")
                  ->orWhere('begin_no', 'like', "%{$search}%")
                  ->orWhere('end_no', 'like', "%{$search}%")
                  ->orWhere('remark', 'like', "%{$search}%")
                  ->orWhereHas('carrier', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('filter_prefix') && $request->filter_prefix) {
            $query->where('prefix', 'like', "%{$request->filter_prefix}%");
        }
        if ($request->has('filter_begin_no') && $request->filter_begin_no) {
            $query->where('begin_no', 'like', "%{$request->filter_begin_no}%");
        }
        if ($request->has('filter_end_no') && $request->filter_end_no) {
            $query->where('end_no', 'like', "%{$request->filter_end_no}%");
        }
        if ($request->has('filter_carrier_id') && $request->filter_carrier_id) {
            $query->where('carrier_id', $request->filter_carrier_id);
        }

        $blocks = $query->get();
        
        $csv = "Created Date,Carrier,Prefix,Begin No,End No,Total Count,Available,Reserved,Assigned,Latest Assigned No,Remark\n";
        
        foreach ($blocks as $block) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $block->created_date ?? '',
                $block->carrier->name ?? '',
                $block->prefix ?? '',
                $block->begin_no ?? '',
                $block->end_no ?? '',
                $block->total_count ?? 0,
                $block->available_count ?? 0,
                $block->reserved_count ?? 0,
                $block->assigned_count ?? 0,
                $block->latest_assigned_no ?? '',
                $block->remark ?? ''
            );
        }
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="awb-blocks.csv"');
    }
}
