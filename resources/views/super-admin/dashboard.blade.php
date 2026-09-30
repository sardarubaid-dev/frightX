@extends('super-admin.layout')

@section('content')
<div style="padding: 16px 20px;">
    {{-- Page Header --}}
    <div style="margin-bottom: 16px;">
        <h1 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Super Admin Dashboard</h1>
        <p style="font-size: 11px; color: #64748b; margin: 4px 0 0;">System overview and company management</p>
    </div>

    {{-- KPI Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 20px;">
        @php
            $cards = [
                ['label' => 'Total Companies', 'value' => $stats['total_companies'], 'icon' => 'fa-building', 'color' => '#405189'],
                ['label' => 'Active Companies', 'value' => $stats['active_companies'], 'icon' => 'fa-check-circle', 'color' => '#0ab39c'],
                ['label' => 'Inactive Companies', 'value' => $stats['inactive_companies'], 'icon' => 'fa-ban', 'color' => '#f06548'],
                ['label' => 'Total Users', 'value' => $stats['total_users'], 'icon' => 'fa-users', 'color' => '#3577f1'],
            ];
        @endphp

        @foreach($cards as $card)
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 600; margin-bottom: 6px;">{{ $card['label'] }}</div>
                <div style="font-size: 24px; font-weight: 700; color: #1e293b; font-family: 'Oswald', sans-serif;">{{ number_format($card['value']) }}</div>
            </div>
            <div style="width: 42px; height: 42px; border-radius: 8px; background: {{ $card['color'] }}15; display: flex; align-items: center; justify-content: center;">
                <i class="fa {{ $card['icon'] }}" style="font-size: 18px; color: {{ $card['color'] }};"></i>
            </div>
        </div>
        @endforeach
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        {{-- Recent Companies --}}
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 12px; font-weight: 600; color: #1e293b;">Recent Companies</span>
                <a href="{{ route('super-admin.companies.index') }}" style="font-size: 10px; color: #405189; text-decoration: none;">View All →</a>
            </div>
            <div style="padding: 0;">
                @forelse($stats['recent_companies'] as $company)
                <div style="padding: 10px 16px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; font-size: 11px;">
                    <div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $company->name }}</div>
                        <div style="font-size: 9px; color: #94a3b8;">{{ $company->code ?? '—' }} · {{ $company->created_at?->format('M d, Y') }}</div>
                    </div>
                    <span style="font-size: 9px; padding: 2px 8px; border-radius: 10px; font-weight: 600;
                        {{ $company->status === 'active' ? 'background: #d1fae5; color: #065f46;' : 'background: #fee2e2; color: #991b1b;' }}">
                        {{ ucfirst($company->status) }}
                    </span>
                </div>
                @empty
                <div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 11px;">No companies yet</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Activity --}}
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 12px; font-weight: 600; color: #1e293b;">Recent Activity</span>
                <a href="{{ route('super-admin.audit-log') }}" style="font-size: 10px; color: #405189; text-decoration: none;">View All →</a>
            </div>
            <div style="padding: 0;">
                @forelse($stats['recent_logs'] as $log)
                <div style="padding: 10px 16px; border-bottom: 1px solid #f1f5f9; font-size: 11px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @php
                            $actionIcons = [
                                'company_created' => ['fa-plus-circle', '#22c55e'],
                                'company_updated' => ['fa-pencil', '#3b82f6'],
                                'status_changed' => ['fa-toggle-on', '#f59e0b'],
                                'modules_updated' => ['fa-th-large', '#8b5cf6'],
                                'password_reset' => ['fa-key', '#ef4444'],
                            ];
                            $iconData = $actionIcons[$log->action] ?? ['fa-circle', '#94a3b8'];
                        @endphp
                        <i class="fa {{ $iconData[0] }}" style="color: {{ $iconData[1] }}; font-size: 10px;"></i>
                        <span style="color: #1e293b; font-weight: 500;">{{ str_replace('_', ' ', ucfirst($log->action)) }}</span>
                        <span style="color: #94a3b8; font-size: 9px;">{{ $log->created_at?->diffForHumans() }}</span>
                    </div>
                    @if($log->user)
                    <div style="font-size: 9px; color: #64748b; margin-top: 2px; padding-left: 18px;">by {{ $log->user->name }}</div>
                    @endif
                </div>
                @empty
                <div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 11px;">No activity yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>document.addEventListener('DOMContentLoaded', function() { showToast('success', '{{ session('success') }}'); });</script>
@endif
@endsection
