<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill of Lading - {{ $truckShipment->file_no ?? 'New Shipment' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; background: #f4f6f9; padding: 20px; }
        .bol-box { max-width: 900px; margin: 0 auto; background: #fff; border: 2px solid #000; padding: 15px; }
        .row { display: flex; width: 100%; border-bottom: 1px solid #000; }
        .col { flex: 1; border-right: 1px solid #000; padding: 6px; }
        .col:last-child { border-right: none; }
        .label { font-size: 9px; font-weight: bold; text-transform: uppercase; color: #444; margin-bottom: 3px; }
        .value { font-size: 11px; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; font-size: 10px; }
        th { background: #eee; font-weight: bold; }
        .toolbar { display: flex; justify-content: flex-end; gap: 10px; max-width: 900px; margin: 0 auto 15px auto; }
        .btn-action { padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-print { background: #2563eb; color: #fff; }
        .btn-close { background: #64748b; color: #fff; }
        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none; }
            .bol-box { border: 2px solid #000; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button onclick="window.print()" class="btn-action btn-print"><i class="fa fa-print"></i> Print BOL</button>
        <button onclick="window.close()" class="btn-action btn-close"><i class="fa fa-times"></i> Close</button>
    </div>

    <div class="bol-box">
        <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 8px;">
            <h2 style="font-size: 18px; text-transform: uppercase; letter-spacing: 1px;">STRAIGHT BILL OF LADING - ORIGINAL - NOT NEGOTIABLE</h2>
            <div style="font-size: 10px; font-weight: bold;">FREIGHTX TRUCKING & TRANSPORTATION</div>
        </div>

        <div class="row">
            <div class="col" style="flex: 2;">
                <div class="label">SHIPPER (FROM)</div>
                <div class="value"><strong>{{ $truckShipment->shipper->name ?? 'N/A' }}</strong></div>
                <div class="value">{{ $truckShipment->pol->name ?? '' }}</div>
            </div>
            <div class="col">
                <div class="label">BOL NUMBER</div>
                <div class="value"><strong>{{ $truckShipment->file_no ?? 'N/A' }}</strong></div>
            </div>
            <div class="col">
                <div class="label">DATE</div>
                <div class="value">{{ date('Y-m-d') }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col" style="flex: 2;">
                <div class="label">CONSIGNEE (TO)</div>
                <div class="value"><strong>{{ $truckShipment->consignee->name ?? 'N/A' }}</strong></div>
                <div class="value">{{ $truckShipment->pod->name ?? '' }}</div>
            </div>
            <div class="col">
                <div class="label">CARRIER / TRUCKER</div>
                <div class="value"><strong>{{ $truckShipment->trucker->name ?? 'N/A' }}</strong></div>
            </div>
            <div class="col">
                <div class="label">TRAILER / CONT NO.</div>
                <div class="value">{{ $truckShipment->containers[0]->container_no ?? 'N/A' }}</div>
            </div>
        </div>

        <div style="margin-top: 10px; font-weight: bold; font-size: 11px;">CARGO ITEM DETAILS</div>
        <table>
            <thead>
                <tr>
                    <th>HANDLING UNITS</th>
                    <th>PACKAGE TYPE</th>
                    <th>COMMODITY DESCRIPTION</th>
                    <th style="text-align: right;">WEIGHT (KG)</th>
                    <th style="text-align: right;">CBM</th>
                </tr>
            </thead>
            <tbody>
                @forelse($truckShipment->containers ?? [] as $container)
                    <tr>
                        <td style="text-align: center;">{{ $container->pkg ?? 1 }}</td>
                        <td>CTN / PKG</td>
                        <td>CONTAINER NO: {{ $container->container_no ?? 'N/A' }} | SEAL: {{ $container->seal_no ?? 'N/A' }}</td>
                        <td style="text-align: right;">{{ number_format($container->weight ?? 0, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($container->measurement ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #888;">No items registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 15px; border: 1px solid #000; padding: 8px;">
            <div class="label">SPECIAL INSTRUCTIONS</div>
            <div style="min-height: 35px;">{{ $truckShipment->remark ?? 'Standard freight transport terms apply.' }}</div>
        </div>

        <div class="row" style="margin-top: 20px; border: none;">
            <div class="col" style="border: none; text-align: center; padding-top: 30px;">
                <div style="border-top: 1px solid #000; padding-top: 4px; font-weight: bold;">SHIPPER SIGNATURE</div>
            </div>
            <div class="col" style="border: none; text-align: center; padding-top: 30px;">
                <div style="border-top: 1px solid #000; padding-top: 4px; font-weight: bold;">CARRIER SIGNATURE</div>
            </div>
            <div class="col" style="border: none; text-align: center; padding-top: 30px;">
                <div style="border-top: 1px solid #000; padding-top: 4px; font-weight: bold;">CONSIGNEE SIGNATURE</div>
            </div>
        </div>
    </div>
</body>
</html>
