<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank List Report - Print</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
            background: #fff;
        }
        .print-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4b77be;
        }
        .print-header h1 {
            font-size: 22px;
            color: #4b77be;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .print-header .subtitle {
            font-size: 12px;
            color: #64748b;
        }
        .print-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 10px;
            color: #64748b;
            padding: 10px;
            background: #f8fafc;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }
        .print-info strong {
            color: #475569;
            font-weight: 600;
        }
        .print-info .value {
            color: #3b82f6;
            font-weight: 700;
        }
        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .print-table th {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            color: #334155;
            white-space: nowrap;
        }
        .print-table td {
            border: 1px solid #e2e8f0;
            padding: 6px 6px;
            font-size: 10px;
            color: #475569;
        }
        .print-table tr:nth-child(even) {
            background: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .print-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }
        @media print {
            body {
                padding: 10px;
            }
            .print-header {
                margin-bottom: 10px;
                padding-bottom: 10px;
            }
            .print-table th,
            .print-table td {
                padding: 4px 3px;
            }
        }
        @page {
            size: landscape;
            margin: 10mm;
        }
    </style>
</head>
<body>
    <div class="print-header">
        <h1>🏦 BANK LIST REPORT</h1>
        <div class="subtitle">Bank Account Records</div>
    </div>

    <div class="print-info">
        <div>
            <strong>Generated:</strong> {{ now()->format('F d, Y h:i A') }}
        </div>
        <div>
            <strong>Total Records:</strong> <span class="value">{{ count($banks) }}</span>
        </div>
        @if(request('search'))
        <div>
            <strong>Search:</strong> "{{ request('search') }}"
        </div>
        @endif
    </div>

    <table class="print-table">
        <thead>
            <tr>
                <th class="text-center" style="width:30px;">#</th>
                <th style="width:120px;">Bank Name</th>
                <th style="width:150px;">G/L No.</th>
                <th class="text-right" style="width:90px;">Initial Amount</th>
                <th style="width:60px;">Currency</th>
                <th class="text-center" style="width:70px;">Rev. Default</th>
                <th class="text-center" style="width:70px;">Cost Default</th>
                <th style="width:100px;">Notes Receivable</th>
                <th style="width:100px;">Notes Payable</th>
                <th class="text-center" style="width:60px;">Active</th>
                <th style="width:90px;">Inactive Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banks as $index => $bank)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $bank->bank_name }}</strong></td>
                    <td>{{ $bank->gl_no ?: '--' }}</td>
                    <td class="text-right">{{ number_format($bank->initial_amount ?? 0, 2) }}</td>
                    <td>
                        <span class="badge badge-info">{{ $bank->currency }}</span>
                    </td>
                    <td class="text-center">
                        @if($bank->revenue_default)
                            <span class="badge badge-success">✓</span>
                        @else
                            <span>--</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($bank->cost_default)
                            <span class="badge badge-success">✓</span>
                        @else
                            <span>--</span>
                        @endif
                    </td>
                    <td>{{ $bank->notes_receivable ?: '--' }}</td>
                    <td>{{ $bank->notes_payable ?: '--' }}</td>
                    <td class="text-center">
                        @if($bank->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $bank->inactive_date ?: '--' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center" style="padding:30px;">
                        No banks found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(count($banks) > 0)
    <div style="margin-top:15px; padding:10px; background:#f8fafc; border-radius:4px; font-size:10px; color:#64748b;">
        <strong>Summary:</strong> Showing {{ count($banks) }} bank account(s)
        @php
            $activeCount = collect($banks)->where('is_active', true)->count();
            $inactiveCount = count($banks) - $activeCount;
        @endphp
        | <strong>Active:</strong> {{ $activeCount }} | <strong>Inactive:</strong> {{ $inactiveCount }}
    </div>
    @endif

    <div class="print-footer">
        Bank List Report • Generated by Freight Management System • {{ config('app.name') }}
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
