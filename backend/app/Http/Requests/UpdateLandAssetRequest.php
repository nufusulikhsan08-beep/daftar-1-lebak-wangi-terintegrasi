<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLandAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'government_owned' => 'nullable|integer|min:0',
            'foundation_owned' => 'nullable|integer|min:0',
            'individual_owned' => 'nullable|integer|min:0',
            'other_owned' => 'nullable|integer|min:0',
            'area_size' => 'nullable|numeric|min:0',
            'purchase_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'ownership_proof' => 'nullable|in:Akte,Sertifikat,Hibah,Wakaf,Lainnya',
            'proof_number' => 'nullable|string|max:100',
            'proof_description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'area_size.numeric' => 'Luas tanah harus berupa angka.',
            'purchase_year.integer' => 'Tahun pembelian harus berupa angka.',
            'purchase_year.min' => 'Tahun pembelian minimal 1900.',
            'purchase_year.max' => 'Tahun pembelian maksimal tahun ini.',
        ];
    }

    public function attributes(): array
    {
        return [
            'government_owned' => 'Milik Pemerintah',
            'foundation_owned' => 'Milik Yayasan',
            'individual_owned' => 'Milik Perorangan',
            'other_owned' => 'Milik Lainnya',
            'area_size' => 'Luas Tanah',
            'purchase_year' => 'Tahun Pembelian',
            'ownership_proof' => 'Bukti Kepemilikan',
            'proof_number' => 'Nomor Bukti',
            'proof_description' => 'Deskripsi Bukti',
        ];
    }
}