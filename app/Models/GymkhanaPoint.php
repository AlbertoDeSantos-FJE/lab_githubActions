<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymkhanaPoint extends Model
{
    use HasFactory;

    protected $fillable = ['gymkhana_id', 'place_id', 'order', 'question', 'expected_answer', 'next_clue'];

    public function gymkhana()
    {
        return $this->belongsTo(Gymkhana::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
