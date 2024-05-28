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
 * @property string|null $foto
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property TbSiswa $tb_siswa
 * @property Collection|TbFeedback[] $tb_feedbacks
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
		'status',
		'foto'
	];

	public function tb_siswa()
	{
		return $this->belongsTo(TbSiswa::class, 'id_siswa');
	}

	public function tb_feedbacks()
	{
		return $this->hasMany(TbFeedback::class, 'id_pengaduan');
	}
}
