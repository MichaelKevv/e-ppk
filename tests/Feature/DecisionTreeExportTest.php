<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DecisionTreeExportTest extends TestCase
{
    public function test_export_excel_endpoint_works()
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.decision-tree.export-excel'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_export_csv_endpoint_works()
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.decision-tree.export-csv'));

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
    }

    public function test_decision_tree_page_renders_successfully()
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.decision-tree.index'));

        $response->assertStatus(200);
        $response->assertSee('Export Excel (.xlsx)');
        $response->assertSee('Ekspor Pohon (PNG)');
        $response->assertSee('html2canvas');
    }
}
