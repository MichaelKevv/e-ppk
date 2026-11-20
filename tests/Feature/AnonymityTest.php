<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Feedback;
use Tests\TestCase;

class AnonymityTest extends TestCase
{
    public function test_guru_bk_sees_masked_reporter_name_in_pengaduan_index()
    {
        $guru = User::where('role', 'gurubk')->first();
        if (!$guru) {
            $guru = User::factory()->create(['role' => 'gurubk']);
        }

        $response = $this->actingAs($guru)->get(route('admin.pengaduan.index'));

        $response->assertStatus(200);
        $response->assertSee('Pelapor:');
        $response->assertSee('***');
    }

    public function test_dinsos_sees_masked_reporter_name_in_pengaduan_index()
    {
        $dinsos = User::where('role', 'dinsos')->first();
        if (!$dinsos) {
            $dinsos = User::factory()->create(['role' => 'dinsos']);
        }

        $response = $this->actingAs($dinsos)->get(route('admin.pengaduan.index'));

        $response->assertStatus(200);
        $response->assertSee('Pelapor:');
        $response->assertSee('***');
    }

    public function test_guru_bk_sees_masked_reporter_in_pengaduan_detail()
    {
        $guru = User::where('role', 'gurubk')->first();
        if (!$guru) {
            $guru = User::factory()->create(['role' => 'gurubk']);
        }

        $pengaduan = Pengaduan::first();
        if ($pengaduan && $guru->sekolah_id) {
            $pengaduan->id_sekolah = $guru->sekolah_id;
            $pengaduan->save();
        }

        $this->assertNotNull($pengaduan, 'Pengaduan harus ada untuk pengujian detail.');

        $response = $this->actingAs($guru)->get(route('admin.pengaduan.show', $pengaduan->id_pengaduan));
        $response->assertStatus(200);
        $response->assertSee('***');
        $response->assertSee('Identitas Dirahasiakan / Anonim');
    }

    public function test_guru_bk_and_dinsos_see_masked_student_in_feedback_index()
    {
        $guru = User::where('role', 'gurubk')->first();
        if (!$guru) {
            $guru = User::factory()->create(['role' => 'gurubk']);
        }

        $response = $this->actingAs($guru)->get(route('admin.feedback.index'));

        $response->assertStatus(200);
        if (Feedback::count() > 0) {
            $response->assertSee('***');
            $response->assertSee('Identitas Dirahasiakan');
        }
    }

    public function test_pengaduan_and_feedback_exports_run_successfully()
    {
        $admin = User::whereIn('role', ['admin', 'admin_it'])->first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin']);
        }

        $responseAll = $this->actingAs($admin)->get(route('admin.pengaduan.export'));
        $responseAll->assertStatus(200);

        $pengaduan = Pengaduan::first();
        if ($pengaduan) {
            $responseSingle = $this->actingAs($admin)->get(route('admin.pengaduan.export_single', $pengaduan->id_pengaduan));
            $responseSingle->assertStatus(200);
        }

        $responseFeedback = $this->actingAs($admin)->get(route('admin.feedback.export'));
        $responseFeedback->assertStatus(200);
    }
}
