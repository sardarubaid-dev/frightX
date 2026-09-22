/**
 * AIR EXPORT FIELD DIAGNOSTIC UTILITY
 * 
 * Usage: Add this to Air Export controller store() and update() methods
 * This will log complete field comparison in console
 */

// PHP Code to add in AirExportController@store method (after line 291):
/*
// DIAGNOSTIC: Field Population Report
$allFields = [
    // Core Fields (Main Tab - Basic Info)
    'file_no', 'mawb_no', 'booking_no', 'post_date',
    'office_id', 'op_id',
    
    // Agent & Carrier Fields
    'forwarding_agent_id', 'oversea_agent_id', 'carrier_id', 'acct_carrier_id',
    
    // Flight & Route Details
    'flight_no', 'dep_port_id', 'dst_port_id',
    'etd', 'eta', 'atd', 'ata',
    
    // Quantities & Measurements
    'pkg_qty', 'pkg_unit_id', 'gross_weight', 'chargeable_weight', 'volume',
    'buying_rate', 'selling_rate',
    
    // Terms & Options
    'freight_term', 'is_ecommerce', 'sales_type', 'is_blocked',
    
    // Direct Master Fields
    'is_direct_master', 'dm_customer_id', 'dm_shipper_id', 'dm_bill_to_id',
    'dm_consignee_id', 'dm_notify_id', 'dm_sales_person_id', 'agent_ref_no',
    
    // MAWB Party Fields
    'shipper_id', 'consignee_id', 'notify_id', 'actual_shipper_id',
    
    // Additional Fields (from UpdateRequest validation)
    'incoterm_id', 'mark_number', 'service_term_from', 'service_term_to',
    'agent_id', 'co_loader_id', 'trans_port_id', 'trans_port1_id',
    'trans_port2_id', 'trans_port3_id', 'delivery_port_id', 'route_data',
    
    // Other Fields
    'internal_remark', 'color', 'label_description',
    
    // AWB Fields (from Model fillable but may not be in migration)
    'itn_no', 'cers_no', 'reference_no', 'awb_date', 'cargo_ready_date',
    'issuing_carrier', 'awb_type', 'dv_carriage', 'dv_customs', 
    'insurance', 'wt_val', 'other_term',
];

$requestData = $request->validated();
$filled = [];
$empty = [];

foreach ($allFields as $field) {
    if (isset($requestData[$field]) && $requestData[$field] !== null && $requestData[$field] !== '') {
        $filled[] = $field;
    } else {
        $empty[] = $field;
    }
}

$report = [
    'total_fields' => count($allFields),
    'filled_count' => count($filled),
    'empty_count' => count($empty),
    'filled_fields' => $filled,
    'empty_fields' => $empty,
    'percentage_filled' => round((count($filled) / count($allFields)) * 100, 2),
];

\Log::info('=== AIR EXPORT FIELD DIAGNOSTIC ===');
\Log::info('Total Fields: ' . $report['total_fields']);
\Log::info('Filled: ' . $report['filled_count'] . ' (' . $report['percentage_filled'] . '%)');
\Log::info('Empty: ' . $report['empty_count']);
\Log::info('');
\Log::info('FILLED FIELDS:');
foreach ($filled as $f) {
    \Log::info('  ✓ ' . $f . ' = ' . json_encode($requestData[$f]));
}
\Log::info('');
\Log::info('EMPTY FIELDS:');
foreach ($empty as $f) {
    \Log::info('  ✗ ' . $f);
}
\Log::info('===================================');

// Return for frontend (optional)
session()->flash('diagnostic', $report);
*/

// JavaScript Console Output (Add to create.blade.php after form submit)
/*
console.log('%c=== AIR EXPORT FIELD DIAGNOSTIC ===', 'color: #0066cc; font-weight: bold; font-size: 14px;');
console.log(`%cTotal Fields: ${diagnostic.total_fields}`, 'font-weight: bold;');
console.log(`%cFilled: ${diagnostic.filled_count} (${diagnostic.percentage_filled}%)`, 'color: green; font-weight: bold;');
console.log(`%cEmpty: ${diagnostic.empty_count}`, 'color: red; font-weight: bold;');
console.log('');
console.log('%cFILLED FIELDS:', 'color: green; font-weight: bold;');
diagnostic.filled_fields.forEach(field => {
    console.log(`  ✓ ${field}`);
});
console.log('');
console.log('%cEMPTY FIELDS:', 'color: red; font-weight: bold;');
diagnostic.empty_fields.forEach(field => {
    console.log(`  ✗ ${field}`);
});
console.log('%c===================================', 'color: #0066cc; font-weight: bold;');
*/
