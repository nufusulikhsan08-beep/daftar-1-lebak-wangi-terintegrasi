<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacherId = $this->route('teacherId');
        
        $rules = [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'position' => 'required|in:GK,G PAI,G PJOK,OP,TU,Lainnya',
            'employment_status' => 'required|in:ASN,Sukwan',
        ];

        // NIP required for ASN
        if ($this->employment_status === 'ASN') {
            $rules['nip'] = 'required|string|max:20|unique:teachers,nip,' . $teacherId;
            $rules['tmt_cpns'] = 'required|date';
            $rules['tmt_pns'] = 'required|date|after_or_equal:tmt_cpns';
        } else {
            $rules['nip'] = 'nullable|string|max:20|unique:teachers,nip,' . $teacherId;
        }

        // NUPTK optional but unique if provided
        $rules['nuptk'] = 'nullable|string|max:20|unique:teachers,nuptk,' . $teacherId;

        // Dates validation
        $rules['birth_date'] = 'nullable|date|before:today';
        $rules['tmt_school'] = 'nullable|date|before_or_equal:today';
        $rules['tmt_golongan'] = 'nullable|date|before_or_equal:today';

        // Masa kerja validation
        $rules['mk_school_years'] = 'nullable|integer|min:0|max:100';
        $rules['mk_school_months'] = 'nullable|integer|min:0|max:11';
        $rules['mk_total_years'] = 'nullable|integer|min:0|max:100';
        $rules['mk_total_months'] = 'nullable|integer|min:0|max:11';
        $rules['mk_golongan_years'] = 'nullable|integer|min:0|max:100';
        $rules['mk_golongan_months'] = 'nullable|integer|min:0|max:11';

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama guru wajib diisi.',
            'nip.required' => 'NIP wajib diisi untuk guru ASN.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nuptk.unique' => 'NUPTK sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'position.required' => 'Jabatan wajib dipilih.',
            'employment_status.required' => 'Status kepegawaian wajib dipilih.',
            'tmt_cpns.required' => 'TMT CPNS wajib diisi untuk guru ASN.',
            'tmt_pns.required' => 'TMT PNS wajib diisi untuk guru ASN.',
            'tmt_pns.after_or_equal' => 'TMT PNS harus setelah atau sama dengan TMT CPNS.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'tmt_school.before_or_equal' => 'TMT di sekolah harus sebelum atau sama dengan hari ini.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'nip' => 'NIP',
            'nuptk' => 'NUPTK',
            'gender' => 'Jenis Kelamin',
            'religion' => 'Agama',
            'marital_status' => 'Status Kawin',
            'birth_date' => 'Tanggal Lahir',
            'birth_place' => 'Tempat Lahir',
            'education_initial' => 'Ijazah Awal',
            'education_current' => 'Ijazah Sekarang',
            'major' => 'Jurusan',
            'position' => 'Jabatan',
            'tmt_cpns' => 'TMT CPNS',
            'tmt_pns' => 'TMT PNS',
            'tmt_school' => 'TMT di Sekolah',
            'teaching_class' => 'Mengajar di Kelas',
            'golongan' => 'Golongan',
            'tmt_golongan' => 'TMT Golongan',
            'mk_school_years' => 'Masa Kerja di Sekolah (Tahun)',
            'mk_school_months' => 'Masa Kerja di Sekolah (Bulan)',
            'mk_total_years' => 'Masa Kerja Seluruh (Tahun)',
            'mk_total_months' => 'Masa Kerja Seluruh (Bulan)',
            'mk_golongan_years' => 'Masa Kerja Golongan (Tahun)',
            'mk_golongan_months' => 'Masa Kerja Golongan (Bulan)',
            'employment_status' => 'Status Kepegawaian',
        ];
    }
}