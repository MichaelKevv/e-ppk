<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EvaluasiTam
 * 
 * @property int $id_evaluasi
 * @property int $id_pengguna
 * @property int $perceived_usefulness
 * @property int $perceived_ease_of_use
 * @property int $intention_to_use
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class EvaluasiTam extends Model
{
	protected $table = 'evaluasi_tam';
	protected $primaryKey = 'id_evaluasi';

	protected $casts = [
		'id_pengguna' => 'int',
		'perceived_usefulness' => 'int',
		'perceived_ease_of_use' => 'int',
		'intention_to_use' => 'int'
	];

	protected $fillable = [
		'id_pengguna',
		'perceived_usefulness',
		'perceived_ease_of_use',
		'intention_to_use'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_pengguna');
	}
}
