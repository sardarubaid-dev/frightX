{{-- Ocean Blue Express Template --}}
<style>
#ocean-blue-template {
    position: relative;
    width: 816px;
    margin: 0 auto;
    background: #fff;
}
#ocean-blue-template img {
    width: 100%;
    height: auto;
    display: block;
}

#obe_shipper        { top: 11%; left: 3%; width: 49%; height: 7%; }
#obe_doc_no         { top: 10%; left: 53%; width: 21%; height: 1.5%; }
#obe_bl_no          { top: 10%; left: 75%; width: 21%; height: 1.5%; }
#obe_export_ref     { top: 13%; left: 53%; width: 43%; height: 4%; }
#obe_consignee      { top: 19.5%; left: 3%; width: 49%; height: 7.5%; }
#obe_fwd_agent      { top: 19%; left:53%; width: 43%; height: 5%; }
#obe_origin         { top: 25%; left: 53%; width:43%; height: 1.5%; }
#obe_notify         { top: 28%; left: 3%; width: 49%; height: 8%; }
#obe_routing        {top: 28%; left: 53%; width: 43%; height: 10%;}
#obe_pre_carriage   { top: 37%; left: 3%; width: 28.5%; height: 2%; }
#obe_receipt        { top: 37%; left: 32%; width: 20%; height: 2%; }
#obe_vessel         { top: 40%; left: 3%; width: 28.5%; height: 2%; }
#obe_pol            { top: 40%; left: 32%; width: 20%; height: 2%; }
#obe_final_dest     { top: 40%; left: 53%; width: 43%; height: 5%; }
#obe_pod            { top: 43%; left: 3%; width: 28.5%; height: 2%; }
#obe_del            { top: 43%; left: 32%; width: 20%; height: 2%; }
#obe_marks          { top: 49%; left: 3%; width: 19%; height: 26%; font-size: 8px; }
#obe_pkgs           { top: 49%; left: 22.8%; width: 9%; height: 26%; font-size: 8px; }
#obe_desc           { top: 49%; left: 32%; width: 35%; height: 26%; font-size: 8px; }
#obe_weight         { top: 49%; left: 67%; width: 15%; height: 26%; font-size: 8px; }
#obe_measure        { top: 49%; left: 82.6%; width: 14%; height: 26%; font-size: 8px; }
#obe_currency       { display: none; }
#obe_freight        { top: 76.8%; left: 3.0%; width: 23.2%; height: 21.5%; font-size: 8px; }
#obe_prepaid        { top: 76.8%; left: 27%; width: 12.3%; height: 21.5%; text-align: center; font-size: 8px; }
#obe_collect        { top: 76.8%; left: 39.5%; width: 12.6%; height: 21.5%; text-align: center; font-size: 8px; }
#obe_total_prepaid  { display: none; }
#obe_total_collect  { display: none; }
#obe_orig_bl        { top: 86.5%; left: 70.5%; width: 11.0%; height: 1.5%; }
#obe_dated          { top: 90.2%; left: 64.5%; width: 16.0%; height: 1.5%; }
#obe_by             { top: 97.0%; left: 61.8%; width: 24.0%; height: 1.5%; }
</style>

<div id="ocean-blue-template">
    <!-- Page 1 -->
    <div style="position: relative;">
        <img src="/hbl-backgrounds/ocean-blue-page-1.png" alt="Ocean Blue Express Page 1">
        
        <textarea id="obe_shipper" class="hbl-field">{{ $data['shipper'] ?? '' }}</textarea>
        <input type="text" id="obe_doc_no" class="hbl-field" value="{{ $data['booking_number'] ?? '' }}">
        <input type="text" id="obe_bl_no" class="hbl-field" value="{{ $data['hbl_number'] ?? '' }}">
        <textarea id="obe_export_ref" class="hbl-field">{{ $data['export_references'] ?? '' }}</textarea>
        
        <textarea id="obe_consignee" class="hbl-field">{{ $data['consignee'] ?? '' }}</textarea>
        <input type="text" id="obe_fwd_agent" class="hbl-field" value="{{ $data['forwarding_agent'] ?? '' }}">
        <input type="text" id="obe_origin" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
        
        <textarea id="obe_notify" class="hbl-field">{{ $data['notify_party'] ?? '' }}</textarea>
        <textarea id="obe_routing" class="hbl-field"></textarea>
        
        <input type="text" id="obe_pre_carriage" class="hbl-field" value="{{ $data['pre_carriage_by'] ?? '' }}">
        <input type="text" id="obe_receipt" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
        <input type="text" id="obe_vessel" class="hbl-field" value="{{ $data['vessel'] ?? '' }}">
        <input type="text" id="obe_pol" class="hbl-field" value="{{ $data['port_of_loading'] ?? '' }}">
        <input type="text" id="obe_final_dest" class="hbl-field" value="{{ $data['final_destination'] ?? '' }}">
        
        <input type="text" id="obe_pod" class="hbl-field" value="{{ $data['port_of_discharge'] ?? '' }}">
        <input type="text" id="obe_del" class="hbl-field" value="{{ $data['place_of_delivery'] ?? '' }}">
        
        <textarea id="obe_marks" class="hbl-field">{{ $data['marks_numbers'] ?? '' }}</textarea>
        <textarea id="obe_pkgs" class="hbl-field">{{ $data['no_of_packages'] ?? '' }}</textarea>
        <textarea id="obe_desc" class="hbl-field">{{ $data['description'] ?? '' }}</textarea>
        <textarea id="obe_weight" class="hbl-field">{{ $data['gross_weight'] ?? '' }}</textarea>
        <textarea id="obe_measure" class="hbl-field">{{ $data['measurement'] ?? '' }}</textarea>
        
        <input type="text" id="obe_currency" class="hbl-field" value="{{ $data['currency'] ?? 'USD' }}">
        <textarea id="obe_freight" class="hbl-field">{{ $data['freight_payable_at'] ?? '' }}</textarea>
        <textarea id="obe_prepaid" class="hbl-field">{{ $data['prepaid_amount'] ?? '' }}</textarea>
        <textarea id="obe_collect" class="hbl-field">{{ $data['collect_amount'] ?? '' }}</textarea>
        <input type="text" id="obe_total_prepaid" class="hbl-field" value="{{ $data['prepaid_amount'] ?? '' }}">
        <input type="text" id="obe_total_collect" class="hbl-field" value="{{ $data['collect_amount'] ?? '' }}">
        
        <input type="text" id="obe_orig_bl" class="hbl-field" value="THREE (3)">
        <input type="text" id="obe_dated" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">
        <input type="text" id="obe_by" class="hbl-field" value="">
    </div>
    
    <!-- Page 2 (Terms & Conditions) -->
    <div style="position: relative; margin-top: 20px;">
        <img src="/hbl-backgrounds/ocean-blue-page-2.png" alt="Ocean Blue Express Page 2">
    </div>
</div>
