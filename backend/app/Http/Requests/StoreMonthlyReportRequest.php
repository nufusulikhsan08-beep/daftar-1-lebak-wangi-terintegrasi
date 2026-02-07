<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMonthlyReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'month' => [
                'required',
                Rule::in(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                         'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
            ],
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            
            // Student absences
            'student_absent_sick' => 'nullable|integer|min:0',
            'student_absent_permit' => 'nullable|integer|min:0',
            'student_absent_alpha' => 'nullable|integer|min:0',
            
            // Teacher absences (ASN)
            'teacher_absent_sick' => 'nullable|integer|min:0',
            'teacher_absent_permit' => 'nullable|integer|min:0',
            'teacher_absent_alpha' => 'nullable|integer|min:0',
            
            // Non-PNS absences
            'non_pns_absent_sick' => 'nullable|integer|min:0',
            'non_pns_absent_permit' => 'nullable|integer|min:0',
            'non_pns_absent_alpha' => 'nullable|integer|min:0',
            
            // Effective days
            'effective_days' => 'nullable|integer|min:0|max:31',
            
            // Student changes per class
            'student_changes' => 'nullable|array',
            'student_changes.*' => 'array',
            'student_changes.*.L' => 'nullable|integer|min:0',
            'student_changes.*.P' => 'nullable|integer|min:0',
            'student_changes.*.akhir_lalu' => 'nullable|integer|min:0',
            'student_changes.*.masuk' => 'nullable|integer|min:0',
            'student_changes.*.keluar' => 'nullable|integer|min:0',
            'student_changes.*.akhir_ini' => 'nullable|integer|min:0',
            
            'status' => 'required|in:draft,submitted',
        ];
    }

    public function messages(): array
    {
        return [
            'month.required' => 'Bulan wajib dipilih.',
            'year.required' => 'Tahun wajib diisi.',
            'effective_days.max' => 'Hari efektif maksimal 31 hari.',
            'status.required' => 'Status laporan wajib dipilih.',
        ];
    }

    public function attributes(): array
    {
        return [
            'month' => 'Bulan',
            'year' => 'Tahun',
            'student_absent_sick' => 'Sakit (S)',
            'student_absent_permit' => 'Ijin (I)',
            'student_absent_alpha' => 'Alpa (A)',
            'teacher_absent_sick' => 'Sakit Guru ASN',
            'teacher_absent_permit' => 'Ijin Guru ASN',
            'teacher_absent_alpha' => 'Alpa Guru ASN',
            'non_pns_absent_sick' => 'Sakit Guru Sukwan',
            'non_pns_absent_permit' => 'Ijin Guru Sukwan',
            'non_pns_absent_alpha' => 'Alpa Guru Sukwan',
            'effective_days' => 'Hari Efektif',
            'status' => 'Status Laporan',
        ];
    }
}