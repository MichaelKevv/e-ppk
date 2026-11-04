<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sekolah;
use App\Models\GuruBK;
use App\Models\Siswa;
use App\Models\Dinso;
use App\Models\Pengaduan;
use Tests\TestCase;

class RoleMenuVisibilityTest extends TestCase
{
    public function test_guru_bk_sidebar_does_not_contain_dinsos_or_analisis_komputasi()
    {
        $user = User::where('role', 'gurubk')->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'gurubk']);
        }

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Analisis Komputasi');
        $response->assertDontSee('Decision Tree (ID3)');
        $response->assertDontSee('Dinas Sosial');
    }

    public function test_siswa_sidebar_does_not_contain_analisis_komputasi()
    {
        $user = User::where('role', 'siswa')->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'siswa']);
        }

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Analisis Komputasi');
        $response->assertDontSee('Decision Tree (ID3)');
    }

    public function test_admin_sidebar_contains_analisis_komputasi_and_dinsos()
    {
        $user = User::whereIn('role', ['admin', 'admin_it'])->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'admin']);
        }

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Analisis Komputasi');
        $response->assertSee('Decision Tree (ID3)');
        $response->assertSee('Dinas Sosial');
    }

    public function test_dinsos_sees_all_pengaduan_across_schools()
    {
        $user = User::where('role', 'dinsos')->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'dinsos']);
        }

        $response = $this->actingAs($user)->get(route('admin.pengaduan.index'));

        $response->assertStatus(200);
        // Dinsos has access to all complaints without school restriction
        $allCount = Pengaduan::count();
        $scopedCount = Pengaduan::forUser($user)->count();
        $this->assertEquals($allCount, $scopedCount);
    }
}

