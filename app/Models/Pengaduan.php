<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';

    protected $casts = [
        'id_sekolah' => 'int',
        'id_user' => 'int',
        'trauma_mental' => 'bool',
        'luka_fisik' => 'bool',
        'pelaku_lebih_dari_satu' => 'bool',
        'konten_digital' => 'bool'
    ];

    protected $fillable = [
        'id_sekolah',
        'kode_kasus',
        'id_user',
        'nama_pelaku',
        'nama_pelapor',
        'bentuk_perundungan',
        'frekuensi_kejadian',
        'lokasi',
        'trauma_mental',
        'luka_fisik',
        'pelaku_lebih_dari_satu',
        'konten_digital',
        'jenis_kata',
        'klasifikasi',
        'deskripsi',
        'status',
        'tahap_penanganan',
        'tanggal_selesai',
        'kesimpulan_kasus',
        'sumber',
        'foto'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_pengguna');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_user', 'id_pengguna');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'id_pengaduan');
    }

    public function riwayatTindakan()
    {
        return $this->hasMany(RiwayatPenangananKasus::class, 'id_pengaduan')->orderBy('created_at', 'asc');
    }

    /**
     * Hitung persentase progres alur penanganan kasus (0 - 100%)
     */
    public function getProgressPercentAttribute(): int
    {
        return match($this->status) {
            'investigasi' => 40,
            'konseling' => 60,
            'mediasi' => 80,
            'selesai', 'ditutup' => 100,
            default => 20, // 'diproses' / 'menunggu'
        };
    }

    /**
     * Dapatkan label tahap penanganan ramah pengguna
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'investigasi' => 'Investigasi Bukti & Saksi',
            'konseling' => 'Sesi Konseling Siswa',
            'mediasi' => 'Mediasi Pihak Terkait',
            'selesai' => 'Penanganan Kasus Selesai',
            'ditutup' => 'Kasus Selesai & Ditutup',
            'history' => 'Arsip Data Historis',
            default => 'Laporan Diterima / Diproses',
        };
    }

    /**
     * Scope untuk pengaduan aktif yang dilaporkan siswa
     */
    public function scopeKasusAktif($query)
    {
        return $query->where('sumber', 'pengaduan');
    }

    /**
     * Scope untuk dataset history latihan
     */
    public function scopeHistory($query)
    {
        return $query->where('sumber', 'history');
    }

    /**
     * Scope multi-tenancy berdasarkan hak akses sekolah dan peran pengguna
     */
    public function scopeForUser($query, $user = null)
    {
        $user = $user ?: \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return $query;
        }

        if ($user->isSiswa()) {
            return $query->where('id_user', $user->id_pengguna);
        }

        if ($user->isGuruBk() && $user->sekolah_id) {
            return $query->where('id_sekolah', $user->sekolah_id);
        }

        return $query;
    }

    /**
     * Scope untuk pengaduan darurat yang membutuhkan tanggap darurat 1x24 jam
     */
    public function scopeDarurat($query)
    {
        return $query->where('sumber', 'pengaduan')
                     ->where(function($q) {
                         $q->where('klasifikasi', 'berat')
                           ->orWhere('luka_fisik', 1)
                           ->orWhere('trauma_mental', 1);
                     })
                     ->whereNotIn('status', ['selesai', 'ditutup']);
    }

    /**
     * Cek apakah kasus ini tergolong darurat / prioritas tinggi
     */
    public function getIsDaruratAttribute(): bool
    {
        return $this->sumber === 'pengaduan'
            && ($this->klasifikasi === 'berat' || (bool)$this->luka_fisik || (bool)$this->trauma_mental)
            && !in_array($this->status, ['selesai', 'ditutup']);
    }

    public function getFotoSmAttribute()
    {
        return $this->foto ? asset('storage/pengaduan/foto/sm/' . $this->foto) : null;
    }

    public function getFotoMdAttribute()
    {
        return $this->foto ? asset('storage/pengaduan/foto/md/' . $this->foto) : null;
    }

    public function getFotoLgAttribute()
    {
        return $this->foto ? asset('storage/pengaduan/foto/lg/' . $this->foto) : null;
    }
}
