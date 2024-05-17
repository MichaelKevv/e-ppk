<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbKepalaSekolah
 * 
 * @property int $id_kepala
 * @property int $id_pengguna
 * @property string $nama
 * @property string $alamat
 * @property string $kontak
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbPengguna $tb_pengguna
 * @property Collection|TbReviewPengaduan[] $tb_review_pengaduans
 *
 * @package App\Models
 */
class TbKepalaSekolah extends Model
{
	protected $table = 'tb_kepala_sekolah';
	protected $primaryKey = 'id_kepala';

	protected $casts = [
		'id_pengguna' => 'int'
	];

	protected $fillable = [
		'id_pengguna',
		'nama',
		'alamat',
		'kontak'
	];

	public function tb_pengguna()
	{
		return $this->belongsTo(TbPengguna::class, 'id_pengguna');
	}

	public function tb_review_pengaduans()
	{
		return $this->hasMany(TbReviewPengaduan::class, 'id_kepala');
	}
}
