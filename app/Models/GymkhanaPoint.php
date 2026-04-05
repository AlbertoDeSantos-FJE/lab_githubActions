<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymkhanaPoint extends Model
{
    use HasFactory;

    protected $fillable = ['gymkhana_id', 'place_id', 'order', 'question', 'expected_answer', 'answer_options', 'next_clue'];

    protected $casts = [
        'answer_options' => 'array',
    ];

    protected $appends = ['correct_index'];

    public function getCorrectIndexAttribute()
    {
        if (is_array($this->answer_options)) {
            $idx = array_search($this->expected_answer, $this->answer_options);
            return $idx !== false ? $idx : 0;
        }
        return 0;
    }


    public function gymkhana()
    {
        return $this->belongsTo(Gymkhana::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
