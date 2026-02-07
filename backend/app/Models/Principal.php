<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'nip',
        'nuptk',
        'gender',
        'religion',
        'marital_status',
        'birth_date',
        'birth_place',
        'education_initial',
        'education_current',
        'major',
        'rank',
        'golongan',
        'tmt_golongan',
        'tmt_cpns',
        'tmt_pns',
        'tmt_school',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getAgeAttribute()
    {
        if ($this->birth_date) {
            return \Carbon\Carbon::parse($this->birth_date)->age;
        }
        return null;
    }
}