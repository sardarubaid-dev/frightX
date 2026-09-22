<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Billing Code List - Print</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 9px; padding: 20px; }
        h1 { text-align: center; font-size: 16px; margin-bottom: 10px; color: #1e293b; }
        .meta { text-align: center; font-size: 10px; color: #64748b; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f1f5f9; color: #1e293b; padding: 6px 4px; text-align: left; border: 1px solid #cbd5e1; font-weight: 700; font-size: 8px; }
        td { padding: 5px 4px; border: 1px solid #e2e8f0; font-size: 8px; }
        tr:nth-child(even) { background: #f8fafc; }
        .text-center { text-align: center; }
        .check { color: #22c55e; font-weight: bold; }
        @media print {
            body { padding: 10px; }
            @page { size: landscape; margin: 10mm; }
        }
    </style>
</head>
<body>
    <h1>BILLING CODE LIST</h1>
    <div class="meta">
        Generated: {{ date('Y-m-d H:i:s') }} | Total Records: {{ count($codes) }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:80px;">Code</th>
                <th style="width:120px;">Name (Eng)</th>
                <th style="width:120px;">Name (Local)</th>
                <th style="width:60px;">Revenue</th>
                <th style="width:60px;">Cost</th>
                <th style="width:60px;">Credit</th>
                <th style="width:60px;">Debit</th>
                <th style="width:50px;">Dept.</th>
                <th class="text-center" style="width:25px;">A/R</th>
                <th class="text-center" style="width:25px;">A/P</th>
                <th class="text-center" style="width:25px;">D/C</th>
                <th class="text-center" style="width:25px;">B&A</th>
                <th class="text-center" style="width:30px;">Payroll</th>
                <th class="text-center" style="width:30px;">OHW</th>
                <th class="text-center" style="width:30px;">OIM</th>
                <th class="text-center" style="width:30px;">AIM</th>
                <th class="text-center" style="width:30px;">AIE</th>
                <th class="text-center" style="width:30px;">OEM</th>
                <th class="text-center" style="width:30px;">OEW</th>
                <th class="text-center" style="width:35px;">Aerial</th>
                <th class="text-center" style="width:30px;">Alog</th>
                <th class="text-center" style="width:25px;">TK</th>
                <th class="text-center" style="width:30px;">Misc</th>
                <th class="text-center" style="width:25px;">WH</th>
                <th class="text-center" style="width:35px;">Active</th>
            </tr>
        </thead>
        <tbody>
            @forelse($codes as $code)
            <tr>
                <td><strong>{{ $code->code }}</strong></td>
                <td>{{ $code->name_eng }}</td>
                <td>{{ $code->name_local }}</td>
                <td>{{ $code->revenue }}</td>
                <td>{{ $code->cost }}</td>
                <td>{{ $code->credit }}</td>
                <td>{{ $code->debit }}</td>
                <td>{{ $code->department }}</td>
                <td class="text-center">{!! $code->ar ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->ap ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->dc ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->ba ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->payroll ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->ohw ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->oim ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->aim ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->aie ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->oem ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->oew ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->aerial ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->alog ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->tk ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->misc ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->wh ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->is_active ? '<span class="check">✓</span>' : '' !!}</td>
            </tr>
            @empty
            <tr>
                <td colspan="25" style="text-align:center;padding:20px;color:#94a3b8;">No billing codes found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
