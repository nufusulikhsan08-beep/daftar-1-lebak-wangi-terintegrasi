<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'month',
        'year',
        'student_absent_sick',
        'student_absent_permit',
        'student_absent_alpha',
        'student_absent_total',
        'teacher_absent_sick',
        'teacher_absent_permit',
        'teacher_absent_alpha',
        'teacher_absent_total',
        'non_pns_absent_sick',
        'non_pns_absent_permit',
        'non_pns_absent_alpha',
        'non_pns_absent_total',
        'effective_days',
        'student_changes',
        'status',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'student_changes' => 'array',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Accessors
    public function getFormattedPeriodAttribute()
    {
        return $this->month . ' ' . $this->year;
    }

    public function getTotalAbsentStudentsAttribute()
    {
        return $this->student_absent_sick + $this->student_absent_permit + $this->student_absent_alpha;
    }

    public function getTotalAbsentTeachersAttribute()
    {
        return $this->teacher_absent_sick + $this->teacher_absent_permit + $this->teacher_absent_alpha;
    }

    public function getTotalAbsentNonPnsAttribute()
    {
        return $this->non_pns_absent_sick + $this->non_pns_absent_permit + $this->non_pns_absent_alpha;
    }

    public function getTotalAbsentAllAttribute()
    {
        return $this->getTotalAbsentStudentsAttribute() + 
               $this->getTotalAbsentTeachersAttribute() + 
               $this->getTotalAbsentNonPnsAttribute();
    }

    // Scopes
    public function scopeByPeriod($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeForCurrentMonth($query)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $currentMonthName = $months[$currentMonth - 1];
        
        return $query->where('month', $currentMonthName)->where('year', $currentYear);
    }
}