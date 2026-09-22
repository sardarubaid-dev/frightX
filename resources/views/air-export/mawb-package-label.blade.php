<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MAWB Package Label - {{ $shipment->mawb_no ?? '02605203306' }}</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            color: #1e293b; 
            margin: 0; 
            padding: 20px 0; 
            font-size: 11px; 
            line-height: 1.3; 
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
            justify-content: space-between;
            align-items: center;
        }

        .controls-center {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }

        .controls-center select {
            padding: 3px 8px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 11px;
            background: #fff;
            color: #1e293b;
        }

        .toolbar-icons {
            display: flex;
            align-items: center;
            gap: 15px;
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

        .label-container {
            width: 420px;
            margin: 0 auto 30px auto;
            background: #ffffff;
            border: 2px solid #0f172a;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .label-section {
            border-bottom: 2px solid #0f172a;
            padding: 10px 14px;
        }
        .label-section:last-child {
            border-bottom: none;
        }

        .barcode-box {
            text-align: center;
            padding: 15px 10px 10px 10px;
            background: #fff;
        }

        .barcode-box svg {
            max-width: 100%;
            height: 75px;
        }

        .barcode-num {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-top: 4px;
            color: #0f172a;
        }

        .field-label {
            font-style: italic;
            font-weight: 700;
            font-size: 11px;
            color: #334155;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .field-value-box {
            border: 1px solid #94a3b8;
            background: #f8fafc;
            padding: 6px 10px;
            font-weight: 800;
            color: #0f172a;
            font-size: 18px;
            border-radius: 2px;
        }

        .field-value-box.large {
            font-size: 24px;
            padding: 8px 12px;
            letter-spacing: 1px;
        }

        .grid-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .input-note-field {
            width: 100%;
            border: 1px solid #cbd5e1;
            padding: 5px 8px;
            font-size: 11px;
            color: #334155;
            outline: none;
        }
        .input-note-field:focus {
            border-color: #0284c7;
        }

        @media print {
            .controls-bar { display: none !important; }
            body { padding: 0; background: #fff; }
            .label-container { 
                box-shadow: none; 
                margin: 0 auto; 
                page-break-after: always;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

@php
    $mawbNo = $shipment->mawb_no ?? '02605203306';
    $rawMawb = preg_replace('/[^0-9]/', '', $mawbNo);
    
    // Calculate 3-letter IATA Origin and Destination
    $originCode = 'LAX';
    if ($shipment->depPort) {
        $originCode = $shipment->depPort->code ?: (substr(preg_replace('/[^A-Z]/', '', strtoupper($shipment->depPort->name)), 0, 3) ?: 'LAX');
    }
    
    $destCode = 'AMS';
    if ($shipment->dstPort) {
        $destCode = $shipment->dstPort->code ?: (substr(preg_replace('/[^A-Z]/', '', strtoupper($shipment->dstPort->name)), 0, 3) ?: 'AMS');
    }

    $totalPieces = $totalPcs ?: 1;
@endphp

<div x-data="labelApp()" x-init="initBarcodes()" x-cloak>
    <!-- Controls Top Bar -->
    <div class="controls-bar">
        <div class="toolbar-icons">
            <button class="toolbar-btn" @click="window.print()" title="Save PDF"><i class="fa fa-file-pdf-o"></i></button>
            <button class="toolbar-btn" @click="window.print()" title="Print"><i class="fa fa-print"></i></button>
            <button class="toolbar-btn" @click="alert('Email label sent')" title="Email"><i class="fa fa-envelope-o"></i></button>
        </div>

        <div class="controls-center">
            <span style="font-weight: 700; color: #dc2626;">Data Source :</span>
            <select x-model="dataSource">
                <option value="shipment">Shipment</option>
                <option value="last_modified">Last Modified</option>
                <option value="load_empty">Load empty fields from last modified</option>
            </select>

            <div style="margin-left: 20px; display: flex; align-items: center; gap: 6px;">
                <span style="font-weight: 700; color: #475569;">Piece:</span>
                <select x-model="currentPiece" @change="renderCurrentBarcode()">
                    <template x-for="p in totalPiecesCount" :key="p">
                        <option :value="p" x-text="p + ' of ' + totalPiecesCount"></option>
                    </template>
                </select>
            </div>
        </div>

        <div></div>
    </div>

    <!-- MAIN LABEL CONTAINER -->
    <div class="label-container">
        <!-- Section 1: Barcode -->
        <div class="label-section barcode-box">
            <svg id="label-barcode"></svg>
            <div class="barcode-num" x-text="formattedBarcodeValue"></div>
        </div>

        <!-- Section 2: AIR WAYBILL NO -->
        <div class="label-section">
            <div class="field-label">AIR WAYBILL NO</div>
            <div class="field-value-box large">{{ $mawbNo }}</div>
        </div>

        <!-- Section 3: DESTINATION & TOTAL NO OF PIECES -->
        <div class="label-section">
            <div class="grid-2col">
                <div>
                    <div class="field-label">DESTINATION</div>
                    <div class="field-value-box">{{ $destCode }}</div>
                </div>
                <div>
                    <div class="field-label">TOTAL NO OF PIECES</div>
                    <div class="field-value-box" x-text="totalPiecesCount"></div>
                </div>
            </div>
        </div>

        <!-- Section 4: NAME OF FORWARDER -->
        <div class="label-section">
            <div class="field-label">NAME OF FORWARDER</div>
            <div class="field-value-box">FREIGHTX</div>
        </div>

        <!-- Section 5: ORIGIN & AIR WAYBILL PC. -->
        <div class="label-section">
            <div class="grid-2col">
                <div>
                    <div class="field-label">ORIGIN</div>
                    <div class="field-value-box">{{ $originCode }}</div>
                </div>
                <div>
                    <div class="field-label">AIR WAYBILL PC.</div>
                    <div class="field-value-box" style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" checked style="width: 16px; height: 16px; accent-color: #0284c7;">
                        <span x-text="currentPiece" style="font-size: 18px;"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 6: Description Note Field -->
        <div class="label-section" style="padding: 8px 14px;">
            <input type="text" x-model="descriptionNote" @input.debounce.500ms="saveNote()" class="input-note-field" placeholder="Input more description here">
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('labelApp', () => ({
            dataSource: 'shipment',
            totalPiecesCount: {{ $totalPieces }},
            currentPiece: 1,
            rawMawb: '{{ $rawMawb }}',
            mawbNo: '{{ $mawbNo }}',
            shipmentId: {{ $shipment->id ?? 0 }},
            descriptionNote: '{{ addslashes($shipment->label_description ?? "") }}',

            get formattedBarcodeValue() {
                const suffix = String(this.currentPiece).padStart(5, '0');
                return this.rawMawb + suffix;
            },

            initBarcodes() {
                this.$nextTick(() => {
                    this.renderCurrentBarcode();
                });
            },

            saveNote() {
                if (!this.shipmentId) return;
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch(`/air-export/${this.shipmentId}/label-description`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ label_description: this.descriptionNote })
                }).then(res => res.json()).then(data => {
                    console.log('Saved to DB:', data);
                }).catch(err => console.error('Error saving note:', err));
            },

            renderCurrentBarcode() {
                const codeVal = this.formattedBarcodeValue;
                try {
                    JsBarcode("#label-barcode", codeVal, {
                        format: "CODE128",
                        lineColor: "#000",
                        width: 2.2,
                        height: 70,
                        displayValue: false,
                        margin: 0
                    });
                } catch(e) {
                    console.error("Barcode generation failed", e);
                }
            }
        }));
    });
</script>
</body>
</html>
