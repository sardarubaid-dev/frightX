<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HBL Print - {{ $shipment->file_no ?? 'MOE-EXPORT' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            background: #525659;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        /* Top Header Bar */
        .top-bar {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            height: 46px;
            background: #323639;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }

        .bar-left, .bar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .bar-center {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bar-btn {
            background: #2563eb;
            border: none;
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            cursor: pointer;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.15s ease-in-out;
        }
        .bar-btn:hover {
            background: #1d4ed8;
        }
        .bar-btn.white-btn {
            background: rgba(255,255,255,0.1);
            color: #f1f1f1;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .bar-btn.white-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .dropdown-label {
            color: #9ca3af;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hbl-select {
            background: #fff;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            outline: none;
            cursor: pointer;
            min-width: 140px;
        }

        /* Document Container */
        .doc-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 15px;
            gap: 30px;
        }

        /* Editing indicator banner */
        .edit-banner {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #b45309;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 820px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Interactive HBL Page Container */
        .hbl-page-container {
            background: #ffffff !important;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
            margin: 0 auto;
        }

        /* Print Overrides */
        @media print {
            body {
                background: #ffffff !important;
                color: #000 !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .top-bar, .edit-banner {
                display: none !important;
            }
            .doc-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                gap: 0 !important;
                display: block !important;
            }
            .hbl-page-container {
                box-shadow: none !important;
                margin: 0 !important;
                page-break-before: always !important;
                break-before: page !important;
                page-break-after: always !important;
                break-after: page !important;
                width: 100% !important;
            }
            .hbl-page-container:first-child {
                page-break-before: avoid !important;
                break-before: avoid !important;
            }
            @page {
                size: portrait;
                margin: 0;
            }
        }
    </style>
    
    {{-- Dynamic CSS Overrides tag --}}
    <style id="dynamic-template-css"></style>
</head>
<body x-data="batchPrintApp()">

    <!-- Top Header Bar -->
    <header class="top-bar">
        <div class="bar-left">
            <button class="bar-btn white-btn" onclick="window.close()">
                <i class="fa fa-arrow-left"></i> Back to Shipment
            </button>
            <div style="color: #fff; font-size:12px; font-weight:700;">
                Ocean Export File: <span style="color:#60a5fa;">{{ $shipment->file_no }}</span>
            </div>
        </div>

        <div class="bar-center">
            @if($shipment->hbls->count() > 0)
                <span class="dropdown-label">House B/L:</span>
                <select class="hbl-select" x-model="selectedHblId" @change="fetchHblContent(false)">
                    @foreach($shipment->hbls as $hbl)
                        <option value="{{ $hbl->id }}">{{ $hbl->hbl_no }}</option>
                    @endforeach
                </select>

                <span class="dropdown-label" style="margin-left: 10px;">HBL Layout Type:</span>
                <select class="hbl-select" x-model="selectedTemplateId" @change="fetchHblContent(true)">
                    @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}">{{ $tpl->name }}</option>
                    @endforeach
                </select>
            @else
                <span style="color:#ef4444; font-weight:700;">NO HOUSE B/L RECORD CREATED YET</span>
            @endif
        </div>

        <div class="bar-right">
            <button class="bar-btn" @click="printDoc()" :disabled="!selectedHblId">
                <i class="fa fa-print"></i> Print Document
            </button>
        </div>
    </header>

    <!-- Document Container -->
    <main class="doc-wrapper">
        <!-- Dynamic Editing Notification -->
        <div class="edit-banner">
            <i class="fa fa-pencil" style="font-size:14px;"></i>
            <div>
                <strong>Interactive View:</strong> All text contents are inline editable. Click anywhere in the HBL structure below to customize dates, remarks, weights, or names before sending to the printer.
            </div>
        </div>

        <!-- Rendered Dynamic Layout content editable -->
        <div id="render-target" x-html="renderedHtml" contenteditable="true" style="outline:none; width: 100%; display: flex; flex-direction: column; align-items: center; gap: 30px;">
            <div style="padding: 100px 0; text-align: center; color: #fff;">
                <i class="fa fa-spinner fa-spin" style="font-size: 28px; margin-bottom: 10px;"></i>
                <div>Generating HBL layout...</div>
            </div>
        </div>
    </main>

    <script>
        function batchPrintApp() {
            return {
                shipmentId: "{{ $shipment->id }}",
                selectedHblId: (new URLSearchParams(window.location.search)).get('hbl_id') || "{{ $shipment->hbls->first()?->id ?? '' }}",
                selectedTemplateId: "",
                renderedHtml: "",
                isRendering: false,

                init() {
                    // Match templates mapping
                    const hblsMap = {
                        @foreach($shipment->hbls as $hbl)
                            "{{ $hbl->id }}": "{{ $hbl->hbl_template_id ?? '' }}",
                        @endforeach
                    };

                    const currentHblTplId = hblsMap[this.selectedHblId];
                    if (currentHblTplId && currentHblTplId !== '') {
                        this.selectedTemplateId = currentHblTplId;
                    } else {
                        this.selectedTemplateId = "{{ $templates->first()?->id ?? '' }}";
                    }

                    this.$watch('selectedHblId', (newVal) => {
                        const tplId = hblsMap[newVal];
                        if (tplId && tplId !== '') {
                            this.selectedTemplateId = tplId;
                        }
                    });

                    this.fetchHblContent(false);
                },

                async fetchHblContent(saveSelection = false) {
                    if (!this.selectedHblId) return;
                    this.isRendering = true;
                    
                    try {
                        let url = `/api/ocean-export/${this.shipmentId}/hbl/${this.selectedHblId}/render`;
                        if (this.selectedTemplateId) {
                            url += `?template_id=${this.selectedTemplateId}`;
                        }

                        const response = await fetch(url);
                        const data = await response.json();
                        
                        if (data.html) {
                            this.renderedHtml = data.html;
                            
                            // Inject CSS overrides dynamically
                            const cssTag = document.getElementById('dynamic-template-css');
                            if (cssTag) {
                                cssTag.textContent = data.css || '';
                            }

                            if (data.template_id && !this.selectedTemplateId) {
                                this.selectedTemplateId = data.template_id;
                            }

                            if (saveSelection) {
                                this.saveTemplateSelection();
                            }
                        } else {
                            this.renderedHtml = `<div style="padding:40px;text-align:center;color:#ef4444;font-weight:bold;">Error rendering layout.</div>`;
                        }
                    } catch (error) {
                        this.renderedHtml = `<div style="padding:40px;text-align:center;color:#ef4444;font-weight:bold;">Connection failure. Failed to build HBL preview.</div>`;
                    } finally {
                        this.isRendering = false;
                    }
                },

                async saveTemplateSelection() {
                    try {
                        const response = await fetch(`/api/ocean-export/hbl/${this.selectedHblId}/save-template`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ template_id: this.selectedTemplateId })
                        });
                        const data = await response.json();
                        if (data.success) {
                            console.log("HBL template configuration updated: HBL ID " + this.selectedHblId + " -> Template ID " + this.selectedTemplateId);
                        }
                    } catch (error) {
                        console.error("Save template error:", error);
                    }
                },

                printDoc() {
                    window.print();
                }
            }
        }
    </script>
</body>
</html>
