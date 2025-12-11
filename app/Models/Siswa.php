<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Siswa
 *
 * @property int $id_siswa
 * @property int $id_pengguna
 * @property string $nama
 * @property string $kelas
 * @property string $gender
 * @property string|null $alamat
 * @property string|null $no_telp
 * @property string|null $foto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Pengaduan[] $pengaduans
 *
 * @package App\Models
 */
class Siswa extends Model
{
	protected $table = 'siswa';
	protected $primaryKey = 'id_siswa';

	protected $casts = [
		'id_pengguna' => 'int'
	];

	protected $fillable = [
		'id_pengguna',
		'nama',
		'kelas',
		'gender',
		'alamat',
		'no_telp',
		'foto'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_pengguna');
	}

	public function pengaduans()
	{
		return $this->hasMany(Pengaduan::class, 'id_pengguna');
	}
}
