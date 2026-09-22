<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\HblTemplate;
use App\Models\OceanExportHbl;
use Tests\TestCase;

class HblTemplatesTest extends TestCase
{
    protected function getAuthenticatedUser()
    {
        return User::first() ?: User::factory()->create();
    }

    public function test_settings_page_is_accessible_to_authenticated_user(): void
    {
        $user = $this->getAuthenticatedUser();

        $response = $this->actingAs($user)
                         ->get('/settings/hbl-templates');

        $response->assertStatus(200);
        $response->assertSee('HBL TEMPLATES');
    }

    public function test_can_retrieve_hbl_templates_via_api(): void
    {
        $user = $this->getAuthenticatedUser();

        $response = $this->actingAs($user)
                         ->getJson('/api/hbl-templates');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'templates' => [
                '*' => ['id', 'name', 'title', 'content', 'css', 'is_active']
            ]
        ]);
    }

    public function test_can_bulk_save_and_update_templates(): void
    {
        $user = $this->getAuthenticatedUser();
        $name = 'TEST_TEMPLATE_' . uniqid();

        $payload = [
            'templates' => [
                [
                    'id' => null,
                    'name' => $name,
                    'title' => 'Test Template Title',
                    'content' => '<div>Test {{ $hbl->hbl_no }}</div>',
                    'css' => '.test { color: red; }',
                    'is_active' => true
                ]
            ]
        ];

        $response = $this->actingAs($user)
                         ->postJson('/api/hbl-templates/bulk-save', $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        
        $this->assertDatabaseHas('hbl_templates', [
            'name' => $name,
            'title' => 'Test Template Title'
        ]);
    }

    public function test_can_render_hbl_html_dynamically(): void
    {
        $user = $this->getAuthenticatedUser();
        
        // Find or create HBL and template
        $hbl = OceanExportHbl::first();
        $template = HblTemplate::first();

        if ($hbl && $template) {
            $response = $this->actingAs($user)
                             ->getJson("/api/ocean-export/{$hbl->ocean_export_id}/hbl/{$hbl->id}/render?template_id={$template->id}");

            $response->assertStatus(200);
            $response->assertJsonStructure(['html', 'css', 'template_id', 'template_name']);
        }
    }

    public function test_can_save_selected_template_on_hbl(): void
    {
        $user = $this->getAuthenticatedUser();
        
        $hbl = OceanExportHbl::first();
        $template = HblTemplate::first();

        if ($hbl && $template) {
            $response = $this->actingAs($user)
                             ->postJson("/api/ocean-export/hbl/{$hbl->id}/save-template", [
                                 'template_id' => $template->id
                             ]);

            $response->assertStatus(200);
            $response->assertJsonPath('success', true);
            
            $this->assertDatabaseHas('ocean_export_hbls', [
                'id' => $hbl->id,
                'hbl_template_id' => $template->id
            ]);
        }
    }
}
