<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dinso
 *
 * @property string $nip
 * @property int $id_pengguna
 * @property string $nama
 * @property string $gender
 * @property string|null $alamat
 * @property string|null $no_telp
 * @property string|null $foto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class Dinso extends Model
{
    protected $table = 'dinsos';
    protected $primaryKey = 'id_dinsos';
    public $incrementing = false;

    protected $casts = [
        'id_pengguna' => 'int'
    ];

    protected $fillable = [
        'id_pengguna',
        'nip',
        'nama',
        'gender',
        'alamat',
        'no_telp',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function getFotoSmAttribute()
    {
        return $this->foto ? asset('storage/dinsos/foto/sm/' . $this->foto) : null;
    }

    public function getFotoMdAttribute()
    {
        return $this->foto ? asset('storage/dinsos/foto/md/' . $this->foto) : null;
    }

    public function getFotoLgAttribute()
    {
        return $this->foto ? asset('storage/dinsos/foto/lg/' . $this->foto) : null;
    }
}
