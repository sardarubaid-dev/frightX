<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('styles')
    <x-list-styles />
    <style>
        .page-bar {
            background-color: #fff;
            padding: 10px 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ebec;
            border-radius: 4px;
        }
        
        .page-breadcrumb {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .page-breadcrumb li {
            font-size: 13px;
            color: #888;
            display: flex;
            align-items: center;
        }
        
        .page-breadcrumb li a {
            color: #337ab7;
            text-decoration: none;
        }
        
        .page-breadcrumb li a:hover {
            color: #1d4ed8;
        }
        
        .page-breadcrumb li i {
            margin: 0 10px;
            font-size: 11px;
            opacity: 0.5;
        }
        
        .input-inline {
            font-size: 11px;
            padding: 6px 10px;
            height: 28px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            transition: border-color 0.2s;
        }
        
        .input-inline:focus {
            outline: none;
            border-color: #32c5d2;
            box-shadow: 0 0 0 3px rgba(50, 197, 210, 0.1);
        }
        
        .select-inline {
            font-size: 11px;
            padding: 5px 8px;
            height: 28px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            background: #fff;
            cursor: pointer;
        }
        
        .select-inline:focus {
            outline: none;
            border-color: #32c5d2;
        }
        
        /* Table styling to match Ocean Import */
        .grid-table input[type="text"],
        .grid-table select {
            width: 100%;
            font-size: 10px;
            padding: 4px 6px;
            border: 1px solid transparent;
            background: transparent;
            border-radius: 2px;
        }
        
        .grid-table input[type="text"]:focus,
        .grid-table select:focus {
            border-color: #32c5d2;
            background: #fff;
            outline: none;
        }
        
        .grid-table tbody tr {
            transition: background-color 0.2s;
        }
        
        .grid-table tbody tr.unsaved {
            background-color: #fef3c7 !important;
            border-left: 3px solid #f59e0b;
        }
        
        .grid-table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .info-icon {
            color: #94a3b8;
            font-size: 10px;
            margin-left: 4px;
            cursor: help;
        }
        
        /* Save button at bottom */
        .save-footer {
            background: #fff;
            padding: 12px 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .save-footer-info {
            font-size: 11px;
            color: #666;
        }
        
        .btn-save-all {
            background: #32c5d2;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.2s;
            font-weight: 600;
        }
        
        .btn-save-all:hover {
            background: #27a9b5;
        }
        .btn-save-all:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        /* Professional table styling */
        .grid-wrapper {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .grid-table {
            border-collapse: collapse;
            width: 100%;
        }
        
        .grid-table th {
            background: #f8fafc;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 10px;
            color: #64748b;
            padding: 10px 8px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .grid-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 4px;
        }
        
        .btn-tool.danger {
            background: transparent;
            color: #94a3b8;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
            border-radius: 3px;
        }
        
        .btn-tool.danger:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fca5a5;
        }
        
        .btn-tool.green {
            background: #32c5d2;
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 6px 14px;
            transition: all 0.2s;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-tool.green:hover {
            background: #27a9b5;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(50, 197, 210, 0.3);
        }
    </style>
    @endpush

    {{-- Toast Container --}}
    <div class="toast-container" id="toast-container"></div>

    <!-- Breadcrumb -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="/settings">Settings</a> <i class="fa fa-angle-right"></i></li>
            <li><span style="color: #333; font-weight: 700;">Container TP/SZ</span></li>
        </ul>
    </div>

    <div class="portlet light">
        {{-- TITLE --}}
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject">CONTAINER TP/SZ</span>
            </div>
            <div class="actions" style="display:flex;gap:4px;">
                <button class="btn-action-round" id="btn-filter" onclick="toggleFilter()" title="Toggle filter row">
                    <i class="fa fa-filter"></i> Filter
                </button>
                <button class="btn-action-round white" onclick="exportExcel()" title="Export to CSV">
                    <i class="fa fa-file-excel-o"></i> Excel
                </button>
            </div>
        </div>

        {{-- TOOLBAR --}}
        <div class="portlet-tool">
            <div style="display:flex;gap:6px;align-items:center;">
                <button class="btn-tool green" onclick="addContainerType()" title="Add New Container Type">
                    <i class="fa fa-plus"></i> <span>Add</span>
                </button>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <i class="fa fa-search" style="font-size:10px;color:#94a3b8;"></i>
                <input type="text" id="quick-search" class="input-inline" style="width:150px;" placeholder="Quick search…" oninput="quickSearch(this.value)">
            </div>
        </div>

        {{-- TABLE --}}
        <div class="portlet-body">
            <div class="grid-container">
                <div class="grid-wrapper" style="max-height:calc(100vh - 350px);overflow-y:auto;">
                    <table class="grid-table" id="container-types-grid">
                        <thead>
                            <tr>
                                <th style="width:30px;text-align:center;">#</th>
                                <th style="width:35px;text-align:center;"><i class="fa fa-trash"></i></th>
                                <th style="width:110px;">Code <i class="fa fa-sort" style="font-size:9px;"></i></th>
                                <th style="width:300px;">Description</th>
                                <th style="width:160px;">AMS Type Code</th>
                                <th style="width:130px;">
                                    Type <i class="fa fa-info-circle info-icon" title="Container size classification"></i>
                                </th>
                                <th style="width:90px;">
                                    TEU <i class="fa fa-info-circle info-icon" title="Twenty-foot Equivalent Unit"></i>
                                </th>
                                <th style="width:80px;text-align:center;">Active</th>
                            </tr>

                            {{-- Filter Row --}}
                            <tr id="filter-row" style="display:none;background:#eff6ff;">
                                <td></td>
                                <td></td>
                                <td><input class="filter-input" data-param="filter_code" placeholder="Code…" oninput="applyFilters()"></td>
                                <td><input class="filter-input" data-param="filter_description" placeholder="Description…" oninput="applyFilters()"></td>
                                <td></td>
                                <td><input class="filter-input" data-param="filter_type" placeholder="Type…" oninput="applyFilters()"></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody id="grid-body">
                            @forelse($containerTypes as $index => $type)
                            <tr id="row-{{ $type->id }}" data-id="{{ $type->id }}">
                                <td style="text-align:center;font-size:11px;color:#64748b;">{{ $index + 1 }}</td>
                                <td style="text-align:center;">
                                    <button class="btn-tool danger" style="padding:2px 6px;font-size:10px;" onclick="deleteRow({{ $type->id }})" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>
                                    <input type="text" value="{{ $type->code }}" data-field="code" onchange="markUnsaved({{ $type->id }})" oninput="markUnsaved({{ $type->id }})" style="font-weight:600;">
                                </td>
                                <td>
                                    <input type="text" value="{{ $type->description }}" data-field="description" onchange="markUnsaved({{ $type->id }})" oninput="markUnsaved({{ $type->id }})">
                                </td>
                                <td>
                                    <select data-field="ams_type_code" onchange="markUnsaved({{ $type->id }})" class="ams-type-select">
                                        <option value="">-- Select AMS Type --</option>
                                        <option value="20 GP" {{ $type->ams_type_code == '20 GP' ? 'selected' : '' }}>20 GP</option>
                                        <option value="40 GP" {{ $type->ams_type_code == '40 GP' ? 'selected' : '' }}>40 GP</option>
                                        <option value="45 GP" {{ $type->ams_type_code == '45 GP' ? 'selected' : '' }}>45 GP</option>
                                        <option value="20 HQ" {{ $type->ams_type_code == '20 HQ' ? 'selected' : '' }}>20 HQ</option>
                                        <option value="40 HQ" {{ $type->ams_type_code == '40 HQ' ? 'selected' : '' }}>40 HQ</option>
                                        <option value="45 HQ" {{ $type->ams_type_code == '45 HQ' ? 'selected' : '' }}>45 HQ</option>
                                        <option value="53 HQ (9400)" {{ $type->ams_type_code == '53 HQ (9400)' ? 'selected' : '' }}>53 HQ (9400)</option>
                                        <option value="53 HQ (9500)" {{ $type->ams_type_code == '53 HQ (9500)' ? 'selected' : '' }}>53 HQ (9500)</option>
                                        <option value="20 SPECIAL EQUIP" {{ $type->ams_type_code == '20 SPECIAL EQUIP' ? 'selected' : '' }}>20 SPECIAL EQUIP</option>
                                        <option value="40 SPECIAL EQUIP" {{ $type->ams_type_code == '40 SPECIAL EQUIP' ? 'selected' : '' }}>40 SPECIAL EQUIP</option>
                                    </select>
                                </td>
                                <td>
                                    <select data-field="type" onchange="markUnsaved({{ $type->id }})">
                                        <option value="">-- Select --</option>
                                        <option value="20'" {{ $type->type == "20'" ? 'selected' : '' }}>20'</option>
                                        <option value="40'" {{ $type->type == "40'" ? 'selected' : '' }}>40'</option>
                                        <option value="45'" {{ $type->type == "45'" ? 'selected' : '' }}>45'</option>
                                        <option value="RF" {{ $type->type == 'RF' ? 'selected' : '' }}>RF</option>
                                    </select>
                                </td>
                                <td>
                                    <select data-field="teu" onchange="markUnsaved({{ $type->id }})">
                                        <option value="0.60" {{ $type->teu == 0.60 ? 'selected' : '' }}>0.6</option>
                                        <option value="1.00" {{ $type->teu == 1.00 ? 'selected' : '' }}>1</option>
                                        <option value="2.00" {{ $type->teu == 2.00 ? 'selected' : '' }}>2</option>
                                        <option value="2.25" {{ $type->teu == 2.25 ? 'selected' : '' }}>2.25</option>
                                    </select>
                                </td>
                                <td style="text-align:center;">
                                    <input type="checkbox" data-field="is_active" {{ $type->is_active ? 'checked' : '' }} onchange="markUnsaved({{ $type->id }})">
                                </td>
                            </tr>
                            @empty
                            <tr id="empty-row">
                                <td colspan="8" style="text-align:center;padding:40px;color:#94a3b8;">
                                    <i class="fa fa-cube" style="font-size:48px;display:block;margin-bottom:15px;opacity:0.3;"></i>
                                    <p style="font-size:14px;margin:0 0 5px 0;">No container types found</p>
                                    <p style="font-size:12px;margin:0;color:#cbd5e0;">Click the + button above to add a new container type</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($containerTypes->hasPages())
                <div class="pagination-wrapper" style="padding:12px 20px;border-top:1px solid #e2e8f0;background:#f8fafc;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div style="font-size:11px;color:#666;">
                            Showing {{ $containerTypes->firstItem() }} to {{ $containerTypes->lastItem() }} of {{ $containerTypes->total() }} entries
                        </div>
                        <div>
                            {{ $containerTypes->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- SAVE FOOTER --}}
        <div class="save-footer">
            <div class="save-footer-info">
                <span id="total-count">{{ $containerTypes->total() }}</span> container type(s) total
                <span id="unsaved-indicator" style="display:none;margin-left:15px;color:#f59e0b;font-weight:600;">
                    <i class="fa fa-exclamation-triangle"></i> <span id="unsaved-count">0</span> unsaved
                </span>
            </div>
            <button class="btn-save-all" id="save-all-btn" onclick="saveAll()" disabled>
                <i class="fa fa-save"></i> Save Changes
            </button>
        </div>
    </div>

    <script>
    // Global Helper functions attached directly to window
    window.getCsrfToken = function() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    };

    // State
    window.unsavedRows = new Set();
    window.filterActive = false;

    // Toast Notifications
    window.showToast = function(type, message) {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = 'toast ' + type;
        const icon = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        
        toast.innerHTML = '<i class="fa ' + icon + '"></i> ' + message;
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // Toggle Filter Row
    window.toggleFilter = function() {
        const filterRow = document.getElementById('filter-row');
        const btn = document.getElementById('btn-filter');
        window.filterActive = !window.filterActive;
        
        if (filterRow) filterRow.style.display = window.filterActive ? 'table-row' : 'none';
        if (btn) {
            btn.style.background = window.filterActive ? '#32c5d2' : '';
            btn.style.color = window.filterActive ? '#fff' : '';
        }
    };

    // Apply Column Filters
    window.applyFilters = function() {
        const rows = document.querySelectorAll('#grid-body tr:not(#empty-row)');
        const filters = {};
        
        document.querySelectorAll('.filter-input').forEach(input => {
            const param = input.dataset.param;
            if (input.value) {
                filters[param] = input.value.toLowerCase();
            }
        });
        
        rows.forEach(row => {
            let visible = true;
            if (filters.filter_code) {
                const code = row.querySelector('[data-field="code"]')?.value || '';
                if (!code.toLowerCase().includes(filters.filter_code)) visible = false;
            }
            if (filters.filter_description) {
                const desc = row.querySelector('[data-field="description"]')?.value || '';
                if (!desc.toLowerCase().includes(filters.filter_description)) visible = false;
            }
            if (filters.filter_type) {
                const type = row.querySelector('[data-field="type"]')?.value || '';
                if (!type.toLowerCase().includes(filters.filter_type)) visible = false;
            }
            row.style.display = visible ? '' : 'none';
        });
    };

    // Quick Search
    window.quickSearch = function(query) {
        const q = query.toLowerCase();
        const rows = document.querySelectorAll('#grid-body tr:not(#empty-row)');
        rows.forEach(row => {
            const code = row.querySelector('[data-field="code"]')?.value || '';
            const desc = row.querySelector('[data-field="description"]')?.value || '';
            const visible = code.toLowerCase().includes(q) || desc.toLowerCase().includes(q);
            row.style.display = visible ? '' : 'none';
        });
    };

    // Mark Row as Unsaved
    window.markUnsaved = function(id) {
        window.unsavedRows.add(id);
        const row = document.getElementById('row-' + id);
        if (row) {
            row.classList.add('unsaved');
        }
        window.updateSaveButton();
    };

    // Update Save Button State
    window.updateSaveButton = function() {
        const btn = document.getElementById('save-all-btn');
        const indicator = document.getElementById('unsaved-indicator');
        const countSpan = document.getElementById('unsaved-count');
        
        if (!btn) return;
        
        const count = window.unsavedRows.size;
        btn.disabled = count === 0;
        
        if (count > 0) {
            btn.innerHTML = '<i class="fa fa-save"></i> Save ' + count + ' Change' + (count > 1 ? 's' : '');
            if (indicator) indicator.style.display = 'inline-block';
            if (countSpan) countSpan.textContent = count;
        } else {
            btn.innerHTML = '<i class="fa fa-check"></i> All Saved';
            if (indicator) indicator.style.display = 'none';
        }
    };

    // Add New Container Type Row
    window.addContainerType = function() {
        const tbody = document.getElementById('grid-body');
        if (!tbody) return;

        const newId = 'new-' + Date.now();
        
        // Remove empty placeholder row if present
        const emptyRow = document.getElementById('empty-row');
        if (emptyRow) emptyRow.remove();
        
        const rowCount = tbody.querySelectorAll('tr:not(#empty-row)').length + 1;
        
        const row = document.createElement('tr');
        row.id = 'row-' + newId;
        row.dataset.id = newId;
        row.classList.add('unsaved');
        row.innerHTML = `
            <td style="text-align:center;font-size:11px;color:#3b82f6;font-weight:600;">${rowCount}</td>
            <td style="text-align:center;">
                <button class="btn-tool danger" style="padding:2px 6px;font-size:10px;" onclick="deleteRow('${newId}')" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
            <td><input type="text" value="" data-field="code" onchange="markUnsaved('${newId}')" oninput="markUnsaved('${newId}')" placeholder="e.g. 40HC" style="font-weight:600;"></td>
            <td><input type="text" value="" data-field="description" onchange="markUnsaved('${newId}')" oninput="markUnsaved('${newId}')" placeholder="Container description"></td>
            <td>
                <select data-field="ams_type_code" onchange="markUnsaved('${newId}')" class="ams-type-select">
                    <option value="">-- Select AMS Type --</option>
                    <option value="20 GP">20 GP</option>
                    <option value="40 GP">40 GP</option>
                    <option value="45 GP">45 GP</option>
                    <option value="20 HQ">20 HQ</option>
                    <option value="40 HQ">40 HQ</option>
                    <option value="45 HQ">45 HQ</option>
                    <option value="53 HQ (9400)">53 HQ (9400)</option>
                    <option value="53 HQ (9500)">53 HQ (9500)</option>
                    <option value="20 SPECIAL EQUIP">20 SPECIAL EQUIP</option>
                    <option value="40 SPECIAL EQUIP">40 SPECIAL EQUIP</option>
                </select>
            </td>
            <td>
                <select data-field="type" onchange="markUnsaved('${newId}')">
                    <option value="">-- Select --</option>
                    <option value="20'">20'</option>
                    <option value="40'">40'</option>
                    <option value="45'">45'</option>
                    <option value="RF">RF</option>
                </select>
            </td>
            <td>
                <select data-field="teu" onchange="markUnsaved('${newId}')">
                    <option value="0.60">0.6</option>
                    <option value="1.00" selected>1</option>
                    <option value="2.00">2</option>
                    <option value="2.25">2.25</option>
                </select>
            </td>
            <td style="text-align:center;">
                <input type="checkbox" data-field="is_active" checked onchange="markUnsaved('${newId}')">
            </td>
        `;
        
        tbody.insertBefore(row, tbody.firstChild);
        window.unsavedRows.add(newId);
        window.updateSaveButton();

        // Focus code input
        const codeInput = row.querySelector('[data-field="code"]');
        if (codeInput) codeInput.focus();

        window.showToast('info', 'New container type row added. Enter details and click Save Changes.');
    };

    // Delete Row
    window.deleteRow = function(id) {
        if (!confirm('Are you sure you want to delete this container type?')) return;
        
        const row = document.getElementById('row-' + id);
        if (!row) return;
        
        // Unsaved new row: just remove from DOM
        if (String(id).startsWith('new-')) {
            row.remove();
            window.unsavedRows.delete(id);
            window.updateSaveButton();
            window.showToast('info', 'Row removed');
            return;
        }
        
        // Existing database row: send DELETE request
        window.showToast('info', 'Deleting container type from database...');
        
        fetch(`/api/container-types/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': window.getCsrfToken(),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                row.remove();
                window.unsavedRows.delete(id);
                window.updateSaveButton();
                const totalEl = document.getElementById('total-count');
                if (totalEl) {
                    const currentTotal = parseInt(totalEl.textContent) || 1;
                    totalEl.textContent = Math.max(0, currentTotal - 1);
                }
                window.showToast('success', 'Container type deleted successfully from database');
            } else {
                window.showToast('error', data.message || 'Failed to delete container type');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            window.showToast('error', 'Failed to delete container type');
        });
    };

    // Save All Unsaved Rows to Database atomically
    window.saveAll = function() {
        if (window.unsavedRows.size === 0) {
            window.showToast('info', 'No changes to save');
            return;
        }
        
        const payloadTypes = [];
        let hasValidationError = false;
        const seenCodes = new Set();
        
        // Collect existing codes in table to prevent duplicate entry submit
        document.querySelectorAll('#grid-body tr:not(#empty-row)').forEach(tr => {
            const trId = tr.dataset.id;
            if (!window.unsavedRows.has(trId) && !window.unsavedRows.has(parseInt(trId))) {
                const existingCode = tr.querySelector('[data-field="code"]')?.value?.trim();
                if (existingCode) seenCodes.add(existingCode.toLowerCase());
            }
        });
        
        window.unsavedRows.forEach(id => {
            const row = document.getElementById('row-' + id);
            if (!row) return;
            
            const codeInput = row.querySelector('[data-field="code"]');
            const descInput = row.querySelector('[data-field="description"]');
            
            const code = codeInput ? codeInput.value.trim() : '';
            const description = descInput ? descInput.value.trim() : '';
            
            if (!code) {
                window.showToast('error', 'Code is required for all container types');
                if (codeInput) codeInput.style.borderColor = '#ef4444';
                hasValidationError = true;
                return;
            }

            if (seenCodes.has(code.toLowerCase())) {
                window.showToast('error', 'Container type code "' + code + '" already exists in table. Code must be unique.');
                if (codeInput) codeInput.style.borderColor = '#ef4444';
                hasValidationError = true;
                return;
            }
            seenCodes.add(code.toLowerCase());
            
            if (!description) {
                window.showToast('error', 'Description is required for code: ' + code);
                if (descInput) descInput.style.borderColor = '#ef4444';
                hasValidationError = true;
                return;
            }
            
            payloadTypes.push({
                id: String(id).startsWith('new-') ? null : id,
                code: code,
                name: code,
                description: description,
                ams_type_code: row.querySelector('[data-field="ams_type_code"]')?.value || '',
                type: row.querySelector('[data-field="type"]')?.value || '',
                teu: row.querySelector('[data-field="teu"]')?.value || '1.00',
                is_active: row.querySelector('[data-field="is_active"]')?.checked ? 1 : 0
            });
        });

        if (hasValidationError || payloadTypes.length === 0) {
            return;
        }

        window.showToast('info', 'Saving ' + payloadTypes.length + ' container type(s) to database...');

        fetch('/api/container-types/bulk-save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.getCsrfToken()
            },
            body: JSON.stringify({ types: payloadTypes })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.unsavedRows.clear();
                window.updateSaveButton();
                window.showToast('success', data.message || 'Container types saved successfully to database');
                setTimeout(() => {
                    window.location.reload();
                }, 600);
            } else {
                window.showToast('error', data.message || 'Failed to save container types');
            }
        })
        .catch(err => {
            console.error('Bulk save error:', err);
            window.showToast('error', 'Failed to save container types to database');
        });
    };

    // Export CSV
    window.exportExcel = function() {
        window.showToast('info', 'Preparing Excel export...');
        
        const filters = {};
        document.querySelectorAll('.filter-input').forEach(input => {
            const param = input.dataset.param;
            if (input.value) filters[param] = input.value;
        });
        
        const url = new URL('/settings/container-types/export-csv', window.location.origin);
        Object.keys(filters).forEach(key => {
            url.searchParams.append(key, filters[key]);
        });
        
        fetch(url.toString())
            .then(response => response.blob())
            .then(blob => {
                const downloadUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = downloadUrl;
                a.download = 'container-types-' + new Date().toISOString().split('T')[0] + '.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(downloadUrl);
                window.showToast('success', 'Excel file downloaded successfully');
            })
            .catch(error => {
                console.error('Export error:', error);
                window.showToast('error', 'Failed to export');
            });
    };

    // Page initialization
    function initContainerTypesPage() {
        window.updateSaveButton();
    }

    if (document.readyState === 'interactive' || document.readyState === 'complete') {
        initContainerTypesPage();
    } else {
        document.addEventListener('DOMContentLoaded', initContainerTypesPage);
    }
    document.addEventListener('turbo:load', initContainerTypesPage);
    document.addEventListener('turbolinks:load', initContainerTypesPage);
    </script>
</x-layout>
