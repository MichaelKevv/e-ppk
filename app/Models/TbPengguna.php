<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class TbPengguna
 *
 * @property int $id_pengguna
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $role
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|TbKepalaSekolah[] $tb_kepala_sekolahs
 * @property Collection|TbPetuga[] $tb_petugas
 * @property Collection|TbSiswa[] $tb_siswas
 *
 * @package App\Models
 */
class TbPengguna extends Authenticatable
{
	protected $table = 'tb_pengguna';
	protected $primaryKey = 'id_pengguna';

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'email',
		'username',
		'password',
		'role'
	];

	public function tb_kepala_sekolahs()
	{
		return $this->hasMany(TbKepalaSekolah::class, 'id_pengguna');
	}

	public function tb_petugas()
	{
		return $this->hasMany(TbPetuga::class, 'id_pengguna');
	}

	public function tb_siswas()
	{
		return $this->hasMany(TbSiswa::class, 'id_pengguna');
	}
}
