<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'class' => 'required|in:I,II,III,IV,V,VI',
            'economic_status' => 'required|in:Mampu,Sedang,Tidak Mampu',
            'status' => 'required|in:Aktif,Pindah,Dropout,Lulus',
        ];

        // NIS/NISN unique validation
        $rules['nis'] = 'nullable|string|max:20|unique:students,nis,' . $this->route('studentId');
        $rules['nisn'] = 'nullable|string|max:20|unique:students,nisn,' . $this->route('studentId');

        // Dates validation
        $rules['birth_date'] = 'nullable|date|before:today';
        $rules['entry_date'] = 'nullable|date|before_or_equal:today';
        $rules['exit_date'] = 'nullable|date|after_or_equal:entry_date';

        // Exit date required if status is Pindah, Dropout, or Lulus
        if (in_array($this->status, ['Pindah', 'Dropout', 'Lulus'])) {
            $rules['exit_date'] = 'required|date|after_or_equal:entry_date';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama siswa wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'class.required' => 'Kelas wajib dipilih.',
            'economic_status.required' => 'Status ekonomi wajib dipilih.',
            'status.required' => 'Status siswa wajib dipilih.',
            'exit_date.required' => 'Tanggal keluar wajib diisi untuk siswa yang pindah/dropout/lulus.',
            'exit_date.after_or_equal' => 'Tanggal keluar harus setelah atau sama dengan tanggal masuk.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'nis' => 'NIS',
            'nisn' => 'NISN',
            'gender' => 'Jenis Kelamin',
            'class' => 'Kelas',
            'birth_date' => 'Tanggal Lahir',
            'birth_place' => 'Tempat Lahir',
            'address' => 'Alamat',
            'father_name' => 'Nama Ayah',
            'mother_name' => 'Nama Ibu',
            'guardian_name' => 'Nama Wali',
            'economic_status' => 'Status Ekonomi',
            'status' => 'Status Siswa',
            'entry_date' => 'Tanggal Masuk',
            'exit_date' => 'Tanggal Keluar',
        ];
    }
}