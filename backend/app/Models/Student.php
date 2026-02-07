<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'nis',
        'nisn',
        'name',
        'gender',
        'class',
        'birth_date',
        'birth_place',
        'address',
        'father_name',
        'mother_name',
        'guardian_name',
        'economic_status',
        'status',
        'entry_date',
        'exit_date',
        'notes',
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
        return $query->where('status', 'Aktif');
    }

    public function scopeByClass($query, $class)
    {
        return $query->where('class', $class);
    }

    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }
}