<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyData extends Model
{
    use HasFactory;
    protected $table = 'survey_data';

    protected $fillable = [
        'respondent_name',
        'email',
        'id_pengaduan',
        'perceived_usefulness',
        'perceived_ease_of_use',
        'behavioral_intention_to_use',
    ];
}
