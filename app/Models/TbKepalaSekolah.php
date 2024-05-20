<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbKepalaSekolah
 * 
 * @property int $id_kepala
 * @property int $id_pengguna
 * @property string $nama
 * @property string $gender
 * @property string $alamat
 * @property string $no_telp
 * @property string $foto
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbPengguna $tb_pengguna
 *
 * @package App\Models
 */
class TbKepalaSekolah extends Model
{
	protected $table = 'tb_kepala_sekolah';
	protected $primaryKey = 'id_kepala';

	protected $casts = [
		'id_pengguna' => 'int'
	];

	protected $fillable = [
		'id_pengguna',
		'nama',
		'gender',
		'alamat',
		'no_telp',
		'foto'
	];

	public function tb_pengguna()
	{
		return $this->belongsTo(TbPengguna::class, 'id_pengguna');
	}
}
