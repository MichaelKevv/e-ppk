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
 * Class User
 *
 * @property int $id_pengguna
 * @property string $username
 * @property string $password
 * @property string $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Admin[] $admins
 * @property Collection|Dinso[] $dinsos
 * @property Collection|EvaluasiTam[] $evaluasi_tams
 * @property Collection|Gurubk[] $gurubks
 * @property Collection|Siswa[] $siswas
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';
	protected $primaryKey = 'id_pengguna';

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'email',
		'password',
		'role'
	];

	public function admins()
	{
		return $this->hasMany(Admin::class, 'id_pengguna');
	}

	public function dinsos()
	{
		return $this->hasMany(Dinso::class, 'id_pengguna');
	}

	public function evaluasi_tams()
	{
		return $this->hasMany(EvaluasiTam::class, 'id_pengguna');
	}

	public function gurubks()
	{
		return $this->hasMany(Gurubk::class, 'id_pengguna');
	}

	public function siswas()
	{
		return $this->hasMany(Siswa::class, 'id_pengguna');
	}

    public function getFotoSmAttribute()
    {
        return $this->foto ? asset('storage/foto-siswa/sm/' . $this->gambar) : null;
    }

    public function getFotoMdAttribute()
    {
        return $this->foto ? asset('storage/foto-siswa/md/' . $this->gambar) : null;
    }

    public function getFotoLgAttribute()
    {
        return $this->foto ? asset('storage/foto-siswa/lg/' . $this->gambar) : null;
    }
}
