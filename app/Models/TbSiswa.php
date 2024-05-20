<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSiswa
 * 
 * @property int $id_siswa
 * @property int $id_pengguna
 * @property string $nama
 * @property string $kelas
 * @property string $jurusan
 * @property string $gender
 * @property string $alamat
 * @property string $no_telp
 * @property string $foto
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbPengguna $tb_pengguna
 * @property Collection|TbPengaduan[] $tb_pengaduans
 *
 * @package App\Models
 */
class TbSiswa extends Model
{
	protected $table = 'tb_siswa';
	protected $primaryKey = 'id_siswa';

	protected $casts = [
		'id_pengguna' => 'int'
	];

	protected $fillable = [
		'id_pengguna',
		'nama',
		'kelas',
		'jurusan',
		'gender',
		'alamat',
		'no_telp',
		'foto'
	];

	public function tb_pengguna()
	{
		return $this->belongsTo(TbPengguna::class, 'id_pengguna');
	}

	public function tb_pengaduans()
	{
		return $this->hasMany(TbPengaduan::class, 'id_siswa');
	}
}
