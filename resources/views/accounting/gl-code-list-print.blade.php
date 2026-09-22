<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>G/L Code List - Print</title>
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
    <h1>G/L CODE LIST</h1>
    <div class="meta">
        Generated: {{ date('Y-m-d H:i:s') }} | Total Records: {{ count($codes) }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:80px;">G/L Code</th>
                <th style="width:150px;">Name (Eng)</th>
                <th style="width:150px;">Name (Local)</th>
                <th style="width:80px;">Name Type</th>
                <th style="width:120px;">Sub</th>
                <th class="text-center" style="width:60px;">AIRE_AP</th>
                <th class="text-center" style="width:50px;">Detail</th>
                <th class="text-center" style="width:50px;">Deposit</th>
                <th class="text-center" style="width:60px;">Forgotten</th>
                <th class="text-center" style="width:70px;">Transaction</th>
                <th class="text-center" style="width:50px;">Active</th>
            </tr>
        </thead>
        <tbody>
            @forelse($codes as $code)
            <tr>
                <td><strong>{{ $code->gl_code }}</strong></td>
                <td>{{ $code->gl_name_eng }}</td>
                <td>{{ $code->gl_name_local }}</td>
                <td>{{ $code->name_type }}</td>
                <td>{{ $code->sub }}</td>
                <td class="text-center">{!! $code->aire_ap_code ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->detail ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->deposit ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->forgotten ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->transaction ? '<span class="check">✓</span>' : '' !!}</td>
                <td class="text-center">{!! $code->is_active ? '<span class="check">✓</span>' : '' !!}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center;padding:20px;color:#94a3b8;">No G/L codes found.</td>
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
