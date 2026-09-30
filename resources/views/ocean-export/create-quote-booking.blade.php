<x-layout title="New Booking from Quote">
    @push('styles')
    <x-form-styles />
    <style>
        [x-cloak] { display: none !important; }
        .wizard-circle { width: 18px; height: 18px; min-width: 18px; min-height: 18px; flex-shrink: 0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 10px; font-weight: bold; }
        .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 999999; }
        .modal-container { background: #fff; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 900px; max-width: 95vw; display: flex; flex-direction: column; overflow: hidden; }
        .form-group-gf { margin-bottom: 0; }
        .form-label-gf { font-size: 11px; font-weight: 600; color: #333; margin-bottom: 2px; }
        .form-control-gf { width: 100%; border: 1px solid #ccc; border-radius: 2px; font-size: 12px; padding: 2px 6px; box-shadow: inset 0 1px 1px rgba(0,0,0,.075); transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; }
        .form-control-gf:focus { border-color: #66afe9; outline: 0; box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6); }
        .table-custom { width: 100%; border-collapse: collapse; font-size: 11px; }
        .table-custom th, .table-custom td { border: 1px solid #ddd; padding: 4px 8px; text-align: left; vertical-align: middle; }
        .table-custom th { background: #f9fafb; font-weight: 600; color: #333; }
        .table-custom tr:hover td { background-color: #f5f5f5; }
        .btn-freightx { background-color: #1abc9c; color: white; border: 1px solid #1abc9c; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 3px; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 4px; }
        .btn-freightx:hover { background-color: #16a085; }
        .btn-default-gf { background-color: #fff; color: #333; border: 1px solid #ccc; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 3px; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 4px; }
        .btn-default-gf:hover { background-color: #e6e6e6; border-color: #adadad; }


        /* =========================================================
   OCEAN EXPORT QUOTE MODAL
   UI matched with AIR EXPORT
   Backend / Alpine / Alignment untouched
   ========================================================= */

.ocean-quote-modal .modal-container {
    /* Air Export default modal appearance */
    max-width: 950px;
}

.ocean-quote-modal .modal-header {
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
}

.ocean-quote-modal .modal-header-title {
    margin: 0;
    font-size: 18px;
    color: #333;
    font-weight: 500;
}

.ocean-quote-modal .modal-close {
    background: none;
    border: none;
    font-size: 21px;
    cursor: pointer;
    color: #000;
    opacity: .2;
}

.ocean-quote-modal .modal-body {
    padding: 20px;
}

/* Wizard */
.ocean-quote-modal .wizard-circle {
    width: 18px;
    height: 18px;
    min-width: 18px;
    min-height: 18px;
    flex-shrink: 0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 10px;
    font-weight: bold;
}

/* Search buttons */
.ocean-quote-modal .quote-search-btn {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 4px;
}

/* Config */
.ocean-quote-modal .quote-config-btn {
    background: #67809f;
    padding: 2px 8px;
    border-radius: 12px !important;
}

/* Quote table wrapper */
.ocean-quote-modal .quote-table-wrapper {
    border: 1px solid #e7ecf1;
    height: 310px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

/* Table */
.ocean-quote-modal .quote-table-wrapper .table-custom {
    margin: 0;
    border: none;
}

.ocean-quote-modal .quote-table-wrapper .table-custom thead th {
    background: #888;
    color: #fff;
}

.ocean-quote-modal .quote-table-wrapper tbody tr {
    border-bottom: 1px solid #e7ecf1;
}

.ocean-quote-modal .quote-table-wrapper tbody td {
    padding: 6px;
}

/* Section headings - same visual language as Air */
.ocean-quote-modal .quote-section-title {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}

/* Step 2 route table */
.ocean-quote-modal .route-table {
    margin-bottom: 20px;
}

.ocean-quote-modal .route-selected {
    background: #fffdf2;
}

/* Step 3 */
.ocean-quote-modal .freight-options {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

/* Footer - Air Export visual style */
.ocean-quote-modal .modal-footer {
    padding: 15px;
    border-top: 1px solid #e5e5e5;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    background: #f9fafb;
    border-radius: 0 0 4px 4px;
}

.ocean-quote-modal .footer-btn {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 4px;
}

.ocean-quote-modal .next-btn {
    background: #1abc9c;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 4px;
}

.ocean-quote-modal .finish-btn {
    background: #1abc9c;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 4px;
}

/* Disabled button */
.ocean-quote-modal .next-btn-disabled {
    background: #ccc;
    border: none;
    color: #666;
    cursor: not-allowed;
    opacity: .7;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 4px;
}
    </style>
    @endpush

    <div style="opacity: 0.3; pointer-events: none; padding: 15px;">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
                <li>Ocean Export <i class="fa fa-angle-right"></i></li>
                <li><span style="color: #333; font-weight: 700;">New Booking</span></li>
            </ul>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h1 class="caption-subject" style="font-size: 18px;">Create Ocean Export Booking</h1>
            <div style="display: flex; gap: 8px;">
                <button class="btn-freightx"><i class="fa fa-save"></i> SAVE BOOKING</button>
            </div>
        </div>
        <div style="height: 500px; border: 1px solid #e2e8f0; background: #fff; border-radius: 4px;"></div>
    </div>

<div class="modal-overlay" x-data="window.quoteSelectorModule()" x-cloak>
    <div class="modal-container" style="max-width: 950px; display: flex; flex-direction: column;">

        <!-- Modal Header -->
        <div class="modal-header">
            <span>
                <i class="fa fa-file-text-o text-blue-500"></i>
                Load Quotation Data
            </span>

            <i class="fa fa-times cursor-pointer text-gray-500 hover:text-gray-700"
               @click="closeQuoteModal()"></i>
        </div>

        <!-- Modal Body -->
        <div class="modal-body hide-scrollbar">

            <style>
                .hide-scrollbar::-webkit-scrollbar {
                    display: none;
                }

                .hide-scrollbar {
                    -ms-overflow-style: none;
                    scrollbar-width: none;
                }

                .wizard-circle {
                    width: 18px;
                    height: 18px;
                    min-width: 18px;
                    min-height: 18px;
                    flex-shrink: 0;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #fff;
                    font-size: 10px;
                    font-weight: bold;
                }
            </style>

            <!-- =========================================================
                 WIZARD STEPS
            ========================================================== -->
            <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-bottom: 15px;">

                <!-- Step 1 -->
                <div style="display: flex; align-items: center; gap: 5px;">
                    <div class="wizard-circle"
                         :style="quoteStep >= 1 ? 'background: #3b82f6;' : 'background: #cbd5e1;'">

                        <template x-if="quoteStep > 1">
                            <i class="fa fa-check"></i>
                        </template>

                        <template x-if="quoteStep === 1">
                            <span>1</span>
                        </template>
                    </div>

                    <span :style="quoteStep >= 1
                        ? 'color: #1e293b; font-size: 10px; font-weight: 600;'
                        : 'color: #94a3b8; font-size: 10px;'">
                        Select Quotation
                    </span>
                </div>

                <div style="height: 1px; width: 20px; background: #e2e8f0;"></div>

                <!-- Step 2 -->
                <div style="display: flex; align-items: center; gap: 5px;">
                    <div class="wizard-circle"
                         :style="quoteStep >= 2 ? 'background: #3b82f6;' : 'background: #cbd5e1;'">

                        <template x-if="quoteStep > 2">
                            <i class="fa fa-check"></i>
                        </template>

                        <template x-if="quoteStep <= 2">
                            <span>2</span>
                        </template>
                    </div>

                    <span :style="quoteStep >= 2
                        ? 'color: #1e293b; font-size: 10px; font-weight: 600;'
                        : 'color: #94a3b8; font-size: 10px;'">
                        Fill in shipment data
                    </span>
                </div>

                <div style="height: 1px; width: 20px; background: #e2e8f0;"></div>

                <!-- Step 3 -->
                <div style="display: flex; align-items: center; gap: 5px;">
                    <div class="wizard-circle"
                         :style="quoteStep >= 3 ? 'background: #3b82f6;' : 'background: #cbd5e1;'">
                        <span>3</span>
                    </div>

                    <span :style="quoteStep >= 3
                        ? 'color: #1e293b; font-size: 10px; font-weight: 600;'
                        : 'color: #94a3b8; font-size: 10px;'">
                        Select invoice items
                    </span>
                </div>

            </div>


            <!-- =========================================================
                 STEP 1 — SELECT QUOTATION
            ========================================================== -->
            <div x-show="quoteStep === 1">

                <div class="form-grid-4" style="grid-template-columns: repeat(3, 1fr);">

                    <!-- Column 1 -->
                    <div class="main-grid">

                        <div class="form-group-gf">
                            <label class="form-label-gf">Customer</label>

                            <div class="form-input-container">
                                <select class="form-control-gf"
                                        x-model="filters.customer_id">

                                    <option value="">Select...</option>

                                    @foreach($customers as $c)
                                        <option value="{{ $c->id }}">
                                            {{ $c->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group-gf">
                            <label class="form-label-gf">Departure (POL)</label>

                            <div class="form-input-container">
                                <select class="form-control-gf"
                                        x-model="filters.pol_id">

                                    <option value="">Select...</option>

                                    @foreach($ports as $p)
                                        <option value="{{ $p->id }}">
                                            {{ $p->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group-gf">
                            <label class="form-label-gf">Quote No.</label>

                            <div class="form-input-container">
                                <input type="text"
                                       class="form-control-gf"
                                       x-model="filters.quote_no">
                            </div>
                        </div>

                    </div>


                    <!-- Column 2 -->
                    <div class="main-grid">

                        <div class="form-group-gf">
                            <label class="form-label-gf">Valid Date</label>

                            <div class="form-input-container"
                                 style="display: flex; gap: 5px;">

                                <input type="date"
                                       class="form-control-gf"
                                       x-model="filters.date_from">

                                <input type="date"
                                       class="form-control-gf"
                                       x-model="filters.date_to">

                            </div>
                        </div>


                        <div class="form-group-gf">
                            <label class="form-label-gf">Destination (POD)</label>

                            <div class="form-input-container">
                                <select class="form-control-gf"
                                        x-model="filters.pod_id">

                                    <option value="">Select...</option>

                                    @foreach($ports as $p)
                                        <option value="{{ $p->id }}">
                                            {{ $p->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group-gf">
                            <label class="form-label-gf">Status</label>

                            <div class="form-input-container">
                                <select class="form-control-gf"
                                        x-model="filters.status">

                                    <option value="">Select...</option>

                                    @foreach($statuses as $s)
                                        <option value="{{ $s }}">
                                            {{ $s }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>


                    <!-- Column 3 -->
                    <div class="main-grid">

                        <div class="form-group-gf">
                            <label class="form-label-gf">Commodity</label>

                            <div class="form-input-container">
                                <input type="text"
                                       class="form-control-gf"
                                       x-model="filters.commodity">
                            </div>
                        </div>


                        <div class="form-group-gf">
                            <label class="form-label-gf">Sales</label>

                            <div class="form-input-container">
                                <select class="form-control-gf"
                                        x-model="filters.sales_person_id">

                                    <option value="">Select...</option>

                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">
                                            {{ $u->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group-gf">
                            <label class="form-label-gf">OP</label>

                            <div class="form-input-container">
                                <select class="form-control-gf">

                                    <option value="">Select...</option>

                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">
                                            {{ $u->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>

                </div>


                <!-- Search Buttons -->
                <div style="display: flex; justify-content: center; gap: 8px; margin: 10px 0;">

                    <button type="button"
                            class="btn-default-gf"
                            @click="clearSearch()">
                        Clear
                    </button>

                    <button type="button"
                            class="btn-freightx"
                            @click="applySearch()">
                        <i class="fa fa-search"></i>
                        Search
                    </button>

                </div>


                <hr style="border-top: 1px solid #e2e8f0; margin: 10px 0;">


                <!-- Config -->

<!-- Config Button -->
<div style="display: flex; justify-content: flex-end; margin-bottom: 5px;">

    <button type="button"
            class="btn-tool-secondary"
            @click="showQuoteConfig = !showQuoteConfig">
        <i class="fa fa-cogs"></i>
        Config
    </button>

</div>


<!-- Config Panel -->
<div x-show="showQuoteConfig"
     x-cloak
     style="margin-bottom: 10px;
            padding: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 10px;">

    <div class="form-grid-4"
         style="grid-template-columns: repeat(4, 1fr);">

        <template x-for="(label, key) in {
            select: 'Select',
            quote_no: 'Quote No.',
            valid_date: 'Valid Date',
            status: 'Status',
            creation_date: 'Creation Date',
            commodity: 'Commodity',
            pol: 'Departure',
            pod: 'Destination',
            carrier: 'Carrier',
            sales: 'Sales'
        }"
        :key="key">

            <label style="display: flex;
                          align-items: center;
                          gap: 4px;
                          font-size: 10px;
                          cursor: pointer;">

                <input type="checkbox"
                       x-model="colVisibility[key]"
                       style="width: 12px;
                              height: 12px;
                              margin: 0;">

                <span x-text="label"></span>

            </label>

        </template>

    </div>

</div>




                <!-- Quotations Table -->
<div class="table-responsive" style="margin-bottom: 10px;">

                   <table class="table-custom">

    <thead>
        <tr>

            <th x-show="colVisibility.select" style="text-align: center;">
                Select
            </th>

            <th x-show="colVisibility.quote_no">
                Quote No.
            </th>

            <th x-show="colVisibility.valid_date">
                Valid Date
                <i class="fa fa-sort" style="float: right;"></i>
            </th>

            <th x-show="colVisibility.status">
                Status
                <i class="fa fa-sort" style="float: right;"></i>
            </th>

            <th x-show="colVisibility.creation_date">
                Creation Date
                <i class="fa fa-sort" style="float: right;"></i>
            </th>

            <th x-show="colVisibility.commodity">
                Commodity
            </th>

            <th x-show="colVisibility.pol">
                Departure
            </th>

            <th x-show="colVisibility.pod">
                Destination
            </th>

            <th x-show="colVisibility.carrier">
                Carrier
            </th>

            <th x-show="colVisibility.sales">
                Sales
            </th>

        </tr>
    </thead>


    <tbody>

        <template x-for="(quote, idx) in quotations"
                  :key="quote.id">

            <tr x-show="matchFilters(quote)"
                class="cursor-pointer hover:bg-blue-50"
                :style="selectedQuote && selectedQuote.id === quote.id
                    ? 'background-color: #eff6ff;'
                    : ''"
                @click="selectQuote(quote)">

                <td x-show="colVisibility.select" style="text-align: center;">

                    <input type="radio"
                           name="quote_sel"
                           :checked="selectedQuote && selectedQuote.id === quote.id"
                           @click.stop="selectQuote(quote)">

                </td>


                <td x-show="colVisibility.quote_no">
                    <a href="#"
                       @click.prevent
                       style="color: #3b82f6; font-weight: 600;"
                       x-text="quote.quote_no">
                    </a>
                </td>


                <td x-show="colVisibility.valid_date" x-text="quote.quote_date + ' ~ ' + quote.expiry_date"></td>


                <td x-show="colVisibility.status">

                    <span
                        :style="quote.status === 'ACCEPTED'
                            ? 'background: #10b981;'
                            : 'background: #64748b;'"
                        style="color: #fff;
                               padding: 1px 4px;
                               border-radius: 2px;
                               font-size: 9px;
                               font-weight: 600;"
                        x-text="quote.status || '-'">
                    </span>

                </td>


                <td x-show="colVisibility.creation_date" x-text="quote.quote_date"></td>


                <td x-show="colVisibility.commodity" x-text="quote.commodity || '-'"></td>


                <td x-show="colVisibility.pol" x-text="quote.pol_name || '-'"></td>


                <td x-show="colVisibility.pod" x-text="quote.pod_name || '-'"></td>


                <td x-show="colVisibility.carrier" x-text="quote.carrier || '-'"></td>


                <td x-show="colVisibility.sales" x-text="quote.sales_name || '-'"></td>

            </tr>

        </template>


        <tr x-show="quotations.filter(q => matchFilters(q)).length === 0">

            <td colspan="10"
                style="text-align: center;
                       color: #94a3b8;
                       font-size: 11px;
                       padding: 20px;">

                No quotations found

            </td>

        </tr>
    </tbody>

</table>
                </div>

            </div>


            <!-- =========================================================
                 STEP 2 — BOOKING / SHIPMENT INFORMATION
            ========================================================== -->
            <div x-show="quoteStep === 2">

                <!-- Route Header -->
                <div class="hbl-header">
                    Select a Route
                </div>


                <!-- Route Table -->
                <div class="table-responsive" style="margin-bottom: 10px;">

                    <table class="table-custom">

                        <thead>
                            <tr>

                                <th style="text-align: center;">
                                    Select
                                </th>

                                <th>
                                    Departure
                                </th>

                                <th>
                                    Destination
                                </th>

                                <th>
                                    Final Destination
                                </th>

                                <th>
                                    Carrier
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            <tr>

                                <td style="text-align: center;">
                                    <input type="radio"
                                           checked>
                                </td>

                                <td x-text="selectedQuote ? selectedQuote.pol_name : ''"></td>

                                <td x-text="selectedQuote ? selectedQuote.pod_name : ''"></td>

                                <td x-text="selectedQuote ? selectedQuote.pod_name : ''"></td>

                                <td>
                                    <span x-text="selectedQuote ? selectedQuote.carrier : 'DEMO CARRIER'"></span>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <!-- Booking Information Header -->
                <div class="hbl-header">
                    Fill in the Booking Information
                </div>


                <!-- Booking Form -->
                <div class="form-grid-4"
                     style="grid-template-columns: repeat(2, 1fr);">

                    <!-- Column 1 -->
                    <div class="main-grid">

                        <div class="form-group-gf">

                            <label class="form-label-gf">
                                Booking No.
                            </label>

                            <div class="form-input-container">

                                <input type="text"
                                       class="form-control-gf"
                                       :value="nextBookingNo"
                                       disabled>

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf"
                                   style="color: #ef4444;">
                                *Booking Date
                            </label>

                            <div class="form-input-container">

                                <input type="date"
                                       class="form-control-gf"
                                       x-model="bookingForm.booking_date">

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf"
                                   style="color: #ef4444;">
                                *ETD
                            </label>

                            <div class="form-input-container">

                                <input type="date"
                                       class="form-control-gf"
                                       x-model="bookingForm.etd">

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf"
                                   style="color: #ef4444;">
                                *Customer
                            </label>

                            <div class="form-input-container">

                                <input type="text"
                                       class="form-control-gf"
                                       x-model="bookingForm.customer_name"
                                       readonly>

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf">
                                Ship Mode
                            </label>

                            <div class="form-input-container">

                                <select class="form-control-gf"
                                        x-model="bookingForm.ship_mode">

                                    <option value="FCL">
                                        FCL
                                    </option>

                                    <option value="LCL">
                                        LCL
                                    </option>

                                </select>

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf">
                                POL
                            </label>

                            <div class="form-input-container">

                                <input type="text"
                                       class="form-control-gf"
                                       x-model="bookingForm.pol_name"
                                       readonly>

                            </div>

                        </div>

                    </div>


                    <!-- Column 2 -->
                    <div class="main-grid">

                        <div class="form-group-gf">

                            <label class="form-label-gf">
                                ETA
                            </label>

                            <div class="form-input-container">

                                <input type="date"
                                       class="form-control-gf"
                                       x-model="bookingForm.eta">

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf">
                                Sales Person
                            </label>

                            <div class="form-input-container">

                                <input type="text"
                                       class="form-control-gf"
                                       x-model="bookingForm.sales_name"
                                       readonly>

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf">
                                POD
                            </label>

                            <div class="form-input-container">

                                <input type="text"
                                       class="form-control-gf"
                                       x-model="bookingForm.pod_name"
                                       readonly>

                            </div>

                        </div>


                        <div class="form-group-gf">

                            <label class="form-label-gf">
                                Items from Quotation
                            </label>

                            <div class="form-input-container">

                                <span style="font-size: 10px; color: #334155;">
                                    <span x-text="selectedQuote ? selectedQuote.items_count : 0"></span>
                                    charge items will be copied
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =========================================================
                 STEP 3 — FREIGHT ITEMS
            ========================================================== -->
            <div x-show="quoteStep === 3">

                <div class="hbl-header">
                    Select Freight Item(s)
                </div>


                <!-- Draft Checkbox -->
                <div style="margin-bottom: 10px;
                            display: flex;
                            align-items: center;
                            gap: 4px;">

                    <input type="checkbox"
                           x-model="saveAsDraft"
                           style="margin: 0;
                                  width: 12px;
                                  height: 12px;
                                  cursor: pointer;
                                  accent-color: #3b82f6;">

                    <span style="font-size: 10px;
                                 color: #475569;
                                 font-weight: 600;">
                        Save as a draft invoice
                    </span>

                </div>


                <!-- Freight Items Table -->
                <div class="table-responsive"
                     style="margin-bottom: 10px;">

                    <table class="table-custom">

                        <thead>

                            <tr>

                                <th style="text-align: center;">
                                    Select
                                </th>

                                <th>
                                    Freight Code
                                </th>

                                <th>
                                    Freight Description
                                </th>

                                <th>
                                    Unit
                                </th>

                                <th>
                                    Currency
                                </th>

                                <th>
                                    Volume
                                </th>

                                <th>
                                    Rate
                                </th>

                                <th style="text-align: right;">
                                    Amount
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <template x-if="selectedQuote &&
                                             selectedQuote.items &&
                                             selectedQuote.items.length > 0">

                                <template x-for="(item, index) in selectedQuote.items"
                                          :key="index">

                                    <tr>

                                        <td style="text-align: center;">

                                            <input type="checkbox"
                                                   x-model="item.selected"
                                                   @change="updateSelection()">

                                        </td>


                                        <td x-text="item.charge_code || '-'"></td>


                                        <td x-text="item.charge_name || '-'"></td>


                                        <td x-text="item.unit || '-'"></td>


                                        <td x-text="item.currency_id || '-'"></td>


                                        <td x-text="item.qty || '1'"></td>


                                        <td x-text="Number(item.rate || 0).toFixed(2)"></td>


                                        <td style="text-align: right;"
                                            x-text="Number(item.amount || 0).toFixed(2)">
                                        </td>

                                    </tr>

                                </template>

                            </template>


                            <tr x-show="!selectedQuote ||
                                       !selectedQuote.items ||
                                       selectedQuote.items.length === 0">

                                <td colspan="8"
                                    style="text-align: center;
                                           color: #94a3b8;
                                           font-size: 11px;
                                           padding: 20px;">

                                    No charge items available for this quotation.

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- =========================================================
             MODAL FOOTER
        ========================================================== -->
        <div class="modal-footer">

            <button type="button"
                    class="btn-default-gf"
                    @click="closeQuoteModal()">
                Cancel
            </button>


            <button type="button"
                    x-show="quoteStep > 1"
                    class="btn-default-gf"
                    @click="quoteStep--">
                Back
            </button>


            <button type="button"
                    x-show="quoteStep < 3"
                    :class="(
                        (quoteStep === 1 && !selectedQuote) ||
                        (quoteStep === 2 &&
                            (!bookingForm.booking_date ||
                             !bookingForm.etd))
                    )
                    ? 'btn-freightx opacity-50 cursor-not-allowed'
                    : 'btn-freightx'"

                    :disabled="(
                        (quoteStep === 1 && !selectedQuote) ||
                        (quoteStep === 2 &&
                            (!bookingForm.booking_date ||
                             !bookingForm.etd))
                    )"

                    @click="quoteStep++">

                Next
                <i class="fa fa-arrow-right"></i>

            </button>


            <button type="button"
                    x-show="quoteStep === 3"
                    class="btn-freightx"
                    @click="confirmQuoteSelection()">

                <i class="fa fa-check"></i>
                Finish

            </button>

        </div>

    </div>
</div>



    <script>
        window.quoteSelectorModule = function() {
            return {
                quoteStep: 1,
                selectedQuote: null,

                quotations: @json($quotationsData).map(q => ({
                    ...q,
                    items: q.items ? q.items.map(i => ({...i, selected: true})) : []
                })),
                
                nextBookingNo: '{{ $nextBookingNo }}',

                filters: {
                    customer_id: '',
                    date_from: '',
                    date_to: '',
                    pol_id: '',
                    pod_id: '',
                    sales_person_id: '',
                    quote_no: '',
                    status: '',
                    commodity: '',
                },
                
                activeFilters: {
                    customer_id: '',
                    date_from: '',
                    date_to: '',
                    pol_id: '',
                    pod_id: '',
                    sales_person_id: '',
                    quote_no: '',
                    status: '',
                    commodity: '',
                },

                bookingForm: {
                    booking_date: new Date().toISOString().split('T')[0],
                    etd: '',
                    eta: '',
                    ship_mode: 'FCL',
                    customer_name: '',
                    sales_name: '',
                    pol_name: '',
                    pod_name: ''
                },

                saveAsDraft: false,

                showQuoteConfig: false,

                colVisibility: {
                    select: true,
                    quote_no: true,
                    valid_date: true,
                    status: true,
                    creation_date: true,
                    commodity: true,
                    pol: true,
                    pod: true,
                    carrier: true,
                    sales: true,
                },

                get allItemsSelected() {
                    if (!this.selectedQuote || !this.selectedQuote.items || this.selectedQuote.items.length === 0) return false;
                    return this.selectedQuote.items.every(i => i.selected);
                },

                matchFilters(quote) {
                    if (this.activeFilters.customer_id && quote.customer_id != this.activeFilters.customer_id) return false;
                    if (this.activeFilters.pol_id && quote.pol_id != this.activeFilters.pol_id) return false;
                    if (this.activeFilters.pod_id && quote.pod_id != this.activeFilters.pod_id) return false;
                    if (this.activeFilters.sales_person_id && quote.sales_person_id != this.activeFilters.sales_person_id) return false;
                    if (this.activeFilters.status && quote.status !== this.activeFilters.status) return false;
                    if (this.activeFilters.quote_no && !quote.quote_no.toLowerCase().includes(this.activeFilters.quote_no.toLowerCase())) return false;
                    if (this.activeFilters.commodity && (!quote.commodity || !quote.commodity.toLowerCase().includes(this.activeFilters.commodity.toLowerCase()))) return false;
                    
                    if (this.activeFilters.date_from && quote.expiry_date < this.activeFilters.date_from) return false;
                    if (this.activeFilters.date_to && quote.expiry_date > this.activeFilters.date_to) return false;
                    
                    return true;
                },

                selectQuote(quote) {
                    this.selectedQuote = quote;
                    
                    this.bookingForm.customer_name = quote.customer_name;
                    this.bookingForm.sales_name = quote.sales_name;
                    this.bookingForm.pol_name = quote.pol_name;
                    this.bookingForm.pod_name = quote.pod_name;
                    
                    this.bookingForm.etd = quote.quote_date;
                    this.bookingForm.eta = quote.expiry_date;
                },

                clearSearch() {
                    this.filters = {
                        customer_id: '', date_from: '', date_to: '', pol_id: '', pod_id: '', sales_person_id: '', quote_no: '', status: '', commodity: ''
                    };
                    this.activeFilters = { ...this.filters };
                },

                applySearch() {
                    this.activeFilters = { ...this.filters };
                    this.quoteStep = 1;
                    this.selectedQuote = null;
                },

                toggleAllItems() {
                    if (!this.selectedQuote || !this.selectedQuote.items) return;
                    const val = !this.allItemsSelected;
                    this.selectedQuote.items.forEach(i => i.selected = val);
                },
                
                updateSelection() {
                    // force reactivity if needed
                },

                closeQuoteModal() {
                    window.location.href = '/ocean-export/booking/list';
                },

                confirmQuoteSelection() {
                    if (!this.selectedQuote) return;
                    let selectedItems = this.selectedQuote.items.filter(i => i.selected).map(i => i.id);
                    let ids = selectedItems.length ? selectedItems.join(',') : '';
                    window.location.href = '/ocean-export/booking/create?quote_id=' + this.selectedQuote.id + 
                                           '&items=' + ids + 
                                           '&ship_mode=' + this.bookingForm.ship_mode + 
                                           '&etd=' + this.bookingForm.etd + 
                                           '&eta=' + this.bookingForm.eta;
                }
            }
        };
    </script>
</x-layout>