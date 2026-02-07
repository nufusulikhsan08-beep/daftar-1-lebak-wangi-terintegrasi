<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
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
        'position',
        'position_detail',
        'tmt_cpns',
        'tmt_pns',
        'tmt_school',
        'teaching_class',
        'golongan',
        'tmt_golongan',
        'mk_school_years',
        'mk_school_months',
        'mk_total_years',
        'mk_total_months',
        'mk_golongan_years',
        'mk_golongan_months',
        'employment_status',
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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByEmploymentStatus($query, $status)
    {
        return $query->where('employment_status', $status);
    }
}