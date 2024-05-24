<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbFeedback
 * 
 * @property int $id_tanggapan
 * @property int $id_pengaduan
 * @property int|null $id_siswa
 * @property int $id_petugas
 * @property string $teks_tanggapan
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbPengaduan $tb_pengaduan
 * @property TbPetuga $tb_petuga
 * @property TbSiswa|null $tb_siswa
 *
 * @package App\Models
 */
class TbFeedback extends Model
{
	protected $table = 'tb_feedback';
	protected $primaryKey = 'id_tanggapan';

	protected $casts = [
		'id_pengaduan' => 'int',
		'id_siswa' => 'int',
		'id_petugas' => 'int'
	];

	protected $fillable = [
		'id_pengaduan',
		'id_siswa',
		'id_petugas',
		'teks_tanggapan',
		'status'
	];

	public function tb_pengaduan()
	{
		return $this->belongsTo(TbPengaduan::class, 'id_pengaduan');
	}

	public function tb_petuga()
	{
		return $this->belongsTo(TbPetuga::class, 'id_petugas');
	}

	public function tb_siswa()
	{
		return $this->belongsTo(TbSiswa::class, 'id_siswa');
	}
}
