{{-- Silk Container Lines Template --}}
<style>
#silk-container-template {
    position: relative;
    width: 794px;
    margin: 0 auto;
    background: #fff;
}
#silk-container-template img {
    width: 100%;
    height: auto;
    display: block;
}
/* Field IDs and Positionings for Silk Container */
#silk_shipper          { top: 3.4%; left: 2.4%; width: 45%; height: 8%; }
#silk_consignee        { top: 13%; left: 2.4%; width: 45%; height: 8%; }
#silk_notify           { top: 22.5%; left: 2.4%; width: 45%; height: 7.6%; }
#silk_date_issue       { top: 22%; left: 48.5%; width: 23%; height: 4.5%; }
#silk_bl_no            { top: 22%; left: 72.3%; width: 23%; height: 4.5%; }
#silk_delivery_agent   { top: 28.5%; left: 49%; width: 46%; height: 9%; font-size: 8px; }
#silk_receipt          { top: 32%; left: 2.4%; width: 22%; height: 2.2%; }
#silk_pol              { top: 32%; left: 25.5%; width: 22%; height: 2.2%; }
#silk_vessel           { top: 36%; left: 2.4%; width: 22%; height: 2.2%; }
#silk_voyage           { top: 36%; left: 25.4%; width: 22%; height: 2.2%; }
#silk_pod              { top: 40%; left: 2.4%; width: 22%; height: 2.2%; }
#silk_del              { top: 40%; left: 25.4%; width: 23%; height: 2.2%; }
#silk_final_dest       { top: 40%; left: 49%; width: 15%; height: 2.2%; }
#silk_freight_pay      { top: 40%; left: 65%; width: 14%; height: 2.2%; }
#silk_orig_bl          { top: 40%; left: 81%; width: 14%; height: 2.2%; }
#silk_marks            { top: 46%; left: 2.4%; width: 23%; height: 29%; font-size: 8px; }
#silk_pkgs             { top: 46%; left: 25.4%; width: 13%; height: 29%; font-size: 8px; }
#silk_desc             { top: 46%; left: 38.5%; width: 34%; height: 29%; font-size: 8px; }
#silk_weight           { top: 46%; left: 73%; width: 11.6%; height: 29%; font-size: 8px; }
#silk_measure          { top: 46%; left: 84.5%; width: 11%; height: 29%; font-size: 8px; }
#silk_shipped_on_board { top: 76.2%; left: 23.5%; width: 28%; height: 2.2%; }
#silk_dated            { top: 79%; left: 7.5%; width: 44.5%; height: 2.2%; }
#silk_freight_charges  { top: 85%; left: 2.4%; width: 24%; height: 9%; font-size: 8px; }
#silk_prepaid          { top: 85%; left: 27%; width: 13%; height: 9%; text-align: center; }
#silk_collect          { top: 85%; left: 40%; width: 13%; height: 9%; text-align: center; }


</style>

<div id="silk-container-template">
    <img src="/hbl-backgrounds/silk-container-page-1.png" alt="Silk Container Lines">
    
    <textarea id="silk_shipper" class="hbl-field">{{ $data['shipper'] ?? '' }}</textarea>
    <textarea id="silk_consignee" class="hbl-field">{{ $data['consignee'] ?? '' }}</textarea>
    <textarea id="silk_notify" class="hbl-field">{{ $data['notify_party'] ?? '' }}</textarea>
    
    <input type="text" id="silk_date_issue" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">
    <input type="text" id="silk_bl_no" class="hbl-field" value="{{ $data['hbl_number'] ?? '' }}">
    
    <textarea id="silk_delivery_agent" class="hbl-field">{{ $data['delivery_agent'] ?? '' }}</textarea>
    
    <input type="text" id="silk_receipt" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
    <input type="text" id="silk_pol" class="hbl-field" value="{{ $data['port_of_loading'] ?? '' }}">
    <input type="text" id="silk_vessel" class="hbl-field" value="{{ $data['vessel'] ?? '' }}">
    <input type="text" id="silk_voyage" class="hbl-field" value="{{ $data['voyage'] ?? '' }}">
    
    <input type="text" id="silk_pod" class="hbl-field" value="{{ $data['port_of_discharge'] ?? '' }}">
    <input type="text" id="silk_del" class="hbl-field" value="{{ $data['place_of_delivery'] ?? '' }}">
    <input type="text" id="silk_final_dest" class="hbl-field" value="{{ $data['final_destination'] ?? '' }}">
    <input type="text" id="silk_freight_pay" class="hbl-field" value="{{ $data['freight_payable_at'] ?? '' }}">
    <input type="text" id="silk_orig_bl" class="hbl-field" value="THREE (3)">
    
    <textarea id="silk_marks" class="hbl-field">{{ $data['marks_numbers'] ?? '' }}</textarea>
    <textarea id="silk_pkgs" class="hbl-field">{{ $data['no_of_packages'] ?? '' }}</textarea>
    <textarea id="silk_desc" class="hbl-field">{{ $data['description'] ?? '' }}</textarea>
    <textarea id="silk_weight" class="hbl-field">{{ $data['gross_weight'] ?? '' }}</textarea>
    <textarea id="silk_measure" class="hbl-field">{{ $data['measurement'] ?? '' }}</textarea>
    
    <input type="text" id="silk_shipped_on_board" class="hbl-field" value="{{ $data['shipped_on_board'] ?? $data['vessel'] ?? '' }}">
    <input type="text" id="silk_dated" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">
    <textarea id="silk_freight_charges" class="hbl-field">{{ $data['freight_payable_at'] ?? '' }}</textarea>
    <input type="text" id="silk_prepaid" class="hbl-field" value="{{ $data['prepaid_amount'] ?? '' }}">
    <input type="text" id="silk_collect" class="hbl-field" value="{{ $data['collect_amount'] ?? '' }}">

</div>
