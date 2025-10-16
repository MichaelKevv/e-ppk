<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pengaduan
 * 
 * @property int $id_pengaduan
 * @property int $id_siswa
 * @property string $bentuk_perundungan
 * @property string $frekuensi_kejadian
 * @property string|null $lokasi
 * @property bool $trauma_mental
 * @property bool $luka_fisik
 * @property bool $pelaku_lebih_dari_satu
 * @property bool $konten_digital
 * @property string|null $jenis_kata
 * @property string $klasifikasi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Siswa $siswa
 * @property Collection|Feedback[] $feedback
 *
 * @package App\Models
 */
class Pengaduan extends Model
{
	protected $table = 'pengaduan';
	protected $primaryKey = 'id_pengaduan';

	protected $casts = [
		'id_siswa' => 'int',
		'trauma_mental' => 'bool',
		'luka_fisik' => 'bool',
		'pelaku_lebih_dari_satu' => 'bool',
		'konten_digital' => 'bool'
	];

	protected $fillable = [
		'id_siswa',
		'bentuk_perundungan',
		'frekuensi_kejadian',
		'lokasi',
		'trauma_mental',
		'luka_fisik',
		'pelaku_lebih_dari_satu',
		'konten_digital',
		'jenis_kata',
		'klasifikasi'
	];

	public function siswa()
	{
		return $this->belongsTo(Siswa::class, 'id_siswa');
	}

	public function feedback()
	{
		return $this->hasMany(Feedback::class, 'id_pengaduan');
	}
}
