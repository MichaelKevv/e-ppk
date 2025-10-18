<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 *
 * @property int $id_admin
 * @property int $id_pengguna
 * @property string $nama
 * @property string|null $jabatan
 * @property string|null $no_telp
 * @property string|null $foto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Artikel[] $artikels
 *
 * @package App\Models
 */
class Admin extends Model
{
	protected $table = 'admin';
	protected $primaryKey = 'id_admin';

	protected $casts = [
		'id_pengguna' => 'int'
	];

	protected $fillable = [
		'id_pengguna',
		'nama',
		'jabatan',
		'no_telp',
		'foto'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_pengguna');
	}

	public function artikels()
	{
		return $this->hasMany(Artikel::class, 'author');
	}

    public function getFotoSmAttribute()
    {
        return $this->foto ? asset('storage/admin/foto/sm/' . $this->foto) : null;
    }

    public function getFotoMdAttribute()
    {
        return $this->foto ? asset('storage/admin/foto/md/' . $this->foto) : null;
    }

    public function getFotoLgAttribute()
    {
        return $this->foto ? asset('storage/admin/foto/lg/' . $this->foto) : null;
    }
}
