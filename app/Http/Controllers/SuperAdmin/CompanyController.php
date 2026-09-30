<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyModule;
use App\Models\SuperAdminAuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CompanyController extends Controller
{
    /**
     * Super Admin Dashboard with stats.
     */
    public function dashboard()
    {
        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::where('status', 'active')->count(),
            'inactive_companies' => Company::where('status', 'inactive')->count(),
            'total_users' => User::where('role', '!=', 'SuperAdmin')->count(),
            'recent_companies' => Company::latest()->take(5)->get(),
            'recent_logs' => SuperAdminAuditLog::with('user')->latest('created_at')->take(10)->get(),
        ];

        return view('super-admin.dashboard', compact('stats'));
    }

    /**
     * Company list with search, filter, pagination.
     */
    public function index(Request $request)
    {
        $query = Company::with(['users' => function ($q) {
            $q->orderBy('id')->limit(1);
        }, 'modules']);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('users', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $companies = $query->latest()->paginate(15)->withQueryString();

        // For AJAX partial reload
        if ($request->ajax()) {
            return view('super-admin.companies.partials.table-rows', compact('companies'));
        }

        return view('super-admin.companies.index', compact('companies'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $modules = config('modules');
        return view('super-admin.companies.form', [
            'company' => null,
            'adminUser' => null,
            'modules' => $modules,
            'companyModules' => [],
        ]);
    }

    /**
     * Store new company + admin user + modules.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_code' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:50',
            'company_address' => 'nullable|string|max:1000',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
            'admin_password' => ['required', 'confirmed', Password::min(8)],
            'company_status' => 'required|in:active,inactive',
            'modules' => 'nullable|array',
            'modules.*' => 'string|max:50',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Create company
            $company = Company::create([
                'name' => $validated['company_name'],
                'code' => $validated['company_code'] ?? null,
                'email' => $validated['company_email'] ?? null,
                'phone' => $validated['company_phone'] ?? null,
                'address' => $validated['company_address'] ?? null,
                'status' => $validated['company_status'],
            ]);

            // Create admin user for the company
            $nameParts = explode(' ', $validated['admin_name'], 2);
            User::create([
                'company_id' => $company->id,
                'name' => $validated['admin_name'],
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['admin_password']),
                'role' => 'Admin',
                'status' => $validated['company_status'] === 'active' ? 'Enable' : 'Disable',
                'email_verified_at' => now(),
            ]);

            // Save module access
            if (!empty($validated['modules'])) {
                $moduleRecords = array_map(fn($key) => [
                    'company_id' => $company->id,
                    'module_key' => $key,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], $validated['modules']);
                CompanyModule::insert($moduleRecords);
            }

            // Audit log
            SuperAdminAuditLog::log('company_created', 'company', $company->id, [
                'company_name' => $company->name,
                'admin_email' => $validated['admin_email'],
                'modules' => $validated['modules'] ?? [],
            ]);
        });

        return redirect()->route('super-admin.companies.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Company $company)
    {
        $adminUser = $company->users()->orderBy('id')->first();
        $modules = config('modules');
        $companyModules = $company->moduleKeys();

        return view('super-admin.companies.form', compact('company', 'adminUser', 'modules', 'companyModules'));
    }

    /**
     * Update company + admin user + modules.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_code' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:50',
            'company_address' => 'nullable|string|max:1000',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email,' . ($company->users()->orderBy('id')->first()?->id ?? 0),
            'company_status' => 'required|in:active,inactive',
            'modules' => 'nullable|array',
            'modules.*' => 'string|max:50',
        ]);

        DB::transaction(function () use ($validated, $company) {
            $oldModules = $company->moduleKeys();
            $oldStatus = $company->status;

            // Update company
            $company->update([
                'name' => $validated['company_name'],
                'code' => $validated['company_code'] ?? null,
                'email' => $validated['company_email'] ?? null,
                'phone' => $validated['company_phone'] ?? null,
                'address' => $validated['company_address'] ?? null,
                'status' => $validated['company_status'],
            ]);

            // Update admin user
            $adminUser = $company->users()->orderBy('id')->first();
            if ($adminUser) {
                $nameParts = explode(' ', $validated['admin_name'], 2);
                $adminUser->update([
                    'name' => $validated['admin_name'],
                    'first_name' => $nameParts[0],
                    'last_name' => $nameParts[1] ?? '',
                    'email' => $validated['admin_email'],
                    'status' => $validated['company_status'] === 'active' ? 'Enable' : 'Disable',
                ]);
            }

            // Sync modules
            $company->modules()->delete();
            $newModules = $validated['modules'] ?? [];
            if (!empty($newModules)) {
                $moduleRecords = array_map(fn($key) => [
                    'company_id' => $company->id,
                    'module_key' => $key,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], $newModules);
                CompanyModule::insert($moduleRecords);
            }

            // Audit logs
            SuperAdminAuditLog::log('company_updated', 'company', $company->id, [
                'company_name' => $company->name,
            ]);

            if ($oldStatus !== $validated['company_status']) {
                SuperAdminAuditLog::log('status_changed', 'company', $company->id, [
                    'from' => $oldStatus,
                    'to' => $validated['company_status'],
                ]);
            }

            if (array_diff($oldModules, $newModules) || array_diff($newModules, $oldModules)) {
                SuperAdminAuditLog::log('modules_updated', 'company', $company->id, [
                    'old_modules' => $oldModules,
                    'new_modules' => $newModules,
                ]);
            }
        });

        return redirect()->route('super-admin.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Toggle company status (AJAX).
     */
    public function toggleStatus(Request $request, Company $company)
    {
        $newStatus = $company->status === 'active' ? 'inactive' : 'active';
        $company->update(['status' => $newStatus]);

        // Also toggle the admin user status
        $company->users()->update([
            'status' => $newStatus === 'active' ? 'Enable' : 'Disable',
        ]);

        SuperAdminAuditLog::log('status_changed', 'company', $company->id, [
            'from' => $company->getOriginal('status') ?? ($newStatus === 'active' ? 'inactive' : 'active'),
            'to' => $newStatus,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $newStatus,
                'message' => 'Company ' . ($newStatus === 'active' ? 'activated' : 'deactivated') . ' successfully.',
            ]);
        }

        return back()->with('success', 'Company status updated.');
    }

    /**
     * Reset admin user password.
     */
    public function resetPassword(Request $request, Company $company)
    {
        $validated = $request->validate([
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $adminUser = $company->users()->orderBy('id')->first();
        if (!$adminUser) {
            return back()->with('error', 'No admin user found for this company.');
        }

        $adminUser->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        SuperAdminAuditLog::log('password_reset', 'user', $adminUser->id, [
            'company_name' => $company->name,
            'user_email' => $adminUser->email,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Password reset successfully.']);
        }

        return back()->with('success', 'Password reset successfully.');
    }

    /**
     * Audit log listing.
     */
    public function auditLog(Request $request)
    {
        $query = SuperAdminAuditLog::with('user')->latest('created_at');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('target_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($action = $request->input('action')) {
            $query->where('action', $action);
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('super-admin.audit-log', compact('logs'));
    }

    /**
     * Export companies to CSV.
     */
    public function exportCsv()
    {
        $companies = Company::with(['users' => fn($q) => $q->orderBy('id')->limit(1), 'modules'])->get();

        $csv = "Company,Code,Admin,Email,Phone,Status,Modules,Created\n";
        foreach ($companies as $c) {
            $admin = $c->users->first();
            $modules = $c->modules->pluck('module_key')->implode('; ');
            $csv .= implode(',', [
                '"' . str_replace('"', '""', $c->name) . '"',
                '"' . ($c->code ?? '') . '"',
                '"' . ($admin?->name ?? '') . '"',
                '"' . ($admin?->email ?? '') . '"',
                '"' . ($c->phone ?? '') . '"',
                $c->status,
                '"' . $modules . '"',
                $c->created_at?->format('Y-m-d') ?? '',
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="companies-' . date('Y-m-d') . '.csv"',
        ]);
    }
}
