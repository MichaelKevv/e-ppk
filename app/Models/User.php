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

	public function guruBk()
	{
		return $this->hasOne(Gurubk::class, 'id_pengguna');
	}

	public function siswa()
	{
		return $this->hasOne(Siswa::class, 'id_pengguna');
	}

	public function isAdmin(): bool
	{
		return in_array($this->role, ['admin', 'admin_it', 'dinsos']);
	}

	public function isGuruBk(): bool
	{
		return $this->role === 'gurubk';
	}

	public function isSiswa(): bool
	{
		return $this->role === 'siswa';
	}

	public function getSekolahIdAttribute(): ?int
	{
		if ($this->isGuruBk()) {
			return $this->guruBk?->id_sekolah;
		}
		if ($this->isSiswa()) {
			return $this->siswa?->id_sekolah;
		}
		return null;
	}

	public function getSekolahAttribute(): ?Sekolah
	{
		if ($this->isGuruBk()) {
			return $this->guruBk?->sekolah;
		}
		if ($this->isSiswa()) {
			return $this->siswa?->sekolah;
		}
		return null;
	}

	public function getNamaLengkapAttribute(): string
	{
		if ($this->isGuruBk()) {
			return $this->guruBk?->nama ?? $this->username;
		}
		if ($this->isSiswa()) {
			return $this->siswa?->nama ?? $this->username;
		}
		return $this->username;
	}

    public function getFotoSmAttribute()
    {
        return $this->foto ? asset('storage/foto-siswa/sm/' . $this->foto) : null;
    }

    public function getFotoMdAttribute()
    {
        return $this->foto ? asset('storage/foto-siswa/md/' . $this->foto) : null;
    }

    public function getFotoLgAttribute()
    {
        return $this->foto ? asset('storage/foto-siswa/lg/' . $this->foto) : null;
    }
}
