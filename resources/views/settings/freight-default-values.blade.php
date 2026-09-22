<x-layout>
    @push('styles')
    <x-list-styles />
    <style>
        /* Freight Default Value - Matching Ocean Import EXACTLY */
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
            letter-spacing: 0.5px;
        }
        
        .office-btns {
            display: flex;
            gap: 6px;
        }
        
        .office-btn {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 4px 12px;
            border-radius: 2px;
            cursor: pointer;
            font-size: 10px;
            font-weight: 600;
            transition: all 0.15s;
        }
        
        .office-btn.active {
            background: #fff;
            color: #67809f;
            border-color: #fff;
        }
        
        .freight-tabs {
            background: #f8fafc;
            border-bottom: 1px solid #cbd5e1;
            padding: 0 20px;
            display: flex;
            gap: 0;
        }
        
        .freight-tab {
            padding: 10px 18px;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.15s;
            color: #64748b;
            background: transparent;
        }
        
        .freight-tab:hover {
            color: #1e293b;
            background: #f1f5f9;
        }
        
        .freight-tab.active {
            color: #1e293b;
            font-weight: 700;
            border-bottom-color: #3b82f6;
            background: #fff;
        }
        
        .freight-section-title {
            font-size: 11px;
            font-weight: 600;
            color: #1e293b;
            padding: 8px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .freight-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
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
            border-right: 1px solid rgba(255,255,255,0.15);
            height: 28px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .freight-table thead th:last-child {
            border-right: none;
        }
        
        .freight-table tbody td {
            padding: 4px 6px;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            height: 26px;
            vertical-align: middle;
        }
        
        .freight-table tbody td:last-child {
            border-right: none;
        }
        
        .freight-table input,
        .freight-table select {
            width: 100%;
            height: 20px;
            padding: 2px 4px;
            border: 1px solid transparent;
            background: transparent;
            font-size: 10px;
            color: #334155;
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
            background: #f8fafc;
        }
        
        .freight-table tbody tr.unsaved {
            background: #fef3c7 !important;
        }
        
        .btn-add-freight {
            background: #3b82f6;
            color: #fff;
            border: 1px solid #2563eb;
            width: 22px;
            height: 22px;
            border-radius: 2px;
            cursor: pointer;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: all 0.15s;
        }
        
        .btn-add-freight:hover {
            background: #2563eb;
        }
        
        .btn-delete-row {
            color: #ef4444;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 12px;
            padding: 0;
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }
        
        .btn-delete-row:hover {
            color: #dc2626;
            transform: scale(1.15);
        }
        
        .empty-row {
            padding: 30px;
            text-align: center;
            color: #94a3b8;
            font-size: 10px;
            background: #f8fafc;
        }
        
        .save-footer {
            padding: 15px 20px;
            text-align: center;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        
        .btn-save-all {
            background: #3b82f6;
            color: #fff;
            border: 1px solid #2563eb;
            padding: 7px 24px;
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

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Delete Confirmation Modal --}}
    <div class="overlay" id="delete-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.35);z-index:9990;align-items:center;justify-content:center;">
        <div class="confirm-box">
            <div class="confirm-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <h4>Delete Freight Record?</h4>
            <p id="delete-msg">This action cannot be undone.</p>
            <div class="confirm-actions">
                <button class="btn-tool" style="padding:0 18px;height:26px;" onclick="closeDeleteConfirm()">Cancel</button>
                <button class="btn-tool danger" style="padding:0 18px;height:26px;" onclick="executeDeleteRow()">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- Toast Container --}}
    <div class="toast-container" id="toast-container"></div>

    <div class="page-content">
        
        {{-- Breadcrumb - EXACT Ocean Import style --}}
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
                <li><a href="/settings">Settings</a> <i class="fa fa-angle-right"></i></li>
                <li><span style="color:#333;font-weight:700;">Freight Default Value</span></li>
            </ul>
        </div>

        <div class="portlet light">
            
            {{-- Header with Office/NEO --}}
            <div class="freight-header">
                <h4>Freight Default Value Setting</h4>
                <div class="office-btns">
                    <button class="office-btn active" id="btn-office" onclick="switchOffice('Office')">Office</button>
                    <button class="office-btn" id="btn-neo" onclick="switchOffice('NEO')">NEO</button>
                </div>
            </div>

            {{-- Module Tabs --}}
            <div class="freight-tabs">
                <div class="freight-tab active" data-module="ocean-import" onclick="switchModule('ocean-import')">Ocean Import</div>
                <div class="freight-tab" data-module="ocean-export" onclick="switchModule('ocean-export')">Ocean Export / Booking</div>
                <div class="freight-tab" data-module="air-import" onclick="switchModule('air-import')">Air Import</div>
                <div class="freight-tab" data-module="air-export" onclick="switchModule('air-export')">Air Export</div>
            </div>

            {{-- Content --}}
            <div class="portlet-body">
                
                {{-- Invoice Section --}}
                <div class="freight-section-title">Invoice (A/R) Default</div>
                <table class="freight-table">
                    <thead>
                        <tr>
                            <th style="width:30px;"><button class="btn-add-freight" onclick="addRow('invoice')"><i class="fa fa-plus"></i></button></th>
                            <th style="width:30px;text-align:center;"><i class="fa fa-trash"></i></th>
                            <th style="width:120px;" class="col-sm">SHIP MODE</th>
                            <th style="width:150px;">FREIGHT CODE</th>
                            <th style="width:100px;" class="col-pc">P/C</th>
                            <th style="width:120px;">TYPE</th>
                            <th style="width:100px;">UNIT</th>
                            <th style="width:80px;">CUR.</th>
                            <th style="width:80px;">VOL.</th>
                            <th style="width:80px;">RATE</th>
                            <th style="width:100px;">AMOUNT</th>
                            <th style="width:120px;">AGENT AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-invoice">
                        <tr><td colspan="12" class="empty-row">No Data Available. Please click <strong>here</strong> to add a new row.</td></tr>
                    </tbody>
                </table>

                {{-- AP Section --}}
                <div class="freight-section-title">AP Default</div>
                <table class="freight-table">
                    <thead>
                        <tr>
                            <th style="width:30px;"><button class="btn-add-freight" onclick="addRow('ap')"><i class="fa fa-plus"></i></button></th>
                            <th style="width:30px;text-align:center;"><i class="fa fa-trash"></i></th>
                            <th style="width:120px;" class="col-sm">SHIP MODE</th>
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
                    <tbody id="tbody-ap">
                        <tr><td colspan="11" class="empty-row">No Data Available. Please click <strong>here</strong> to add a new row.</td></tr>
                    </tbody>
                </table>

                {{-- D/C Note Section --}}
                <div class="freight-section-title">D/C Note Default</div>
                <table class="freight-table">
                    <thead>
                        <tr>
                            <th style="width:30px;"><button class="btn-add-freight" onclick="addRow('dc_note')"><i class="fa fa-plus"></i></button></th>
                            <th style="width:30px;text-align:center;"><i class="fa fa-trash"></i></th>
                            <th style="width:120px;" class="col-sm">SHIP MODE</th>
                            <th style="width:150px;">FREIGHT CODE</th>
                            <th style="width:100px;" class="col-pc">P/C</th>
                            <th style="width:120px;">TYPE</th>
                            <th style="width:100px;">UNIT</th>
                            <th style="width:80px;">CUR.</th>
                            <th style="width:80px;">VOL.</th>
                            <th style="width:80px;">RATE</th>
                            <th style="width:100px;">AMOUNT</th>
                            <th style="width:120px;">AGENT AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-dc">
                        <tr><td colspan="12" class="empty-row">No Data Available. Please click <strong>here</strong> to add a new row.</td></tr>
                    </tbody>
                </table>

            </div>

            {{-- Save Button --}}
            <div class="save-footer">
                <button class="btn-save-all" id="btn-save" onclick="saveAll()"><i class="fa fa-save"></i> Save</button>
            </div>

        </div>
    </div>

    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentOffice = 'Office';
    let currentModule = 'ocean-import';
    let unsavedRows = new Set();

    document.addEventListener('DOMContentLoaded', () => {
        loadData();
        updateColumns();
    });

    function switchOffice(type) {
        if (unsavedRows.size > 0 && !confirm('You have unsaved changes. Continue?')) return;
        currentOffice = type;
        document.getElementById('btn-office').classList.toggle('active', type === 'Office');
        document.getElementById('btn-neo').classList.toggle('active', type === 'NEO');
        loadData(); // Silent reload, no toast
    }

    function switchModule(module) {
        if (unsavedRows.size > 0 && !confirm('You have unsaved changes. Continue?')) return;
        currentModule = module;
        document.querySelectorAll('.freight-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.module === module);
        });
        updateColumns();
        loadData();
    }

    function updateColumns() {
        const showSM = currentModule.includes('ocean');
        document.querySelectorAll('.col-sm').forEach(el => el.style.display = showSM ? '' : 'none');
        document.querySelectorAll('.cell-sm').forEach(el => el.style.display = showSM ? '' : 'none');
    }

    function loadData() {
        fetch(`/api/freight-default-values/module?office_type=${currentOffice}&module=${currentModule}`, {
            headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken}
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                render('invoice', data.data.invoice || []);
                render('ap', data.data.ap || []);
                render('dc_note', data.data.dc_note || []);
                unsavedRows.clear();
                updateBtn();
                // No toast on load - silent loading
            }
        })
        .catch(err => {
            console.error('Failed to load data:', err);
            // Only show toast on error
            showToast('error', 'Failed to load data');
        });
    }

    function render(sec, items) {
        const tbody = document.getElementById('tbody-' + (sec === 'dc_note' ? 'dc' : sec));
        const showSM = currentModule.includes('ocean');
        const showPC = sec !== 'ap';
        
        if (items.length === 0) {
            const cs = (showSM ? 1 : 0) + (showPC ? 1 : 0) + 10;
            tbody.innerHTML = `<tr><td colspan="${cs}" class="empty-row">No Data Available. Please click <strong>here</strong> to add a new row.</td></tr>`;
            return;
        }
        
        tbody.innerHTML = '';
        items.forEach(item => tbody.appendChild(createRow(sec, item)));
    }

    function createRow(sec, data = {}) {
        const tr = document.createElement('tr');
        tr.dataset.id = data.id || '';
        tr.dataset.section = sec;
        
        const showSM = currentModule.includes('ocean');
        const showPC = sec !== 'ap';
        
        // Empty cell for + button column
        let html = '<td></td>';
        
        // Delete button
        html += `<td style="text-align:center;">
            <button class="btn-delete-row" onclick="confirmDeleteRow(this)" title="Delete row">
                <i class="fa fa-trash"></i>
            </button>
        </td>`;
        
        if (showSM) {
            html += `<td class="cell-sm"><input type="text" value="${data.ship_mode||''}" data-field="ship_mode" onchange="mark(this)"></td>`;
        }
        
        html += `<td><input type="text" value="${data.freight_code||''}" data-field="freight_code" onchange="mark(this)"></td>`;
        
        if (showPC) {
            html += `<td class="cell-pc"><select data-field="pc" onchange="mark(this)">
                <option value=""></option>
                <option value="PREPAID" ${data.pc==='PREPAID'?'selected':''}>PREPAID</option>
                <option value="COLLECT" ${data.pc==='COLLECT'?'selected':''}>COLLECT</option>
            </select></td>`;
        }
        
        html += `<td><input type="text" value="${data.type||''}" data-field="type" onchange="mark(this)"></td>`;
        html += `<td><select data-field="unit" onchange="mark(this)">
            <option value=""></option>
            <option value="UNIT" ${data.unit==='UNIT'?'selected':''}>UNIT</option>
            <option value="BL" ${data.unit==='BL'?'selected':''}>BL</option>
            <option value="CBM" ${data.unit==='CBM'?'selected':''}>CBM</option>
            <option value="KG" ${data.unit==='KG'?'selected':''}>KG</option>
        </select></td>`;
        html += `<td><select data-field="currency" onchange="mark(this)">
            <option value=""></option>
            <option value="USD" ${data.currency==='USD'?'selected':''}>USD</option>
            <option value="EUR" ${data.currency==='EUR'?'selected':''}>EUR</option>
            <option value="CNY" ${data.currency==='CNY'?'selected':''}>CNY</option>
        </select></td>`;
        html += `<td><input type="number" step="0.01" value="${data.volume||''}" data-field="volume" onchange="mark(this)"></td>`;
        html += `<td><input type="number" step="0.01" value="${data.rate||''}" data-field="rate" onchange="mark(this)"></td>`;
        html += `<td><input type="number" step="0.01" value="${data.amount||''}" data-field="amount" onchange="mark(this)"></td>`;
        html += `<td><input type="number" step="0.01" value="${data.agent_amount||''}" data-field="agent_amount" onchange="mark(this)"></td>`;
        
        tr.innerHTML = html;
        return tr;
    }

    function addRow(sec) {
        const tbody = document.getElementById('tbody-' + (sec === 'dc_note' ? 'dc' : sec));
        const empty = tbody.querySelector('.empty-row');
        if (empty) empty.parentElement.remove();
        
        const tr = createRow(sec);
        tr.classList.add('unsaved');
        tbody.appendChild(tr);
        unsavedRows.add('new-' + Date.now());
        updateBtn();
    }

    function mark(input) {
        const tr = input.closest('tr');
        tr.classList.add('unsaved');
        unsavedRows.add(tr.dataset.id || 'new-' + Date.now());
        updateBtn();
    }

    function updateBtn() {
        const btn = document.getElementById('btn-save');
        btn.disabled = unsavedRows.size === 0;
        btn.innerHTML = unsavedRows.size > 0 ? `<i class="fa fa-save"></i> Save (${unsavedRows.size})` : '<i class="fa fa-check"></i> Saved';
    }

    function saveAll() {
        if (unsavedRows.size === 0) return;
        
        const items = [];
        document.querySelectorAll('tr.unsaved').forEach(tr => {
            const item = {
                office_type: currentOffice,
                module: currentModule,
                section: tr.dataset.section,
                id: tr.dataset.id || null
            };
            tr.querySelectorAll('[data-field]').forEach(inp => {
                item[inp.dataset.field] = inp.value;
            });
            items.push(item);
        });
        
        fetch('/api/freight-default-values/bulk-save', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken},
            body: JSON.stringify({items})
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message || 'Saved');
                loadData();
            } else {
                showToast('error', data.message || 'Failed');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('error', 'Network error');
        });
    }

    function showToast(type, msg) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast ' + type;
        toast.innerHTML = '<i class="fa fa-'+(type==='success'?'check-circle':'exclamation-circle')+'"></i> ' + msg;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Delete functionality
    let rowToDelete = null;

    function confirmDeleteRow(btn) {
        rowToDelete = btn.closest('tr');
        const overlay = document.getElementById('delete-overlay');
        overlay.style.display = 'flex';
    }

    function closeDeleteConfirm() {
        rowToDelete = null;
        document.getElementById('delete-overlay').style.display = 'none';
    }

    function executeDeleteRow() {
        if (!rowToDelete) return;
        
        const id = rowToDelete.dataset.id;
        
        // If it's a new unsaved row (no id), just remove it
        if (!id) {
            rowToDelete.remove();
            closeDeleteConfirm();
            showToast('success', 'Row removed');
            checkEmptyTable(rowToDelete.dataset.section);
            return;
        }
        
        // If it has an id, delete from database
        fetch(`/api/freight-default-values/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const section = rowToDelete.dataset.section;
                rowToDelete.remove();
                showToast('success', data.message || 'Deleted successfully');
                checkEmptyTable(section);
                unsavedRows.delete(id);
                updateBtn();
            } else {
                showToast('error', data.message || 'Failed to delete');
            }
            closeDeleteConfirm();
        })
        .catch(err => {
            console.error('Delete error:', err);
            showToast('error', 'Failed to delete');
            closeDeleteConfirm();
        });
    }

    function checkEmptyTable(sec) {
        const tbody = document.getElementById('tbody-' + (sec === 'dc_note' ? 'dc' : sec));
        const rows = tbody.querySelectorAll('tr:not(.empty-row)');
        
        if (rows.length === 0) {
            const showSM = currentModule.includes('ocean');
            const showPC = sec !== 'ap';
            const cs = (showSM ? 1 : 0) + (showPC ? 1 : 0) + 10;
            tbody.innerHTML = `<tr><td colspan="${cs}" class="empty-row">No Data Available. Please click <strong>here</strong> to add a new row.</td></tr>`;
        }
    }
    </script>

</x-layout>
