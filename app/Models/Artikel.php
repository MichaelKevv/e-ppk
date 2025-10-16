<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artikel
 *
 * @property int $id_artikel
 * @property int $author
 * @property string $judul
 * @property string $konten
 * @property string $kategori
 * @property string|null $gambar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Admin $admin
 *
 * @package App\Models
 */
class Artikel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';

    protected $casts = [
        'author' => 'int'
    ];

    protected $fillable = [
        'author',
        'judul',
        'konten',
        'kategori',
        'gambar'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'author');
    }

    public function getGambarSmAttribute()
    {
        return $this->gambar ? asset('storage/artikel/gambar/sm/' . $this->gambar) : null;
    }

    public function getGambarMdAttribute()
    {
        return $this->gambar ? asset('storage/artikel/gambar/md/' . $this->gambar) : null;
    }

    public function getGambarLgAttribute()
    {
        return $this->gambar ? asset('storage/artikel/gambar/lg/' . $this->gambar) : null;
    }
}
