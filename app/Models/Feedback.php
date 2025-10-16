<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * 
 * @property int $id_feedback
 * @property int $id_pengaduan
 * @property string $nip
 * @property string $isi_tanggapan
 * @property Carbon $created_at
 * 
 * @property Pengaduan $pengaduan
 * @property Gurubk $gurubk
 *
 * @package App\Models
 */
class Feedback extends Model
{
	protected $table = 'feedback';
	protected $primaryKey = 'id_feedback';
	public $timestamps = false;

	protected $casts = [
		'id_pengaduan' => 'int'
	];

	protected $fillable = [
		'id_pengaduan',
		'nip',
		'isi_tanggapan'
	];

	public function pengaduan()
	{
		return $this->belongsTo(Pengaduan::class, 'id_pengaduan');
	}

	public function gurubk()
	{
		return $this->belongsTo(Gurubk::class, 'nip');
	}
}
