<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * 
 * @property int $id_feedback
 * @property int $id_pengaduan
 * @property int $id_user
 * @property string $nip
 * @property string $isi_tanggapan
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Pengaduan $pengaduan
 * @property Gurubk $gurubk
 * @property User $user
 *
 * @package App\Models
 */
class Feedback extends Model
{
	protected $table = 'feedback';
	protected $primaryKey = 'id_feedback';
	public $timestamps = false;

	protected $casts = [
		'id_pengaduan' => 'int',
		'id_user' => 'int'
	];

	protected $fillable = [
		'id_pengaduan',
		'nip',
		'id_user',
		'isi_tanggapan',
		'created_at',
	];


	// Relasi ke tabel pengaduan
	public function pengaduan()
	{
		return $this->belongsTo(Pengaduan::class, 'id_pengaduan');
	}

	// Relasi ke tabel guru BK (jika masih digunakan)
	public function gurubk()
	{
		return $this->belongsTo(Gurubk::class, 'nip');
	}

	// 🔗 Relasi ke tabel users
	public function user()
	{
		return $this->belongsTo(User::class, 'id_user', 'id_pengguna');
	}
}
