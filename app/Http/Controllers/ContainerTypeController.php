<?php

namespace App\Http\Controllers;

use App\Models\ContainerType;
use Illuminate\Http\Request;

class ContainerTypeController extends Controller
{
    public function index()
    {
        $containerTypes = ContainerType::orderBy('code')->paginate(25);
        return view('settings.container-types', compact('containerTypes'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:20|unique:container_types,code',
                'name' => 'nullable|string|max:255',
                'description' => 'required|string|max:255',
                'ams_type_code' => 'nullable|string|max:50',
                'type' => 'nullable|string|max:50',
                'teu' => 'nullable|numeric|min:0|max:99.99',
                'is_active' => 'nullable|boolean'
            ]);

            $validated['name'] = $validated['name'] ?? $validated['code'];
            $validated['teu'] = $validated['teu'] ?? 1.00;
            $validated['is_active'] = $validated['is_active'] ?? true;

            $containerType = ContainerType::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Container type created successfully',
                'containerType' => $containerType
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors()))
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            if (($e->errorInfo[1] ?? 0) == 1062 || str_contains($e->getMessage(), '1062')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Container type code "' . ($request->input('code')) . '" already exists. Code must be unique.'
                ], 422);
            }
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while saving.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create container type: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $containerType = ContainerType::findOrFail($id);
            
            $validated = $request->validate([
                'code' => 'required|string|max:20|unique:container_types,code,' . $id,
                'name' => 'nullable|string|max:255',
                'description' => 'required|string|max:255',
                'ams_type_code' => 'nullable|string|max:50',
                'type' => 'nullable|string|max:50',
                'teu' => 'nullable|numeric|min:0|max:99.99',
                'is_active' => 'nullable|boolean'
            ]);

            $validated['name'] = $validated['name'] ?? $validated['code'];

            $containerType->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Container type updated successfully',
                'containerType' => $containerType
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors()))
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            if (($e->errorInfo[1] ?? 0) == 1062 || str_contains($e->getMessage(), '1062')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Container type code "' . ($request->input('code')) . '" already exists. Code must be unique.'
                ], 422);
            }
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while updating.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update container type: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $containerType = ContainerType::findOrFail($id);
            $containerType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Container type deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete container type: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkSave(Request $request)
    {
        try {
            $types = $request->input('types', []);
            $savedTypes = [];

            foreach ($types as $typeData) {
                $id = $typeData['id'] ?? null;
                $code = trim($typeData['code'] ?? '');
                $description = trim($typeData['description'] ?? '');

                if (empty($code) || empty($description)) {
                    continue; // Skip invalid entries
                }

                // Pre-check duplicate code in database
                if ($id && is_numeric($id) && intval($id) > 0) {
                    $exists = ContainerType::where('code', $code)->where('id', '!=', $id)->exists();
                } else {
                    $exists = ContainerType::where('code', $code)->exists();
                }

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Container type code "' . $code . '" already exists in database. Code must be unique.'
                    ], 422);
                }

                $payload = [
                    'code' => $code,
                    'name' => !empty($typeData['name']) ? trim($typeData['name']) : $code,
                    'description' => $description,
                    'ams_type_code' => !empty($typeData['ams_type_code']) ? trim($typeData['ams_type_code']) : null,
                    'type' => !empty($typeData['type']) ? trim($typeData['type']) : null,
                    'teu' => isset($typeData['teu']) ? floatval($typeData['teu']) : 1.00,
                    'is_active' => filter_var($typeData['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
                ];

                if ($id && is_numeric($id) && intval($id) > 0) {
                    $type = ContainerType::find($id);
                    if ($type) {
                        $type->update($payload);
                        $savedTypes[] = $type;
                    }
                } else {
                    $type = ContainerType::create($payload);
                    $savedTypes[] = $type;
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($savedTypes) . ' container type(s) saved successfully',
                'types' => $savedTypes
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if (($e->errorInfo[1] ?? 0) == 1062 || str_contains($e->getMessage(), '1062')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Duplicate container type code detected. Each code must be unique.'
                ], 422);
            }
            return response()->json([
                'success' => false,
                'message' => 'Database query error occurred.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save container types: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportCsv(Request $request)
    {
        $query = ContainerType::orderBy('code');
        
        // Apply filters if provided
        if ($request->has('filter_code')) {
            $query->where('code', 'like', '%' . $request->filter_code . '%');
        }
        if ($request->has('filter_description')) {
            $query->where('description', 'like', '%' . $request->filter_description . '%');
        }
        if ($request->has('filter_type')) {
            $query->where('type', 'like', '%' . $request->filter_type . '%');
        }
        
        $types = $query->get();
        
        $filename = 'container-types-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($types) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Code', 'Description', 'AMS Type Code', 'Type', 'TEU', 'Active']);
            
            foreach ($types as $type) {
                fputcsv($file, [
                    $type->code,
                    $type->description,
                    $type->ams_type_code ?? '',
                    $type->type ?? '',
                    $type->teu,
                    $type->is_active ? 'Yes' : 'No'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
