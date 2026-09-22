<?php

namespace App\Http\Controllers;

use App\Models\GLCode;
use Illuminate\Http\Request;

class GLCodeController extends Controller
{
    public function index()
    {
        $codes = GLCode::orderBy('gl_code')->get();
        return view('accounting.gl-code-list', compact('codes'));
    }

    public function print(Request $request)
    {
        $query = GLCode::orderBy('gl_code');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('gl_code', 'like', "%{$search}%")
                  ->orWhere('gl_name_eng', 'like', "%{$search}%")
                  ->orWhere('gl_name_local', 'like', "%{$search}%")
                  ->orWhere('sub', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('filter_gl_name_eng')) {
            $query->where('gl_name_eng', 'like', "%{$request->filter_gl_name_eng}%");
        }
        
        if ($request->has('filter_name_type')) {
            $query->where('name_type', $request->filter_name_type);
        }
        
        $codes = $query->get();
        return view('accounting.gl-code-list-print', compact('codes'));
    }

    public function getCodes()
    {
        $codes = GLCode::orderBy('gl_code')->get();
        return response()->json(['codes' => $codes]);
    }

    public function bulkSave(Request $request)
    {
        try {
            $codes = $request->input('codes', []);
            $savedCodes = [];

            foreach ($codes as $codeData) {
                if (isset($codeData['id']) && $codeData['id']) {
                    $code = GLCode::find($codeData['id']);
                    if ($code) {
                        $code->update($codeData);
                        $savedCodes[] = $code;
                    }
                } else {
                    $code = GLCode::create($codeData);
                    $savedCodes[] = $code;
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($savedCodes) . ' G/L code(s) saved successfully',
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
                    'message' => 'Cannot delete: G/L code is linked to active ledger entries, banks, or system controls. Please mark as inactive instead.'
                ], 422);
            }

            $code = GLCode::findOrFail($id);
            $code->delete();

            return response()->json([
                'success' => true,
                'message' => 'G/L code deleted successfully'
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
                    'message' => 'Cannot delete: One or more selected G/L codes are linked to active ledger entries, banks, or system controls. Please mark them as inactive instead.'
                ], 422);
            }

            GLCode::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' G/L code(s) deleted successfully'
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

        $codes = GLCode::whereIn('id', $ids)->pluck('gl_code')->toArray();

        // Tables and columns to check for relations (by ID)
        $idChecks = [
            ['table' => 'journal_entries', 'column' => 'gl_account_id'],
            ['table' => 'gl_accounts', 'column' => 'gl_code_id'],
            ['table' => 'gl_accounts', 'column' => 'parent_id'],
        ];

        foreach ($idChecks as $check) {
            if (\Illuminate\Support\Facades\Schema::hasTable($check['table'])) {
                if (\Illuminate\Support\Facades\Schema::hasColumn($check['table'], $check['column'])) {
                    if (\Illuminate\Support\Facades\DB::table($check['table'])->whereIn($check['column'], $ids)->exists()) {
                        return true;
                    }
                }
            }
        }

        // Tables and columns to check for string values (by gl_code)
        if (!empty($codes)) {
            $codeChecks = [
                ['table' => 'banks', 'column' => 'gl_no'],
            ];

            foreach ($codeChecks as $check) {
                if (\Illuminate\Support\Facades\Schema::hasTable($check['table'])) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn($check['table'], $check['column'])) {
                        if (\Illuminate\Support\Facades\DB::table($check['table'])->whereIn($check['column'], $codes)->exists()) {
                            return true;
                        }
                    }
                }
            }
        }
        
        return false;
    }

    public function export(Request $request)
    {
        $query = GLCode::orderBy('gl_code');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('gl_code', 'like', "%{$search}%")
                  ->orWhere('gl_name_eng', 'like', "%{$search}%")
                  ->orWhere('gl_name_local', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('filter_gl_name_eng')) {
            $query->where('gl_name_eng', 'like', "%{$request->filter_gl_name_eng}%");
        }
        
        if ($request->has('filter_name_type')) {
            $query->where('name_type', $request->filter_name_type);
        }
        
        $codes = $query->get();
        
        $csv = "G/L Code,Name (Eng),Name (Local),Name Type,Sub,AIRE_AP_CODE,Detail,Deposit,Forgotten,Transaction,Active\n";
        
        foreach ($codes as $code) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $code->gl_code ?? '',
                $code->gl_name_eng ?? '',
                $code->gl_name_local ?? '',
                $code->name_type ?? '',
                $code->sub ?? '',
                $code->aire_ap_code ? 'Yes' : 'No',
                $code->detail ? 'Yes' : 'No',
                $code->deposit ? 'Yes' : 'No',
                $code->forgotten ? 'Yes' : 'No',
                $code->transaction ? 'Yes' : 'No',
                $code->is_active ? 'Yes' : 'No'
            );
        }
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="gl-codes.csv"');
    }
}
