<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('styles')
    <x-list-styles />
    <style>
        /* Freight Default Value Specific Styles */
        .freight-header {
            background: #67809f;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #5a6d84;
        }
        
        .freight-header h4 {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        
        .office-toggle {
            display: flex;
            gap: 6px;
        }
        
        .office-toggle-btn {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 4px 14px;
            border-radius: 2px;
            cursor: pointer;
            font-size: 10px;
            font-weight: 600;
            transition: all 0.15s;
        }
        
        .office-toggle-btn:hover {
            background: rgba(255,255,255,0.25);
        }
        
        .office-toggle-btn.active {
            background: #fff;
            color: #67809f;
            border-color: #fff;
        }
        
        /* Module tabs - matching Ocean Import exactly */
        .module-tabs {
            background: #f8fafc;
            border-bottom: 1px solid #cbd5e1;
            padding: 0 20px;
            display: flex;
            gap: 0;
        }
        
        .module-tab {
            padding: 10px 20px;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.15s;
            color: #64748b;
            background: transparent;
        }
        
        .module-tab:hover {
            color: #1e293b;
            background: #f1f5f9;
        }
        
        .module-tab.active {
            color: #1e293b;
            font-weight: 700;
            border-bottom-color: #3b82f6;
            background: #fff;
        }
        
        /* Section styling - matching exactly */
        .freight-section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
            padding: 10px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        /* Table styling - EXACT Ocean Import match */
        .freight-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            font-size: 10px;
        }
        
        .freight-table thead th {
            background: #67809f;
            color: #fff;
            padding: 6px 8px;
            font-size: 10px;
            font-weight: 600;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-right: 1px solid rgba(255,255,255,0.1);
            height: 28px;
        }
        
        .freight-table thead th:last-child {
            border-right: none;
        }
        
        .freight-table tbody td {
            padding: 4px 6px;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            font-size: 10px;
            height: 26px;
            vertical-align: middle;
        }
        
        .freight-table tbody td:last-child {
            border-right: none;
        }
        
        .freight-table input[type="text"],
        .freight-table input[type="number"],
        .freight-table select {
            width: 100%;
            padding: 3px 6px;
            border: 1px solid transparent;
            background: transparent;
            font-size: 10px;
            height: 20px;
        }
        
        .freight-table input:focus,
        .freight-table select:focus {
            border-color: #3b82f6;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 1px rgba(59,130,246,0.1);
        }
        
        .freight-table tbody tr {
            transition: background 0.15s;
        }
        
        .freight-table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .freight-table tbody tr.unsaved {
            background-color: #fef3c7 !important;
        }
        
        /* Add button - matching exactly */
        .btn-add-row {
            background: #3b82f6;
            color: #fff;
            border: 1px solid #2563eb;
            width: 22px;
            height: 22px;
            border-radius: 2px;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            padding: 0;
        }
        
        .btn-add-row:hover {
            background: #2563eb;
        }
        
        /* Empty state */
        .empty-state {
            padding: 30px 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 10px;
            background: #f8fafc;
        }
        
        /* Save button - matching Ocean Import */
        .save-container {
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        
        .btn-save-all {
            background: #3b82f6;
            color: #fff;
            border: 1px solid #2563eb;
            padding: 8px 30px;
            border-radius: 2px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }
        
        .btn-save-all:hover {
            background: #2563eb;
        }
        
        .btn-save-all:disabled {
            background: #cbd5e0;
            border-color: #cbd5e0;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
    @endpush

    {{-- Toast Container --}}
    <div class="toast-container" id="toast-container"></div>

    <!-- Page Content -->
    <div class="page-content">
        <div class="portlet light" style="margin-top:0;border-radius:0;">
            
            {{-- HEADER with Office/NEO Toggle --}}
            <div class="freight-header">
                <h4>Freight Default Value Setting</h4>
                <div class="office-toggle">
                    <button class="office-toggle-btn active" id="btn-office" onclick="switchOffice('Office')">Office</button>
                    <button class="office-toggle-btn" id="btn-neo" onclick="switchOffice('NEO')">NEO</button>
                </div>
            </div>

            {{-- MODULE TABS --}}
            <div class="module-tabs">
                <div class="module-tab active" data-module="ocean-import" onclick="switchModule('ocean-import')">
                    Ocean Import
                </div>
                <div class="module-tab" data-module="ocean-export" onclick="switchModule('ocean-export')">
                    Ocean Export / Booking
                </div>
                <div class="module-tab" data-module="air-import" onclick="switchModule('air-import')">
                    Air Import
                </div>
                <div class="module-tab" data-module="air-export" onclick="switchModule('air-export')">
                    Air Export
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="portlet-body">
                {{-- Invoice (A/R) Default Section --}}
                <div class="freight-section">
                    <div class="section-title">Invoice (A/R) Default</div>
                    <table class="freight-table" id="invoice-table">
                        <thead>
                            <tr>
                                <th style="width:30px;">
                                    <button class="btn-add-row" onclick="addRow('invoice')" title="Add row">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>
                                <th style="width:30px;text-align:center;"><input type="checkbox" id="check-invoice-all" onchange="toggleAllChecks('invoice', this.checked)"></th>
                                <th style="width:120px;" class="ship-mode-col">SHIP MODE</th>
                                <th style="width:150px;">FREIGHT CODE</th>
                                <th style="width:100px;" class="pc-col">P/C</th>
                                <th style="width:120px;">TYPE</th>
                                <th style="width:100px;">UNIT</th>
                                <th style="width:80px;">CUR.</th>
                                <th style="width:80px;">VOL.</th>
                                <th style="width:80px;">RATE</th>
                                <th style="width:100px;">AMOUNT</th>
                                <th style="width:120px;">AGENT AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-body">
                            <tr>
                                <td colspan="12" class="empty-state">
                                    No Data Available. Please click <strong>here</strong> to add a new row.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            {{-- AP Default Section --}}
            <div class="freight-section">
                <div class="section-title">AP Default</div>
                <table class="freight-table" id="ap-table">
                    <thead>
                        <tr>
                            <th style="width:30px;">
                                <button class="btn-add-row" onclick="addRow('ap')" title="Add row">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                            <th style="width:30px;text-align:center;"><input type="checkbox" id="check-ap-all" onchange="toggleAllChecks('ap', this.checked)"></th>
                            <th style="width:120px;" class="ship-mode-col">SHIP MODE</th>
                            <th style="width:150px;">FREIGHT CODE</th>
                            <th style="width:120px;">TYPE</th>
                            <th style="width:100px;">UNIT</th>
                            <th style="width:80px;">CUR.</th>
                            <th style="width:80px;">VOL.</th>
                            <th style="width:80px;">RATE</th>
                            <th style="width:100px;">AMOUNT</th>
                            <th style="width:120px;">AGENT AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody id="ap-body">
                        <tr>
                            <td colspan="11" class="empty-state">
                                No Data Available. Please click <strong>here</strong> to add a new row.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- D/C Note Default Section --}}
            <div class="freight-section">
                <div class="section-title">D/C Note Default</div>
                <table class="freight-table" id="dc-table">
                    <thead>
                        <tr>
                            <th style="width:30px;">
                                <button class="btn-add-row" onclick="addRow('dc_note')" title="Add row">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                            <th style="width:30px;text-align:center;"><input type="checkbox" id="check-dc-all" onchange="toggleAllChecks('dc_note', this.checked)"></th>
                            <th style="width:120px;" class="ship-mode-col">SHIP MODE</th>
                            <th style="width:150px;">FREIGHT CODE</th>
                            <th style="width:100px;" class="pc-col">P/C</th>
                            <th style="width:120px;">TYPE</th>
                            <th style="width:100px;">UNIT</th>
                            <th style="width:80px;">CUR.</th>
                            <th style="width:80px;">VOL.</th>
                            <th style="width:80px;">RATE</th>
                            <th style="width:100px;">AMOUNT</th>
                            <th style="width:120px;">AGENT AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody id="dc-body">
                        <tr>
                            <td colspan="12" class="empty-state">
                                No Data Available. Please click <strong>here</strong> to add a new row.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>

            {{-- SAVE BUTTON --}}
            <div class="save-container">
                <button class="btn-save-all" id="btn-save" onclick="saveAll()">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>

        </div>
    </div>

    <script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // State
    let currentOffice = 'Office';
    let currentModule = 'ocean-import';
    let unsavedChanges = new Set();
    
    // Data storage
    let invoiceData = [];
    let apData = [];
    let dcData = [];
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadModuleData();
        updateShipModeColumns();
    });

    // Switch Office/NEO
    function switchOffice(type) {
        currentOffice = type;
        
        // Update button states
        document.getElementById('btn-office').classList.toggle('active', type === 'Office');
        document.getElementById('btn-neo').classList.toggle('active', type === 'NEO');
        
        // Reload data
        loadModuleData();
    }

    // Switch Module Tab
    function switchModule(module) {
        // Save confirmation if unsaved
        if (unsavedChanges.size > 0) {
            if (!confirm('You have unsaved changes. Continue anyway?')) {
                return;
            }
        }
        
        currentModule = module;
        
        // Update tab states
        document.querySelectorAll('.module-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.module === module);
        });
        
        // Update Ship Mode column visibility
        updateShipModeColumns();
        
        // Reload data
        loadModuleData();
    }

    // Update Ship Mode column visibility
    function updateShipModeColumns() {
        const showShipMode = currentModule.includes('ocean');
        const shipModeCols = document.querySelectorAll('.ship-mode-col');
        
        shipModeCols.forEach(col => {
            col.style.display = showShipMode ? '' : 'none';
        });
        
        // Also update existing rows
        document.querySelectorAll('.ship-mode-cell').forEach(cell => {
            cell.style.display = showShipMode ? '' : 'none';
        });
    }

    // Load data for current module
    function loadModuleData() {
        fetch(`/api/freight-default-values/module?office_type=${currentOffice}&module=${currentModule}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                invoiceData = data.data.invoice || [];
                apData = data.data.ap || [];
                dcData = data.data.dc_note || [];
                
                renderSection('invoice', invoiceData);
                renderSection('ap', apData);
                renderSection('dc_note', dcData);
                
                unsavedChanges.clear();
                updateSaveButton();
            }
        })
        .catch(error => {
            console.error('Load error:', error);
        });
    }

    // Render section table
    function renderSection(section, data) {
        const bodyId = section === 'dc_note' ? 'dc-body' : section + '-body';
        const tbody = document.getElementById(bodyId);
        const showShipMode = currentModule.includes('ocean');
        const showPC = section !== 'ap';
        
        if (!data || data.length === 0) {
            const colspan = section === 'ap' ? (showShipMode ? 11 : 10) : (showShipMode ? 12 : 11);
            tbody.innerHTML = `<tr><td colspan="${colspan}" class="empty-state">No Data Available. Please click <strong>here</strong> to add a new row.</td></tr>`;
            return;
        }
        
        tbody.innerHTML = '';
        data.forEach((item, index) => {
            const row = createRow(section, item, index);
            tbody.appendChild(row);
        });
    }

    // Create table row
    function createRow(section, data = {}, index = 0) {
        const tr = document.createElement('tr');
        tr.dataset.section = section;
        tr.dataset.id = data.id || '';
        tr.dataset.index = index;
        
        const showShipMode = currentModule.includes('ocean');
        const showPC = section !== 'ap';
        
        let html = '<td></td>'; // Empty for + button column
        html += `<td style="text-align:center;"><input type="checkbox" class="row-checkbox"></td>`;
        
        if (showShipMode) {
            html += `<td class="ship-mode-cell"><input type="text" value="${data.ship_mode || ''}" data-field="ship_mode" onchange="markUnsaved(this)" placeholder=""></td>`;
        }
        
        html += `<td><input type="text" value="${data.freight_code || ''}" data-field="freight_code" onchange="markUnsaved(this)" placeholder=""></td>`;
        
        if (showPC) {
            html += `<td class="pc-cell">
                <select data-field="pc" onchange="markUnsaved(this)">
                    <option value=""></option>
                    <option value="PREPAID" ${data.pc === 'PREPAID' ? 'selected' : ''}>PREPAID</option>
                    <option value="COLLECT" ${data.pc === 'COLLECT' ? 'selected' : ''}>COLLECT</option>
                </select>
            </td>`;
        }
        
        html += `<td><input type="text" value="${data.type || ''}" data-field="type" onchange="markUnsaved(this)" placeholder=""></td>`;
        html += `<td>
            <select data-field="unit" onchange="markUnsaved(this)">
                <option value=""></option>
                <option value="UNIT" ${data.unit === 'UNIT' ? 'selected' : ''}>UNIT</option>
                <option value="BL" ${data.unit === 'BL' ? 'selected' : ''}>BL</option>
                <option value="CBM" ${data.unit === 'CBM' ? 'selected' : ''}>CBM</option>
                <option value="KG" ${data.unit === 'KG' ? 'selected' : ''}>KG</option>
            </select>
        </td>`;
        html += `<td>
            <select data-field="currency" onchange="markUnsaved(this)">
                <option value=""></option>
                <option value="USD" ${data.currency === 'USD' ? 'selected' : ''}>USD</option>
                <option value="EUR" ${data.currency === 'EUR' ? 'selected' : ''}>EUR</option>
                <option value="CNY" ${data.currency === 'CNY' ? 'selected' : ''}>CNY</option>
            </select>
        </td>`;
        html += `<td><input type="number" step="0.01" value="${data.volume || ''}" data-field="volume" onchange="markUnsaved(this)" placeholder=""></td>`;
        html += `<td><input type="number" step="0.01" value="${data.rate || ''}" data-field="rate" onchange="markUnsaved(this)" placeholder=""></td>`;
        html += `<td><input type="number" step="0.01" value="${data.amount || ''}" data-field="amount" onchange="markUnsaved(this)" placeholder=""></td>`;
        html += `<td><input type="number" step="0.01" value="${data.agent_amount || ''}" data-field="agent_amount" onchange="markUnsaved(this)" placeholder=""></td>`;
        
        tr.innerHTML = html;
        return tr;
    }

    // Add new row
    function addRow(section) {
        const bodyId = section === 'dc_note' ? 'dc-body' : section + '-body';
        const tbody = document.getElementById(bodyId);
        
        // Remove empty state if exists
        const emptyRow = tbody.querySelector('.empty-state');
        if (emptyRow) {
            emptyRow.parentElement.remove();
        }
        
        const newRow = createRow(section, {}, tbody.children.length);
        newRow.classList.add('unsaved');
        tbody.appendChild(newRow);
        
        // Mark as unsaved
        unsavedChanges.add(section);
        updateSaveButton();
        
        showToast('info', 'New row added. Don\'t forget to save!');
    }

    // Mark row as unsaved
    function markUnsaved(input) {
        const row = input.closest('tr');
        row.classList.add('unsaved');
        unsavedChanges.add(row.dataset.section);
        updateSaveButton();
    }

    // Toggle all checkboxes
    function toggleAllChecks(section, checked) {
        const bodyId = section === 'dc_note' ? 'dc-body' : section + '-body';
        const checkboxes = document.querySelectorAll(`#${bodyId} .row-checkbox`);
        checkboxes.forEach(cb => cb.checked = checked);
    }

    // Update save button state
    function updateSaveButton() {
        const btn = document.getElementById('btn-save');
        if (unsavedChanges.size > 0) {
            btn.innerHTML = '<i class="fa fa-save"></i> Save (' + unsavedChanges.size + ' section' + (unsavedChanges.size > 1 ? 's' : '') + ')';
        } else {
            btn.innerHTML = '<i class="fa fa-check"></i> All Saved';
        }
    }

    // Save all changes
    function saveAll() {
        if (unsavedChanges.size === 0) {
            showToast('info', 'No changes to save');
            return;
        }
        
        showToast('info', 'Saving changes...');
        
        const items = [];
        
        // Collect all unsaved rows
        document.querySelectorAll('tr.unsaved').forEach(row => {
            const section = row.dataset.section;
            const id = row.dataset.id;
            
            const item = {
                office_type: currentOffice,
                module: currentModule,
                section: section,
                id: id || null
            };
            
            // Get all field values
            row.querySelectorAll('[data-field]').forEach(input => {
                const field = input.dataset.field;
                item[field] = input.value;
            });
            
            items.push(item);
        });
        
        // Send to server
        fetch('/api/freight-default-values/bulk-save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message);
                unsavedChanges.clear();
                updateSaveButton();
                
                // Remove unsaved class from rows
                document.querySelectorAll('tr.unsaved').forEach(row => {
                    row.classList.remove('unsaved');
                });
                
                // Reload to get IDs for new rows
                loadModuleData();
            } else {
                showToast('error', data.message || 'Failed to save');
            }
        })
        .catch(error => {
            console.error('Save error:', error);
            showToast('error', 'Network error while saving');
        });
    }

    // Toast notifications
    function showToast(type, message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast ' + type;
        
        const icon = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        
        toast.innerHTML = '<i class="fa ' + icon + '"></i> ' + message;
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    </script>

</x-layout>
