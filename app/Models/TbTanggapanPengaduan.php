<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbTanggapanPengaduan
 * 
 * @property int $id_tanggapan
 * @property int $id_pengaduan
 * @property int $id_petugas
 * @property string $teks_tanggapan
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbPengaduan $tb_pengaduan
 * @property TbPetuga $tb_petuga
 *
 * @package App\Models
 */
class TbTanggapanPengaduan extends Model
{
	protected $table = 'tb_tanggapan_pengaduan';
	protected $primaryKey = 'id_tanggapan';

	protected $casts = [
		'id_pengaduan' => 'int',
		'id_petugas' => 'int'
	];

	protected $fillable = [
		'id_pengaduan',
		'id_petugas',
		'teks_tanggapan'
	];

	public function tb_pengaduan()
	{
		return $this->belongsTo(TbPengaduan::class, 'id_pengaduan');
	}

	public function tb_petuga()
	{
		return $this->belongsTo(TbPetuga::class, 'id_petugas');
	}
}
