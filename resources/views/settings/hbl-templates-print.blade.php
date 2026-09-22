<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HBL Templates - Print</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 9px; padding: 20px; }
        h1 { text-align: center; font-size: 16px; margin-bottom: 10px; color: #1e293b; }
        .meta { text-align: center; font-size: 10px; color: #64748b; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f1f5f9; color: #1e293b; padding: 6px 4px; text-align: left; border: 1px solid #cbd5e1; font-weight: 700; font-size: 8px; }
        td { padding: 5px 4px; border: 1px solid #e2e8f0; font-size: 8px; vertical-align: top; }
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
    <h1>HBL TEMPLATE LIST</h1>
    <div class="meta">
        Generated: {{ date('Y-m-d H:i:s') }} | Total Records: {{ count($templates) }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px;">ID</th>
                <th style="width:200px;">Template Name</th>
                <th style="width:300px;">Display Title</th>
                <th class="text-center" style="width:100px;">Active</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($templates as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td><strong>{{ $t->name }}</strong></td>
                <td>{{ $t->title }}</td>
                <td class="text-center">{!! $t->is_active ? '<span class="check">✓</span>' : 'No' !!}</td>
                <td>{{ $t->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:20px;color:#94a3b8;">No HBL templates found.</td>
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
