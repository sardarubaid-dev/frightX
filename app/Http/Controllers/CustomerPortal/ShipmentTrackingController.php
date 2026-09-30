<?php
namespace App\Http\Controllers\CustomerPortal;
use App\Http\Controllers\Controller;
use App\Models\OceanImport;
use Illuminate\Http\Request;

class ShipmentTrackingController extends Controller
{
    public function index(Request $request)
    {
        $tpId = auth()->user()->trade_partner_id;
        $shipments = OceanImport::with(['portOfLoading', 'portOfDischarge', 'vessel'])
            ->where('company_id', auth()->user()->company_id)
            ->where(function($q) use ($tpId) {
                $q->where('dm_shipper_id', $tpId)->orWhere('dm_consignee_id', $tpId)->orWhere('dm_customer_id', $tpId);
            })->latest()->paginate(15);

        if ($request->ajax()) {
            return view('customer-portal.partials.shipment-rows', compact('shipments'));
        }

        return view('customer-portal.shipments', compact('shipments'));
    }

    public function show($id)
    {
        $tpId = auth()->user()->trade_partner_id;
        $shipment = OceanImport::with(['portOfLoading', 'portOfDischarge', 'vessel', 'containers'])
            ->where('company_id', auth()->user()->company_id)
            ->where(function($q) use ($tpId) {
                $q->where('dm_shipper_id', $tpId)->orWhere('dm_consignee_id', $tpId)->orWhere('dm_customer_id', $tpId);
            })->findOrFail($id);

        return view('customer-portal.shipment-detail', compact('shipment'));
    }
}
