<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'item_name',
        'quantity',
        'condition_good',
        'condition_medium',
        'condition_light_damage',
        'condition_heavy_damage',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Accessors
    public function getTotalConditionAttribute()
    {
        return $this->condition_good + $this->condition_medium +
               $this->condition_light_damage + $this->condition_heavy_damage;
    }

    public function getGoodConditionPercentageAttribute()
    {
        $total = $this->getTotalConditionAttribute();
        return $total > 0 ? round(($this->condition_good / $total) * 100, 2) : 0;
    }
}