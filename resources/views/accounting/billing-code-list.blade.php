<x-layout>
    @push('styles')
    <x-list-styles />
    <style>
        [x-cloak] { display: none !important; }
        
        /* Data Mapping Modal Specific Styles */
        .mapping-modal-dialog {
            max-width: 700px;
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        
        .mapping-header {
            background: #4b77be;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .mapping-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .mapping-notice {
            background: #fffbeb;
            border: 1px solid #fde047;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 12px;
            color: #854d0e;
            line-height: 1.5;
        }
        
        .mapping-table-wrapper {
            overflow-y: auto;
            max-height: calc(90vh - 220px);
        }
        
        .mapping-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        
        .mapping-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .mapping-table th {
            background: #64748b;
            color: #fff;
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #475569;
        }
        
        .mapping-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .mapping-table tr:hover {
            background: #f8fafc;
        }
        
        .mapping-select {
            width: 100%;
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            background: #fff;
            color: #1e293b;
            cursor: pointer;
        }
        
        .mapping-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }
        
        .mapping-select option {
            color: #1e293b;
            background: #fff;
        }
        
        .mapping-footer {
            padding: 15px 20px;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
    @endpush

    {{-- ═══════ TOAST CONTAINER ═══════ --}}
    <div class="toast-container" id="toast-container"></div>

    {{-- ═══════ DELETE CONFIRM MODAL ═══════ --}}
    <div class="overlay" id="confirm-overlay" onclick="if(event.target===this) closeConfirm()">
        <div class="confirm-box">
            <div class="confirm-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <h4>Delete Billing Code(s)?</h4>
            <p id="confirm-msg">This action cannot be undone.</p>
            <div class="confirm-actions">
                <button class="btn-tool" style="padding:0 18px;height:26px;" onclick="closeConfirm()">Cancel</button>
                <button class="btn-tool danger" style="padding:0 18px;height:26px;" onclick="executeDelete()">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════ DATA MAPPING MODAL ═══════ --}}
    <div class="overlay" id="mapping-overlay" x-data="dataMappingModal()" 
         :style="isOpen ? 'display: flex !important; opacity: 1; pointer-events: auto;' : 'display: none !important;'"
         @click="if($event.target === $el) closeModal()">
        <div class="mapping-modal-dialog" @click.stop>
            <div class="mapping-header">
                <h4><i class="fa fa-link"></i> Data Mapping</h4>
                <i class="fa fa-times" @click="closeModal()" style="cursor:pointer;font-size:18px;"></i>
            </div>
            <div class="modal-body" style="padding:20px;overflow-y:auto;">
                <div class="mapping-notice">
                    <i class="fa fa-info-circle"></i>
                    <strong>Please select the current Freight Code or the IATA Charge Items.</strong> If it's not listed, ensure it's active in the Billing Code setup. Matched item charge won't affect any existing invoice—only those created after the update.
                </div>
                
                <div class="mapping-table-wrapper">
                    <table class="mapping-table">
                        <thead>
                            <tr>
                                <th style="width:50%;">IATA Charge Item</th>
                                <th style="width:50%;">Freight Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in iataItems" :key="index">
                                <tr>
                                    <td>
                                        <span x-text="item.code + ' - ' + item.name" style="color:#475569;"></span>
                                    </td>
                                    <td>
                                        <select x-model="item.freight_code_id" class="mapping-select">
                                            <option value="">--- Select ---</option>
                                            <template x-for="code in freightCodes" :key="code.id">
                                                <option :value="code.id" x-text="code.code + ' - ' + code.name"></option>
                                            </template>
                                        </select>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mapping-footer">
                <button @click="closeModal()" class="btn-tool" style="padding:8px 20px;font-size:12px;">Cancel</button>
                <button @click="confirmMapping()" class="btn-tool" style="padding:8px 20px;font-size:12px;background:#22c55e;color:#fff;border-color:#22c55e;">
                    <i class="fa fa-check"></i> Confirm
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
                <li><span style="color:#333;font-weight:700;">Billing Code</span></li>
            </ul>
        </div>

        <div class="portlet light" x-data="billingCodeList()">

            {{-- ── PORTLET TITLE ── --}}
            <div class="portlet-title">
                <div class="caption" style="display:flex;align-items:center;gap:12px;">
                    <span class="caption-subject">BILLING CODE</span>
                </div>
                <div class="actions" style="display:flex;gap:4px;position:relative;align-items:center;">
                    <button class="btn-action-round white" onclick="window.dispatchEvent(new CustomEvent('open-mapping-modal'))" title="Data Mapping with IATA Charge Item">
                        <i class="fa fa-link"></i> Data Mapping
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
                        <button class="btn-tool green" @click="addCode()" title="Add New Billing Code">
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
                <div style="display:flex;align-items:center;gap:10px;margin:0;">
                    <select class="select-tool" x-model="departmentFilter" @change="filterCodes()" style="width:120px;">
                        <option value="">All Departments</option>
                        <option value="A/R">A/R</option>
                        <option value="A/P">A/P</option>
                        <option value="Payroll">Payroll</option>
                    </select>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <i class="fa fa-search" style="font-size:10px;color:#94a3b8;"></i>
                        <input type="text" x-model="searchTerm" @input="filterCodes()" class="input-inline" style="width:160px;"
                               placeholder="Quick search...">
                    </div>
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
                                    <th class="sticky-col sticky-col-header" style="width:130px;left:55px;">Billing Code</th>
                                    <th style="width:140px;">Name(Eng.)</th>
                                    <th style="width:140px;">Name(Local)</th>
                                    <th style="width:90px;">Revenue</th>
                                    <th style="width:90px;">Cost</th>
                                    <th style="width:90px;">Credit</th>
                                    <th style="width:90px;">Debit</th>
                                    <th style="width:80px;text-align:center;">Department</th>
                                    <th style="width:60px;text-align:center;">A/R</th>
                                    <th style="width:60px;text-align:center;">A/P</th>
                                    <th style="width:60px;text-align:center;">D/C</th>
                                    <th style="width:60px;text-align:center;">B&A</th>
                                    <th style="width:60px;text-align:center;">Payroll</th>
                                    <th style="width:60px;text-align:center;">OHW</th>
                                    <th style="width:60px;text-align:center;">OIM</th>
                                    <th style="width:60px;text-align:center;">AIM</th>
                                    <th style="width:60px;text-align:center;">AIE</th>
                                    <th style="width:60px;text-align:center;">OEM</th>
                                    <th style="width:60px;text-align:center;">OEW</th>
                                    <th style="width:60px;text-align:center;">Aerial</th>
                                    <th style="width:60px;text-align:center;">Alog</th>
                                    <th style="width:60px;text-align:center;">TK</th>
                                    <th style="width:60px;text-align:center;">Misc.</th>
                                    <th style="width:60px;text-align:center;">WH</th>
                                    <th style="width:80px;text-align:center;">Active</th>
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
                                            <input type="text" x-model="code.code" 
                                                   class="input-inline" style="width:100%;font-weight:600;"
                                                   @input="code._unsaved = true" placeholder="Code">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.name_eng" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Name (Eng)">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.name_local" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Name (Local)">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.revenue" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Revenue">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.cost" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Cost">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.credit" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Credit">
                                        </td>
                                        <td @click.stop>
                                            <input type="text" x-model="code.debit" 
                                                   class="input-inline" style="width:100%;"
                                                   @input="code._unsaved = true" placeholder="Debit">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <select class="select-tool" x-model="code.department" 
                                                    @change="code._unsaved = true" style="width:100%;">
                                                <option value="">--</option>
                                                <option value="All">All</option>
                                                <option value="A/R">A/R</option>
                                                <option value="A/P">A/P</option>
                                                <option value="Payroll">Payroll</option>
                                            </select>
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.ar" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.ap" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.dc" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.ba" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.payroll" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.ohw" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.oim" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.aim" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.aie" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.oem" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.oew" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.aerial" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.alog" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.tk" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.misc" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.wh" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="code.is_active" @change="code._unsaved = true" @click.stop style="width:16px;height:16px;">
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="filteredCodes.length === 0">
                                    <tr>
                                        <td colspan="25" style="text-align:center;padding:30px 10px;color:#94a3b8;">
                                            <i class="fa fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                                            No billing codes found.
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
    function billingCodeList() {
        return {
            codes: @json($codes ?? []),
            filteredCodes: [],
            selectedCodes: [],
            searchTerm: '',
            departmentFilter: '',
            allSelected: false,

            init() {
                this.filteredCodes = [...this.codes];
                this.loadCodes();
            },

            async loadCodes() {
                try {
                    const response = await fetch('/api/billing-codes');
                    if (response.ok) {
                        const data = await response.json();
                        this.codes = data.codes || [];
                        this.filteredCodes = [...this.codes];
                    }
                } catch (error) {
                    console.error('Failed to load billing codes:', error);
                }
            },

            filterCodes() {
                let filtered = [...this.codes];
                
                if (this.departmentFilter) {
                    filtered = filtered.filter(code => code.department === this.departmentFilter);
                }
                
                if (this.searchTerm) {
                    const search = this.searchTerm.toLowerCase();
                    filtered = filtered.filter(code => {
                        return code.code?.toLowerCase().includes(search) ||
                               code.name_eng?.toLowerCase().includes(search) ||
                               code.name_local?.toLowerCase().includes(search);
                    });
                }

                this.filteredCodes = filtered;
            },

            addCode() {
                const newCode = {
                    id: null, code: '', name_eng: '', name_local: '',
                    revenue: '', cost: '', credit: '', debit: '',
                    department: '', ar: false, ap: false, dc: false,
                    ba: false, payroll: false, ohw: false, oim: false,
                    aim: false, aie: false, oem: false, oew: false,
                    aerial: false, alog: false, tk: false, misc: false,
                    wh: false, is_active: true, selected: false, _unsaved: true
                };
                this.codes.unshift(newCode);
                this.filteredCodes = [...this.codes];
                showToast('info', 'New billing code added. Don\'t forget to save!');
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
                    `You are about to permanently delete ${n} billing code(s). This cannot be undone.`;
                document.getElementById('confirm-overlay').classList.add('open');
            },

            async executeDelete() {
                closeConfirm();
                const ids = this.selectedCodes.map(c => c.id).filter(id => id !== null);
                
                if (ids.length === 0) {
                    this.codes = this.codes.filter(c => !c.selected || c.id !== null);
                    this.filteredCodes = [...this.codes];
                    showToast('success', 'Unsaved codes removed');
                    return;
                }

                showToast('info', 'Deleting...');
                
                try {
                    const response = await fetch('/api/billing-codes/bulk-delete', {
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
                        this.filteredCodes = [...this.codes];
                        showToast('success', data.message || 'Deleted successfully');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    showToast('error', 'Failed to delete billing codes');
                }
            },

            async deleteSingleCode(code) {
                if (!confirm('Delete this billing code?')) return;

                if (!code.id) {
                    this.codes = this.codes.filter(c => c !== code);
                    this.filteredCodes = [...this.codes];
                    showToast('success', 'Code removed');
                    return;
                }

                showToast('info', 'Deleting...');

                try {
                    const response = await fetch(`/api/billing-codes/${code.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.codes = this.codes.filter(c => c.id !== code.id);
                        this.filteredCodes = [...this.codes];
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

                showToast('info', `Saving ${unsaved.length} billing code(s)...`);

                try {
                    const response = await fetch('/api/billing-codes/bulk-save', {
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
                        
                        showToast('success', `${unsaved.length} billing code(s) saved successfully`);
                        await this.loadCodes();
                    } else {
                        showToast('error', data.message || 'Failed to save');
                    }
                } catch (error) {
                    showToast('error', 'Failed to save billing codes');
                }
            },

            cancelChanges() {
                if (!confirm('Discard all unsaved changes?')) return;
                this.loadCodes();
                showToast('info', 'Changes cancelled');
            },

            refreshCodes() {
                showToast('info', 'Refreshing billing codes...');
                this.loadCodes();
            },

            printTable() {
                const url = new URL('{{ route("accounting.billing-code-list-print") }}');
                if (this.searchTerm) url.searchParams.set('search', this.searchTerm);
                showToast('info', 'Opening print view...');
                window.open(url.toString(), '_blank');
            },

            async exportExcel() {
                showToast('info', 'Preparing Excel export...');
                
                try {
                    const response = await fetch('/api/billing-codes/export');
                    if (!response.ok) throw new Error('Export failed');
                    
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'billing-codes-' + new Date().toISOString().split('T')[0] + '.csv';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                    showToast('success', 'Excel file downloaded');
                } catch (error) {
                    console.error('Export error:', error);
                    showToast('error', 'Failed to export Excel');
                }
            }
        }
    }

    // Data Mapping Modal
    function dataMappingModal() {
        return {
            isOpen: false,
            iataItems: @json($iataItems ?? []),
            freightCodes: @json($freightCodes ?? []),
            
            init() {
                window.addEventListener('open-mapping-modal', () => {
                    this.openModal();
                });
            },
            
            async openModal() {
                // Load latest data
                try {
                    const response = await fetch('/api/billing-codes/mapping-data');
                    if (response.ok) {
                        const data = await response.json();
                        this.iataItems = data.iata_items || [];
                        this.freightCodes = data.freight_codes || [];
                    }
                } catch (error) {
                    console.error('Failed to load mapping data:', error);
                }
                this.isOpen = true;
            },
            
            closeModal() {
                this.isOpen = false;
            },
            
            async confirmMapping() {
                const mappings = this.iataItems.map(item => ({
                    iata_code: item.code,
                    freight_code_id: item.freight_code_id
                })).filter(m => m.freight_code_id);
                
                if (mappings.length === 0) {
                    showToast('info', 'No mappings to save');
                    this.closeModal();
                    return;
                }

                showToast('info', `Saving ${mappings.length} mapping(s)...`);
                
                try {
                    const response = await fetch('/api/billing-codes/save-mappings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ mappings })
                    });

                    const data = await response.json();
                    if (data.success) {
                        showToast('success', `${mappings.length} mapping(s) saved successfully`);
                        showToast('info', 'Data mapping will apply to new invoices only');
                        this.closeModal();
                    } else {
                        showToast('error', data.message || 'Failed to save mappings');
                    }
                } catch (error) {
                    showToast('error', 'Failed to save mappings');
                }
            }
        }
    }

    function closeConfirm() {
        document.getElementById('confirm-overlay').classList.remove('open');
    }

    window.executeDelete = function() {
        const component = Alpine.$data(document.querySelector('[x-data="billingCodeList()"]'));
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
