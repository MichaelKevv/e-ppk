<?php

namespace App\Models;

/**
 * Class DatasetKasus
 * 
 * Alias model yang mengarah ke tabel `pengaduan` untuk data historis & latih.
 */
class DatasetKasus extends Pengaduan
{
    protected static function booted()
    {
        static::addGlobalScope('history_or_latih', function ($builder) {
            $builder->where('sumber', 'history');
        });
    }
}
