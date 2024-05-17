<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbReviewPengaduan
 * 
 * @property int $id_review
 * @property int $id_pengaduan
 * @property int $id_kepala
 * @property string $teks_review
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbPengaduan $tb_pengaduan
 * @property TbKepalaSekolah $tb_kepala_sekolah
 *
 * @package App\Models
 */
class TbReviewPengaduan extends Model
{
	protected $table = 'tb_review_pengaduan';
	protected $primaryKey = 'id_review';

	protected $casts = [
		'id_pengaduan' => 'int',
		'id_kepala' => 'int'
	];

	protected $fillable = [
		'id_pengaduan',
		'id_kepala',
		'teks_review'
	];

	public function tb_pengaduan()
	{
		return $this->belongsTo(TbPengaduan::class, 'id_pengaduan');
	}

	public function tb_kepala_sekolah()
	{
		return $this->belongsTo(TbKepalaSekolah::class, 'id_kepala');
	}
}
