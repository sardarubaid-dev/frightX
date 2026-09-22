{{-- Transamerica Logistics Template --}}
<style>
#transamerica-template {
    position: relative;
    width: 794px;
    margin: 0 auto;
    background: #fff;
}
#transamerica-template img {
    width: 100%;
    height: auto;
    display: block;
}

#tra_shipper        { top: 9.5%; left: 3.5%; width: 48%; height: 7.5%; }
#tra_doc_no         { top: 9.4%; left: 52.5%; width: 22%; height: 1.5%; }
#tra_booking        { top: 9.4%; left: 75%; width: 23%; height: 1.5%; }
#tra_delivery_agent { top: 12%; left: 52.5%; width: 45%; height: 8%; font-size: 8px; }
#tra_consignee      { top: 19.5%; left: 3.5%; width: 48%; height: 7%; }
#tra_notify         { top: 22%; left:52.5%; width: 45%; height: 8%; }
#tra_pre_carriage   { top: 29%; left: 3.5%; width: 27.5%; height: 1%; }
#tra_receipt        { top: 29%; left: 31.5%; width: 21%; height: 1%; }
#tra_vessel         { top: 31.7%; left: 3.5%; width: 17%; height: 1%; }
#tra_flag           { top: 31.7%; left: 21%; width: 10%; height: 1%; }
#tra_pol            { top: 31.7%; left: 31.5%; width: 21%; height: 1%; }
#tra_pier           { top: 31.2%; left: 52.5%; width: 45%; height: 1.5%; }
#tra_pod           { top: 34.5%; left: 3.5%; width: 27.5%; height: 1%; }
#tra_del            { top: 34.5%; left: 31.5%; width: 21%; height: 1%; }
#tra_move_type     { top: 34.2%; left: 52.5%; width: 45%; height: 1.5%; }
#tra_marks          { top: 39%; left: 3.5%; width: 17%; height: 28%; font-size: 8px; }
#tra_desc           { top: 39%; left: 21%; width: 52.5%; height: 28%; font-size: 8px; }
#tra_weight         { top: 39%; left: 75%; width: 14%; height: 28%; font-size: 8px; }
#tra_measure        { top: 39%; left:89%; width: 10%; height: 28%; font-size: 8px; }
#tra_place_issue    { top: 68%; left: 28.5%; width: 25%; height: 2.5%; }
#tra_date_issue     { top: 71.8%; left: 28.5%; width: 25%; height: 2.5%; }
#tra_board_date     { top: 75.8%; left: 28.5%; width: 25%; height: 2.5%; }
#tra_freight_on     { top: 81%; left: 3.9%; width: 29%; height: 11%; text-align: center; }
#tra_prepaid        { top: 81%; left: 33.5%; width: 10%; height: 11%; text-align: center; }
#tra_collect        { top: 81%; left: 43.8%; width: 9.5%; height: 11%; text-align: center; }
#tra_total_prepaid  { top: 92.5%; left: 33.5%; width: 10.5%; height: 2%; text-align: center; }
#tra_total_collect  { top: 92.5%; left: 43.8%; width: 9.5%; height: 2%; text-align: center; }

#tra_packages_words { top: 69%; left: 3.5%; width: 25%; height: 1.5%; }
#tra_orig_bl        { top: 71.8%; left: 3.5%; width: 25%; height: 2.5%; }
#tra_declared_val   { top: 75.8%; left: 3.5%; width: 25%; height: 2.5%; }

#tra_shipped_on_board { display: none; }
#tra_dated            { display: none; }
#tra_freight_charges  { display: none; }
</style>

<div id="transamerica-template">
    <img src="/hbl-backgrounds/transamerica-page-1.png" alt="Transamerica Logistics">
    
    <textarea id="tra_shipper" class="hbl-field">{{ $data['shipper'] ?? '' }}</textarea>
    <input type="text" id="tra_doc_no" class="hbl-field" value="{{ $data['hbl_number'] ?? '' }}">
    <input type="text" id="tra_booking" class="hbl-field" value="{{ $data['booking_number'] ?? '' }}">
    <textarea id="tra_delivery_agent" class="hbl-field">{{ $data['delivery_agent'] ?? '' }}</textarea>
    
    <textarea id="tra_consignee" class="hbl-field">{{ $data['consignee'] ?? '' }}</textarea>
    <textarea id="tra_notify" class="hbl-field">{{ $data['notify_party'] ?? '' }}</textarea>
    
    <input type="text" id="tra_pre_carriage" class="hbl-field" value="{{ $data['pre_carriage_by'] ?? '' }}">
    <input type="text" id="tra_receipt" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
    <input type="text" id="tra_vessel" class="hbl-field" value="{{ $data['vessel'] ?? '' }}">
    <input type="text" id="tra_flag" class="hbl-field" value="">
    <input type="text" id="tra_pol" class="hbl-field" value="{{ $data['port_of_loading'] ?? '' }}">
    <input type="text" id="tra_pier" class="hbl-field" value="">
    
    <input type="text" id="tra_pod" class="hbl-field" value="{{ $data['port_of_discharge'] ?? '' }}">
    <input type="text" id="tra_del" class="hbl-field" value="{{ $data['place_of_delivery'] ?? '' }}">
    <input type="text" id="tra_move_type" class="hbl-field" value="{{ $data['ship_mode'] ?? '' }}">
    
    <textarea id="tra_marks" class="hbl-field">{{ $data['marks_numbers'] ?? '' }}</textarea>
    <textarea id="tra_desc" class="hbl-field">{{ $data['description'] ?? '' }}</textarea>
    <textarea id="tra_weight" class="hbl-field">{{ $data['gross_weight'] ?? '' }}</textarea>
    <textarea id="tra_measure" class="hbl-field">{{ $data['measurement'] ?? '' }}</textarea>
    
    <!-- Left Column (Bottom Table) -->
    <input type="text" id="tra_packages_words" class="hbl-field" value="{{ $data['no_of_packages'] ?? '' }}">
    <input type="text" id="tra_orig_bl" class="hbl-field" value="THREE (3)">
    <input type="text" id="tra_declared_val" class="hbl-field" value="">

    <!-- Right Column (Bottom Table) -->
    <input type="text" id="tra_place_issue" class="hbl-field" value="{{ $data['port_of_loading'] ?? '' }}">
    <input type="text" id="tra_date_issue" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">
    <input type="text" id="tra_board_date" class="hbl-field" value="{{ $data['on_board_date'] ?? $data['date_of_issue'] ?? '' }}">

    <!-- Freight Table -->
    <input type="text" id="tra_freight_on" class="hbl-field" value="{{ $data['freight_payable_at'] ?? '' }}">
    <input type="text" id="tra_prepaid" class="hbl-field" value="{{ $data['prepaid_amount'] ?? '' }}">
    <input type="text" id="tra_collect" class="hbl-field" value="{{ $data['collect_amount'] ?? '' }}">
    <input type="text" id="tra_total_prepaid" class="hbl-field" value="{{ $data['prepaid_amount'] ?? '' }}">
    <input type="text" id="tra_total_collect" class="hbl-field" value="{{ $data['collect_amount'] ?? '' }}">

    <!-- Aliases for Compatibility -->
    <input type="text" id="tra_shipped_on_board" class="hbl-field" value="{{ $data['shipped_on_board'] ?? $data['vessel'] ?? '' }}">
    <input type="text" id="tra_dated" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">
    <textarea id="tra_freight_charges" class="hbl-field">{{ $data['freight_payable_at'] ?? '' }}</textarea>
</div>
