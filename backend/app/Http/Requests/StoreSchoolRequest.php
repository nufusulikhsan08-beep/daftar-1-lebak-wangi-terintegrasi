<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'npsn' => 'required|string|max:20|unique:schools,npsn',
            'nss' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'status' => 'required|in:negeri,swasta',
            'accreditation' => 'nullable|string|max:50',
            'address' => 'required|string',
            'village' => 'nullable|string|max:100',
            'district' => 'required|string|max:100',
            'regency' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'npsn.required' => 'NPSN wajib diisi.',
            'npsn.unique' => 'NPSN sudah terdaftar.',
            'name.required' => 'Nama sekolah wajib diisi.',
            'status.required' => 'Status sekolah wajib dipilih.',
            'address.required' => 'Alamat wajib diisi.',
            'district.required' => 'Kecamatan wajib diisi.',
            'regency.required' => 'Kabupaten wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berupa file jpeg, png, jpg, gif, atau svg.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'npsn' => 'NPSN',
            'nss' => 'NSS',
            'name' => 'Nama Sekolah',
            'status' => 'Status',
            'accreditation' => 'Akreditasi',
            'address' => 'Alamat',
            'village' => 'Desa/Kelurahan',
            'district' => 'Kecamatan',
            'regency' => 'Kabupaten/Kota',
            'province' => 'Provinsi',
            'postal_code' => 'Kode Pos',
            'phone' => 'Telepon',
            'email' => 'Email',
            'website' => 'Website',
            'logo' => 'Logo',
        ];
    }
}