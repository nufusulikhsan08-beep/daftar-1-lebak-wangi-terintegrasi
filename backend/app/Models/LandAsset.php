<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'government_owned',
        'foundation_owned',
        'individual_owned',
        'other_owned',
        'area_size',
        'purchase_year',
        'ownership_proof',
        'proof_number',
        'proof_description',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Accessors
    public function getTotalAreaAttribute()
    {
        return $this->area_size;
    }

    public function getTotalOwnedAttribute()
    {
        return $this->government_owned + $this->foundation_owned + 
               $this->individual_owned + $this->other_owned;
    }
}