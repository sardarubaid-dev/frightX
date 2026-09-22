<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AWB No. Management - Print</title>
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
        .text-right { text-align: right; }
        @media print {
            body { padding: 10px; }
            @page { size: landscape; margin: 10mm; }
        }
    </style>
</head>
<body>
    <h1>AWB NO. MANAGEMENT LIST</h1>
    <div class="meta">
        Generated: {{ date('Y-m-d H:i:s') }} | Total Records: {{ count($blocks) }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:100px;">Created Date</th>
                <th style="width:180px;">Carrier</th>
                <th style="width:70px;">Prefix</th>
                <th style="width:100px;">Begin No</th>
                <th style="width:100px;">End No</th>
                <th class="text-right" style="width:80px;">Total</th>
                <th class="text-right" style="width:80px;">Available</th>
                <th class="text-right" style="width:80px;">Reserved</th>
                <th class="text-right" style="width:80px;">Assigned</th>
                <th style="width:120px;">Latest Assigned</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blocks as $block)
            <tr>
                <td>{{ $block->created_date }}</td>
                <td>{{ $block->carrier->name ?? '' }}</td>
                <td><strong>{{ $block->prefix }}</strong></td>
                <td>{{ $block->begin_no }}</td>
                <td>{{ $block->end_no }}</td>
                <td class="text-right">{{ $block->total_count }}</td>
                <td class="text-right">{{ $block->available_count }}</td>
                <td class="text-right">{{ $block->reserved_count }}</td>
                <td class="text-right">{{ $block->assigned_count }}</td>
                <td>{{ $block->latest_assigned_no }}</td>
                <td>{{ $block->remark }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center;padding:20px;color:#94a3b8;">No AWB blocks found.</td>
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
