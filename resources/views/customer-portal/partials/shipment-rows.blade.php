@forelse($shipments as $shipment)
    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s; cursor: pointer;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'" onclick="window.location.href='/portal/shipments/{{ $shipment->id }}'">
        <td style="padding: 12px 16px; color: #1e293b; font-weight: 500;">
            <div style="font-size: 13px;">{{ $shipment->file_no ?? '-' }}</div>
            <div style="font-size: 11px; color: #64748b; margin-top: 2px;">Ocean Import</div>
        </td>
        <td style="padding: 12px 16px;">
            <div style="color: #334155; font-size: 12px; font-weight: 500;"><i class="fa fa-arrow-circle-up" style="color:#3b82f6; width:14px;"></i> {{ $shipment->portOfLoading->name ?? ($shipment->pol_name ?? 'Unknown POL') }}</div>
            <div style="color: #334155; font-size: 12px; font-weight: 500; margin-top: 4px;"><i class="fa fa-map-marker" style="color:#ef4444; width:14px;"></i> {{ $shipment->portOfDischarge->name ?? ($shipment->pod_name ?? 'Unknown POD') }}</div>
        </td>
        <td style="padding: 12px 16px; color: #475569; font-size: 12px;">
            <div style="font-weight: 600; color: #1e293b;">{{ $shipment->vessel->name ?? ($shipment->vessel_name ?? 'TBA') }}</div>
            <div style="margin-top: 2px;">Voy: {{ $shipment->voyage ?? 'TBA' }}</div>
        </td>
        <td style="padding: 12px 16px; color: #475569; font-size: 12px;">
            <div style="font-weight: 600; color: #1e293b;" title="MBL">{{ $shipment->mbl_no ?: 'TBA' }}</div>
            <div style="margin-top: 2px;" title="HBL">{{ $shipment->hbl_no ?: 'TBA' }}</div>
        </td>
        <td style="padding: 12px 16px; color: #475569; font-size: 12px;">
            <div style="color: #1e293b;"><span style="color:#64748b; font-size:10px;">ETD:</span> {{ isset($shipment->etd) ? \Carbon\Carbon::parse($shipment->etd)->format('M d, Y') : '-' }}</div>
            <div style="margin-top: 2px; color: #1e293b;"><span style="color:#64748b; font-size:10px;">ETA:</span> {{ isset($shipment->eta) ? \Carbon\Carbon::parse($shipment->eta)->format('M d, Y') : '-' }}</div>
        </td>
        <td style="padding: 12px 16px;">
            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">
                {{ $shipment->status ?? 'Pending' }}
            </span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" style="padding: 20px; text-align: center; color: #64748b; font-size: 13px;">
            No shipments found.
        </td>
    </tr>
@endforelse
