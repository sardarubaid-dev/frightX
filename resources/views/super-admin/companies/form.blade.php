@extends('super-admin.layout')

@section('content')
<div style="padding: 16px 20px; width: 100%;">
    {{-- Page Header --}}
    <div style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h1 style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">
                <i class="fa fa-{{ $company ? 'pencil' : 'plus-circle' }}" style="color: #405189; margin-right: 4px;"></i>
                {{ $company ? 'Edit Company' : 'Create New Company' }}
            </h1>
            <p style="font-size: 10px; color: #64748b; margin: 4px 0 0;">{{ $company ? 'Update company information and module access' : 'Set up a new company account with admin user' }}</p>
        </div>
        <a href="{{ route('super-admin.companies.index') }}" style="height: 28px; padding: 0 12px; display: inline-flex; align-items: center; gap: 4px; font-size: 10px; border: 1px solid #cbd5e1; border-radius: 3px; color: #475569; text-decoration: none; background: #fff;"
           onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div style="margin-bottom: 12px; padding: 10px 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 4px;">
        <div style="font-size: 11px; font-weight: 600; color: #991b1b; margin-bottom: 4px;"><i class="fa fa-exclamation-triangle"></i> Please fix the following errors:</div>
        @foreach($errors->all() as $error)
        <div style="font-size: 10px; color: #b91c1c; padding-left: 16px;">• {{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ $company ? route('super-admin.companies.update', $company) : route('super-admin.companies.store') }}">
        @csrf
        @if($company) @method('PUT') @endif

        {{-- Company Information --}}
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 12px;">
            <div style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0; font-size: 11px; font-weight: 600; color: #405189;">
                <i class="fa fa-building" style="margin-right: 4px;"></i> Company Information
            </div>
            <div style="padding: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Company Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="company_name" value="{{ old('company_name', $company?->name) }}" required
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;"
                        @focus="$el.style.borderColor='#405189'" @blur="$el.style.borderColor='#cbd5e1'">
                </div>
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Company Code</label>
                    <input type="text" name="company_code" value="{{ old('company_code', $company?->code) }}"
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;" placeholder="e.g. ACME">
                </div>
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Company Email</label>
                    <input type="email" name="company_email" value="{{ old('company_email', $company?->email) }}"
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Phone</label>
                    <input type="text" name="company_phone" value="{{ old('company_phone', $company?->phone) }}"
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Address</label>
                    <textarea name="company_address" rows="2"
                        style="width: 100%; padding: 6px 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none; resize: vertical;">{{ old('company_address', $company?->address) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Admin Account --}}
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 12px;">
            <div style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0; font-size: 11px; font-weight: 600; color: #405189;">
                <i class="fa fa-user" style="margin-right: 4px;"></i> Admin Account
                @if($company)
                <span style="font-size: 9px; color: #94a3b8; font-weight: 400;">— Password can be reset from the company list</span>
                @endif
            </div>
            <div style="padding: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Full Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="admin_name" value="{{ old('admin_name', $adminUser?->name) }}" required
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Email <span style="color: #ef4444;">*</span></label>
                    <input type="email" name="admin_email" value="{{ old('admin_email', $adminUser?->email) }}" required
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;">
                </div>
                @unless($company)
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Password <span style="color: #ef4444;">*</span></label>
                    <input type="password" name="admin_password" required minlength="8"
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 600; color: #475569; margin-bottom: 3px;">Confirm Password <span style="color: #ef4444;">*</span></label>
                    <input type="password" name="admin_password_confirmation" required minlength="8"
                        style="width: 100%; height: 30px; padding: 0 10px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;">
                </div>
                @endunless
            </div>
        </div>

        {{-- Module Access --}}
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 12px;">
            <div style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0; font-size: 11px; font-weight: 600; color: #405189; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa fa-th-large" style="margin-right: 4px;"></i> Module Access</span>
                <label style="font-size: 9px; color: #64748b; font-weight: 400; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                    <input type="checkbox" id="select-all-modules" onclick="toggleAllModules(this)" style="cursor: pointer;"> Select All
                </label>
            </div>
            <div style="padding: 14px; display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 8px;">
                @foreach($modules as $key => $mod)
                <label style="display: flex; align-items: center; gap: 8px; padding: 8px 10px; border: 1px solid #e2e8f0; border-radius: 4px; cursor: pointer; transition: all 0.15s;
                    {{ in_array($key, old('modules', $companyModules)) ? 'background: #eff6ff; border-color: #93c5fd;' : '' }}"
                    onmouseover="this.style.borderColor='#93c5fd'" onmouseout="if(!this.querySelector('input').checked) this.style.borderColor='#e2e8f0';">
                    <input type="checkbox" name="modules[]" value="{{ $key }}" class="module-checkbox"
                        {{ in_array($key, old('modules', $companyModules)) ? 'checked' : '' }}
                        onchange="this.closest('label').style.background = this.checked ? '#eff6ff' : ''; this.closest('label').style.borderColor = this.checked ? '#93c5fd' : '#e2e8f0';">
                    <i class="fa {{ $mod['icon'] }}" style="font-size: 12px; color: #405189; width: 16px; text-align: center;"></i>
                    <span style="font-size: 10px; font-weight: 500; color: #1e293b;">{{ $mod['label'] }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Account Status --}}
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 16px;">
            <div style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0; font-size: 11px; font-weight: 600; color: #405189;">
                <i class="fa fa-toggle-on" style="margin-right: 4px;"></i> Account Status
            </div>
            <div style="padding: 14px; display: flex; gap: 16px;">
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 11px;">
                    <input type="radio" name="company_status" value="active" {{ old('company_status', $company?->status ?? 'active') === 'active' ? 'checked' : '' }}>
                    <span style="color: #065f46; font-weight: 600;"><i class="fa fa-check-circle" style="margin-right: 2px;"></i> Active</span>
                </label>
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 11px;">
                    <input type="radio" name="company_status" value="inactive" {{ old('company_status', $company?->status) === 'inactive' ? 'checked' : '' }}>
                    <span style="color: #991b1b; font-weight: 600;"><i class="fa fa-ban" style="margin-right: 2px;"></i> Inactive</span>
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <div style="display: flex; gap: 8px;">
            <button type="submit" style="height: 34px; padding: 0 20px; font-size: 11px; font-weight: 600; border: none; border-radius: 4px; background: #0ab39c; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 6px;"
                onmouseover="this.style.background='#099c88'" onmouseout="this.style.background='#0ab39c'">
                <i class="fa fa-{{ $company ? 'save' : 'plus-circle' }}"></i>
                {{ $company ? 'Update Company' : 'Create Company' }}
            </button>
            <a href="{{ route('super-admin.companies.index') }}" style="height: 34px; padding: 0 16px; font-size: 11px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff; color: #475569; cursor: pointer; display: inline-flex; align-items: center; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function toggleAllModules(el) {
    document.querySelectorAll('.module-checkbox').forEach(function(cb) {
        cb.checked = el.checked;
        cb.dispatchEvent(new Event('change'));
    });
}
</script>
@endpush
@endsection
