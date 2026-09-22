<x-layout>
    @push('styles')
    <x-list-styles />
    <style>
        [x-cloak] { display: none !important; }
        .row-unsaved { background-color: #fffbeb !important; }
        .active-filter { background-color: #3b82f6 !important; color: white !important; border-color: #3b82f6 !important; }
        .filter-input {
            width: 100%;
            height: 20px;
            font-size: 10px;
            padding: 2px 4px;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            background: #ffffff;
        }
        .filter-row th {
            background-color: #f1f5f9 !important;
            padding: 3px 4px !important;
        }
        @media (max-width: 768px) {
            .portlet-title { flex-direction: column; align-items: flex-start !important; gap: 8px; }
            .portlet-tool { flex-direction: column; align-items: stretch !important; gap: 8px; }
            .modal-dialog { max-width: 95vw !important; margin: 10px auto; }
        }
    </style>
    @endpush

    {{-- ═══════ TOAST CONTAINER ═══════ --}}
    <div class="toast-container" id="toast-container"></div>

    {{-- ═══════ DELETE CONFIRM MODAL ═══════ --}}
    <div class="overlay" id="confirm-overlay" onclick="if(event.target===this) closeConfirm()">
        <div class="confirm-box">
            <div class="confirm-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <h4>Delete Bank(s)?</h4>
            <p id="confirm-msg">This action cannot be undone.</p>
            <div class="confirm-actions">
                <button class="btn-tool" style="padding:0 18px;height:26px;" onclick="closeConfirm()">Cancel</button>
                <button class="btn-tool danger" style="padding:0 18px;height:26px;" onclick="executeDelete()">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════ CHECK NO. SEQUENCE MODAL ═══════ --}}
    <div class="overlay" id="checkno-overlay" x-data="checkNoModal()" 
         :style="isOpen ? 'display: flex !important; opacity: 1; pointer-events: auto;' : 'display: none !important;'"
         @click="if($event.target === $el) closeModal()">
        <div class="modal-dialog" style="max-width:900px;width:100%;background:#fff;border-radius:6px;overflow:hidden;" @click.stop>
            <div class="modal-header" style="background:#4b77be;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;">
                <h4 style="margin:0;font-size:16px;font-weight:600;">Check No. Sequence Settings</h4>
                <i class="fa fa-times" @click="closeModal()" style="cursor:pointer;font-size:18px;"></i>
            </div>
            <div class="modal-body" style="padding:20px;max-height:75vh;overflow-y:auto;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                    <div style="display:flex;gap:8px;">
                        <button @click="addSequence()" class="btn-tool green" style="padding:6px 14px;font-size:12px;">
                            <i class="fa fa-plus"></i> Add
                        </button>
                        <button @click="deleteSelected()" class="btn-tool" style="padding:6px 14px;font-size:12px;">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
                <div style="overflow-x:auto;max-height:400px;">
                    <table class="table-custom" style="width:100%;font-size:12px;">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th style="width:40px;text-align:center;"><input type="checkbox" @change="toggleAll($event.target.checked)"></th>
                                <th style="width:220px;padding:10px;">Office</th>
                                <th style="width:140px;padding:10px;">Prefix</th>
                                <th style="width:180px;padding:10px;">Start / Current No.</th>
                                <th style="width:140px;padding:10px;">End No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(seq, idx) in sequences" :key="idx">
                                <tr>
                                    <td style="text-align:center;padding:8px;">
                                        <input type="checkbox" x-model="seq.selected" style="width:16px;height:16px;">
                                    </td>
                                    <td style="padding:8px;">
                                        <select x-model="seq.office" 
                                                style="width:100%;font-size:12px;padding:6px 8px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;">
                                            <option value="" style="color:#1e293b;background:#fff;">All / All Others</option>
                                            @foreach($offices as $office)
                                                <option value="{{ $office->id }}" style="color:#1e293b;background:#fff;">{{ $office->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="padding:8px;">
                                        <input type="text" x-model="seq.prefix" style="width:100%;font-size:12px;padding:6px 8px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="CAD">
                                    </td>
                                    <td style="padding:8px;">
                                        <input type="number" x-model="seq.start_no" style="width:100%;text-align:right;font-size:12px;padding:6px 8px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="3">
                                    </td>
                                    <td style="padding:8px;">
                                        <input type="number" x-model="seq.end_no" style="width:100%;text-align:right;font-size:12px;padding:6px 8px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="200">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="padding:15px 20px;background:#f8fafc;display:flex;justify-content:flex-end;gap:8px;">
                <button @click="closeModal()" class="btn-tool" style="padding:8px 20px;font-size:12px;">Cancel</button>
                <button @click="saveSequences()" class="btn-tool" style="padding:8px 20px;font-size:12px;background:#22c55e;color:#fff;border-color:#22c55e;">OK</button>
            </div>
        </div>
    </div>

    {{-- ═══════ CLEAR CHECK BY CYCLE MODAL ═══════ --}}
    <div class="overlay" id="clearcheck-overlay" x-data="clearCheckModal()" 
         :style="isOpen ? 'display: flex !important; opacity: 1; pointer-events: auto;' : 'display: none !important;'"
         @click="if($event.target === $el) closeModal()">
        <div class="modal-dialog" style="max-width:650px;width:100%;background:#fff;border-radius:6px;overflow:hidden;" @click.stop>
            <div class="modal-header" style="background:#4b77be;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;">
                <h4 style="margin:0;font-size:16px;font-weight:600;">Clear Check by Excel Configuration</h4>
                <i class="fa fa-times" @click="closeModal()" style="cursor:pointer;font-size:18px;"></i>
            </div>
            <div class="modal-body" style="padding:25px 20px;max-height:75vh;overflow-y:auto;">
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:15px;">
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            <span style="color:#ef4444;margin-right:2px;">*</span> Start Row
                        </label>
                        <input type="number" x-model="config.startRow" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="(Ex: 1)">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            <span style="color:#ef4444;margin-right:2px;">*</span> Date Column
                        </label>
                        <input type="text" x-model="config.dateColumn" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="(Ex: 1)">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            <span style="color:#ef4444;margin-right:2px;">*</span> Date Format
                        </label>
                        <input type="text" x-model="config.dateFormat" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="mm/dd/yyyy">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            <span style="color:#ef4444;margin-right:2px;">*</span> Check No. Column
                        </label>
                        <input type="text" x-model="config.checkNoColumn" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="(Ex: 1)">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            <span style="color:#ef4444;margin-right:2px;">*</span> Amount Column
                        </label>
                        <input type="text" x-model="config.amountColumn" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="(Ex: 1)">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            Check Condition Column
                        </label>
                        <input type="text" x-model="config.conditionColumn" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="(Ex: 1)">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            Check Condition
                        </label>
                        <input type="text" x-model="config.condition" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="(Ex: CHECK)">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#475569;font-weight:600;">
                            Check No. Exclude ⓘ
                        </label>
                        <input type="text" x-model="config.exclude" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="(Ex: CHECK)">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding:15px 20px;background:#f8fafc;display:flex;justify-content:flex-end;gap:8px;">
                <button @click="closeModal()" class="btn-tool" style="padding:8px 20px;font-size:12px;">Cancel</button>
                <button @click="saveConfig()" class="btn-tool" style="padding:8px 20px;font-size:12px;background:#22c55e;color:#fff;border-color:#22c55e;">OK</button>
            </div>
        </div>
    </div>

    {{-- ═══════ DISPLAY INFORMATION MODAL ═══════ --}}
    <div class="overlay" id="displayinfo-overlay" x-data="displayInfoModal()" 
         :style="isOpen ? 'display: flex !important; opacity: 1; pointer-events: auto;' : 'display: none !important;'"
         @click="if($event.target === $el) closeModal()">
        <div class="modal-dialog" style="max-width:650px;width:100%;background:#fff;border-radius:6px;overflow:hidden;" @click.stop>
            <div class="modal-header" style="background:#4b77be;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;">
                <h4 style="margin:0;font-size:16px;font-weight:600;">Display Information Settings</h4>
                <i class="fa fa-times" @click="closeModal()" style="cursor:pointer;font-size:18px;"></i>
            </div>
            <div class="modal-body" style="padding:25px 20px;max-height:75vh;overflow-y:auto;">
                <p style="font-size:13px;color:#64748b;margin-bottom:20px;line-height:1.5;">
                    Please enter bank information to be shown on invoices and account statements.
                </p>
                <textarea x-model="displayText" rows="8" 
                          style="width:100%;resize:vertical;font-size:13px;padding:10px 12px;line-height:1.6;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" 
                          placeholder="Enter bank display information..."></textarea>
            </div>
            <div class="modal-footer" style="padding:15px 20px;background:#f8fafc;display:flex;justify-content:flex-end;gap:8px;">
                <button @click="closeModal()" class="btn-tool" style="padding:8px 20px;font-size:12px;">Cancel</button>
                <button @click="saveDisplayInfo()" class="btn-tool" style="padding:8px 20px;font-size:12px;background:#22c55e;color:#fff;border-color:#22c55e;">OK</button>
            </div>
        </div>
    </div>

    {{-- ═══════ INVOICE REMARK MODAL ═══════ --}}
    <div class="overlay" id="invoiceremark-overlay" x-data="invoiceRemarkModal()" 
         :style="isOpen ? 'display: flex !important; opacity: 1; pointer-events: auto;' : 'display: none !important;'"
         @click="if($event.target === $el) closeModal()">
        <div class="modal-dialog" style="max-width:700px;width:100%;background:#fff;border-radius:6px;overflow:hidden;" @click.stop>
            <div class="modal-header" style="background:#4b77be;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;">
                <h4 style="margin:0;font-size:16px;font-weight:600;">Invoice Remark Settings</h4>
                <i class="fa fa-times" @click="closeModal()" style="cursor:pointer;font-size:18px;"></i>
            </div>
            <div class="modal-body" style="padding:20px;max-height:75vh;overflow-y:auto;">
                <div style="margin-bottom:15px;background:#f8fafc;padding:12px;border:1px solid #e2e8f0;border-radius:4px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <label style="font-size:13px;color:#334155;font-weight:600;margin:0;">Set as Default Invoice Bank</label>
                        <div @click="toggleDefault()" 
                             style="width:44px;height:22px;border-radius:11px;position:relative;cursor:pointer;transition:background 0.3s;" 
                             :style="isDefault ? 'background:#22c55e' : 'background:#cbd5e1'">
                            <div style="width:18px;height:18px;background:#fff;border-radius:50%;position:absolute;top:2px;transition:left 0.3s;box-shadow:0 1px 2px rgba(0,0,0,0.2);" 
                                 :style="isDefault ? 'left:24px' : 'left:2px'"></div>
                        </div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                    <div style="grid-column: span 2;">
                        <label style="display:block;margin-bottom:4px;font-size:12px;color:#475569;font-weight:600;">
                            <span style="color:#ef4444;margin-right:2px;">*</span> Bank Name
                        </label>
                        <input type="text" x-model="bankInfo.name" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="Enter bank name">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block;margin-bottom:4px;font-size:12px;color:#475569;font-weight:600;">Bank Address</label>
                        <input type="text" x-model="bankInfo.address" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="Enter bank address">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:4px;font-size:12px;color:#475569;font-weight:600;">Bank Account No.</label>
                        <input type="text" x-model="bankInfo.accountNo" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="Enter account number">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:4px;font-size:12px;color:#475569;font-weight:600;">SWIFT Code</label>
                        <input type="text" x-model="bankInfo.swiftCode" style="width:100%;padding:6px 10px;font-size:12px;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="Enter SWIFT code">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block;margin-bottom:4px;font-size:12px;color:#475569;font-weight:600;">Remark</label>
                        <textarea x-model="bankInfo.remark" rows="3" style="width:100%;resize:vertical;font-size:12px;padding:8px 10px;line-height:1.5;border:1px solid #cbd5e1;border-radius:4px;background:#fff;color:#1e293b;" placeholder="Enter remark..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding:15px 20px;background:#f8fafc;display:flex;justify-content:flex-end;gap:8px;">
                <button @click="closeModal()" class="btn-tool" style="padding:8px 20px;font-size:12px;">Cancel</button>
                <button @click="saveSettings()" class="btn-tool" style="padding:8px 20px;font-size:12px;background:#22c55e;color:#fff;border-color:#22c55e;">Save</button>
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
                <li><span style="color:#333;font-weight:700;">Bank List</span></li>
            </ul>
        </div>

        <div class="portlet light" x-data="bankList()">

            {{-- ── PORTLET TITLE ── --}}
            <div class="portlet-title">
                <div class="caption" style="display:flex;align-items:center;gap:12px;">
                    <span class="caption-subject">BANK LIST</span>
                </div>
                <div class="actions" style="display:flex;gap:4px;position:relative;align-items:center;">
                    <button class="btn-action-round white" :class="{'active-filter': showFilters}" @click="toggleFilters()" title="Toggle Column Filters">
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
                        <button class="btn-tool green" @click="addBank()" title="Add New Bank">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button class="btn-tool" :disabled="selectedBanks.length === 0" @click="confirmDelete()" title="Delete Selected">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button class="btn-tool" @click="refreshBanks()" title="Refresh Data">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:6px;margin:0;">
                    <i class="fa fa-search" style="font-size:10px;color:#94a3b8;"></i>
                    <input type="text" x-model="searchTerm" @input="filterBanks()" class="input-inline" style="width:160px;"
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
                                    <th class="sticky-col sticky-col-header" style="width:140px;left:55px;">Bank Name</th>
                                    <th style="width:180px;">G/L No.</th>
                                    <th style="width:100px;text-align:right;">Initial Amount</th>
                                    <th style="width:80px;">Currency</th>
                                    <th style="width:80px;text-align:center;">Revenue Default</th>
                                    <th style="width:80px;text-align:center;">Cost Default</th>
                                    <th style="width:130px;">Notes Receivable</th>
                                    <th style="width:130px;">Notes Payable</th>
                                    <th style="width:80px;text-align:center;">Active</th>
                                    <th style="width:100px;">Inactive Date</th>
                                    <th style="width:150px;text-align:center;">More Settings</th>
                                </tr>
                                {{-- COLUMN FILTER ROW --}}
                                <tr x-show="showFilters" class="filter-row" x-cloak>
                                    <th colspan="2" class="sticky-col" style="left:0;"></th>
                                    <th class="sticky-col" style="left:55px;">
                                        <input type="text" x-model="filters.bank_name" @input="filterBanks()" class="filter-input" placeholder="Bank Name...">
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.gl_no" @input="filterBanks()" class="filter-input" placeholder="G/L No...">
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.initial_amount" @input="filterBanks()" class="filter-input" placeholder="Amount...">
                                    </th>
                                    <th>
                                        <input type="text" x-model="filters.currency" @input="filterBanks()" class="filter-input" placeholder="Currency...">
                                    </th>
                                    <th colspan="4"></th>
                                    <th>
                                        <select x-model="filters.is_active" @change="filterBanks()" class="filter-input">
                                            <option value="">ALL</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(bank, index) in filteredBanks" :key="bank.id || index">
                                    <tr @click="toggleRowSelect(bank)" :class="{'row-selected': bank.selected, 'row-unsaved': bank._unsaved}">
                                        <td class="sticky-col" style="text-align:center;" @click.stop>
                                            <input type="checkbox" :checked="bank.selected" @change="bank.selected = !bank.selected; updateToolbar()">
                                        </td>
                                        <td class="sticky-col" style="left:30px;text-align:center;" @click.stop>
                                            <i class="fa fa-trash" style="color:#ef4444;cursor:pointer;font-size:10px;" 
                                               @click="deleteSingleBank(bank)" title="Delete"></i>
                                        </td>
                                        <td class="sticky-col" style="left:55px;" @click.stop>
                                            <input type="text" x-model="bank.bank_name" 
                                                   class="input-inline" style="width:100%;font-weight:600;"
                                                   @input="bank._unsaved = true" placeholder="Bank Name">
                                        </td>
                                        <td @click.stop>
                                            <div style="display:flex;align-items:center;gap:3px;">
                                                <input type="text" x-model="bank.gl_no" 
                                                       class="input-inline" style="width:100%;"
                                                       @input="bank._unsaved = true" placeholder="G/L No.">
                                                <button type="button" class="btn-tool-icon" style="padding:2px 4px;font-size:9px;" @click="bank.gl_no = ''; bank._unsaved = true" title="Clear">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td @click.stop>
                                            <input type="number" step="0.01" x-model="bank.initial_amount" 
                                                   class="input-inline" style="width:100%;text-align:right;"
                                                   @input="bank._unsaved = true">
                                        </td>
                                        <td @click.stop>
                                            <select class="select-tool" x-model="bank.currency" 
                                                    @change="bank._unsaved = true" style="width:100%;">
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->code }}">{{ $currency->code }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <i class="fa fa-circle" :style="bank.revenue_default ? 'color:#22c55e' : 'color:#cbd5e1'" 
                                               style="cursor:pointer;font-size:10px;" 
                                               @click.stop="toggleRevenueDefault(bank)"></i>
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <i class="fa fa-circle" :style="bank.cost_default ? 'color:#22c55e' : 'color:#cbd5e1'" 
                                               style="cursor:pointer;font-size:10px;" 
                                               @click.stop="toggleCostDefault(bank)"></i>
                                        </td>
                                        <td @click.stop>
                                            <select class="select-tool" x-model="bank.notes_receivable" 
                                                    @change="bank._unsaved = true" style="width:100%;">
                                                <option value="">Select...</option>
                                                <option value="Notes Receivable Standard">Notes Receivable Standard</option>
                                                <option value="Notes Receivable Special">Notes Receivable Special</option>
                                            </select>
                                        </td>
                                        <td @click.stop>
                                            <select class="select-tool" x-model="bank.notes_payable" 
                                                    @change="bank._unsaved = true" style="width:100%;">
                                                <option value="">Select...</option>
                                                <option value="Notes Payable Standard">Notes Payable Standard</option>
                                                <option value="Notes Payable Special">Notes Payable Special</option>
                                            </select>
                                        </td>
                                        <td style="text-align:center;" @click.stop>
                                            <input type="checkbox" x-model="bank.is_active" 
                                                   @change="bank._unsaved = true"
                                                   style="width:16px;height:16px;">
                                        </td>
                                        <td @click.stop>
                                            <div style="display:flex;align-items:center;gap:3px;">
                                                <input type="date" x-model="bank.inactive_date" 
                                                       :id="'inactive-date-' + index"
                                                       class="input-inline" style="width:100%;"
                                                       @input="bank._unsaved = true">
                                            </div>
                                        </td>
                                        <td onclick="event.stopPropagation()" style="text-align:center;overflow:visible !important;position:relative;">
                                            <div style="position:relative;">
                                                <button type="button" onclick="toggleSettingsDropdown(this, event)" 
                                                        class="btn-tool" style="font-size:9px;padding:3px 10px;">
                                                    <i class="fa fa-cog"></i> Settings <i class="fa fa-caret-down" style="margin-left:3px;"></i>
                                                </button>
                                                <div class="settings-dropdown" style="display:none;position:absolute;right:0;top:100%;margin-top:4px;background:#fff;border:1px solid #cbd5e1;border-radius:4px;min-width:200px;box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:9999;padding:4px 0;">
                                                    <div onclick="openSettingsModal(event, 'checkno', this)" 
                                                         style="padding:8px 16px;cursor:pointer;font-size:11px;color:#334155;display:flex;align-items:center;gap:8px;background:#fff;"
                                                         onmouseover="this.style.background='#f1f5f9'" 
                                                         onmouseout="this.style.background='#fff'">
                                                        <i class="fa fa-list-ol" style="color:#4b77be;width:16px;"></i>
                                                        <span>Check No. Sequence</span>
                                                    </div>
                                                    <div onclick="openSettingsModal(event, 'clearcheck', this)" 
                                                         style="padding:8px 16px;cursor:pointer;font-size:11px;color:#334155;display:flex;align-items:center;gap:8px;background:#fff;"
                                                         onmouseover="this.style.background='#f1f5f9'" 
                                                         onmouseout="this.style.background='#fff'">
                                                        <i class="fa fa-refresh" style="color:#4b77be;width:16px;"></i>
                                                        <span>Clear Check by Cycle</span>
                                                    </div>
                                                    <div onclick="openSettingsModal(event, 'displayinfo', this)" 
                                                         style="padding:8px 16px;cursor:pointer;font-size:11px;color:#334155;display:flex;align-items:center;gap:8px;background:#fff;"
                                                         onmouseover="this.style.background='#f1f5f9'" 
                                                         onmouseout="this.style.background='#fff'">
                                                        <i class="fa fa-info-circle" style="color:#4b77be;width:16px;"></i>
                                                        <span>Display Information</span>
                                                    </div>
                                                    <div onclick="openSettingsModal(event, 'invoiceremark', this)" 
                                                         style="padding:8px 16px;cursor:pointer;font-size:11px;color:#334155;display:flex;align-items:center;gap:8px;background:#fff;"
                                                         onmouseover="this.style.background='#f1f5f9'" 
                                                         onmouseout="this.style.background='#fff'">
                                                        <i class="fa fa-file-text" style="color:#4b77be;width:16px;"></i>
                                                        <span>Invoice Remark Settings</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="filteredBanks.length === 0">
                                    <tr>
                                        <td colspan="13" style="text-align:center;padding:30px 10px;color:#94a3b8;">
                                            <i class="fa fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                                            No banks found.
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
                        <i class="fa fa-save"></i> Save All
                    </button>
                    <button class="btn-tool" @click="cancelChanges()" 
                            :disabled="!hasUnsavedChanges()"
                            title="Cancel all changes">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:10px;color:#64748b;">
                    <span>Total Records: <span style="font-weight:600;color:#334155;" x-text="filteredBanks.length"></span></span>
                    <template x-if="selectedBanks.length > 0">
                        <span style="color:#3b82f6;font-weight:600;">
                            | <span x-text="selectedBanks.length"></span> selected
                        </span>
                    </template>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    let currentBank = null;
    let currentBankIndex = null;
    let currentDropdown = null;

    const currenciesData = @json($currencies);
    const officesData = @json($offices);
    const glAccountsData = @json($glAccounts);

    function toggleSettingsDropdown(button, event) {
        event.stopPropagation();
        
        if (currentDropdown && currentDropdown !== button.nextElementSibling) {
            currentDropdown.style.display = 'none';
        }
        
        const dropdown = button.nextElementSibling;
        
        if (dropdown.style.display === 'none' || !dropdown.style.display) {
            dropdown.style.display = 'block';
            currentDropdown = dropdown;
        } else {
            dropdown.style.display = 'none';
            currentDropdown = null;
        }
    }

    document.addEventListener('click', function(e) {
        if (currentDropdown && !currentDropdown.contains(e.target)) {
            currentDropdown.style.display = 'none';
            currentDropdown = null;
        }
    });

    function openSettingsModal(event, modalType, element) {
        event.stopPropagation();
        
        if (currentDropdown) {
            currentDropdown.style.display = 'none';
            currentDropdown = null;
        }

        const row = element.closest('tr');
        const component = Alpine.$data(document.querySelector('[x-data="bankList()"]'));
        const index = Array.from(row.parentElement.children).indexOf(row);
        
        if (component && component.filteredBanks[index]) {
            currentBank = component.filteredBanks[index];
            currentBankIndex = index;
        }

        if (modalType === 'checkno') {
            window.dispatchEvent(new CustomEvent('open-checkno-modal'));
        } else if (modalType === 'clearcheck') {
            window.dispatchEvent(new CustomEvent('open-clearcheck-modal'));
        } else if (modalType === 'displayinfo') {
            window.dispatchEvent(new CustomEvent('open-displayinfo-modal'));
        } else if (modalType === 'invoiceremark') {
            window.dispatchEvent(new CustomEvent('open-invoiceremark-modal'));
        }
    }

    function bankList() {
        return {
            banks: @json($banks ?? []),
            filteredBanks: [],
            selectedBanks: [],
            searchTerm: '',
            allSelected: false,
            showFilters: false,
            filters: {
                bank_name: '',
                gl_no: '',
                initial_amount: '',
                currency: '',
                is_active: ''
            },

            init() {
                this.filteredBanks = [...this.banks];
                this.loadBanks();
            },

            toggleFilters() {
                this.showFilters = !this.showFilters;
            },

            toggleRevenueDefault(bank) {
                if (!bank.revenue_default) {
                    bank.revenue_default = true;
                    bank.cost_default = false;
                } else {
                    bank.revenue_default = false;
                }
                bank._unsaved = true;
            },

            toggleCostDefault(bank) {
                if (!bank.cost_default) {
                    bank.cost_default = true;
                    bank.revenue_default = false;
                } else {
                    bank.cost_default = false;
                }
                bank._unsaved = true;
            },

            async loadBanks() {
                try {
                    const response = await fetch('/api/banks');
                    if (response.ok) {
                        const data = await response.json();
                        this.banks = data.banks || [];
                        this.filterBanks();
                    }
                } catch (error) {
                    console.error('Failed to load banks:', error);
                }
            },

            filterBanks() {
                let filtered = [...this.banks];
                
                if (this.searchTerm) {
                    const search = this.searchTerm.toLowerCase();
                    filtered = filtered.filter(bank => {
                        return bank.bank_name?.toLowerCase().includes(search) ||
                               bank.gl_no?.toLowerCase().includes(search) ||
                               bank.currency?.toLowerCase().includes(search);
                    });
                }

                if (this.filters.bank_name) {
                    const search = this.filters.bank_name.toLowerCase();
                    filtered = filtered.filter(b => b.bank_name?.toLowerCase().includes(search));
                }
                if (this.filters.gl_no) {
                    const search = this.filters.gl_no.toLowerCase();
                    filtered = filtered.filter(b => b.gl_no?.toLowerCase().includes(search));
                }
                if (this.filters.initial_amount) {
                    filtered = filtered.filter(b => String(b.initial_amount).includes(this.filters.initial_amount));
                }
                if (this.filters.currency) {
                    const search = this.filters.currency.toLowerCase();
                    filtered = filtered.filter(b => b.currency?.toLowerCase().includes(search));
                }
                if (this.filters.is_active !== '') {
                    const activeVal = this.filters.is_active === '1';
                    filtered = filtered.filter(b => Boolean(b.is_active) === activeVal);
                }

                this.filteredBanks = filtered;
                this.updateToolbar();
            },

            addBank() {
                const newBank = {
                    id: null,
                    bank_name: '',
                    gl_no: '',
                    initial_amount: 0,
                    currency: 'CAD',
                    revenue_default: false,
                    cost_default: false,
                    notes_receivable: '',
                    notes_payable: '',
                    is_active: true,
                    inactive_date: '',
                    check_by_sequence: false,
                    clear_check_by_cycle: false,
                    display_remark: false,
                    invoice_remark: false,
                    selected: false,
                    _unsaved: true
                };
                this.banks.unshift(newBank);
                this.filterBanks();
                showToast('info', 'New bank added. Don\'t forget to click Save All!');
            },

            toggleRowSelect(bank) {
                bank.selected = !bank.selected;
                this.updateToolbar();
            },

            toggleSelectAll(checked) {
                this.filteredBanks.forEach(bank => bank.selected = checked);
                this.updateToolbar();
            },

            updateToolbar() {
                this.selectedBanks = this.filteredBanks.filter(b => b.selected);
                this.allSelected = this.filteredBanks.length > 0 && 
                                  this.selectedBanks.length === this.filteredBanks.length;
            },

            confirmDelete() {
                const n = this.selectedBanks.length;
                if (!n) return;
                document.getElementById('confirm-msg').textContent =
                    `You are about to permanently delete ${n} bank(s). This cannot be undone.`;
                document.getElementById('confirm-overlay').classList.add('open');
            },

            async executeDelete() {
                closeConfirm();
                const ids = this.selectedBanks.map(b => b.id).filter(id => id !== null);
                
                if (ids.length === 0) {
                    this.banks = this.banks.filter(b => !b.selected || b.id !== null);
                    this.filterBanks();
                    showToast('success', 'Unsaved banks removed');
                    return;
                }

                showToast('info', 'Deleting...');
                
                try {
                    const response = await fetch('/api/banks/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ids })
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.banks = this.banks.filter(b => !ids.includes(b.id));
                        this.filterBanks();
                        showToast('success', data.message || 'Deleted successfully');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    showToast('error', 'Failed to delete banks');
                }
            },

            async deleteSingleBank(bank) {
                if (!confirm('Delete this bank?')) return;

                if (!bank.id) {
                    this.banks = this.banks.filter(b => b !== bank);
                    this.filterBanks();
                    showToast('success', 'Bank removed');
                    return;
                }

                showToast('info', 'Deleting...');

                try {
                    const response = await fetch(`/api/banks/${bank.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.banks = this.banks.filter(b => b.id !== bank.id);
                        this.filterBanks();
                        showToast('success', 'Bank deleted');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    showToast('error', 'Failed to delete bank');
                }
            },

            hasUnsavedChanges() {
                return this.banks.some(b => b._unsaved);
            },

            async saveAll() {
                const unsaved = this.banks.filter(b => b._unsaved);
                if (unsaved.length === 0) return;

                showToast('info', `Saving ${unsaved.length} bank(s)...`);

                try {
                    const response = await fetch('/api/banks/bulk-save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ banks: unsaved })
                    });

                    const data = await response.json();
                    if (data.success) {
                        if (data.banks) {
                            data.banks.forEach((savedBank, index) => {
                                const unsavedBank = unsaved[index];
                                Object.assign(unsavedBank, savedBank);
                                unsavedBank._unsaved = false;
                            });
                        } else {
                            unsaved.forEach(b => b._unsaved = false);
                        }
                        
                        showToast('success', data.message || 'All changes saved successfully');
                        await this.loadBanks();
                    } else {
                        showToast('error', data.message || 'Failed to save');
                    }
                } catch (error) {
                    showToast('error', 'Failed to save banks');
                }
            },

            cancelChanges() {
                if (!confirm('Discard all unsaved changes?')) return;
                this.loadBanks();
                showToast('info', 'Changes cancelled');
            },

            refreshBanks() {
                showToast('info', 'Refreshing bank list...');
                this.loadBanks();
            },

            printTable() {
                const url = new URL('{{ route("accounting.bank-list-print") }}');
                if (this.searchTerm) url.searchParams.set('search', this.searchTerm);
                showToast('info', 'Opening print view...');
                window.open(url.toString(), '_blank');
            },

            async exportExcel() {
                showToast('info', 'Preparing Excel export...');
                
                try {
                    const url = new URL('/api/banks/export', window.location.origin);
                    if (this.searchTerm) url.searchParams.set('search', this.searchTerm);

                    const response = await fetch(url.toString());
                    if (!response.ok) throw new Error('Export failed');
                    
                    const blob = await response.blob();
                    const downloadUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = downloadUrl;
                    a.download = 'bank-list-' + new Date().toISOString().split('T')[0] + '.csv';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(downloadUrl);
                    showToast('success', 'Excel file downloaded successfully');
                } catch (error) {
                    console.error('Export error:', error);
                    showToast('error', 'Failed to export Excel');
                }
            }
        }
    }

    // Check No. Sequence Modal
    function checkNoModal() {
        return {
            isOpen: false,
            sequences: [
                { selected: false, office: '', prefix: 'CAD', start_no: 3, end_no: 200 }
            ],
            init() {
                window.addEventListener('open-checkno-modal', () => {
                    this.openModal();
                });
            },
            openModal() {
                this.loadSequences();
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
            },
            loadSequences() {
                if (currentBank && currentBank.check_sequences) {
                    this.sequences = JSON.parse(JSON.stringify(currentBank.check_sequences));
                }
            },
            addSequence() {
                this.sequences.push({
                    selected: false,
                    office: '',
                    prefix: 'CAD',
                    start_no: 0,
                    end_no: 0
                });
            },
            deleteSelected() {
                this.sequences = this.sequences.filter(s => !s.selected);
            },
            toggleAll(checked) {
                this.sequences.forEach(s => s.selected = checked);
            },
            async saveSequences() {
                if (currentBank) {
                    currentBank.check_sequences = JSON.parse(JSON.stringify(this.sequences));
                    currentBank._unsaved = true;
                    showToast('success', 'Check numbering sequence configured. Click Save All to persist changes.');
                }
                this.closeModal();
            }
        }
    }

    // Clear Check by Cycle Modal
    function clearCheckModal() {
        return {
            isOpen: false,
            config: {
                startRow: '',
                dateColumn: '',
                dateFormat: 'mm/dd/yyyy',
                checkNoColumn: '',
                amountColumn: '',
                conditionColumn: '',
                condition: '',
                exclude: ''
            },
            init() {
                window.addEventListener('open-clearcheck-modal', () => {
                    this.openModal();
                });
            },
            openModal() {
                this.loadConfig();
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
            },
            loadConfig() {
                if (currentBank && currentBank.clear_check_config) {
                    this.config = JSON.parse(JSON.stringify(currentBank.clear_check_config));
                }
            },
            saveConfig() {
                if (currentBank) {
                    currentBank.clear_check_config = JSON.parse(JSON.stringify(this.config));
                    currentBank._unsaved = true;
                    showToast('success', 'Clear check by Excel settings configured. Click Save All to persist.');
                }
                this.closeModal();
            }
        }
    }

    // Display Information Modal
    function displayInfoModal() {
        return {
            isOpen: false,
            displayText: '',
            init() {
                window.addEventListener('open-displayinfo-modal', () => {
                    this.openModal();
                });
            },
            openModal() {
                this.loadDisplayInfo();
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
            },
            loadDisplayInfo() {
                if (currentBank && currentBank.display_information) {
                    this.displayText = currentBank.display_information;
                } else {
                    this.displayText = '';
                }
            },
            async saveDisplayInfo() {
                if (currentBank) {
                    currentBank.display_information = this.displayText;
                    currentBank._unsaved = true;
                    showToast('success', 'Display information updated. Click Save All to persist.');
                }
                this.closeModal();
            }
        }
    }

    // Invoice Remark Modal
    function invoiceRemarkModal() {
        return {
            isOpen: false,
            isDefault: false,
            bankInfo: {
                name: '',
                address: '',
                accountNo: '',
                swiftCode: '',
                remark: ''
            },
            init() {
                window.addEventListener('open-invoiceremark-modal', () => {
                    this.openModal();
                });
            },
            openModal() {
                this.loadSettings();
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
            },
            loadSettings() {
                if (currentBank) {
                    this.isDefault = currentBank.is_default_invoice_bank || false;
                    if (currentBank.invoice_settings) {
                        this.bankInfo = JSON.parse(JSON.stringify(currentBank.invoice_settings));
                    } else {
                        this.bankInfo = {
                            name: currentBank.bank_name || '',
                            address: '',
                            accountNo: '',
                            swiftCode: '',
                            remark: ''
                        };
                    }
                }
            },
            toggleDefault() {
                this.isDefault = !this.isDefault;
            },
            async saveSettings() {
                if (currentBank) {
                    currentBank.is_default_invoice_bank = this.isDefault;
                    currentBank.invoice_settings = JSON.parse(JSON.stringify(this.bankInfo));
                    currentBank._unsaved = true;
                    showToast('success', 'Invoice settings updated. Click Save All to persist.');
                }
                this.closeModal();
            }
        }
    }

    function closeConfirm() {
        document.getElementById('confirm-overlay').classList.remove('open');
    }

    window.executeDelete = function() {
        const component = Alpine.$data(document.querySelector('[x-data="bankList()"]'));
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
