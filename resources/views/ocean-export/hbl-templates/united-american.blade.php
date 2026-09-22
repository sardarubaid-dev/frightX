{{-- United American Line Template --}}
<style>
#united-american-template {
    position: relative;
    width: 794px;
    margin: 0 auto;
    background: #fff;
}
#united-american-template img {
    width: 100%;
    height: auto;
    display: block;
}

#ual_shipper        { top: 8%; left: 1.8%; width: 49%; height: 7%; }
#ual_booking        { top: 8%; left: 52%; width: 24%; height: 1.5%; }
#ual_bl_no          { top: 8%; left: 76.5%; width: 22%; height: 1.5%; }
#ual_export_ref     { top: 10.6%; left: 52%; width: 47.5%; height: 4.5%; }
#ual_consignee      {top: 16.5%; left: 1.8%; width: 49%; height:7%; }
#ual_fwd_agent      { top: 16.2%; left: 52%; width: 47.5%; height: 4%; }
#ual_origin         { top: 22%; left: 52%; width: 47.5%; height: 1.5%; }
#ual_notify         {top: 25.5%; left: 1.8%; width: 49%; height: 7%; }
#ual_delivery_agent {  top: 25.5%; left: 52%; width: 47.5%; height: 9%; }
#ual_pre_carriage   { top: 33.8%; left: 1.7%; width: 26%; height: 2%; }
#ual_receipt        {  top: 33.5%; left: 28%; width: 24%; height: 2%; }
#ual_vessel         { top: 36.5%; left: 1.7%; width: 19%; height: 2%; }
#ual_voyage         {top: 36.5%; left: 21%; width: 7%; height: 2%; }
#ual_pol            {  top: 36.5%; left: 28%; width: 24%; height: 2%; }
#ual_pier           { top: 36.5%; left: 52%; width: 47.5%; height: 2%; }
#ual_pod            { top: 39.2%; left: 1.6%; width: 26%; height: 2%; }
#ual_del            { top: 39.2%; left: 28%; width: 24%; height: 2%; }
#ual_move_type      {top:39.4%; left: 52%; width: 20%; height: 2%; }
#ual_marks          { top: 45%; left: 1.2%; width: 18.5%; height: 22%; font-size: 8px; }
#ual_pkgs           {  top: 45%; left: 19.5%; width: 10%; height: 22%; font-size: 8px; }
#ual_desc           { top: 45%; left: 30.5%; width: 44%; height: 22%; font-size: 8px; }
#ual_weight         {top: 45%; left: 75%; width: 13%; height: 22%; font-size: 8px; }
#ual_measure        { top: 45%; left: 88%; width: 12%;height: 22%; font-size: 8px; }
#ual_freight_basis  { top: 73%; left: 31.5%; width: 14%; height:  12.5%;text-align: center;  }
#ual_charges        { top: 73%; left: 1.2%; width: 30%; height: 12.5%; text-align: center;  }
#ual_rate           { top: 73%; left: 45.5%; width: 15.5%; height:  12.5%;text-align: center;  }
#ual_prepaid        { top: 73%; left: 61.5%; width: 18.2%; height:  12.5%; text-align: center; }
#ual_collect        { top: 73%; left: 80%; width: 19%; height:  12.5%; text-align: center; }

#ual_declared_val   {display:none; top: 69.2%; left: 24%; width: 22%; height: 1.5%; }
#ual_total_prepaid  { top: 86.5%; left: 61.5%; width: 18.2%; height: 1.8%; text-align: center; }
#ual_total_collect  { top: 86.5%; left: 80%; width: 19%; height: 1.8%; text-align: center; }
#ual_place_issue    {display:none; top: 89.2%; left: 54.5%; width: 11%; height: 1.5%; }
#ual_date_on        {top: 89.7%; left: 82%; width: 15%; height: 1.5%; }
#ual_by             {  top: 91.3%; left: 63%; width: 35%; height: 1.5%; }
#ual_dated          { top:  89.7%; left: 64%; width: 14%; height: 1.5%; text-align: center; }
</style>
<div id="united-american-template">
    <img src="/hbl-backgrounds/united-american-page-1.png" alt="United American Line">
    
    <textarea id="ual_shipper" class="hbl-field">{{ $data['shipper'] ?? '' }}</textarea>
    <input type="text" id="ual_booking" class="hbl-field" value="{{ $data['booking_number'] ?? '' }}">
    <input type="text" id="ual_bl_no" class="hbl-field" value="{{ $data['hbl_number'] ?? '' }}">
    <textarea id="ual_export_ref" class="hbl-field">{{ $data['export_references'] ?? '' }}</textarea>
    
    <textarea id="ual_consignee" class="hbl-field">{{ $data['consignee'] ?? '' }}</textarea>
    <input type="text" id="ual_fwd_agent" class="hbl-field" value="{{ $data['forwarding_agent'] ?? '' }}">
    <input type="text" id="ual_origin" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
    
    <textarea id="ual_notify" class="hbl-field">{{ $data['notify_party'] ?? '' }}</textarea>
    <textarea id="ual_delivery_agent" class="hbl-field">{{ $data['delivery_agent'] ?? '' }}</textarea>
    
    <input type="text" id="ual_pre_carriage" class="hbl-field" value="{{ $data['pre_carriage_by'] ?? '' }}">
    <input type="text" id="ual_receipt" class="hbl-field" value="{{ $data['place_of_receipt'] ?? '' }}">
    <input type="text" id="ual_vessel" class="hbl-field" value="{{ $data['vessel'] ?? '' }}">
    <input type="text" id="ual_voyage" class="hbl-field" value="{{ $data['voyage'] ?? '' }}">
    <input type="text" id="ual_pol" class="hbl-field" value="{{ $data['port_of_loading'] ?? '' }}">
    <input type="text" id="ual_pier" class="hbl-field" value="">
    
    <input type="text" id="ual_pod" class="hbl-field" value="{{ $data['port_of_discharge'] ?? '' }}">
    <input type="text" id="ual_del" class="hbl-field" value="{{ $data['place_of_delivery'] ?? '' }}">
    <input type="text" id="ual_move_type" class="hbl-field" value="{{ $data['ship_mode'] ?? '' }}">
    
    <textarea id="ual_marks" class="hbl-field">{{ $data['marks_numbers'] ?? '' }}</textarea>
    <textarea id="ual_pkgs" class="hbl-field">{{ $data['no_of_packages'] ?? '' }}</textarea>
    <textarea id="ual_desc" class="hbl-field">{{ $data['description'] ?? '' }}</textarea>
    <textarea id="ual_weight" class="hbl-field">{{ $data['gross_weight'] ?? '' }}</textarea>
    <textarea id="ual_measure" class="hbl-field">{{ $data['measurement'] ?? '' }}</textarea>
    
    <input type="text" id="ual_declared_val" class="hbl-field" value="">
    <textarea id="ual_charges" class="hbl-field"></textarea>
    <textarea id="ual_freight_basis" class="hbl-field"></textarea>
    <textarea id="ual_rate" class="hbl-field"></textarea>
    <textarea id="ual_prepaid" class="hbl-field">{{ $data['prepaid_amount'] ?? '' }}</textarea>
    <textarea id="ual_collect" class="hbl-field">{{ $data['collect_amount'] ?? '' }}</textarea>

    <input type="text" id="ual_total_prepaid" class="hbl-field" value="{{ $data['prepaid_amount'] ?? '' }}">
    <input type="text" id="ual_total_collect" class="hbl-field" value="{{ $data['collect_amount'] ?? '' }}">
    
    <input type="text" id="ual_date_on" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">
    <input type="text" id="ual_by" class="hbl-field" value="">
    <input type="text" id="ual_dated" class="hbl-field" value="{{ $data['date_of_issue'] ?? '' }}">
</div>
