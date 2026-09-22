<?php

namespace App\Http\Controllers;

use App\Models\TodoTask;
use Illuminate\Http\Request;

class TodoTaskController extends Controller
{
    public function index()
    {
        $tasks = TodoTask::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('settings.todo-list', compact('tasks'));
    }

    public function print(Request $request)
    {
        $module = $request->input('module', 'ocean-import');
        
        $tasks = TodoTask::where('module', $module)
                        ->where('is_active', true)
                        ->orderBy('order')
                        ->get();
        
        return view('settings.todo-list-print', compact('tasks', 'module'));
    }

    public function getTasks(Request $request)
    {
        $module = $request->input('module');
        
        $query = TodoTask::orderBy('order')->orderBy('created_at', 'desc');
        
        if ($module) {
            $query->where('module', $module);
        }
        
        $tasks = $query->get();
        return response()->json(['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'module' => 'required|string',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'config' => 'nullable|array',
                'order' => 'nullable|integer',
                'is_active' => 'nullable|boolean'
            ]);

            $task = TodoTask::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'id' => $task->id,
                'task' => $task
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
            $task = TodoTask::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'config' => 'nullable|array',
                'order' => 'nullable|integer',
                'is_active' => 'nullable|boolean'
            ]);

            $task->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully',
                'task' => $task
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
            $task = TodoTask::findOrFail($id);
            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
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
            $tasks = $request->input('tasks', []);
            $savedTasks = [];

            foreach ($tasks as $taskData) {
                if (isset($taskData['id']) && $taskData['id']) {
                    $task = TodoTask::find($taskData['id']);
                    if ($task) {
                        $task->update($taskData);
                        $savedTasks[] = $task;
                    }
                } else {
                    $task = TodoTask::create($taskData);
                    $savedTasks[] = $task;
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($savedTasks) . ' task(s) saved successfully',
                'tasks' => $savedTasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            TodoTask::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' task(s) deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }
}
