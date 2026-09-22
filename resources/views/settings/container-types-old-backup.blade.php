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
            background-color: #fffbeb !important;
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
            position: sticky;
            bottom: 0;
            background: #f8fafc;
            padding: 12px 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
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
        }
        
        .btn-save-all:hover {
            background: #27a9b5;
        }
        
        .btn-save-all:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            opacity: 0.6;
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
                    <i class="fa fa-plus"></i>
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
                <div class="grid-wrapper" style="max-height:calc(100vh - 350px);">
                    <table class="grid-table" id="container-types-grid">
                        <thead>
                            <tr>
                                <th style="width:25px;text-align:center;">#</th>
                                <th style="width:25px;text-align:center;"><i class="fa fa-trash"></i></th>
                                <th style="width:100px;">Code <i class="fa fa-sort" style="font-size:9px;"></i></th>
                                <th style="width:300px;">Description</th>
                                <th style="width:150px;">AMS Type Code</th>
                                <th style="width:150px;">
                                    Type <i class="fa fa-info-circle info-icon" title="Container size classification"></i>
                                </th>
                                <th style="width:100px;">
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
                            @foreach($containerTypes as $index => $type)
                            <tr id="row-{{ $type->id }}" data-id="{{ $type->id }}">
                                <td style="text-align:center;">{{ $index + 1 }}</td>
                                <td style="text-align:center;">
                                    <button class="btn-tool danger" style="padding:2px 6px;font-size:10px;" onclick="deleteRow({{ $type->id }})" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>
                                    <input type="text" value="{{ $type->code }}" data-field="code" onchange="markUnsaved({{ $type->id }})">
                                </td>
                                <td>
                                    <input type="text" value="{{ $type->description }}" data-field="description" onchange="markUnsaved({{ $type->id }})">
                                </td>
                                <td>
                                    <select data-field="ams_type_code" onchange="markUnsaved({{ $type->id }})">
                                        <option value="">-- Select --</option>
                                        <option value="DC" {{ $type->ams_type_code == 'DC' ? 'selected' : '' }}>DC - Dry Container</option>
                                        <option value="RF" {{ $type->ams_type_code == 'RF' ? 'selected' : '' }}>RF - Reefer</option>
                                        <option value="FR" {{ $type->ams_type_code == 'FR' ? 'selected' : '' }}>FR - Flat Rack</option>
                                        <option value="GP" {{ $type->ams_type_code == 'GP' ? 'selected' : '' }}>GP - General Purpose</option>
                                        <option value="HC" {{ $type->ams_type_code == 'HC' ? 'selected' : '' }}>HC - High Cube</option>
                                        <option value="HQ" {{ $type->ams_type_code == 'HQ' ? 'selected' : '' }}>HQ - High Cube</option>
                                        <option value="NOR" {{ $type->ams_type_code == 'NOR' ? 'selected' : '' }}>NOR - Normal</option>
                                        <option value="OT" {{ $type->ams_type_code == 'OT' ? 'selected' : '' }}>OT - Open Top</option>
                                        <option value="PF" {{ $type->ams_type_code == 'PF' ? 'selected' : '' }}>PF - Platform</option>
                                        <option value="RH" {{ $type->ams_type_code == 'RH' ? 'selected' : '' }}>RH - Reefer High Cube</option>
                                        <option value="TK" {{ $type->ams_type_code == 'TK' ? 'selected' : '' }}>TK - Tank</option>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SAVE FOOTER --}}
        <div class="save-footer">
            <button class="btn-save-all" id="save-all-btn" onclick="saveAll()">
                <i class="fa fa-save"></i> Save All Changes
            </button>
        </div>
    </div>

    <script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // State
    let unsavedRows = new Set();
    let filterActive = false;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateSaveButton();
    });

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

    // Toggle filter row
    function toggleFilter() {
        const filterRow = document.getElementById('filter-row');
        const btn = document.getElementById('btn-filter');
        filterActive = !filterActive;
        
        filterRow.style.display = filterActive ? 'table-row' : 'none';
        btn.style.background = filterActive ? '#32c5d2' : '';
        btn.style.color = filterActive ? '#fff' : '';
    }

    // Apply filters
    function applyFilters() {
        const rows = document.querySelectorAll('#grid-body tr');
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
    }

    // Quick search
    function quickSearch(query) {
        const q = query.toLowerCase();
        const rows = document.querySelectorAll('#grid-body tr');
        
        rows.forEach(row => {
            const code = row.querySelector('[data-field="code"]')?.value || '';
            const desc = row.querySelector('[data-field="description"]')?.value || '';
            const visible = code.toLowerCase().includes(q) || desc.toLowerCase().includes(q);
            row.style.display = visible ? '' : 'none';
        });
    }

    // Mark row as unsaved
    function markUnsaved(id) {
        unsavedRows.add(id);
        const row = document.getElementById('row-' + id);
        if (row) {
            row.classList.add('unsaved');
        }
        updateSaveButton();
    }

    // Update save button state
    function updateSaveButton() {
        const btn = document.getElementById('save-all-btn');
        btn.disabled = unsavedRows.size === 0;
        if (unsavedRows.size > 0) {
            btn.innerHTML = '<i class="fa fa-save"></i> Save ' + unsavedRows.size + ' Change' + (unsavedRows.size > 1 ? 's' : '');
        } else {
            btn.innerHTML = '<i class="fa fa-check"></i> No Changes';
        }
    }

    // Add new container type
    function addContainerType() {
        const tbody = document.getElementById('grid-body');
        const newId = 'new-' + Date.now();
        const rowCount = tbody.querySelectorAll('tr').length + 1;
        
        const row = document.createElement('tr');
        row.id = 'row-' + newId;
        row.dataset.id = newId;
        row.classList.add('unsaved');
        row.innerHTML = `
            <td style="text-align:center;">${rowCount}</td>
            <td style="text-align:center;">
                <button class="btn-tool danger" style="padding:2px 6px;font-size:10px;" onclick="deleteRow('${newId}')" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
            <td><input type="text" value="" data-field="code" onchange="markUnsaved('${newId}')" placeholder="e.g., 20DC"></td>
            <td><input type="text" value="" data-field="description" onchange="markUnsaved('${newId}')" placeholder="Container description"></td>
            <td>
                <select data-field="ams_type_code" onchange="markUnsaved('${newId}')">
                    <option value="">-- Select --</option>
                    <option value="DC">DC - Dry Container</option>
                    <option value="RF">RF - Reefer</option>
                    <option value="FR">FR - Flat Rack</option>
                    <option value="GP">GP - General Purpose</option>
                    <option value="HC">HC - High Cube</option>
                    <option value="HQ">HQ - High Cube</option>
                    <option value="NOR">NOR - Normal</option>
                    <option value="OT">OT - Open Top</option>
                    <option value="PF">PF - Platform</option>
                    <option value="RH">RH - Reefer High Cube</option>
                    <option value="TK">TK - Tank</option>
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
        unsavedRows.add(newId);
        updateSaveButton();
        showToast('info', 'New container type added. Don\'t forget to save!');
    }

    // Delete row
    function deleteRow(id) {
        if (!confirm('Are you sure you want to delete this container type?')) return;
        
        const row = document.getElementById('row-' + id);
        if (!row) return;
        
        // If it's a new row (not in database), just remove from DOM
        if (String(id).startsWith('new-')) {
            row.remove();
            unsavedRows.delete(id);
            updateSaveButton();
            showToast('info', 'Row removed');
            return;
        }
        
        // If it's an existing row, delete from database
        showToast('info', 'Deleting...');
        
        fetch(`/api/container-types/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                row.remove();
                unsavedRows.delete(id);
                updateSaveButton();
                showToast('success', 'Container type deleted successfully');
            } else {
                showToast('error', data.message || 'Failed to delete');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Failed to delete container type');
        });
    }

    // Save all changes
    function saveAll() {
        if (unsavedRows.size === 0) return;
        
        showToast('info', 'Saving ' + unsavedRows.size + ' change(s)...');
        
        const types = [];
        let hasValidationError = false;
        
        // Debug: Log all unsaved row IDs
        console.log('Unsaved rows:', Array.from(unsavedRows));
        
        unsavedRows.forEach(id => {
            const row = document.getElementById('row-' + id);
            if (!row) {
                console.log('Row not found:', id);
                return;
            }
            
            const codeInput = row.querySelector('[data-field="code"]');
            const descInput = row.querySelector('[data-field="description"]');
            
            // Debug: Log what we found
            console.log('Processing row:', id);
            console.log('Code input:', codeInput);
            console.log('Code value:', codeInput?.value);
            console.log('Desc input:', descInput);
            console.log('Desc value:', descInput?.value);
            
            const data = {
                code: (codeInput?.value || '').trim(),
                name: (codeInput?.value || '').trim(), // name same as code for compatibility
                description: (descInput?.value || '').trim(),
                ams_type_code: row.querySelector('[data-field="ams_type_code"]')?.value || '',
                type: row.querySelector('[data-field="type"]')?.value || '',
                teu: row.querySelector('[data-field="teu"]')?.value || '1.00',
                is_active: row.querySelector('[data-field="is_active"]')?.checked ?? true
            };
            
            console.log('Data object:', data);
            
            // Validation - require at least 2 characters for code and description
            if (!data.code || data.code.length < 2) {
                if (!hasValidationError) {
                    showToast('error', 'Code must be at least 2 characters. Current: "' + (data.code || '[empty]') + '" for row ' + id);
                    hasValidationError = true;
                }
                row.style.backgroundColor = '#fee2e2';
                setTimeout(() => row.style.backgroundColor = '', 3000);
                return;
            }
            
            if (!data.description || data.description.length < 2) {
                if (!hasValidationError) {
                    showToast('error', 'Description must be at least 2 characters. Current: "' + (data.description || '[empty]') + '" for row ' + id);
                    hasValidationError = true;
                }
                row.style.backgroundColor = '#fee2e2';
                setTimeout(() => row.style.backgroundColor = '', 3000);
                return;
            }
            
            // If it's a new row, don't include id
            if (!String(id).startsWith('new-')) {
                data.id = id;
            }
            
            types.push({ id, row, data });
        });
        
        console.log('Valid types to save:', types.length);
        
        if (types.length === 0) {
            if (!hasValidationError) {
                showToast('error', 'No valid rows to save');
            }
            return;
        }
        
        // Save each type individually
        let savedCount = 0;
        let errorCount = 0;
        
        types.forEach(({ id, row, data }) => {
            const isNew = String(id).startsWith('new-');
            const url = isNew ? '/api/container-types' : `/api/container-types/${data.id}`;
            const method = isNew ? 'POST' : 'PUT';
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    savedCount++;
                    row.classList.remove('unsaved');
                    unsavedRows.delete(id);
                    
                    // If it was a new row, update its ID
                    if (isNew && result.containerType) {
                        row.id = 'row-' + result.containerType.id;
                        row.dataset.id = result.containerType.id;
                    }
                    
                    if (savedCount + errorCount === types.length) {
                        updateSaveButton();
                        if (errorCount === 0) {
                            showToast('success', `Saved ${savedCount} container type${savedCount > 1 ? 's' : ''} successfully`);
                        } else {
                            showToast('error', `Saved ${savedCount}, Failed ${errorCount}`);
                        }
                    }
                } else {
                    errorCount++;
                    showToast('error', result.message || 'Failed to save');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorCount++;
                showToast('error', 'Failed to save container type');
            });
        });
    }

    // Export to Excel
    function exportExcel() {
        showToast('info', 'Preparing Excel export...');
        
        // Get filter values
        const filters = {};
        document.querySelectorAll('.filter-input').forEach(input => {
            const param = input.dataset.param;
            if (input.value) {
                filters[param] = input.value;
            }
        });
        
        // Build URL with filters
        const url = new URL('/settings/container-types/export-csv', window.location.origin);
        Object.keys(filters).forEach(key => {
            url.searchParams.append(key, filters[key]);
        });
        
        // Download using fetch and blob
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
                showToast('success', 'Excel file downloaded successfully');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'Failed to export');
            });
    }
    </script>

</x-layout>
