<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Gurubk
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
 * @property Collection|Feedback[] $feedback
 *
 * @package App\Models
 */
class Gurubk extends Model
{
    protected $table = 'gurubk';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'nip',
        'id_pengguna',
        'nama',
        'gender',
        'alamat',
        'no_telp',
        'foto',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'id_pengguna' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'nip');
    }

    public function getFotoSmAttribute()
    {
        return $this->foto ? asset('storage/gurubk/foto/sm/' . $this->foto) : null;
    }

    public function getFotoMdAttribute()
    {
        return $this->foto ? asset('storage/gurubk/foto/md/' . $this->foto) : null;
    }

    public function getFotoLgAttribute()
    {
        return $this->foto ? asset('storage/gurubk/foto/lg/' . $this->foto) : null;
    }
}
