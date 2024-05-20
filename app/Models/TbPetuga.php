<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPetuga
 * 
 * @property int $id_petugas
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
 * @property Collection|TbFeedback[] $tb_feedbacks
 *
 * @package App\Models
 */
class TbPetuga extends Model
{
	protected $table = 'tb_petugas';
	protected $primaryKey = 'id_petugas';

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

	public function tb_feedbacks()
	{
		return $this->hasMany(TbFeedback::class, 'id_petugas');
	}
}
