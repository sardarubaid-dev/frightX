<x-layout>
    @push('styles')
    <x-list-styles />
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @endpush

    {{-- ═══════ TOAST CONTAINER ═══════ --}}
    <div class="toast-container" id="toast-container"></div>

    {{-- ═══════ DELETE CONFIRM MODAL ═══════ --}}
    <div class="overlay" id="confirm-overlay" onclick="if(event.target===this) closeConfirm()">
        <div class="confirm-box">
            <div class="confirm-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <h4>Delete G/L Code(s)?</h4>
            <p id="confirm-msg">This action cannot be undone.</p>
            <div class="confirm-actions">
                <button class="btn-tool" style="padding:0 18px;height:26px;" onclick="closeConfirm()">Cancel</button>
                <button class="btn-tool danger" style="padding:0 18px;height:26px;" onclick="executeDelete()">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════ MAIN PAGE ═══════ --}}
    <div class="page-content">

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
                <li>Settings <i class="fa fa-angle-right"></i></li>
                <li>Accounting <i class="fa fa-angle-right"></i></li>
                <li><span style="color:#333;font-weight:700;">G/L Code</span></li>
            </ul>
        </div>

        <div class="portlet light" x-data="glCodeList()">

            {{-- ── PORTLET TITLE ── --}}
            <div class="portlet-title">
                <div class="caption" style="display:flex;align-items:center;gap:12px;">
                    <span class="caption-subject">G/L CODE</span>
                </div>
                <div class="actions" style="display:flex;gap:4px;position:relative;align-items:center;">
                    <button class="btn-action-round white" :class="{'active-filter': showFilters}" @click="toggleFilters()" title="Toggle Filters">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                    <button class="btn-action-round white" @click="printTable()" title="Print this page">
                        <i class="fa fa-print"></i> Print
                    </button>
                    <button class="btn-action-round white" @click="exportExcel()" title="Download as CSV/Excel">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </button>
                </div>
            </div>

            {{-- ── TOOLBAR ── --}}
            <div class="portlet-tool">
                <div style="display:flex;gap:10px;align-items:center;">
                    <div class="btn-group">
                        <button class="btn-tool green" @click="addCode()" title="Add New G/L Code">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button class="btn-tool" :disabled="selectedCodes.length === 0" @click="confirmDelete()" title="Delete Selected">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button class="btn-tool" @click="refreshCodes()" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:6px;margin:0;">
                    <i class="fa fa-search" style="font-size:10px;color:#94a3b8;"></i>
                    <input type="text" x-model="searchTerm" @input="filterCodes()" class="input-inline" style="width:160px;"
                           placeholder="Quick search...">
                </div>
            </div>

            {{-- ── TABLE ── --}}
            <div class="portlet-body">
                <div class="grid-container">
                    <div class="grid-wrapper">
                        <table class="grid-table">
                            <thead>
                                <tr>
                                    <th class="sticky-col sticky-col-header" style="width:30px;text-align:center;">
                                        <input type="checkbox" @change="toggleSelectAll($event.target.checked)" :checked="allSelected">
                                    </th>
                                    <th class="sticky-col sticky-col-header" style="width:25px;left:30px;text-align:center;"><i class="fa fa-trash"></i></th>
                                    <th class="sticky-col sticky-col-header" style="width:120px;left:55px;">G/L Code</th>
                                    <th style="width:180px;">G/L Name (Eng.)</th>
                                    <th style="width:180px;">G/L Name (Local)</th>
                                    <th style="width:120px;">Name Type</th>
                                    <th style="width:150px;">Sub</th>
                                    <th style="width:80px;text-align:center;">AIRE_AP_CODE</th>
                                    <th style="width:80px;text-align:center;">Detail</th>
                                    <th style="width:80px;text-align:center;">Deposit</th>
                                    <th style="width:80px;text-align:center;">Forgotten</th>
                                    <th style="width:80px;text-align:center;">Transaction</th>
                                    <th style="width:80px;text-align:center;">Active</th>
                                </tr>
                                {{-- FILTER ROW --}}
                                <tr x-show="showFilters" class="filter-row" x-cloak>
                                    <th colspan="3"></th>
                                    <th>
                                        <input type="text" x-model="filters.gl_name_eng" @input="applyFilters()" class="filter-input" placeholder="Filter...">
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.gl_name_local" @input="applyFilters()" class="filter-input" placeholder="Filter...">
                                    </th>
                                    <th>
                                        <select x-model="filters.name_type" @change="applyFilters()" class="filter-input" style="height:18px;">
                                            <option value="">All</option>
                                            <option value="ASSET">ASSET</option>
                                            <option value="LIABILITY">LIABILITY</option>
                                            <option value="EQUITY">EQUITY</option>
                                            <option value="REVENUE">REVENUE</option>
                                            <option value="EXPENSE">EXPENSE</option>
                                        </select>
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.sub" @input="applyFilters()" class="filter-input" placeholder="Filter...">
                                    </th>
                                    <th colspan="6"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(code, index) in filteredCodes" :key="code.id || index">
                                    <tr @click="toggleRowSelect(code)" :class="{'row-selected': code.selected}">
                                        <td class="sticky-col" style="text-align:center;" @click.stop>
                                            <input type="checkbox" :checked="code.selected" @change="code.selected = !code.selected; updateToolbar()">
                                        </td>
                                        <td class="sticky-col" style="left:30px;text-align:center;" @click.stop>
                                            <i class="fa fa-trash" style="color:#ef4444;cursor:pointer;font-size:10px;" 
                                               @click="deleteSingleCode(code)" title="Delete"></i>
                                        </td>
                                        <td class="sticky-col" style="left:55px;" @click.stop>
                                            <input type="text" x-model="code.gl_code" 
                                                   class="input-inline" style="width:100%;font-weight:600;"
                                                   @input="code._unsaved = true" placeholder="G/L Code">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.gl_name_eng" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Name (Eng)">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.gl_name_local" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Name (Local)">
                                        </td>
                                        <td @click.stop>
                                            <select class="select-tool" x-model="code.name_type" 
                                                    @change="code._unsaved = true" style="width:100%;">
                                                <option value="">--</option>
                                                <option value="ASSET">ASSET</option>
                                                <option value="LIABILITY">LIABILITY</option>
                                                <option value="EQUITY">EQUITY</option>
                                                <option value="REVENUE">REVENUE</option>
                                                <option value="EXPENSE">EXPENSE</option>
                                            </select>
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.sub" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Sub">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.aire_ap_code" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.detail" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.deposit" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.forgotten" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.transaction" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.is_active" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="filteredCodes.length === 0">
                                    <tr>
                                        <td colspan="13" style="text-align:center;padding:30px 10px;color:#94a3b8;">
                                            <i class="fa fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                                            No G/L codes found.
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ── BOTTOM TOOLBAR ── --}}
            <div class="portlet-tool bottom">
                <div style="display:flex;gap:8px;">
                    <button class="btn-tool green" @click="saveAll()" 
                            :disabled="!hasUnsavedChanges()"
                            title="Save all unsaved changes">
                        <i class="fa fa-save"></i> Save
                    </button>
                    <button class="btn-tool" @click="cancelChanges()" 
                            :disabled="!hasUnsavedChanges()"
                            title="Cancel all changes">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:10px;color:#64748b;">
                    <span>Total Records: <span style="font-weight:600;color:#334155;" x-text="filteredCodes.length"></span></span>
                    <template x-if="selectedCodes.length > 0">
                        <span style="color:#3b82f6;font-weight:600;">
                            | <span x-text="selectedCodes.length"></span> selected
                        </span>
                    </template>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function glCodeList() {
        return {
            codes: @json($codes ?? []),
            filteredCodes: [],
            selectedCodes: [],
            searchTerm: '',
            allSelected: false,
            showFilters: false,
            filters: {
                gl_name_eng: '',
                gl_name_local: '',
                name_type: '',
                sub: ''
            },

            init() {
                this.filteredCodes = [...this.codes];
                this.loadCodes();
            },

            async loadCodes() {
                try {
                    const response = await fetch('/api/gl-codes');
                    if (response.ok) {
                        const data = await response.json();
                        this.codes = data.codes || [];
                        this.filterCodes();
                    }
                } catch (error) {
                    console.error('Failed to load G/L codes:', error);
                }
            },

            toggleFilters() {
                this.showFilters = !this.showFilters;
            },

            applyFilters() {
                this.filterCodes();
            },

            filterCodes() {
                let filtered = [...this.codes];
                
                // Quick search
                if (this.searchTerm) {
                    const search = this.searchTerm.toLowerCase();
                    filtered = filtered.filter(code => {
                        return code.gl_code?.toLowerCase().includes(search) ||
                               code.gl_name_eng?.toLowerCase().includes(search) ||
                               code.gl_name_local?.toLowerCase().includes(search) ||
                               code.sub?.toLowerCase().includes(search);
                    });
                }

                // Column filters
                if (this.filters.gl_name_eng) {
                    const search = this.filters.gl_name_eng.toLowerCase();
                    filtered = filtered.filter(code => 
                        code.gl_name_eng?.toLowerCase().includes(search)
                    );
                }

                if (this.filters.gl_name_local) {
                    const search = this.filters.gl_name_local.toLowerCase();
                    filtered = filtered.filter(code => 
                        code.gl_name_local?.toLowerCase().includes(search)
                    );
                }

                if (this.filters.name_type) {
                    filtered = filtered.filter(code => 
                        code.name_type === this.filters.name_type
                    );
                }

                if (this.filters.sub) {
                    const search = this.filters.sub.toLowerCase();
                    filtered = filtered.filter(code => 
                        code.sub?.toLowerCase().includes(search)
                    );
                }

                this.filteredCodes = filtered;
            },

            addCode() {
                const newCode = {
                    id: null, gl_code: '', gl_name_eng: '', gl_name_local: '',
                    name_type: '', sub: '', aire_ap_code: false, detail: false,
                    deposit: false, forgotten: false, transaction: false,
                    is_active: true, selected: false, _unsaved: true
                };
                this.codes.unshift(newCode);
                this.filterCodes();
                showToast('info', 'New G/L code added. Don\'t forget to save!');
            },

            toggleRowSelect(code) {
                code.selected = !code.selected;
                this.updateToolbar();
            },

            toggleSelectAll(checked) {
                this.filteredCodes.forEach(code => code.selected = checked);
                this.updateToolbar();
            },

            updateToolbar() {
                this.selectedCodes = this.filteredCodes.filter(c => c.selected);
                this.allSelected = this.filteredCodes.length > 0 && 
                                  this.selectedCodes.length === this.filteredCodes.length;
            },

            confirmDelete() {
                const n = this.selectedCodes.length;
                if (!n) return;
                document.getElementById('confirm-msg').textContent =
                    `You are about to permanently delete ${n} G/L code(s). This cannot be undone.`;
                document.getElementById('confirm-overlay').classList.add('open');
            },

            async executeDelete() {
                closeConfirm();
                const ids = this.selectedCodes.map(c => c.id).filter(id => id !== null);
                
                if (ids.length === 0) {
                    this.codes = this.codes.filter(c => !c.selected || c.id !== null);
                    this.filterCodes();
                    showToast('success', 'Unsaved codes removed');
                    return;
                }

                showToast('info', 'Deleting...');
                
                try {
                    const response = await fetch('/api/gl-codes/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ids })
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.codes = this.codes.filter(c => !ids.includes(c.id));
                        this.filterCodes();
                        showToast('success', data.message || 'Deleted successfully');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    showToast('error', 'Failed to delete G/L codes');
                }
            },

            async deleteSingleCode(code) {
                if (!confirm('Delete this G/L code?')) return;

                if (!code.id) {
                    this.codes = this.codes.filter(c => c !== code);
                    this.filterCodes();
                    showToast('success', 'Code removed');
                    return;
                }

                showToast('info', 'Deleting...');

                try {
                    const response = await fetch(`/api/gl-codes/${code.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.codes = this.codes.filter(c => c.id !== code.id);
                        this.filterCodes();
                        showToast('success', 'Code deleted');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    showToast('error', 'Failed to delete code');
                }
            },

            hasUnsavedChanges() {
                return this.codes.some(c => c._unsaved);
            },

            async saveAll() {
                const unsaved = this.codes.filter(c => c._unsaved);
                if (unsaved.length === 0) return;

                showToast('info', `Saving ${unsaved.length} G/L code(s)...`);

                try {
                    const response = await fetch('/api/gl-codes/bulk-save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ codes: unsaved })
                    });

                    const data = await response.json();
                    if (data.success) {
                        if (data.codes) {
                            data.codes.forEach((savedCode, index) => {
                                const unsavedCode = unsaved[index];
                                Object.assign(unsavedCode, savedCode);
                                unsavedCode._unsaved = false;
                            });
                        } else {
                            unsaved.forEach(c => c._unsaved = false);
                        }
                        
                        showToast('success', `${unsaved.length} G/L code(s) saved successfully`);
                        await this.loadCodes();
                    } else {
                        showToast('error', data.message || 'Failed to save');
                    }
                } catch (error) {
                    showToast('error', 'Failed to save G/L codes');
                }
            },

            cancelChanges() {
                if (!confirm('Discard all unsaved changes?')) return;
                this.loadCodes();
                showToast('info', 'Changes cancelled');
            },

            refreshCodes() {
                showToast('info', 'Refreshing G/L codes...');
                this.loadCodes();
            },

            printTable() {
                const url = new URL('{{ route("accounting.gl-code-list-print") }}');
                if (this.searchTerm) url.searchParams.set('search', this.searchTerm);
                Object.keys(this.filters).forEach(key => {
                    if (this.filters[key]) url.searchParams.set('filter_' + key, this.filters[key]);
                });
                showToast('info', 'Opening print view...');
                window.open(url.toString(), '_blank');
            },

            async exportExcel() {
                showToast('info', 'Preparing Excel export...');
                
                try {
                    const url = new URL('/api/gl-codes/export', window.location.origin);
                    if (this.searchTerm) url.searchParams.set('search', this.searchTerm);
                    Object.keys(this.filters).forEach(key => {
                        if (this.filters[key]) url.searchParams.set('filter_' + key, this.filters[key]);
                    });
                    
                    const response = await fetch(url.toString());
                    if (!response.ok) throw new Error('Export failed');
                    
                    const blob = await response.blob();
                    const downloadUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = downloadUrl;
                    a.download = 'gl-codes-' + new Date().toISOString().split('T')[0] + '.csv';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(downloadUrl);
                    showToast('success', 'Excel file downloaded');
                } catch (error) {
                    console.error('Export error:', error);
                    showToast('error', 'Failed to export Excel');
                }
            }
        }
    }

    function closeConfirm() {
        document.getElementById('confirm-overlay').classList.remove('open');
    }

    window.executeDelete = function() {
        const component = Alpine.$data(document.querySelector('[x-data="glCodeList()"]'));
        if (component) component.executeDelete();
    };

    function showToast(type, msg) {
        const icons = { success: 'check-circle', error: 'times-circle', info: 'info-circle' };
        const t = document.createElement('div');
        t.className = `toast ${type}`;
        t.innerHTML = `<i class="fa fa-${icons[type] || 'info-circle'}"></i> <span>${msg}</span>`;
        const container = document.getElementById('toast-container');
        if (container) {
            container.appendChild(t);
            setTimeout(() => {
                if (t.parentElement) {
                    t.style.opacity = '0';
                    t.style.transform = 'translateX(100%)';
                    setTimeout(() => t.remove(), 300);
                }
            }, 3000);
        }
    }

    @if(session('success'))
        showToast('success', @json(session('success')));
    @endif
    @if(session('error'))
        showToast('error', @json(session('error')));
    @endif
    </script>
    @endpush
</x-layout>
