<?php

namespace Database\Seeders;

use App\Models\HblTemplate;
use Illuminate\Database\Seeder;

class HblTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'NTG AIR',
                'title' => 'NTG AIR HBL',
                'css' => '
                    .doc-page {
                        padding: 0 !important;
                        width: 820px !important;
                        height: 1160px !important;
                        min-height: 1160px !important;
                        box-shadow: none !important;
                        background: none !important;
                    }
                ',
                'content' => $this->getNtgAirTemplate(),
                'is_active' => true,
            ],
            [
                'name' => 'OCEAN BLUE EXPRESS INC.',
                'title' => 'OCEAN BLUE EXPRESS HBL',
                'css' => '
                    .doc-page {
                        padding: 0 !important;
                        width: 820px !important;
                        height: 1061px !important;
                        min-height: 1061px !important;
                        box-shadow: none !important;
                        background: none !important;
                    }
                ',
                'content' => $this->getOceanBlueTemplate(),
                'is_active' => true,
            ],
            [
                'name' => 'SILK CONTAINER LINES',
                'title' => 'SILK CONTAINER LINES HBL',
                'css' => '
                    .doc-page {
                        padding: 0 !important;
                        width: 820px !important;
                        height: 1160px !important;
                        min-height: 1160px !important;
                        box-shadow: none !important;
                        background: none !important;
                    }
                ',
                'content' => $this->getSilkTemplate(),
                'is_active' => true,
            ],
            [
                'name' => 'TRANSAMERICA LOGISTIC',
                'title' => 'TRANSAMERICA LOGISTIC HBL',
                'css' => '
                    .doc-page {
                        padding: 0 !important;
                        width: 820px !important;
                        height: 1160px !important;
                        min-height: 1160px !important;
                        box-shadow: none !important;
                        background: none !important;
                    }
                ',
                'content' => $this->getTransamericaTemplate(),
                'is_active' => true,
            ],
            [
                'name' => 'UNITED AMERICAN LINE',
                'title' => 'UNITED AMERICAN LINE HBL',
                'css' => '
                    .doc-page {
                        padding: 0 !important;
                        width: 820px !important;
                        height: 1160px !important;
                        min-height: 1160px !important;
                        box-shadow: none !important;
                        background: none !important;
                    }
                ',
                'content' => $this->getUnitedAmericanTemplate(),
                'is_active' => true,
            ]
        ];

        foreach ($templates as $tpl) {
            HblTemplate::updateOrCreate(['name' => $tpl['name']], $tpl);
        }
    }

    /**
     * NTG AIR template content.
     */
    private function getNtgAirTemplate(): string
    {
        return <<<'HTML'
@php
    $containersList = (isset($hbl->containers) && count($hbl->containers) > 0) ? $hbl->containers : ((isset($hbl->oceanExport) && isset($hbl->oceanExport->containers) && count($hbl->oceanExport->containers) > 0) ? $hbl->oceanExport->containers : collect());
    $firstPageLimit = 4;
    $subsequentLimit = 12;
    $containerChunks = [];
    if ($containersList->count() <= $firstPageLimit) {
        $containerChunks[] = $containersList;
    } else {
        $containerChunks[] = $containersList->slice(0, $firstPageLimit);
        $remaining = $containersList->slice($firstPageLimit);
        foreach ($remaining->chunk($subsequentLimit) as $chunk) {
            $containerChunks[] = $chunk;
        }
    }
    $totalContainerPages = count($containerChunks);
    $firstChunk = $containerChunks[0] ?? collect();
    $continuationStartPage = 3;
    $totalPagesTotal = $totalContainerPages + 1;
@endphp

<!-- PAGE 1: NTG AIR & OCEAN AUTHENTIC FORM -->
<div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-after: always; break-after: page;">
    <img src="/assets/images/hbl/ntg_air-1.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;" />
    
    <div style="position: absolute; z-index: 2; top: 9.3%; left: 62.0%; width: 35.0%; font-size: 13px; color: #b91c1c; overflow: hidden;">{{ $hbl->hbl_no }}</div>
    <div style="position: absolute; z-index: 2; top: 13.4%; left: 51.5%; width: 45.0%; overflow: hidden;">{{ $hbl->oceanExport->file_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 10.8%; left: 2.5%; width: 47.0%; height: 6.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->shipper->name ?? '' }}</strong>
{{ $hbl->shipper->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 18.0%; left: 2.5%; width: 47.0%; height: 5.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->consignee->name ?? '' }}</strong>
{{ $hbl->consignee->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 26.5%; left: 2.5%; width: 47.0%; height: 6.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->notifyParty->name ?? '' }}</strong>
{{ $hbl->notifyParty->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 18.0%; left: 51.5%; width: 45.0%; height: 5.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->oceanExport->overseaAgent->name ?? '' }}</strong>
{{ $hbl->oceanExport->overseaAgent->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 26.5%; left: 51.5%; width: 45.0%; height: 6.0%; overflow: hidden; font-size: 10px; color: #333;">FOR DELIVERY PLEASE APPLY TO OVERSEA AGENT ABOVE.</div>

    <div style="position: absolute; z-index: 2; top: 33.5%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->pre_carriage_by ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 33.5%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfReceipt->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 36.5%; left: 2.5%; width: 17.0%; overflow: hidden;">{{ $hbl->vessel_name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 36.5%; left: 20.0%; width: 11.0%; overflow: hidden;">{{ $hbl->voyage_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 36.5%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->oceanExport->portOfLoading->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 39.5%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->placeOfDischarge->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 39.5%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfDelivery->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 39.5%; left: 51.5%; width: 45.0%; overflow: hidden;">CY/CY</div>
    
    <div style="position: absolute; z-index: 2; top: 44.5%; left: 0; width: 100%; height: 24.0%; padding: 0 1.5%; box-sizing: border-box; overflow: hidden;">
        @if(count($firstChunk) > 0)
            @foreach($firstChunk as $container)
            <div style="display: flex; line-height: 1.3; margin-bottom: 4px; font-size: 10.5px;">
                <div style="width: 18%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $container->container_no }}<br>SL: {{ $container->seal_no ?: 'NONE' }}
                </div>
                <div style="width: 53%; padding-left: 10px; overflow: hidden; white-space: pre-wrap; height: 32px;">
                    {{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}
                </div>
                <div style="width: 13.5%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 10.0%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
            @if($totalContainerPages > 1)
            <div style="text-align: center; font-weight: bold; margin-top: 8px; color: #1e3a8a; font-size: 11px;">
                *** CONTINUED ON ATTACHED SHEET (PAGE 3 OF {{ $totalPagesTotal }}) ***
            </div>
            @endif
        @else
            <div style="font-size: 10px; color: #777;">NO CONTAINERS LOADED</div>
        @endif
    </div>
    
    <div style="position: absolute; z-index: 2; top: 69.8%; left: 2.5%; width: 25.0%; overflow: hidden;">TOTAL CONTAINERS: {{ count($containersList) }}</div>
    <div style="position: absolute; z-index: 2; top: 73.5%; left: 2.5%; width: 25.0%; overflow: hidden;">3 (THREE)</div>
    <div style="position: absolute; z-index: 2; top: 76.8%; left: 2.5%; width: 25.0%; overflow: hidden;">N/A</div>
    <div style="position: absolute; z-index: 2; top: 69.8%; left: 28.5%; width: 22.0%; overflow: hidden;">LOS ANGELES, CA</div>
    <div style="position: absolute; z-index: 2; top: 73.5%; left: 28.5%; width: 22.0%; overflow: hidden;">{{ $hbl->date_of_issue ? \Carbon\Carbon::parse($hbl->date_of_issue)->format('m/d/Y') : date('m/d/Y') }}</div>
    <div style="position: absolute; z-index: 2; top: 76.8%; left: 28.5%; width: 22.0%; overflow: hidden;">{{ $hbl->date_of_issue ? \Carbon\Carbon::parse($hbl->date_of_issue)->format('m/d/Y') : date('m/d/Y') }}</div>
    
    @if(($hbl->freight_payable_at ?? '') == 'PREPAID')
        <div style="position: absolute; z-index: 2; top: 80.8%; left: 31.5%; width: 9.0%; text-align: right;">AS AGREED</div>
    @elseif(($hbl->freight_payable_at ?? '') == 'COLLECT')
        <div style="position: absolute; z-index: 2; top: 80.8%; left: 41.5%; width: 9.5%; text-align: right;">AS AGREED</div>
    @endif
    <div style="position: absolute; z-index: 2; top: 92.5%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->freight_payable_at ?? 'PREPAID' }}</div>
    <div style="position: absolute; z-index: 2; top: 94.0%; left: 68.0%; width: 30.0%; overflow: hidden;">NTG AIR & OCEAN</div>
</div>

<!-- PAGE 2: TERMS & CONDITIONS -->
<div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; box-sizing: border-box; overflow: hidden; page-break-before: always; break-before: page; page-break-after: always; break-after: page; margin-top: 20px;">
    <img src="/assets/images/hbl/ntg_air-2.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;" />
</div>

@if($totalContainerPages > 1)
    @foreach(array_slice($containerChunks, 1) as $cIdx => $chunkContainers)
    <div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-before: always; break-before: page; page-break-after: always; break-after: page; margin-top: 20px;">
        <div style="position: absolute; z-index: 2; top: 4.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 2px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-size: 14px; font-weight: bold; color: #1e3a8a;">NTG AIR & OCEAN - CONTINUATION SHEET</span><br>
                <span style="font-size: 11px;">B/L NO: <strong>{{ $hbl->hbl_no }}</strong> | FILE NO: <strong>{{ $hbl->oceanExport->file_no ?? '' }}</strong></span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px; font-weight: bold; color: #b91c1c;">PAGE {{ $cIdx + 3 }} OF {{ $totalPagesTotal }}</span><br>
                <span style="font-size: 10px;">SHIPPER: {{ $hbl->shipper->name ?? 'N/A' }}</span>
            </div>
        </div>
        <div style="position: absolute; z-index: 2; top: 12.0%; left: 1.5%; width: 97.0%; height: 75.0%; background: #ffffff; border: 1px solid #ccc; padding: 15px; box-sizing: border-box; overflow: hidden;">
            <div style="display: flex; font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 10px; font-size: 11px;">
                <div style="width: 20%;">CONTAINER / SEAL NO</div>
                <div style="width: 50%;">MARKS & DESCRIPTION OF GOODS</div>
                <div style="width: 15%; text-align: right;">GROSS WEIGHT</div>
                <div style="width: 15%; text-align: right;">MEASUREMENT</div>
            </div>
            @foreach($chunkContainers as $container)
            <div style="display: flex; line-height: 1.4; margin-bottom: 8px; font-size: 11px; border-bottom: 1px dashed #eee; padding-bottom: 4px;">
                <div style="width: 20%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <strong>{{ $container->container_no }}</strong><br><span style="font-size: 10px; color: #555;">SEAL: {{ $container->seal_no ?: 'NONE' }}</span>
                </div>
                <div style="width: 50%; padding-left: 10px; overflow: hidden; white-space: pre-wrap;">{{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
        </div>
        <div style="position: absolute; z-index: 2; top: 88.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 1px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; font-size: 10.5px;">
            <div>TOTAL CONTAINERS ON THIS SHEET: <strong>{{ count($chunkContainers) }}</strong></div>
            <div>AUTHORIZED SIGNATURE: <strong>NTG AIR & OCEAN</strong></div>
        </div>
    </div>
    @endforeach
@endif
HTML;
    }

    /**
     * OCEAN BLUE template content.
     */
    private function getOceanBlueTemplate(): string
    {
        return <<<'HTML'
@php
    $containersList = (isset($hbl->containers) && count($hbl->containers) > 0) ? $hbl->containers : ((isset($hbl->oceanExport) && isset($hbl->oceanExport->containers) && count($hbl->oceanExport->containers) > 0) ? $hbl->oceanExport->containers : collect());
    $firstPageLimit = 4;
    $subsequentLimit = 12;
    $containerChunks = [];
    if ($containersList->count() <= $firstPageLimit) {
        $containerChunks[] = $containersList;
    } else {
        $containerChunks[] = $containersList->slice(0, $firstPageLimit);
        $remaining = $containersList->slice($firstPageLimit);
        foreach ($remaining->chunk($subsequentLimit) as $chunk) {
            $containerChunks[] = $chunk;
        }
    }
    $totalContainerPages = count($containerChunks);
    $firstChunk = $containerChunks[0] ?? collect();
    $continuationStartPage = 3;
    $totalPagesTotal = $totalContainerPages + 1;
@endphp

<!-- PAGE 1: OCEAN BLUE EXPRESS AUTHENTIC FORM -->
<div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-after: always; break-after: page;">
    <img src="/assets/images/hbl/ocean_blue-1.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;" />
    
    <div style="position: absolute; z-index: 2; top: 9.3%; left: 62.0%; width: 35.0%; font-size: 13px; color: #b91c1c; overflow: hidden;">{{ $hbl->hbl_no }}</div>
    <div style="position: absolute; z-index: 2; top: 13.4%; left: 51.5%; width: 45.0%; overflow: hidden;">{{ $hbl->oceanExport->file_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 10.2%; left: 2.5%; width: 47.0%; height: 6.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->shipper->name ?? '' }}</strong>
{{ $hbl->shipper->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 18.5%; left: 2.5%; width: 47.0%; height: 5.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->consignee->name ?? '' }}</strong>
{{ $hbl->consignee->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 24.5%; left: 2.5%; width: 47.0%; height: 7.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->notifyParty->name ?? '' }}</strong>
{{ $hbl->notifyParty->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 18.5%; left: 51.5%; width: 45.0%; height: 5.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->oceanExport->overseaAgent->name ?? '' }}</strong>
{{ $hbl->oceanExport->overseaAgent->address ?? '' }}</div>

    <div style="position: absolute; z-index: 2; top: 34.2%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->pre_carriage_by ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 34.2%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfReceipt->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 38.5%; left: 2.5%; width: 17.0%; overflow: hidden;">{{ $hbl->vessel_name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 38.5%; left: 20.0%; width: 11.0%; overflow: hidden;">{{ $hbl->voyage_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 38.5%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->oceanExport->portOfLoading->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 41.5%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->placeOfDischarge->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 41.5%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfDelivery->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 44.5%; left: 51.5%; width: 45.0%; overflow: hidden;">CY/CY</div>
    
    <div style="position: absolute; z-index: 2; top: 48.8%; left: 0; width: 100%; height: 26.0%; padding: 0 1.5%; box-sizing: border-box; overflow: hidden;">
        @if(count($firstChunk) > 0)
            @foreach($firstChunk as $container)
            <div style="display: flex; line-height: 1.3; margin-bottom: 4px; font-size: 10.5px;">
                <div style="width: 18%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $container->container_no }}<br>SL: {{ $container->seal_no ?: 'NONE' }}
                </div>
                <div style="width: 53%; padding-left: 10px; overflow: hidden; white-space: pre-wrap; height: 32px;">
                    {{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}
                </div>
                <div style="width: 13.5%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 10.0%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
            @if($totalContainerPages > 1)
            <div style="text-align: center; font-weight: bold; margin-top: 8px; color: #1e3a8a; font-size: 11px;">
                *** CONTINUED ON ATTACHED SHEET (PAGE 3 OF {{ $totalPagesTotal }}) ***
            </div>
            @endif
        @else
            <div style="font-size: 10px; color: #777;">NO CONTAINERS LOADED</div>
        @endif
    </div>
    
    <div style="position: absolute; z-index: 2; top: 76.8%; left: 2.5%; width: 25.0%; overflow: hidden;">TOTAL CONTAINERS: {{ count($containersList) }}</div>
    <div style="position: absolute; z-index: 2; top: 73.5%; left: 2.5%; width: 25.0%; overflow: hidden;">3 (THREE)</div>
    <div style="position: absolute; z-index: 2; top: 76.8%; left: 28.5%; width: 22.0%; overflow: hidden;">LOS ANGELES, CA</div>
    <div style="position: absolute; z-index: 2; top: 73.5%; left: 28.5%; width: 22.0%; overflow: hidden;">{{ $hbl->date_of_issue ? \Carbon\Carbon::parse($hbl->date_of_issue)->format('m/d/Y') : date('m/d/Y') }}</div>
    <div style="position: absolute; z-index: 2; top: 94.2%; left: 68.0%; width: 30.0%; overflow: hidden;">OCEAN BLUE EXPRESS INC.</div>
</div>

<!-- PAGE 2: TERMS & CONDITIONS -->
<div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; box-sizing: border-box; overflow: hidden; page-break-before: always; break-before: page; page-break-after: always; break-after: page; margin-top: 20px;">
    <img src="/assets/images/hbl/ocean_blue-2.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;" />
</div>

@if($totalContainerPages > 1)
    @foreach(array_slice($containerChunks, 1) as $cIdx => $chunkContainers)
    <div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-before: always; break-before: page; page-break-after: always; break-after: page; margin-top: 20px;">
        <div style="position: absolute; z-index: 2; top: 4.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 2px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-size: 14px; font-weight: bold; color: #1e3a8a;">OCEAN BLUE EXPRESS - CONTINUATION SHEET</span><br>
                <span style="font-size: 11px;">B/L NO: <strong>{{ $hbl->hbl_no }}</strong> | FILE NO: <strong>{{ $hbl->oceanExport->file_no ?? '' }}</strong></span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px; font-weight: bold; color: #b91c1c;">PAGE {{ $cIdx + 3 }} OF {{ $totalPagesTotal }}</span><br>
                <span style="font-size: 10px;">SHIPPER: {{ $hbl->shipper->name ?? 'N/A' }}</span>
            </div>
        </div>
        <div style="position: absolute; z-index: 2; top: 12.0%; left: 1.5%; width: 97.0%; height: 75.0%; background: #ffffff; border: 1px solid #ccc; padding: 15px; box-sizing: border-box; overflow: hidden;">
            <div style="display: flex; font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 10px; font-size: 11px;">
                <div style="width: 20%;">CONTAINER / SEAL NO</div>
                <div style="width: 50%;">MARKS & DESCRIPTION OF GOODS</div>
                <div style="width: 15%; text-align: right;">GROSS WEIGHT</div>
                <div style="width: 15%; text-align: right;">MEASUREMENT</div>
            </div>
            @foreach($chunkContainers as $container)
            <div style="display: flex; line-height: 1.4; margin-bottom: 8px; font-size: 11px; border-bottom: 1px dashed #eee; padding-bottom: 4px;">
                <div style="width: 20%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <strong>{{ $container->container_no }}</strong><br><span style="font-size: 10px; color: #555;">SEAL: {{ $container->seal_no ?: 'NONE' }}</span>
                </div>
                <div style="width: 50%; padding-left: 10px; overflow: hidden; white-space: pre-wrap;">{{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
        </div>
        <div style="position: absolute; z-index: 2; top: 88.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 1px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; font-size: 10.5px;">
            <div>TOTAL CONTAINERS ON THIS SHEET: <strong>{{ count($chunkContainers) }}</strong></div>
            <div>AUTHORIZED SIGNATURE: <strong>OCEAN BLUE EXPRESS INC.</strong></div>
        </div>
    </div>
    @endforeach
@endif
HTML;
    }

    /**
     * SILK template content.
     */
    private function getSilkTemplate(): string
    {
        return <<<'HTML'
@php
    $containersList = (isset($hbl->containers) && count($hbl->containers) > 0) ? $hbl->containers : ((isset($hbl->oceanExport) && isset($hbl->oceanExport->containers) && count($hbl->oceanExport->containers) > 0) ? $hbl->oceanExport->containers : collect());
    $firstPageLimit = 4;
    $subsequentLimit = 12;
    $containerChunks = [];
    if ($containersList->count() <= $firstPageLimit) {
        $containerChunks[] = $containersList;
    } else {
        $containerChunks[] = $containersList->slice(0, $firstPageLimit);
        $remaining = $containersList->slice($firstPageLimit);
        foreach ($remaining->chunk($subsequentLimit) as $chunk) {
            $containerChunks[] = $chunk;
        }
    }
    $totalContainerPages = count($containerChunks);
    $firstChunk = $containerChunks[0] ?? collect();
    $totalPagesTotal = $totalContainerPages;
@endphp

<!-- PAGE 1: SILK CONTAINER LINES AUTHENTIC FORM -->
<div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-after: always; break-after: page;">
    <img src="/assets/images/hbl/silk-1.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;" />
    
    <!-- SHIPPER BOX (TOP LEFT) -->
    <div style="position: absolute; z-index: 2; top: 4.0%; left: 2.5%; width: 43.5%; height: 8.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->shipper->name ?? '' }}</strong>
{{ $hbl->shipper->address ?? '' }}</div>
    
    <!-- CONSIGNEE BOX (MIDDLE LEFT) -->
    <div style="position: absolute; z-index: 2; top: 13.0%; left: 2.5%; width: 43.5%; height: 16.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->consignee->name ?? '' }}</strong>
{{ $hbl->consignee->address ?? '' }}</div>
    
    <!-- NOTIFY PARTY BOX (LOWER MIDDLE LEFT) -->
    <div style="position: absolute; z-index: 2; top: 30.5%; left: 2.5%; width: 43.5%; height: 6.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->notifyParty->name ?? '' }}</strong>
{{ $hbl->notifyParty->address ?? '' }}</div>

    <!-- DATE OF ISSUE & B/L NUMBER (MIDDLE RIGHT BOX BELOW SILK LOGO) -->
    <div style="position: absolute; z-index: 2; top: 30.5%; left: 47.5%; width: 24.0%; overflow: hidden;">{{ $hbl->date_of_issue ? \Carbon\Carbon::parse($hbl->date_of_issue)->format('m/d/Y') : date('m/d/Y') }}</div>
    <div style="position: absolute; z-index: 2; top: 30.5%; left: 72.5%; width: 25.0%; font-size: 12px; color: #b91c1c; overflow: hidden;">{{ $hbl->hbl_no }}</div>
    
    <!-- FOR DELIVERY APPLY TO (BELOW B/L NUMBER) -->
    <div style="position: absolute; z-index: 2; top: 39.5%; left: 47.5%; width: 50.0%; height: 6.0%; overflow: hidden; font-size: 10px; color: #333;"></div>

    <!-- PRE-CARRIAGE / PLACE OF RECEIPT -->
    <div style="position: absolute; z-index: 2; top: 37.0%; left: 2.5%; width: 26.0%; overflow: hidden;">{{ $hbl->pre_carriage_by ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 37.0%; left: 29.5%; width: 16.5%; overflow: hidden;">{{ $hbl->placeOfReceipt->name ?? '' }}</div>
    
    <!-- OCEAN VESSEL / VOYAGE / PORT OF LOADING -->
    <div style="position: absolute; z-index: 2; top: 40.0%; left: 2.5%; width: 18.0%; overflow: hidden;">{{ $hbl->vessel_name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 40.0%; left: 21.0%; width: 7.5%; overflow: hidden;">{{ $hbl->voyage_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 40.0%; left: 29.5%; width: 16.5%; overflow: hidden;">{{ $hbl->oceanExport->portOfLoading->name ?? '' }}</div>
    
    <!-- PORT OF DISCHARGE / PLACE OF DELIVERY -->
    <div style="position: absolute; z-index: 2; top: 43.5%; left: 2.5%; width: 26.0%; overflow: hidden;">{{ $hbl->placeOfDischarge->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 43.5%; left: 29.5%; width: 16.5%; overflow: hidden;">{{ $hbl->placeOfDelivery->name ?? '' }}</div>
    
    <!-- PARTICULARS TABLE FOR SILK -->
    <div style="position: absolute; z-index: 2; top: 48.5%; left: 0; width: 100%; height: 29.5%; padding: 0 1.5%; box-sizing: border-box; overflow: hidden;">
        @if(count($firstChunk) > 0)
            @foreach($firstChunk as $container)
            <div style="display: flex; line-height: 1.3; margin-bottom: 4px; font-size: 10.5px;">
                <div style="width: 25%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $container->container_no }}<br>SL: {{ $container->seal_no ?: 'NONE' }}
                </div>
                <div style="width: 15%;">1 CONTAINER</div>
                <div style="width: 38%; padding-left: 10px; overflow: hidden; white-space: pre-wrap; height: 32px;">
                    {{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}
                </div>
                <div style="width: 12.0%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 10.0%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
            @if($totalContainerPages > 1)
            <div style="text-align: center; font-weight: bold; margin-top: 4px; color: #1e3a8a; font-size: 10px;">
                *** CONTINUED ON ATTACHED SHEET (PAGE 2 OF {{ $totalPagesTotal }}) ***
            </div>
            @endif
        @else
            <div style="font-size: 10px; color: #777;">NO CONTAINERS LOADED</div>
        @endif
    </div>
    
    <!-- FOOTER SUMMARY -->
    <div style="position: absolute; z-index: 2; top: 90.0%; left: 2.5%; width: 25.0%; overflow: hidden;">TOTAL CONTAINERS: {{ count($containersList) }}</div>
    <div style="position: absolute; z-index: 2; top: 90.0%; left: 28.5%; width: 22.0%; overflow: hidden;">LOS ANGELES, CA</div>
</div>


@if($totalContainerPages > 1)
    @foreach(array_slice($containerChunks, 1) as $cIdx => $chunkContainers)
    <div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-before: always; break-before: page; page-break-after: always; break-after: page; margin-top: 20px;">
        <div style="position: absolute; z-index: 2; top: 4.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 2px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-size: 14px; font-weight: bold; color: #1e3a8a;">SILK CONTAINER LINES - CONTINUATION SHEET</span><br>
                <span style="font-size: 11px;">B/L NO: <strong>{{ $hbl->hbl_no }}</strong> | FILE NO: <strong>{{ $hbl->oceanExport->file_no ?? '' }}</strong></span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px; font-weight: bold; color: #b91c1c;">PAGE {{ $cIdx + 2 }} OF {{ $totalPagesTotal }}</span><br>
                <span style="font-size: 10px;">SHIPPER: {{ $hbl->shipper->name ?? 'N/A' }}</span>
            </div>
        </div>
        <div style="position: absolute; z-index: 2; top: 12.0%; left: 1.5%; width: 97.0%; height: 75.0%; background: #ffffff; border: 1px solid #ccc; padding: 15px; box-sizing: border-box; overflow: hidden;">
            <div style="display: flex; font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 10px; font-size: 11px;">
                <div style="width: 25%;">CONTAINER / SEAL NO</div>
                <div style="width: 15%;">PACKAGES</div>
                <div style="width: 38%;">MARKS & DESCRIPTION OF GOODS</div>
                <div style="width: 12%; text-align: right;">GROSS WEIGHT</div>
                <div style="width: 10%; text-align: right;">MEASUREMENT</div>
            </div>
            @foreach($chunkContainers as $container)
            <div style="display: flex; line-height: 1.4; margin-bottom: 8px; font-size: 11px; border-bottom: 1px dashed #eee; padding-bottom: 4px;">
                <div style="width: 25%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <strong>{{ $container->container_no }}</strong><br><span style="font-size: 10px; color: #555;">SEAL: {{ $container->seal_no ?: 'NONE' }}</span>
                </div>
                <div style="width: 15%;">1 CONTAINER</div>
                <div style="width: 38%; padding-left: 10px; overflow: hidden; white-space: pre-wrap;">{{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}</div>
                <div style="width: 12%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 10%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
        </div>
        <div style="position: absolute; z-index: 2; top: 88.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 1px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; font-size: 10.5px;">
            <div>TOTAL CONTAINERS ON THIS SHEET: <strong>{{ count($chunkContainers) }}</strong></div>
            <div>AUTHORIZED SIGNATURE: <strong>SILK CONTAINER LINES</strong></div>
        </div>
    </div>
    @endforeach
@endif
HTML;
    }

    /**
     * TRANSAMERICA template content.
     */
    private function getTransamericaTemplate(): string
    {
        return <<<'HTML'
@php
    $containersList = (isset($hbl->containers) && count($hbl->containers) > 0) ? $hbl->containers : ((isset($hbl->oceanExport) && isset($hbl->oceanExport->containers) && count($hbl->oceanExport->containers) > 0) ? $hbl->oceanExport->containers : collect());
    $firstPageLimit = 4;
    $subsequentLimit = 12;
    $containerChunks = [];
    if ($containersList->count() <= $firstPageLimit) {
        $containerChunks[] = $containersList;
    } else {
        $containerChunks[] = $containersList->slice(0, $firstPageLimit);
        $remaining = $containersList->slice($firstPageLimit);
        foreach ($remaining->chunk($subsequentLimit) as $chunk) {
            $containerChunks[] = $chunk;
        }
    }
    $totalContainerPages = count($containerChunks);
    $firstChunk = $containerChunks[0] ?? collect();
    $totalPagesTotal = $totalContainerPages;
@endphp

<!-- PAGE 1: TRANSAMERICA LOGISTIC AUTHENTIC FORM -->
<div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-after: always; break-after: page;">
    <img src="/assets/images/hbl/transamerica-1.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;" />
    
    <div style="position: absolute; z-index: 2; top: 9.8%; left: 62.0%; width: 35.0%; font-size: 13px; color: #b91c1c; overflow: hidden;">{{ $hbl->hbl_no }}</div>
    <div style="position: absolute; z-index: 2; top: 13.4%; left: 51.5%; width: 45.0%; overflow: hidden;">{{ $hbl->oceanExport->file_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 10.0%; left: 2.5%; width: 47.0%; height: 7.5%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->shipper->name ?? '' }}</strong>
{{ $hbl->shipper->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 19.5%; left: 2.5%; width: 47.0%; height: 7.5%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->consignee->name ?? '' }}</strong>
{{ $hbl->consignee->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 28.8%; left: 2.5%; width: 47.0%; height: 4.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->notifyParty->name ?? '' }}</strong>
{{ $hbl->notifyParty->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 15.0%; left: 51.5%; width: 45.0%; height: 8.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->oceanExport->overseaAgent->name ?? '' }}</strong>
{{ $hbl->oceanExport->overseaAgent->address ?? '' }}</div>

    <div style="position: absolute; z-index: 2; top: 31.5%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->pre_carriage_by ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 31.5%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfReceipt->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 34.0%; left: 2.5%; width: 17.0%; overflow: hidden;">{{ $hbl->vessel_name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 34.0%; left: 20.0%; width: 11.0%; overflow: hidden;">{{ $hbl->voyage_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 34.0%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->oceanExport->portOfLoading->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 36.8%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->placeOfDischarge->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 36.8%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfDelivery->name ?? '' }}</div>
    
    <div style="position: absolute; z-index: 2; top: 40.0%; left: 0; width: 100%; height: 26.8%; padding: 0 1.5%; box-sizing: border-box; overflow: hidden;">
        @if(count($firstChunk) > 0)
            @foreach($firstChunk as $container)
            <div style="display: flex; line-height: 1.3; margin-bottom: 4px; font-size: 10.5px;">
                <div style="width: 18%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $container->container_no }}<br>SL: {{ $container->seal_no ?: 'NONE' }}
                </div>
                <div style="width: 53%; padding-left: 10px; overflow: hidden; white-space: pre-wrap; height: 32px;">
                    {{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}
                </div>
                <div style="width: 13.5%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 10.0%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
            @if($totalContainerPages > 1)
            <div style="text-align: center; font-weight: bold; margin-top: 8px; color: #1e3a8a; font-size: 11px;">
                *** CONTINUED ON ATTACHED SHEET (PAGE 2 OF {{ $totalPagesTotal }}) ***
            </div>
            @endif
        @else
            <div style="font-size: 10px; color: #777;">NO CONTAINERS LOADED</div>
        @endif
    </div>
    
    <div style="position: absolute; z-index: 2; top: 68.5%; left: 2.5%; width: 25.0%; overflow: hidden;">TOTAL CONTAINERS: {{ count($containersList) }}</div>
    <div style="position: absolute; z-index: 2; top: 68.5%; left: 28.5%; width: 22.0%; overflow: hidden;">LOS ANGELES, CA</div>
    <div style="position: absolute; z-index: 2; top: 95.2%; left: 68.0%; width: 30.0%; overflow: hidden;">TRANSAMERICA LOGISTIC</div>
</div>

@if($totalContainerPages > 1)
    @foreach(array_slice($containerChunks, 1) as $cIdx => $chunkContainers)
    <div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-before: always; break-before: page; page-break-after: always; break-after: page; margin-top: 20px;">
        <div style="position: absolute; z-index: 2; top: 4.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 2px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-size: 14px; font-weight: bold; color: #1e3a8a;">TRANSAMERICA LOGISTIC - CONTINUATION SHEET</span><br>
                <span style="font-size: 11px;">B/L NO: <strong>{{ $hbl->hbl_no }}</strong> | FILE NO: <strong>{{ $hbl->oceanExport->file_no ?? '' }}</strong></span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px; font-weight: bold; color: #b91c1c;">PAGE {{ $cIdx + 2 }} OF {{ $totalPagesTotal }}</span><br>
                <span style="font-size: 10px;">SHIPPER: {{ $hbl->shipper->name ?? 'N/A' }}</span>
            </div>
        </div>
        <div style="position: absolute; z-index: 2; top: 12.0%; left: 1.5%; width: 97.0%; height: 75.0%; background: #ffffff; border: 1px solid #ccc; padding: 15px; box-sizing: border-box; overflow: hidden;">
            <div style="display: flex; font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 10px; font-size: 11px;">
                <div style="width: 20%;">CONTAINER / SEAL NO</div>
                <div style="width: 50%;">MARKS & DESCRIPTION OF GOODS</div>
                <div style="width: 15%; text-align: right;">GROSS WEIGHT</div>
                <div style="width: 15%; text-align: right;">MEASUREMENT</div>
            </div>
            @foreach($chunkContainers as $container)
            <div style="display: flex; line-height: 1.4; margin-bottom: 8px; font-size: 11px; border-bottom: 1px dashed #eee; padding-bottom: 4px;">
                <div style="width: 20%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <strong>{{ $container->container_no }}</strong><br><span style="font-size: 10px; color: #555;">SEAL: {{ $container->seal_no ?: 'NONE' }}</span>
                </div>
                <div style="width: 50%; padding-left: 10px; overflow: hidden; white-space: pre-wrap;">{{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
        </div>
        <div style="position: absolute; z-index: 2; top: 88.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 1px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; font-size: 10.5px;">
            <div>TOTAL CONTAINERS ON THIS SHEET: <strong>{{ count($chunkContainers) }}</strong></div>
            <div>AUTHORIZED SIGNATURE: <strong>TRANSAMERICA LOGISTIC</strong></div>
        </div>
    </div>
    @endforeach
@endif
HTML;
    }

    /**
     * UNITED AMERICAN template content.
     */
    private function getUnitedAmericanTemplate(): string
    {
        return <<<'HTML'
@php
    $containersList = (isset($hbl->containers) && count($hbl->containers) > 0) ? $hbl->containers : ((isset($hbl->oceanExport) && isset($hbl->oceanExport->containers) && count($hbl->oceanExport->containers) > 0) ? $hbl->oceanExport->containers : collect());
    $firstPageLimit = 4;
    $subsequentLimit = 12;
    $containerChunks = [];
    if ($containersList->count() <= $firstPageLimit) {
        $containerChunks[] = $containersList;
    } else {
        $containerChunks[] = $containersList->slice(0, $firstPageLimit);
        $remaining = $containersList->slice($firstPageLimit);
        foreach ($remaining->chunk($subsequentLimit) as $chunk) {
            $containerChunks[] = $chunk;
        }
    }
    $totalContainerPages = count($containerChunks);
    $firstChunk = $containerChunks[0] ?? collect();
    $totalPagesTotal = $totalContainerPages;
@endphp

<!-- PAGE 1: UNITED AMERICAN LINE AUTHENTIC FORM -->
<div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-after: always; break-after: page;">
    <img src="/assets/images/hbl/united_american-1.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;" />
    
    <div style="position: absolute; z-index: 2; top: 11.4%; left: 62.0%; width: 35.0%; font-size: 13px; color: #b91c1c; overflow: hidden;">{{ $hbl->hbl_no }}</div>
    <div style="position: absolute; z-index: 2; top: 13.4%; left: 51.5%; width: 45.0%; overflow: hidden;">{{ $hbl->oceanExport->file_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 11.6%; left: 2.5%; width: 47.0%; height: 7.5%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->shipper->name ?? '' }}</strong>
{{ $hbl->shipper->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 20.2%; left: 2.5%; width: 47.0%; height: 7.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->consignee->name ?? '' }}</strong>
{{ $hbl->consignee->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 27.8%; left: 2.5%; width: 47.0%; height: 6.5%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->notifyParty->name ?? '' }}</strong>
{{ $hbl->notifyParty->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 20.2%; left: 51.5%; width: 45.0%; height: 7.0%; overflow: hidden; white-space: pre-wrap; line-height: 1.25;"><strong>{{ $hbl->oceanExport->overseaAgent->name ?? '' }}</strong>
{{ $hbl->oceanExport->overseaAgent->address ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 27.8%; left: 51.5%; width: 45.0%; height: 6.5%; overflow: hidden; font-size: 10px; color: #333;">FOR DELIVERY PLEASE APPLY TO OVERSEA AGENT ABOVE.</div>

    <div style="position: absolute; z-index: 2; top: 34.8%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->pre_carriage_by ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 34.8%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfReceipt->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 37.8%; left: 2.5%; width: 17.0%; overflow: hidden;">{{ $hbl->vessel_name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 37.8%; left: 20.0%; width: 11.0%; overflow: hidden;">{{ $hbl->voyage_no ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 37.8%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->oceanExport->portOfLoading->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 40.8%; left: 2.5%; width: 28.0%; overflow: hidden;">{{ $hbl->placeOfDischarge->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 40.8%; left: 32.0%; width: 18.0%; overflow: hidden;">{{ $hbl->placeOfDelivery->name ?? '' }}</div>
    <div style="position: absolute; z-index: 2; top: 43.5%; left: 51.5%; width: 45.0%; overflow: hidden;">CY/CY</div>
    
    <div style="position: absolute; z-index: 2; top: 45.5%; left: 0; width: 100%; height: 23.8%; padding: 0 1.5%; box-sizing: border-box; overflow: hidden;">
        @if(count($firstChunk) > 0)
            @foreach($firstChunk as $container)
            <div style="display: flex; line-height: 1.3; margin-bottom: 4px; font-size: 10.5px;">
                <div style="width: 18%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $container->container_no }}<br>SL: {{ $container->seal_no ?: 'NONE' }}
                </div>
                <div style="width: 53%; padding-left: 10px; overflow: hidden; white-space: pre-wrap; height: 32px;">
                    {{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}
                </div>
                <div style="width: 13.5%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 10.0%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
            @if($totalContainerPages > 1)
            <div style="text-align: center; font-weight: bold; margin-top: 8px; color: #1e3a8a; font-size: 11px;">
                *** CONTINUED ON ATTACHED SHEET (PAGE 2 OF {{ $totalPagesTotal }}) ***
            </div>
            @endif
        @else
            <div style="font-size: 10px; color: #777;">NO CONTAINERS LOADED</div>
        @endif
    </div>
    
    <div style="position: absolute; z-index: 2; top: 70.5%; left: 2.5%; width: 25.0%; overflow: hidden;">TOTAL CONTAINERS: {{ count($containersList) }}</div>
    <div style="position: absolute; z-index: 2; top: 73.5%; left: 2.5%; width: 25.0%; overflow: hidden;">3 (THREE)</div>
    <div style="position: absolute; z-index: 2; top: 70.5%; left: 28.5%; width: 22.0%; overflow: hidden;">LOS ANGELES, CA</div>
    <div style="position: absolute; z-index: 2; top: 73.5%; left: 28.5%; width: 22.0%; overflow: hidden;">{{ $hbl->date_of_issue ? \Carbon\Carbon::parse($hbl->date_of_issue)->format('m/d/Y') : date('m/d/Y') }}</div>
    <div style="position: absolute; z-index: 2; top: 93.5%; left: 68.0%; width: 30.0%; overflow: hidden;">UNITED AMERICAN LINE</div>
</div>

@if($totalContainerPages > 1)
    @foreach(array_slice($containerChunks, 1) as $cIdx => $chunkContainers)
    <div class="hbl-page-container" style="position: relative; width: 820px; height: 1160px; font-family: 'Courier New', Courier, monospace; font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; box-sizing: border-box; overflow: hidden; page-break-before: always; break-before: page; page-break-after: always; break-after: page; margin-top: 20px;">
        <div style="position: absolute; z-index: 2; top: 4.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 2px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-size: 14px; font-weight: bold; color: #1e3a8a;">UNITED AMERICAN LINE - CONTINUATION SHEET</span><br>
                <span style="font-size: 11px;">B/L NO: <strong>{{ $hbl->hbl_no }}</strong> | FILE NO: <strong>{{ $hbl->oceanExport->file_no ?? '' }}</strong></span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px; font-weight: bold; color: #b91c1c;">PAGE {{ $cIdx + 2 }} OF {{ $totalPagesTotal }}</span><br>
                <span style="font-size: 10px;">SHIPPER: {{ $hbl->shipper->name ?? 'N/A' }}</span>
            </div>
        </div>
        <div style="position: absolute; z-index: 2; top: 12.0%; left: 1.5%; width: 97.0%; height: 75.0%; background: #ffffff; border: 1px solid #ccc; padding: 15px; box-sizing: border-box; overflow: hidden;">
            <div style="display: flex; font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 10px; font-size: 11px;">
                <div style="width: 20%;">CONTAINER / SEAL NO</div>
                <div style="width: 50%;">MARKS & DESCRIPTION OF GOODS</div>
                <div style="width: 15%; text-align: right;">GROSS WEIGHT</div>
                <div style="width: 15%; text-align: right;">MEASUREMENT</div>
            </div>
            @foreach($chunkContainers as $container)
            <div style="display: flex; line-height: 1.4; margin-bottom: 8px; font-size: 11px; border-bottom: 1px dashed #eee; padding-bottom: 4px;">
                <div style="width: 20%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <strong>{{ $container->container_no }}</strong><br><span style="font-size: 10px; color: #555;">SEAL: {{ $container->seal_no ?: 'NONE' }}</span>
                </div>
                <div style="width: 50%; padding-left: 10px; overflow: hidden; white-space: pre-wrap;">{{ $container->remarks ?: 'SAID TO CONTAIN: GENERAL CARGO' }}</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->weight_kg ?? 0, 2) }} KGS</div>
                <div style="width: 15%; text-align: right;">{{ number_format($container->measure_cbm ?? 0, 2) }} CBM</div>
            </div>
            @endforeach
        </div>
        <div style="position: absolute; z-index: 2; top: 88.0%; left: 1.5%; width: 97.0%; background: #ffffff; padding: 10px; border: 1px solid #000; box-sizing: border-box; display: flex; justify-content: space-between; font-size: 10.5px;">
            <div>TOTAL CONTAINERS ON THIS SHEET: <strong>{{ count($chunkContainers) }}</strong></div>
            <div>AUTHORIZED SIGNATURE: <strong>UNITED AMERICAN LINE</strong></div>
        </div>
    </div>
    @endforeach
@endif
HTML;
    }
}
