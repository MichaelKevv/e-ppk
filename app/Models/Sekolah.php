<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'jenjang',
        'status_sekolah',
        'akreditasi',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'no_telp',
        'email',
        'website',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'logo',
        'deskripsi',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_sekolah');
    }

    public function guruBk()
    {
        return $this->hasMany(Gurubk::class, 'id_sekolah');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_sekolah');
    }
}
