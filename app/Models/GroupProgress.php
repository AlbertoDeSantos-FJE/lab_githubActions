<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupProgress extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'gymkhana_id', 'current_point_order', 'completed_at'];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function gymkhana()
    {
        return $this->belongsTo(Gymkhana::class);
    }
}
