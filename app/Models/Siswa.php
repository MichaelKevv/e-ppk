<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
	protected $table = 'siswa';
	protected $primaryKey = 'id_siswa';

	protected $casts = [
		'id_sekolah' => 'int',
		'id_pengguna' => 'int'
	];

	protected $fillable = [
		'id_sekolah',
		'id_pengguna',
		'nama',
		'kelas',
		'gender',
		'alamat',
		'no_telp',
		'foto'
	];

	public function sekolah()
	{
		return $this->belongsTo(Sekolah::class, 'id_sekolah');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_pengguna');
	}

	public function pengaduans()
	{
		return $this->hasMany(Pengaduan::class, 'id_user', 'id_pengguna');
	}
}
