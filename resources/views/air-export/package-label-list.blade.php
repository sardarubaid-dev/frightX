<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Package Label List - {{ $shipment->mawb_no ?? '02605203306' }}</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            color: #1e293b; 
            margin: 0; 
            padding: 20px 0; 
            font-size: 11px; 
            line-height: 1.4; 
            background: #334155;
        }

        .controls-bar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #ffffff;
            border-bottom: 2px solid #cbd5e1;
            padding: 10px 24px;
            margin: -20px 0 25px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .toolbar-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #475569;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .toolbar-btn:hover { color: #0284c7; background: #f1f5f9; }

        .report-page {
            max-width: 900px;
            margin: 0 auto 40px auto;
            background: #ffffff;
            padding: 30px 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            border-radius: 2px;
            transition: transform 0.2s ease;
        }

        .header-box {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .report-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }

        .mawb-row {
            font-weight: 700;
            font-size: 11px;
            margin-bottom: 12px;
            color: #334155;
        }
        .mawb-row span {
            font-weight: 800;
            color: #0f172a;
            margin-left: 6px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #94a3b8;
        }

        .table-custom th {
            background: #cbd5e1;
            color: #0f172a;
            font-weight: 800;
            padding: 6px 10px;
            font-size: 10px;
            border: 1px solid #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .table-custom td {
            border: 1px solid #94a3b8;
            padding: 6px 10px;
            font-size: 11px;
            color: #0f172a;
            text-align: center;
        }

        .table-custom tr.total-row td {
            background: #f1f5f9;
            font-weight: 800;
        }

        .input-inline {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            text-align: center;
            font-family: inherit;
            font-size: 11px;
            font-weight: 600;
            color: #0f172a;
        }

        @media print {
            .controls-bar { display: none !important; }
            body { padding: 0; background: #fff; }
            .report-page { 
                box-shadow: none; 
                margin: 0 auto; 
                max-width: 100%;
                padding: 0;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

@php
    $hbls = $shipment->hbls ?? collect([]);
    $initialItems = [];

    if ($hbls->count() > 0) {
        foreach ($hbls as $idx => $hbl) {
            $initialItems[] = [
                'wh_receipt' => 'WR-' . ($shipment->file_no ?? '26050015') . '-' . sprintf('%02d', $idx + 1),
                'length' => '0',
                'width' => '0',
                'height' => '0',
                'dimension' => '0 x 0 x 0 CM',
                'pkg' => (int)($hbl->pkg_qty ?: 0),
                'pcs' => (int)($hbl->pkg_qty ?: 0),
                'unit' => $hbl->packageUnit->name ?? 'CTN'
            ];
        }
    } else {
        $initialItems[] = [
            'wh_receipt' => 'WR-' . ($shipment->file_no ?? '26050015') . '-01',
            'length' => '0',
            'width' => '0',
            'height' => '0',
            'dimension' => '0 x 0 x 0 CM',
            'pkg' => (int)($shipment->pkg_qty ?: 0),
            'pcs' => (int)($shipment->pkg_qty ?: 0),
            'unit' => 'CTN'
        ];
    }
@endphp

<div x-data="packageListApp()" x-cloak>
    <!-- Controls Top Bar -->
    <div class="controls-bar">
        <button class="toolbar-btn" @click="window.print()" title="Save PDF"><i class="fa fa-file-pdf-o"></i></button>
        <button class="toolbar-btn" @click="window.print()" title="Print"><i class="fa fa-print"></i></button>
        <button class="toolbar-btn" @click="alert('Email sent')" title="Email"><i class="fa fa-envelope-o"></i></button>
        <div style="width: 1px; height: 18px; background: #cbd5e1; margin: 0 4px;"></div>
        <button class="toolbar-btn" @click="zoomIn()" title="Zoom In"><i class="fa fa-search-plus"></i></button>
        <button class="toolbar-btn" @click="zoomOut()" title="Zoom Out"><i class="fa fa-search-minus"></i></button>
    </div>

    <!-- MAIN REPORT PAGE -->
    <div class="report-page" :style="'transform: scale(' + zoomLevel + '); transform-origin: top center;'">
        <!-- Header -->
        <div class="header-box">
            <div class="company-name">FREIGHTX</div>
            <div class="report-title">Package Label List</div>
        </div>

        <!-- MAWB Row -->
        <div class="mawb-row">
            MAWB NO. : <span>{{ $shipment->mawb_no ?? '02605203306' }}</span>
        </div>

        <!-- Table -->
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 20%;">WH RECEIPT NO.</th>
                    <th style="width: 10%;">LENGTH</th>
                    <th style="width: 10%;">WIDTH</th>
                    <th style="width: 10%;">HEIGHT</th>
                    <th style="width: 20%;">DIMENSION</th>
                    <th style="width: 10%;">PKG</th>
                    <th style="width: 10%;">PCS</th>
                    <th style="width: 10%;">UNIT</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, index) in items" :key="index">
                    <tr>
                        <td>
                            <input type="text" x-model="item.wh_receipt" class="input-inline">
                        </td>
                        <td>
                            <input type="number" x-model.number="item.length" @input="updateDimension(index)" class="input-inline">
                        </td>
                        <td>
                            <input type="number" x-model.number="item.width" @input="updateDimension(index)" class="input-inline">
                        </td>
                        <td>
                            <input type="number" x-model.number="item.height" @input="updateDimension(index)" class="input-inline">
                        </td>
                        <td>
                            <span x-text="item.dimension"></span>
                        </td>
                        <td>
                            <input type="number" x-model.number="item.pkg" class="input-inline">
                        </td>
                        <td>
                            <input type="number" x-model.number="item.pcs" class="input-inline">
                        </td>
                        <td>
                            <input type="text" x-model="item.unit" class="input-inline">
                        </td>
                    </tr>
                </template>

                <!-- Total Row -->
                <tr class="total-row">
                    <td style="text-align: left; padding-left: 14px;">TOTAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td x-text="totalPkg"></td>
                    <td x-text="totalPcs"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Add Row Action -->
        <div style="margin-top: 15px; display: flex; justify-content: flex-end;" class="no-print">
            <button @click="addRow()" style="background: #0ea5e9; color: #fff; border: none; padding: 5px 12px; border-radius: 4px; font-weight: 600; font-size: 11px; cursor: pointer;">
                <i class="fa fa-plus"></i> Add Item
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('packageListApp', () => ({
            zoomLevel: 1.0,
            items: @json($initialItems),

            get totalPkg() {
                return this.items.reduce((sum, item) => sum + (parseInt(item.pkg) || 0), 0);
            },

            get totalPcs() {
                return this.items.reduce((sum, item) => sum + (parseInt(item.pcs) || 0), 0);
            },

            updateDimension(index) {
                const item = this.items[index];
                const l = item.length || 0;
                const w = item.width || 0;
                const h = item.height || 0;
                item.dimension = `${l} x ${w} x ${h} CM`;
            },

            addRow() {
                const count = this.items.length + 1;
                this.items.push({
                    wh_receipt: 'WR-26050015-' + String(count).padStart(2, '0'),
                    length: 0,
                    width: 0,
                    height: 0,
                    dimension: '0 x 0 x 0 CM',
                    pkg: 0,
                    pcs: 0,
                    unit: 'CTN'
                });
            },

            zoomIn() {
                if (this.zoomLevel < 1.4) this.zoomLevel += 0.1;
            },

            zoomOut() {
                if (this.zoomLevel > 0.7) this.zoomLevel -= 0.1;
            }
        }));
    });
</script>
</body>
</html>
