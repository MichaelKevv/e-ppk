<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPengaduan
 * 
 * @property int $id_pengaduan
 * @property int $id_siswa
 * @property string $judul
 * @property string $deskripsi
 * @property string|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbSiswa $tb_siswa
 * @property Collection|TbReviewPengaduan[] $tb_review_pengaduans
 * @property Collection|TbTanggapanPengaduan[] $tb_tanggapan_pengaduans
 *
 * @package App\Models
 */
class TbPengaduan extends Model
{
	protected $table = 'tb_pengaduan';
	protected $primaryKey = 'id_pengaduan';

	protected $casts = [
		'id_siswa' => 'int'
	];

	protected $fillable = [
		'id_siswa',
		'judul',
		'deskripsi',
		'status'
	];

	public function tb_siswa()
	{
		return $this->belongsTo(TbSiswa::class, 'id_siswa');
	}

	public function tb_review_pengaduans()
	{
		return $this->hasMany(TbReviewPengaduan::class, 'id_pengaduan');
	}

	public function tb_tanggapan_pengaduans()
	{
		return $this->hasMany(TbTanggapanPengaduan::class, 'id_pengaduan');
	}
}
