<?php

namespace App\Http\Controllers;

use App\Models\HblTemplate;
use Illuminate\Http\Request;

class HblTemplateController extends Controller
{
    public function index()
    {
        return view('settings.hbl-templates');
    }

    public function getTemplates()
    {
        $templates = HblTemplate::orderBy('name')->get();
        return response()->json(['templates' => $templates]);
    }

    public function bulkSave(Request $request)
    {
        try {
            $templates = $request->input('templates', []);
            $savedTemplates = [];

            foreach ($templates as $tplData) {
                if (isset($tplData['id']) && $tplData['id']) {
                    $template = HblTemplate::find($tplData['id']);
                    if ($template) {
                        $template->update($tplData);
                        $savedTemplates[] = $template;
                    }
                } else {
                    $template = HblTemplate::create($tplData);
                    $savedTemplates[] = $template;
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($savedTemplates) . ' HBL template(s) saved successfully',
                'templates' => $savedTemplates
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
            $template = HblTemplate::findOrFail($id);
            
            // Check if template is in use
            if ($template->hbls()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete: This template is currently linked to active export HBL records.'
                ], 422);
            }

            $template->delete();

            return response()->json([
                'success' => true,
                'message' => 'Template deleted successfully'
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
            
            // Check usage
            $inUseCount = HblTemplate::whereIn('id', $ids)
                ->whereHas('hbls')
                ->count();

            if ($inUseCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete: One or more selected templates are currently linked to active export HBL records.'
                ], 422);
            }

            HblTemplate::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected templates deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to bulk delete templates: ' . $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $query = HblTemplate::orderBy('name');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }
        
        $templates = $query->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="hbl-templates-' . date('Y-m-d') . '.csv"',
            'Cache-Control' => 'no-cache, must-revalidate',
            'Expires' => '0',
        ];
        
        $callback = function() use ($templates) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Title', 'Is Active', 'Created At']);
            
            foreach ($templates as $t) {
                fputcsv($file, [
                    $t->id,
                    $t->name,
                    $t->title,
                    $t->is_active ? 'Yes' : 'No',
                    $t->created_at ? $t->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function print(Request $request)
    {
        $query = HblTemplate::orderBy('name');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }
        
        $templates = $query->get();
        
        return view('settings.hbl-templates-print', compact('templates'));
    }
}
