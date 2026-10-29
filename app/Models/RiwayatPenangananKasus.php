<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenangananKasus extends Model
{
    protected $table = 'riwayat_penanganan_kasus';

    protected $fillable = [
        'id_pengaduan',
        'id_user',
        'nama_petugas',
        'peran_petugas',
        'status_tahap',
        'judul_tindakan',
        'catatan',
        'rekomendasi',
        'lampiran',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_pengguna');
    }

    public function getLampiranUrlAttribute()
    {
        return $this->lampiran ? asset('storage/tindakan/' . $this->lampiran) : null;
    }
}
