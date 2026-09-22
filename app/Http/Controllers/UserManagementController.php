<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public static function generateUserId()
    {
        $maxNum = 0;
        $users = User::whereNotNull('user_id')->get();
        foreach ($users as $u) {
            if (preg_match('/USR-(\d+)/i', $u->user_id, $matches)) {
                $num = intval($matches[1]);
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }
        
        $nextNum = max($maxNum + 1, User::count() + 1);
        return 'USR-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        // Backfill missing user_ids for existing users
        $usersWithoutId = User::whereNull('user_id')->orWhere('user_id', '')->orderBy('id', 'asc')->get();
        foreach ($usersWithoutId as $u) {
            $u->user_id = self::generateUserId();
            $u->save();
        }

        $users = User::orderBy('created_at', 'desc')->get();
        return view('settings.user-management', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $userId = !empty($request->user_id) ? trim($request->user_id) : self::generateUserId();
            
            $validated = $request->validate([
                'user_id' => 'nullable|string|max:50|unique:users,user_id',
                'first_name' => 'required|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable|string|min:6',
                'office_code' => 'nullable|string|max:50',
                'office_name' => 'nullable|string|max:150',
                'department_code' => 'nullable|string|max:50',
                'department_name' => 'nullable|string|max:150',
                'branch' => 'nullable|string|max:100',
                'role' => 'nullable|string|max:100',
                'status' => 'nullable|in:Enable,Disable',
            ]);

            $validated['user_id'] = $userId;
            $validated['last_name'] = $validated['last_name'] ?? '';
            $validated['name'] = trim($validated['first_name'] . ' ' . $validated['last_name']);
            
            $rawPassword = !empty($validated['password']) ? $validated['password'] : 'Password123!';
            $validated['password'] = Hash::make($rawPassword);
            $validated['role'] = $validated['role'] ?? 'Operation';
            $validated['status'] = $validated['status'] ?? 'Enable';
            $validated['create_date'] = now();

            $user = User::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'user_id' => 'nullable|string|max:50|unique:users,user_id,' . $id,
                'first_name' => 'required|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'email' => 'required|email|unique:users,email,' . $id,
                'office_code' => 'nullable|string|max:50',
                'office_name' => 'nullable|string|max:150',
                'department_code' => 'nullable|string|max:50',
                'department_name' => 'nullable|string|max:150',
                'branch' => 'nullable|string|max:100',
                'role' => 'nullable|string|max:100',
                'status' => 'nullable|in:Enable,Disable',
            ]);

            if (empty($validated['user_id'])) {
                $validated['user_id'] = $user->user_id ?? self::generateUserId();
            }

            $validated['last_name'] = $validated['last_name'] ?? '';
            $validated['name'] = trim($validated['first_name'] . ' ' . $validated['last_name']);

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkSave(Request $request)
    {
        try {
            $usersData = $request->input('users', []);
            $savedUsers = [];

            foreach ($usersData as $userData) {
                $id = $userData['id'] ?? null;
                $firstName = trim($userData['first_name'] ?? '');
                $lastName = trim($userData['last_name'] ?? '');
                $email = trim($userData['email'] ?? '');

                if (empty($firstName) && empty($email)) {
                    continue; // Skip empty rows
                }

                if (empty($firstName)) {
                    $firstName = 'User';
                }

                $officeCode = trim($userData['office_code'] ?? '');
                $officeName = trim($userData['office_name'] ?? '');
                $departmentCode = trim($userData['department_code'] ?? '');
                $departmentName = trim($userData['department_name'] ?? '');

                $payload = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'name' => trim($firstName . ' ' . $lastName),
                    'email' => $email,
                    'office_code' => $officeCode,
                    'office_name' => $officeName,
                    'department_code' => $departmentCode,
                    'department_name' => $departmentName,
                    'branch' => trim($userData['branch'] ?? ''),
                    'role' => $userData['role'] ?? 'Operation',
                    'status' => $userData['status'] ?? 'Enable',
                ];

                if ($id && is_numeric($id) && intval($id) > 0) {
                    $user = User::find($id);
                    if ($user) {
                        if (!empty($userData['user_id'])) {
                            $payload['user_id'] = trim($userData['user_id']);
                        }
                        $user->update($payload);
                        $savedUsers[] = $user;
                    }
                } else {
                    $payload['user_id'] = !empty($userData['user_id']) ? trim($userData['user_id']) : self::generateUserId();
                    if (empty($payload['email'])) {
                        $payload['email'] = strtolower($payload['user_id']) . '@fms.com';
                    }
                    $password = !empty($userData['password']) ? $userData['password'] : 'Password123!';
                    $payload['password'] = Hash::make($password);
                    $payload['create_date'] = now();

                    $user = User::create($payload);
                    $savedUsers[] = $user;
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($savedUsers) . ' user(s) saved successfully',
                'users' => $savedUsers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save users: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'new_password' => ['required', 'confirmed', Password::min(6)],
            ]);

            $user->password = Hash::make($validated['new_password']);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportCsv(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->get();

        $filename = 'users-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'User ID', 'First Name', 'Last Name', 'Email',
                'Office Code', 'Office Name', 'Department Code', 'Department Name',
                'Branch', 'Role', 'Status', 'Create Date'
            ]);

            // Data rows
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->user_id,
                    $user->first_name,
                    $user->last_name,
                    $user->email,
                    $user->office_code,
                    $user->office_name,
                    $user->department_code,
                    $user->department_name,
                    $user->branch,
                    $user->role,
                    $user->status,
                    $user->create_date ? (is_string($user->create_date) ? $user->create_date : $user->create_date->format('m-d-Y')) : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}


