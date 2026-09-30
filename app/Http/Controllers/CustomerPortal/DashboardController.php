<?php
namespace App\Http\Controllers\CustomerPortal;
use App\Http\Controllers\Controller;
use App\Models\OceanImport;
use App\Models\AirExport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $tpId = auth()->user()->trade_partner_id;

        $oceanQuery = OceanImport::where('company_id', $companyId)
            ->where(function($q) use ($tpId) {
                $q->where('dm_shipper_id', $tpId)->orWhere('dm_consignee_id', $tpId)->orWhere('dm_customer_id', $tpId);
            });

        $oceanImports = (clone $oceanQuery)->count();

        $airExports = AirExport::where('company_id', $companyId)
            ->where(function($q) use ($tpId) {
                $q->where('shipper_id', $tpId)->orWhere('consignee_id', $tpId)->orWhere('dm_customer_id', $tpId);
            })->count();

        $recentShipments = (clone $oceanQuery)
            ->with(['portOfLoading', 'portOfDischarge', 'vessel'])
            ->latest()
            ->take(5)
            ->get();

        $totalShipments = $oceanImports + $airExports;

        return view('customer-portal.dashboard', compact('oceanImports', 'airExports', 'recentShipments', 'totalShipments'));
    }
}
