<?php

namespace App\Http\Controllers;

use App\Models\ShipmentMemoConfig;
use Illuminate\Http\Request;

class ShipmentMemoConfigController extends Controller
{
    public static $defaultFields = [
        'ocean-export' => [
            'master_bl' => ['Oversea Agent', 'Carrier', 'Consignee', 'Notify', 'Customer', 'Bill To'],
            'house_bl' => ['Actual Shipper', 'Consignee', 'Customer', 'Notify', 'Also Notify', 'Bill To', 'Customs Broker', 'Trucker']
        ],
        'ocean-import' => [
            'master_bl' => ['Oversea Agent', 'Carrier', 'Consignee', 'Shipper', 'Notify', 'Customer', 'Bill To'],
            'house_bl' => ['Consignee', 'Shipper', 'Customer', 'Notify', 'Bill To', 'Customs Broker', 'Trucker']
        ],
        'air-export' => [
            'master_bl' => ['Oversea Agent', 'Carrier', 'Consignee', 'Notify', 'Customer', 'Bill To'],
            'house_bl' => ['Actual Shipper', 'Oversea Agent', 'Consignee', 'Customer', 'Notify', 'Bill To', 'Issuing Carrier/Agent', 'Trucker']
        ],
        'air-import' => [
            'master_bl' => ['Oversea Agent', 'Carrier', 'Shipper', 'Consignee', 'Notify', 'Customer', 'Bill To'],
            'house_bl' => ['Consignee', 'Actual Shipper', 'Customer', 'Notify', 'Bill To', 'Customs Broker', 'Trucker']
        ],
        'trucker' => [
            'master_bl' => ['Shipper', 'Consignee', 'Customer', 'Bill To', 'Trucker'],
            'house_bl' => []
        ],
        'misc' => [
            'master_bl' => ['Oversea Agent', 'Shipper', 'Consignee', 'Customer', 'Bill To', 'Trucker'],
            'house_bl' => []
        ]
    ];

    public function index()
    {
        $this->ensureSeededDefaults();
        $configs = ShipmentMemoConfig::orderBy('module')->orderBy('section')->orderBy('order')->get();
        
        return view('settings.shipment-memo-auto-load', compact('configs'));
    }

    public function getByModule(Request $request)
    {
        $module = $request->input('module', 'ocean-export');
        
        // Ensure defaults exist for this module if none exist
        if (ShipmentMemoConfig::where('module', $module)->count() === 0) {
            $this->seedModuleDefaults($module);
        }

        $configs = ShipmentMemoConfig::where('module', $module)
            ->orderBy('section')
            ->orderBy('order')
            ->get()
            ->groupBy('section');
        
        return response()->json([
            'success' => true,
            'module' => $module,
            'data' => $configs
        ]);
    }

    public function checkAutoLoad(Request $request)
    {
        $module = $request->input('module');
        $section = $request->input('section');
        $field = $request->input('field_name');

        $config = ShipmentMemoConfig::where('module', $module)
            ->where('section', $section)
            ->where('field_name', $field)
            ->first();

        return response()->json([
            'success' => true,
            'is_enabled' => $config ? (bool)$config->is_enabled : false,
            'config' => $config
        ]);
    }

    public function bulkSave(Request $request)
    {
        try {
            $items = $request->input('items', []);
            $saved = [];

            foreach ($items as $item) {
                $config = ShipmentMemoConfig::updateOrCreate(
                    [
                        'module' => $item['module'],
                        'section' => $item['section'],
                        'field_name' => $item['field_name'],
                    ],
                    [
                        'is_enabled' => filter_var($item['is_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        'order' => $item['order'] ?? 0,
                    ]
                );
                $saved[] = $config;
            }

            return response()->json([
                'success' => true,
                'message' => 'Configuration saved successfully to database',
                'data' => $saved
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save configuration: ' . $e->getMessage()
            ], 500);
        }
    }

    private function ensureSeededDefaults()
    {
        foreach (array_keys(self::$defaultFields) as $mod) {
            if (ShipmentMemoConfig::where('module', $mod)->count() === 0) {
                $this->seedModuleDefaults($mod);
            }
        }
    }

    private function seedModuleDefaults($module)
    {
        if (!isset(self::$defaultFields[$module])) return;

        $sections = self::$defaultFields[$module];
        $order = 0;

        foreach ($sections as $section => $fields) {
            foreach ($fields as $fieldName) {
                $fieldKey = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $fieldName));
                ShipmentMemoConfig::firstOrCreate(
                    [
                        'module' => $module,
                        'section' => $section,
                        'field_name' => $fieldKey,
                    ],
                    [
                        'is_enabled' => false,
                        'order' => $order++,
                    ]
                );
            }
        }
    }
}

