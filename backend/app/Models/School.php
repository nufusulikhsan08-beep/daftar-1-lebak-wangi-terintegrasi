<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'npsn', 'nss', 'name', 'status', 'accreditation',
        'address', 'village', 'district', 'regency', 'province',
        'postal_code', 'phone', 'email', 'website', 'logo'
    ];

    // Relationships
    public function principal()
    {
        return $this->hasOne(Principal::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function landAsset()
    {
        return $this->hasOne(LandAsset::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function furniture()
    {
        return $this->hasMany(Furniture::class);
    }

    public function facility()
    {
        return $this->hasOne(Facility::class);
    }

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->status == 'negeri' ? 'SDN ' . $this->name : $this->name;
    }
}