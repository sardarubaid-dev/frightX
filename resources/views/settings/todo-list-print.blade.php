<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>To Do List - {{ ucwords(str_replace('-', ' ', $module)) }} - Print</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; padding: 20px; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 8px; color: #1e293b; }
        .meta { text-align: center; font-size: 11px; color: #64748b; margin-bottom: 20px; }
        .module-badge {
            display: inline-block;
            background: #4b77be;
            color: #fff;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .task-item {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .task-title {
            font-weight: 700;
            font-size: 12px;
            color: #1e293b;
            margin-bottom: 6px;
        }
        .task-desc {
            font-size: 10px;
            color: #64748b;
            line-height: 1.5;
        }
        .task-number {
            display: inline-block;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #4b77be;
            text-align: center;
            line-height: 24px;
            font-weight: 700;
            font-size: 11px;
            margin-right: 8px;
            float: left;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #94a3b8;
        }
        @media print {
            body { padding: 10px; }
            @page { size: portrait; margin: 10mm; }
        }
    </style>
</head>
<body>
    <h1>TO DO LIST SETTINGS</h1>
    <div class="meta">
        <span class="module-badge">{{ ucwords(str_replace('-', ' ', $module)) }}</span><br>
        Generated: {{ date('Y-m-d H:i:s') }} | Total Tasks: {{ count($tasks) }}
    </div>

    @forelse($tasks as $index => $task)
    <div class="task-item">
        <div class="task-number">{{ $index + 1 }}</div>
        <div class="task-title">{{ $task->title }}</div>
        @if($task->description)
        <div class="task-desc">{{ $task->description }}</div>
        @endif
    </div>
    @empty
    <div class="empty-state">
        <p style="font-size:14px;font-weight:600;margin-bottom:8px;">No tasks found</p>
        <p style="font-size:11px;">No to-do items have been configured for this module yet.</p>
    </div>
    @endforelse

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
