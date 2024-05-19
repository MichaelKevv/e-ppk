<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbArtikel
 * 
 * @property int $id_artikel
 * @property string $author
 * @property string $judul
 * @property string $konten
 * @property string $kategori
 * @property string $gambar
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class TbArtikel extends Model
{
	protected $table = 'tb_artikel';
	protected $primaryKey = 'id_artikel';

	protected $fillable = [
		'author',
		'judul',
		'konten',
		'kategori',
		'gambar'
	];
}
