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
        'perceived_usefulness',
        'perceived_ease_of_use',
        'attitude_toward_using',
        'behavioral_intention_to_use',
        'actual_system_use',
    ];
}
