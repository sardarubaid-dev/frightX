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
            <h4>Delete AWB Block(s)?</h4>
            <p id="confirm-msg">This action cannot be undone.</p>
            <div class="confirm-actions">
                <button class="btn-tool" style="padding:0 18px;height:26px;" onclick="closeConfirm()">Cancel</button>
                <button class="btn-tool danger" style="padding:0 18px;height:26px;" onclick="executeDelete()">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <script>
    window.awbManagementModule = function awbManagementModule() {
        return {
            carriers: @json($carriers),
            blocks: [],
            filteredBlocks: [],
            selectedBlocks: [],
            searchTerm: '',
            allSelected: false,
            showFilters: false,
            filters: {
                carrier_id: '',
                prefix: '',
                begin_no: '',
                end_no: ''
            },

            onCarrierChange(block) {
                block._unsaved = true;
                if (block.carrier_id) {
                    const carrier = this.carriers.find(c => String(c.id) === String(block.carrier_id));
                    if (carrier && !block.prefix && (carrier.iata_code || carrier.code)) {
                        block.prefix = carrier.iata_code || carrier.code;
                    }
                }
            },

            init() {
                this.loadBlocks();
            },

            async loadBlocks() {
                try {
                    const response = await fetch('/api/awb-management');
                    if (response.ok) {
                        const data = await response.json();
                        this.blocks = (data.blocks || []).map(b => ({
                            ...b,
                            selected: false,
                            _unsaved: false
                        }));
                        this.filterBlocks();
                    }
                } catch (error) {
                    console.error('Failed to load AWB blocks:', error);
                }
            },

            toggleFilters() {
                this.showFilters = !this.showFilters;
            },

            applyFilters() {
                this.filterBlocks();
            },

            filterBlocks() {
                let filtered = [...this.blocks];
                
                // Quick search
                if (this.searchTerm) {
                    const search = this.searchTerm.toLowerCase();
                    filtered = filtered.filter(block => {
                        return block.prefix?.toLowerCase().includes(search) ||
                               block.begin_no?.toLowerCase().includes(search) ||
                               block.end_no?.toLowerCase().includes(search) ||
                               block.remark?.toLowerCase().includes(search);
                    });
                }

                // Column filters
                if (this.filters.carrier_id) {
                    filtered = filtered.filter(block => 
                        String(block.carrier_id) === String(this.filters.carrier_id)
                    );
                }

                if (this.filters.prefix) {
                    const search = this.filters.prefix.toLowerCase();
                    filtered = filtered.filter(block => 
                        block.prefix?.toLowerCase().includes(search)
                    );
                }

                if (this.filters.begin_no) {
                    const search = this.filters.begin_no.toLowerCase();
                    filtered = filtered.filter(block => 
                        block.begin_no?.toLowerCase().includes(search)
                    );
                }

                if (this.filters.end_no) {
                    const search = this.filters.end_no.toLowerCase();
                    filtered = filtered.filter(block => 
                        block.end_no?.toLowerCase().includes(search)
                    );
                }

                this.filteredBlocks = filtered;
                this.updateToolbar();
            },

            addBlock() {
                const today = new Date().toISOString().split('T')[0];
                const newBlock = {
                    id: null,
                    created_date: today,
                    carrier_id: '',
                    prefix: '',
                    begin_no: '',
                    end_no: '',
                    total_count: 0,
                    available_count: 0,
                    reserved_count: 0,
                    assigned_count: 0,
                    latest_assigned_no: '',
                    remark: '',
                    selected: false,
                    _unsaved: true
                };
                this.blocks.unshift(newBlock);
                this.filterBlocks();
                showToast('info', 'New AWB block added. Don\'t forget to save!');
            },

            updateCounts(block) {
                block._unsaved = true;
                if (block.begin_no && block.end_no) {
                    const begin = parseInt(block.begin_no, 10);
                    const end = parseInt(block.end_no, 10);
                    if (!isNaN(begin) && !isNaN(end) && end >= begin) {
                        block.total_count = (end - begin) + 1;
                        block.available_count = block.total_count - (parseInt(block.reserved_count, 10) || 0) - (parseInt(block.assigned_count, 10) || 0);
                    } else {
                        block.total_count = 0;
                        block.available_count = 0;
                    }
                } else {
                    block.total_count = 0;
                    block.available_count = 0;
                }
            },

            toggleRowSelect(block) {
                block.selected = !block.selected;
                this.updateToolbar();
            },

            toggleSelectAll(checked) {
                this.filteredBlocks.forEach(block => block.selected = checked);
                this.updateToolbar();
            },

            updateToolbar() {
                this.selectedBlocks = this.filteredBlocks.filter(b => b.selected);
                this.allSelected = this.filteredBlocks.length > 0 && 
                                   this.selectedBlocks.length === this.filteredBlocks.length;
            },

            confirmDelete() {
                const n = this.selectedBlocks.length;
                if (!n) return;
                document.getElementById('confirm-msg').textContent =
                    `You are about to permanently delete ${n} AWB block(s). This cannot be undone.`;
                document.getElementById('confirm-overlay').classList.add('open');
            },

            async executeDelete() {
                closeConfirm();
                const ids = this.selectedBlocks.map(b => b.id).filter(id => id !== null);
                
                if (ids.length === 0) {
                    this.blocks = this.blocks.filter(b => !b.selected || b.id !== null);
                    this.filterBlocks();
                    showToast('success', 'Unsaved blocks removed');
                    return;
                }

                showToast('info', 'Deleting...');
                
                try {
                    const response = await fetch('/api/awb-management/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ids })
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.blocks = this.blocks.filter(b => !ids.includes(b.id));
                        this.filterBlocks();
                        showToast('success', data.message || 'Deleted successfully');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    showToast('error', 'Failed to delete AWB blocks');
                }
            },

            async deleteSingleBlock(block) {
                if (!confirm('Delete this AWB block?')) return;

                if (!block.id) {
                    this.blocks = this.blocks.filter(b => b !== block);
                    this.filterBlocks();
                    showToast('success', 'Block removed');
                    return;
                }

                showToast('info', 'Deleting...');

                try {
                    const response = await fetch(`/api/awb-management/${block.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.blocks = this.blocks.filter(b => b.id !== block.id);
                        this.filterBlocks();
                        showToast('success', 'Block deleted');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    showToast('error', 'Failed to delete block');
                }
            },

            hasUnsavedChanges() {
                return this.blocks.some(b => b._unsaved);
            },

            async saveAll() {
                const unsaved = this.blocks.filter(b => b._unsaved);
                if (unsaved.length === 0) return;

                // Validation
                const invalid = unsaved.find(b => !b.carrier_id || !b.begin_no || !b.end_no);
                if (invalid) {
                    showToast('error', 'Carrier, Begin No, and End No are required fields.');
                    return;
                }

                showToast('info', `Saving ${unsaved.length} AWB block(s)...`);

                try {
                    const response = await fetch('/api/awb-management/bulk-save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ blocks: unsaved })
                    });

                    const data = await response.json();
                    if (data.success) {
                        showToast('success', data.message || 'Saved successfully');
                        await this.loadBlocks();
                    } else {
                        showToast('error', data.message || 'Failed to save');
                    }
                } catch (error) {
                    showToast('error', 'Failed to save AWB blocks');
                }
            },

            cancelChanges() {
                if (!confirm('Discard all unsaved changes?')) return;
                this.loadBlocks();
                showToast('info', 'Changes cancelled');
            },

            refreshBlocks() {
                showToast('info', 'Refreshing AWB blocks...');
                this.loadBlocks();
            },

            printTable() {
                const url = new URL('/settings/awb-management-print', window.location.origin);
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
                    const url = new URL('/api/awb-management/export', window.location.origin);
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
                    a.download = 'awb-blocks-' + new Date().toISOString().split('T')[0] + '.csv';
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
        };
    };
    </script>

    {{-- ═══════ MAIN PAGE ═══════ --}}
    <div class="page-content" x-data="awbManagementModule()">

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
                <li>Settings <i class="fa fa-angle-right"></i></li>
                <li><span style="color:#333;font-weight:700;">AWB No. Management</span></li>
            </ul>
        </div>

        <div class="portlet light">

            {{-- ── PORTLET TITLE ── --}}
            <div class="portlet-title">
                <div class="caption" style="display:flex;align-items:center;gap:12px;">
                    <span class="caption-subject">AWB NO. MANAGEMENT</span>
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
                        <button class="btn-tool green" @click="addBlock()" title="Add New AWB Block">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button class="btn-tool" :disabled="selectedBlocks.length === 0" @click="confirmDelete()" title="Delete Selected">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button class="btn-tool" @click="refreshBlocks()" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:6px;margin:0;">
                    <i class="fa fa-search" style="font-size:10px;color:#94a3b8;"></i>
                    <input type="text" x-model="searchTerm" @input="filterBlocks()" class="input-inline" style="width:160px;"
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
                                    <th style="width:120px;">Created Date</th>
                                    <th style="width:200px;"><span style="color:red">*</span>Carrier</th>
                                    <th style="width:80px;">Prefix</th>
                                    <th style="width:120px;"><span style="color:red">*</span>Begin No.</th>
                                    <th style="width:120px;"><span style="color:red">*</span>End No.</th>
                                    <th style="width:80px;text-align:right;">Total Count</th>
                                    <th style="width:80px;text-align:right;">Available</th>
                                    <th style="width:80px;text-align:right;">Reserved</th>
                                    <th style="width:80px;text-align:right;">Assigned</th>
                                    <th style="width:120px;">Latest Assigned</th>
                                    <th style="min-width:200px;">Remark</th>
                                </tr>
                                {{-- FILTER ROW --}}
                                <tr x-show="showFilters" class="filter-row" x-cloak>
                                    <th colspan="2"></th>
                                    <th></th>
                                    <th>
                                        <select x-model="filters.carrier_id" @change="applyFilters()" class="filter-input" style="height:18px;">
                                            <option value="">All</option>
                                            @foreach($carriers as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.prefix" @input="applyFilters()" class="filter-input" placeholder="Filter...">
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.begin_no" @input="applyFilters()" class="filter-input" placeholder="Filter...">
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.end_no" @input="applyFilters()" class="filter-input" placeholder="Filter...">
                                    </th>
                                    <th colspan="6"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(block, index) in filteredBlocks" :key="block.id || index">
                                    <tr @click="toggleRowSelect(block)" :class="{'row-selected': block.selected, 'row-unsaved': block._unsaved}" style="background-color: block._unsaved ? '#fffbeb' : '#fff';">
                                        <td class="sticky-col" style="text-align:center;" @click.stop>
                                            <input type="checkbox" :checked="block.selected" @change="block.selected = !block.selected; updateToolbar()">
                                        </td>
                                        <td class="sticky-col" style="left:30px;text-align:center;" @click.stop>
                                            <i class="fa fa-trash" style="color:#ef4444;cursor:pointer;font-size:10px;" 
                                               @click="deleteSingleBlock(block)" title="Delete"></i>
                                        </td>
                                        <td @click.stop>
                                            <input type="date" x-model="block.created_date" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="block._unsaved = true">
                                        </td>
                                        <td @click.stop>
                                            <select class="select-tool" x-model="block.carrier_id" 
                                                    @change="onCarrierChange(block)" style="width:100%;height:20px;padding:0 2px;font-size:10px;">
                                                <option value="">-- Select --</option>
                                                @foreach($carriers as $c)
                                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="block.prefix" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="block._unsaved = true" maxlength="10">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="block.begin_no" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="updateCounts(block)">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="block.end_no" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="updateCounts(block)">
                                        </td>
                                        <td @click.stop>
                                            <input type="number" x-model="block.total_count" 
                                                   class="input-inline" style="width:100%;text-align:right;"
                                                   @input="block._unsaved = true">
                                        </td>
                                        <td @click.stop>
                                            <input type="number" x-model="block.available_count" 
                                                   class="input-inline" style="width:100%;text-align:right;"
                                                   @input="block._unsaved = true">
                                        </td>
                                        <td @click.stop>
                                            <input type="number" x-model="block.reserved_count" 
                                                   class="input-inline" style="width:100%;text-align:right;" 
                                                   @input="updateCounts(block)">
                                        </td>
                                        <td @click.stop>
                                            <input type="number" x-model="block.assigned_count" 
                                                   class="input-inline" style="width:100%;text-align:right;"
                                                   @input="updateCounts(block)">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="block.latest_assigned_no" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="block._unsaved = true">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="block.remark" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="block._unsaved = true">
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="filteredBlocks.length === 0">
                                    <tr>
                                        <td colspan="13" style="text-align:center;padding:30px 10px;color:#94a3b8;">
                                            <i class="fa fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                                            No AWB records found.
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
                        <i class="fa fa-times"></i> Discard
                    </button>
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:10px;color:#64748b;">
                    <span>Total Records: <span style="font-weight:600;color:#334155;" x-text="filteredBlocks.length"></span></span>
                    <template x-if="selectedBlocks.length > 0">
                        <span style="color:#3b82f6;font-weight:600;">
                            | <span x-text="selectedBlocks.length"></span> selected
                        </span>
                    </template>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function closeConfirm() {
        document.getElementById('confirm-overlay').classList.remove('open');
    }

    window.executeDelete = function() {
        const component = Alpine.$data(document.querySelector('[x-data="awbManagementModule()"]'));
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
