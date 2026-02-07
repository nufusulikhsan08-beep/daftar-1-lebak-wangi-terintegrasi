<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'water_well',
        'water_pump',
        'pam',
        'river',
        'other_water',
        'other_water_desc',
        'toilet_count',
        'is_borrowed',
        'borrowed_from',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Accessors
    public function getTotalWaterSourcesAttribute()
    {
        $sources = 0;
        if ($this->water_well) $sources++;
        if ($this->water_pump) $sources++;
        if ($this->pam) $sources++;
        if ($this->river) $sources++;
        if ($this->other_water) $sources++;
        return $sources;
    }

    public function getWaterSourceTypesAttribute()
    {
        $types = [];
        if ($this->water_well) $types[] = 'Sumur';
        if ($this->water_pump) $types[] = 'Pompa Air';
        if ($this->pam) $types[] = 'PAM';
        if ($this->river) $types[] = 'Sungai';
        if ($this->other_water) $types[] = $this->other_water_desc ?: 'Lainnya';
        return $types;
    }
}