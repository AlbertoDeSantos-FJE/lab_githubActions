<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gymkhana extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function points()
    {
        return $this->hasMany(GymkhanaPoint::class)->orderBy('order');
    }

    public function groupProgresses()
    {
        return $this->hasMany(GroupProgress::class);
    }
}
