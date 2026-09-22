{{-- NTG AIR Template --}}
<style>
#ntg-air-template {
    position: relative;
    width: 794px;
    margin: 0 auto;
    background: #fff;
}
#ntg-air-template img {
    width: 100%;
    height: auto;
    display: block;
}

#ntg_shipper        { top: 10.5%; left: 3%; width: 48%; height: 5.8%; }
#ntg_consignee      { top: 18.5%; left: 3%; width: 48%; height: 6%; }
#ntg_notify         { top: 26.5%; left: 3%; width: 48%; height: 6%; }
#ntg_ref_no         { top: 9.9%; left: 52%; width: 27%; height: 1.5%; }
#ntg_bl_no          { top: 9.9%; left: 79.7%; width: 17%; height: 1.5%; }
#ntg_export_ref     { top: 13.0%; left: 52%; width: 44%; height: 3.5%; }
#ntg_fwd_agent      { top: 17.7%; left: 52%; width: 44%; height: 4%; }
#ntg_origin         { top: 23.2%; left: 52%; width: 44%; height: 1.8%; }
#ntg_routing        { top: 26.5%; left: 52%; width: 44%; height: 5%; }
#ntg_pre_carriage   { top: 33.2%; left:3%; width: 26%; height: 1.8%; }
#ntg_receipt        { top: 33.2%; left: 31.2%; width: 20%; height: 1.8%; }
#ntg_delivery_agent { display:none; top: 30%; left: 47%; width: 51%; height: 5.5%; font-size: 8px; }
#ntg_vessel         { top: 36%; left: 3%; width: 26%; height: 1.8%; }
#ntg_pol            { top: 36.2%; left: 31.2%; width: 20%; height: 1.8%; }
#ntg_pod            { top: 39.2%; left: 3%; width: 26%; height: 1.8%; }
#ntg_del            { top: 39.2%; left: 31%; width: 20%; height: 1.8%; }
#ntg_marks          { top: 44%; left: 3%; width: 16%; height: 25%; font-size: 8px; }
#ntg_pkgs           { top: 44%; left: 19.5%; width: 9.5%; height: 25%; font-size: 8px; }
#ntg_desc           { top: 44%; left: 30%; width: 41%; height: 25%; font-size: 8px; }
#ntg_weight         { top: 44%; left: 72%; width: 13.5%; height: 25%; font-size: 8px; }
#ntg_measure        { top: 44%; left: 86%; width: 10%; height: 25%; font-size: 8px; }
#ntg_freight_pay    { top: 70%; left: 46%; width: 25%; height: 2.5%; }
#ntg_bl_bottom      { top: 82.9%; left: 5%; width: 22%; height: 1.5%; }
#ntg_dated          { top: 82.9%;left: 30.5%; width: 15%; height: 1.5%; }

#ntg_excess_val     { display:none; font-weight:bold; top: 69.5%; left: 22%; width: 23%; height: 1.5%; }
#ntg_freight_details {background-color: red; display:none; top: 72.0%; left: 3%; width: 52%; height: 9.5%; font-size: 8px; }
#ntg_currency       {top: 73.5%; left: 72%; width: 6.5%; height: 5.3%; text-align: center; }
#ntg_prepaid        { top: 74%; left: 79%; width: 8%; height: 15.3%; text-align: left; }
#ntg_collect        { top: 74%; left: 87.3%; width: 8%; height: 15.3%; text-align: left; }
#ntg_total_prepaid  { top: 89.5%; left: 78.7%; width: 9%;height: 2.0%; text-align: left; }
#ntg_total_collect  { top: 89.5%; left: 87.5%; width: 8%; height: 2.0%; text-align: left; }
#ntg_bl_lading_no   { top: 87.2%; left: 3%; width: 20%; height: 1.5%; }
#ntg_consol_ref     { top: 87.2%; left: 24%; width: 21%; height: 1.5%; }
#ntg_prod_no_1      { top: 89.9%; left: 3%; width: 20%; height: 1.5%; }
#ntg_prod_no_2      { top:  89.9%; left: 24.2%; width: 21%; height: 1.5%; }
</style>

<div id="ntg-air-template">
    <!-- Page 1 -->
    <div style="position: relative;">
        <img src="/hbl-backgrounds/ntg-air-page-1.png" alt="NTG AIR Page 1">
        
        <textarea id="ntg_shipper" class="hbl-field">{{ $data['shipper'] ?? '' }}</textarea>
        <textarea id="ntg_consignee" class="hbl-field">{{ $data['consignee'] ?? '' }}</textarea>
        <textarea id="ntg_notify" class="hbl-field">{{ $data['notify_party'] ?? '' }}</textarea>
        
        <input type="text" id="ntg_ref_no" class="hbl-field" value="{{ $data['booking_number'] ?? '' }}">
        <input type="text" id="ntg_bl_no" class="hbl-field" value="{{ $data['hbl_number'] ?? '' }}">
        <textarea id="ntg_export_ref" class="hbl-field">{{ $data['export_references'] ?? '' }}</textarea>
        
        <input type="text" id="ntg_fwd_agent" class="hbl-field" value="{{ $data['forwarding_agent'] ?? '' }}">
        <input type="text" id="ntg_origin" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
        <textarea id="ntg_routing" class="hbl-field"></textarea>
        
        <input type="text" id="ntg_pre_carriage" class="hbl-field" value="{{ $data['pre_carriage_by'] ?? '' }}">
        <input type="text" id="ntg_receipt" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
        <textarea id="ntg_delivery_agent" class="hbl-field">{{ $data['delivery_agent'] ?? '' }}</textarea>
        
        <input type="text" id="ntg_vessel" class="hbl-field" value="{{ $data['vessel'] ?? '' }}">
        <input type="text" id="ntg_pol" class="hbl-field" value="{{ $data['port_of_loading'] ?? '' }}">
        <input type="text" id="ntg_pod" class="hbl-field" value="{{ $data['port_of_discharge'] ?? '' }}">
        <input type="text" id="ntg_del" class="hbl-field" value="{{ $data['place_of_delivery'] ?? '' }}">
        
        <textarea id="ntg_marks" class="hbl-field">{{ $data['marks_numbers'] ?? '' }}</textarea>
        <textarea id="ntg_pkgs" class="hbl-field">{{ $data['no_of_packages'] ?? '' }}</textarea>
        <textarea id="ntg_desc" class="hbl-field">{{ $data['description'] ?? '' }}</textarea>
        <textarea id="ntg_weight" class="hbl-field">{{ $data['gross_weight'] ?? '' }}</textarea>
        <textarea id="ntg_measure" class="hbl-field">{{ $data['measurement'] ?? '' }}</textarea>

        <input type="text" id="ntg_excess_val" class="hbl-field" value="">
        <input type="text" id="ntg_freight_pay" class="hbl-field" value="{{ $data['freight_payable_at'] ?? '' }}">
        <textarea id="ntg_freight_details" class="hbl-field"></textarea>
        
        <input type="text" id="ntg_currency" class="hbl-field" value="{{ $data['currency'] ?? 'USD' }}">
        <textarea id="ntg_prepaid" class="hbl-field">{{ $data['prepaid_amount'] ?? '' }}</textarea>
        <textarea id="ntg_collect" class="hbl-field">{{ $data['collect_amount'] ?? '' }}</textarea>
        <input type="text" id="ntg_total_prepaid" class="hbl-field" value="{{ $data['prepaid_amount'] ?? '' }}">
        <input type="text" id="ntg_total_collect" class="hbl-field" value="{{ $data['collect_amount'] ?? '' }}">

        <input type="text" id="ntg_bl_bottom" class="hbl-field" value="{{ $data['hbl_number'] ?? '' }}">
        <input type="text" id="ntg_dated" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">

        <input type="text" id="ntg_bl_lading_no" class="hbl-field" value="{{ $data['hbl_number'] ?? '' }}">
        <input type="text" id="ntg_consol_ref" class="hbl-field" value="{{ $data['booking_number'] ?? '' }}">
        <input type="text" id="ntg_prod_no_1" class="hbl-field" value="">
        <input type="text" id="ntg_prod_no_2" class="hbl-field" value="">
    </div>
    
    <!-- Page 2 (Terms & Conditions) -->
    <div style="position: relative; margin-top: 20px;">
        <img src="/hbl-backgrounds/ntg-air-page-2.png" alt="NTG AIR Page 2">
    </div>
</div>
