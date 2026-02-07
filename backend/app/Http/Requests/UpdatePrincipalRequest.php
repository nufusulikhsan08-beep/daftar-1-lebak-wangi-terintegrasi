<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrincipalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $principalId = $this->route('id');
        
        return [
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:principals,nip,' . $principalId,
            'nuptk' => 'nullable|string|max:20',
            'gender' => 'required|in:L,P',
            'religion' => 'nullable|string|max:50',
            'marital_status' => 'required|in:K,TK',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:100',
            'education_initial' => 'nullable|string|max:100',
            'education_current' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'rank' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:50',
            'tmt_golongan' => 'nullable|date',
            'tmt_cpns' => 'nullable|date',
            'tmt_pns' => 'nullable|date',
            'tmt_school' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'marital_status.required' => 'Status perkawinan wajib dipilih.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
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
            'marital_status' => 'Status Perkawinan',
            'birth_date' => 'Tanggal Lahir',
            'birth_place' => 'Tempat Lahir',
            'education_initial' => 'Ijazah Awal',
            'education_current' => 'Ijazah Sekarang',
            'major' => 'Jurusan',
            'rank' => 'Pangkat',
            'golongan' => 'Golongan',
            'tmt_golongan' => 'TMT Golongan',
            'tmt_cpns' => 'TMT CPNS',
            'tmt_pns' => 'TMT PNS',
            'tmt_school' => 'TMT di Sekolah',
        ];
    }
}