<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Charges Statement - Air Export Shipment {{ $shipment->file_no ?? $shipment->mawb_no }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 30px; font-size: 13px; line-height: 1.4; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); border-radius: 6px; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin: 0; color: #1e3a8a; }
        .shipment-info { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 30px; background: #f8fafc; padding: 15px; border-radius: 4px; }
        .info-item { font-size: 12px; }
        .info-item strong { color: #475569; }
        table { width: 100%; border-collapse: collapse; text-align: left; margin-bottom: 30px; }
        th { background: #3b82f6; color: #fff; padding: 10px; font-size: 12px; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 12px; }
        .total-section { display: flex; justify-content: flex-end; font-size: 15px; font-weight: bold; }
        .total-box { border-top: 2px solid #1e3a8a; padding-top: 10px; width: 250px; text-align: right; }
        .btn-print { background: #3b82f6; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; font-weight: bold; cursor: pointer; float: right; margin-bottom: 20px; }
        @media print {
            .btn-print { display: none; }
            .invoice-box { border: none; box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body>
    <div style="float: right; margin-bottom: 20px;">
        <a href="{{ route('shipments.freight-invoice', ['type' => 'air-export', 'id' => $shipment->id]) }}" class="btn-print" style="text-decoration:none; margin-right: 10px; display: inline-block;" target="_blank">Generate Freight Invoice</a>
        <button class="btn-print" onclick="window.print()" style="display: inline-block;">Print Statement</button>
    </div>
    <div style="clear: both;"></div>
    <div class="invoice-box">
        <div class="header">
            <div>
                <h1>Air Export Charges Statement</h1>
                <p>File / MAWB No: {{ $shipment->file_no ?? $shipment->mawb_no }}</p>
            </div>
            <div style="text-align: right;">
                <p><strong>Date:</strong> {{ date('Y-m-d') }}</p>
                <p><strong>Operator:</strong> {{ $shipment->operator->name ?? 'System' }}</p>
            </div>
        </div>

        <div class="shipment-info">
            <div class="info-item"><strong>MAWB No:</strong> {{ $shipment->mawb_no ?? 'N/A' }}</div>
            <div class="info-item"><strong>Office:</strong> {{ $shipment->office->code ?? 'N/A' }}</div>
            <div class="info-item"><strong>Flight No:</strong> {{ $shipment->flight_no ?? 'N/A' }}</div>
            <div class="info-item"><strong>ETD:</strong> {{ $shipment->etd ? (is_string($shipment->etd) ? $shipment->etd : $shipment->etd->format('Y-m-d')) : 'N/A' }}</div>
            <div class="info-item"><strong>Departure Airport (DEP):</strong> {{ $shipment->depPort->name ?? 'N/A' }}</div>
            <div class="info-item"><strong>Destination Airport (DST):</strong> {{ $shipment->dstPort->name ?? 'N/A' }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Currency</th>
                    <th>ROE</th>
                    <th>VAT</th>
                    <th style="text-align: right;">Total Amount (Local)</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($shipment->charges as $c)
                    @php
                        $foreignAmount = ($c->rate ?? 0) * ($c->qty ?? 1);
                        $localAmount = $foreignAmount * ($c->roe ?? 1.0);
                        if (($c->tax_percent ?? 0) > 0) {
                            $localAmount += ($localAmount * (($c->tax_percent ?? 0) / 100));
                        }
                        $grandTotal += $localAmount;
                    @endphp
                    <tr>
                        <td>{{ $c->type }}</td>
                        <td>{{ $c->charge_code }}</td>
                        <td>{{ $c->charge_name }}</td>
                        <td>{{ number_format($c->qty ?? 1, 2) }}</td>
                        <td>{{ $c->unit ?? 'B/L' }}</td>
                        <td>{{ number_format($c->rate ?? 0, 2) }}</td>
                        <td>{{ $c->currency->code ?? 'USD' }}</td>
                        <td>{{ number_format($c->roe ?? 1.0, 4) }}</td>
                        <td>{{ number_format($c->tax_percent ?? 0, 2) }}%</td>
                        <td style="text-align: right;">{{ number_format($localAmount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-box">
                Total Local Amount: {{ number_format($grandTotal, 2) }}
            </div>
        </div>
    </div>
</body>
</html>
