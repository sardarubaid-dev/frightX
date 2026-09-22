<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Table Report - Print</title>
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
        .print-info .info-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .print-info strong {
            color: #475569;
            font-weight: 600;
        }
        .print-info .value {
            color: #3b82f6;
            font-weight: 700;
        }
        .filter-info {
            margin-bottom: 12px;
            padding: 8px 10px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 4px;
            font-size: 10px;
            color: #1e40af;
        }
        .filter-info strong {
            font-weight: 600;
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
        .currency-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }
        .rate-value {
            font-weight: 600;
            color: #16a34a;
        }
        .print-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }
        .conversion-header {
            background: #3b82f6 !important;
            color: white !important;
            text-align: center;
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
            @page {
                size: landscape;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>
    <div class="print-header">
        <h1>💱 CURRENCY TABLE REPORT</h1>
        <div class="subtitle">Exchange Rate Records</div>
    </div>

    <div class="print-info">
        <div class="info-group">
            <div><strong>Generated:</strong> {{ now()->format('F d, Y h:i A') }}</div>
            <div><strong>Total Records:</strong> <span class="value">{{ count($rates) }}</span></div>
        </div>
        <div class="info-group">
            <div><strong>Current Rate:</strong> <span class="value">{{ $latestRate ?? '1.0000' }}</span></div>
            <div><strong>Last Accounting Block Date:</strong> <span class="value">{{ $lastBlockDate ?? 'N/A' }}</span></div>
        </div>
        @if(request('from_currency') || request('to_currency'))
        <div class="info-group">
            <div><strong>Conversion:</strong> 
                <span class="value">
                    {{ request('from_currency', 'ALL') }} → {{ request('to_currency', 'ALL') }}
                </span>
            </div>
        </div>
        @endif
    </div>

    @if(request('from_currency') || request('to_currency') || request('search'))
    <div class="filter-info">
        <strong>Filters Applied:</strong>
        @if(request('from_currency'))
            From Currency: <strong>{{ request('from_currency') }}</strong>
        @endif
        @if(request('to_currency'))
            | To Currency: <strong>{{ request('to_currency') }}</strong>
        @endif
        @if(request('search'))
            | Search: <strong>"{{ request('search') }}"</strong>
        @endif
    </div>
    @endif

    <table class="print-table">
        <thead>
            <tr>
                <th class="text-center" style="width:30px;">#</th>
                <th style="width:60px;">From</th>
                <th style="width:60px;">To</th>
                <th style="width:90px;">As of Date</th>
                <th class="text-right" style="width:90px;">Rate (Internal)</th>
                <th class="text-right" style="width:90px;">Rate (External)</th>
                <th style="width:120px;">Created By</th>
                <th style="width:80px;">Created</th>
                <th style="width:120px;">Modified By</th>
                <th style="width:80px;">Last Modified</th>
                <th style="width:120px;">Generated By</th>
                <th style="width:150px;">Remark</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rates as $index => $rate)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <span class="currency-badge">{{ $rate->from_currency }}</span>
                    </td>
                    <td>
                        <span class="currency-badge">{{ $rate->to_currency }}</span>
                    </td>
                    <td>{{ $rate->as_of_date ? date('m-d-Y', strtotime($rate->as_of_date)) : '--' }}</td>
                    <td class="text-right">
                        <span class="rate-value">{{ number_format($rate->rate_internal, 6) }}</span>
                    </td>
                    <td class="text-right">
                        <span class="rate-value">{{ number_format($rate->rate_external, 6) }}</span>
                    </td>
                    <td>{{ $rate->created_by ?: '--' }}</td>
                    <td>{{ $rate->created_at ? date('m-d-Y', strtotime($rate->created_at)) : '--' }}</td>
                    <td>{{ $rate->modified_by ?: '--' }}</td>
                    <td>{{ $rate->updated_at ? date('m-d-Y', strtotime($rate->updated_at)) : '--' }}</td>
                    <td>{{ $rate->generated_by ?: '--' }}</td>
                    <td>{{ $rate->remark ?: '--' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center" style="padding:30px;">
                        No currency rates found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(count($rates) > 0)
    <div style="margin-top:15px; padding:10px; background:#f8fafc; border-radius:4px; font-size:10px; color:#64748b;">
        <strong>Summary:</strong> Showing {{ count($rates) }} currency exchange rate(s)
        @if(request('from_currency') && request('to_currency'))
            for <strong>{{ request('from_currency') }} → {{ request('to_currency') }}</strong> conversion
        @endif
    </div>
    @endif

    <div class="print-footer">
        Currency Table Report • Generated by Freight Management System • {{ config('app.name') }}
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
