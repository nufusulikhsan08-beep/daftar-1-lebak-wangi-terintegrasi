<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'room_type',
        'quantity',
        'condition_non_standard',
        'condition_good',
        'condition_light_damage',
        'condition_medium_damage',
        'condition_heavy_damage',
        'age_le_6',
        'age_7',
        'age_8',
        'age_9',
        'age_10',
        'age_11',
        'age_12',
        'age_ge_13',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Accessors
    public function getTotalConditionAttribute()
    {
        return $this->condition_non_standard + $this->condition_good +
               $this->condition_light_damage + $this->condition_medium_damage +
               $this->condition_heavy_damage;
    }

    public function getTotalAgeAttribute()
    {
        return $this->age_le_6 + $this->age_7 + $this->age_8 +
               $this->age_9 + $this->age_10 + $this->age_11 +
               $this->age_12 + $this->age_ge_13;
    }
}