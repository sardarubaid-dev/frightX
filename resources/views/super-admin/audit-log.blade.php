@extends('super-admin.layout')

@section('content')
<div style="padding: 8px 12px;">
    <div style="background: #fff; border: 1px solid #cbd5e1; border-radius: 2px;">
        {{-- Toolbar --}}
        <div style="padding: 6px 10px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 6px;">
            <span style="font-size: 12px; font-weight: 600; color: #1e293b;"><i class="fa fa-history" style="color: #405189; margin-right: 4px;"></i> Audit Log</span>
            <form method="GET" style="display: flex; gap: 4px;">
                <div style="position: relative;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search logs..."
                        style="height: 26px; width: 180px; padding: 0 8px 0 26px; font-size: 10px; border: 1px solid #cbd5e1; border-radius: 3px; outline: none;">
                    <i class="fa fa-search" style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); font-size: 10px; color: #94a3b8;"></i>
                </div>
                <select name="action" onchange="this.form.submit()"
                    style="height: 26px; padding: 0 6px; font-size: 10px; border: 1px solid #cbd5e1; border-radius: 3px; background: #fff;">
                    <option value="">All Actions</option>
                    @foreach(['company_created','company_updated','status_changed','modules_updated','password_reset'] as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($action)) }}</option>
                    @endforeach
                </select>
                <button type="submit" style="height: 26px; padding: 0 10px; font-size: 10px; border: 1px solid #cbd5e1; border-radius: 3px; background: #f8fafc; cursor: pointer;">Filter</button>
            </form>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 6px 8px; text-align: left; border: 1px solid #e2e8f0; font-weight: 600; color: #475569; font-size: 9px; text-transform: uppercase; width: 150px;">Date</th>
                        <th style="padding: 6px 8px; text-align: left; border: 1px solid #e2e8f0; font-weight: 600; color: #475569; font-size: 9px; text-transform: uppercase; width: 120px;">User</th>
                        <th style="padding: 6px 8px; text-align: left; border: 1px solid #e2e8f0; font-weight: 600; color: #475569; font-size: 9px; text-transform: uppercase; width: 140px;">Action</th>
                        <th style="padding: 6px 8px; text-align: left; border: 1px solid #e2e8f0; font-weight: 600; color: #475569; font-size: 9px; text-transform: uppercase;">Details</th>
                        <th style="padding: 6px 8px; text-align: left; border: 1px solid #e2e8f0; font-weight: 600; color: #475569; font-size: 9px; text-transform: uppercase; width: 100px;">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                        <td style="padding: 6px 8px; border: 1px solid #f1f5f9; color: #475569; font-size: 9px;">{{ $log->created_at?->format('M d, Y H:i') }}</td>
                        <td style="padding: 6px 8px; border: 1px solid #f1f5f9; color: #1e293b; font-weight: 500;">{{ $log->user?->name ?? 'System' }}</td>
                        <td style="padding: 6px 8px; border: 1px solid #f1f5f9;">
                            @php
                                $actionColors = [
                                    'company_created' => '#22c55e',
                                    'company_updated' => '#3b82f6',
                                    'status_changed' => '#f59e0b',
                                    'modules_updated' => '#8b5cf6',
                                    'password_reset' => '#ef4444',
                                ];
                                $color = $actionColors[$log->action] ?? '#64748b';
                            @endphp
                            <span style="font-size: 9px; padding: 2px 8px; border-radius: 10px; font-weight: 600; background: {{ $color }}15; color: {{ $color }};">
                                {{ str_replace('_', ' ', ucfirst($log->action)) }}
                            </span>
                        </td>
                        <td style="padding: 6px 8px; border: 1px solid #f1f5f9; color: #64748b; font-size: 9px;">
                            @if($log->details)
                                @foreach($log->details as $key => $val)
                                    <span style="color: #475569; font-weight: 500;">{{ $key }}:</span>
                                    {{ is_array($val) ? implode(', ', $val) : $val }}
                                    @if(!$loop->last) · @endif
                                @endforeach
                            @else
                                —
                            @endif
                        </td>
                        <td style="padding: 6px 8px; border: 1px solid #f1f5f9; color: #94a3b8; font-size: 9px;">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: #94a3b8; font-size: 12px;">No audit logs found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
        <div style="padding: 8px 10px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; font-size: 10px; color: #64748b;">
            <span>Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }}</span>
            <div style="display: flex; gap: 2px;">
                @if($logs->onFirstPage())
                    <span style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; border-radius: 3px; color: #cbd5e1;">‹</span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #cbd5e1; border-radius: 3px; color: #475569; text-decoration: none;">‹</a>
                @endif
                @foreach($logs->getUrlRange(max(1, $logs->currentPage()-2), min($logs->lastPage(), $logs->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid {{ $page == $logs->currentPage() ? '#405189' : '#cbd5e1' }}; border-radius: 3px; text-decoration: none;
                        {{ $page == $logs->currentPage() ? 'background: #405189; color: #fff; font-weight: 600;' : 'color: #475569;' }}">{{ $page }}</a>
                @endforeach
                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #cbd5e1; border-radius: 3px; color: #475569; text-decoration: none;">›</a>
                @else
                    <span style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; border-radius: 3px; color: #cbd5e1;">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
