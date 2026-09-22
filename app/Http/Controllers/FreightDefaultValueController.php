<?php

namespace App\Http\Controllers;

use App\Models\FreightDefaultValue;
use Illuminate\Http\Request;

class FreightDefaultValueController extends Controller
{
    public function index()
    {
        return view('settings.freight-default-values');
    }

    public function getByModule(Request $request)
    {
        $officeType = $request->input('office_type', 'Office');
        $module = $request->input('module');
        
        $values = FreightDefaultValue::where('office_type', $officeType)
            ->where('module', $module)
            ->orderBy('section')
            ->orderBy('order')
            ->get()
            ->groupBy('section');
        
        return response()->json([
            'success' => true,
            'data' => $values
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'office_type' => 'required|string',
                'module' => 'required|string',
                'section' => 'required|string',
                'ship_mode' => 'nullable|string',
                'freight_code' => 'nullable|string',
                'pc' => 'nullable|string',
                'type' => 'nullable|string',
                'unit' => 'nullable|string',
                'currency' => 'nullable|string',
                'volume' => 'nullable|numeric',
                'rate' => 'nullable|numeric',
                'amount' => 'nullable|numeric',
                'agent_amount' => 'nullable|numeric',
                'order' => 'nullable|integer'
            ]);

            $value = FreightDefaultValue::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Freight default value created successfully',
                'data' => $value
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $value = FreightDefaultValue::findOrFail($id);
            
            $validated = $request->validate([
                'ship_mode' => 'nullable|string',
                'freight_code' => 'nullable|string',
                'pc' => 'nullable|string',
                'type' => 'nullable|string',
                'unit' => 'nullable|string',
                'currency' => 'nullable|string',
                'volume' => 'nullable|numeric',
                'rate' => 'nullable|numeric',
                'amount' => 'nullable|numeric',
                'agent_amount' => 'nullable|numeric'
            ]);

            $value->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Freight default value updated successfully',
                'data' => $value
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $value = FreightDefaultValue::findOrFail($id);
            $value->delete();

            return response()->json([
                'success' => true,
                'message' => 'Freight default value deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkSave(Request $request)
    {
        try {
            $items = $request->input('items', []);
            $saved = [];

            foreach ($items as $item) {
                if (isset($item['id']) && $item['id']) {
                    $value = FreightDefaultValue::find($item['id']);
                    if ($value) {
                        $value->update($item);
                        $saved[] = $value;
                    }
                } else {
                    $value = FreightDefaultValue::create($item);
                    $saved[] = $value;
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($saved) . ' item(s) saved successfully',
                'data' => $saved
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save: ' . $e->getMessage()
            ], 500);
        }
    }
}
