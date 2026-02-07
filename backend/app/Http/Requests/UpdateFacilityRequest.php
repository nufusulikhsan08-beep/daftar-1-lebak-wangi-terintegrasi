<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'water_well' => 'nullable|boolean',
            'water_pump' => 'nullable|boolean',
            'pam' => 'nullable|boolean',
            'river' => 'nullable|boolean',
            'other_water' => 'nullable|boolean',
            'other_water_desc' => 'nullable|string|max:255',
            'toilet_count' => 'nullable|integer|min:0',
            'is_borrowed' => 'nullable|boolean',
            'borrowed_from' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'toilet_count.integer' => 'Jumlah toilet harus berupa angka.',
            'toilet_count.min' => 'Jumlah toilet minimal 0.',
            'other_water_desc.string' => 'Deskripsi sumber air lain harus berupa teks.',
            'other_water_desc.max' => 'Deskripsi sumber air lain maksimal 255 karakter.',
            'borrowed_from.string' => 'Asal pinjaman harus berupa teks.',
            'borrowed_from.max' => 'Asal pinjaman maksimal 255 karakter.',
        ];
    }

    public function attributes(): array
    {
        return [
            'water_well' => 'Sumur',
            'water_pump' => 'Pompa Air',
            'pam' => 'PAM',
            'river' => 'Sungai',
            'other_water' => 'Sumber Air Lain',
            'other_water_desc' => 'Deskripsi Sumber Air Lain',
            'toilet_count' => 'Jumlah Toilet',
            'is_borrowed' => 'Status Pinjam',
            'borrowed_from' => 'Dipinjam dari',
        ];
    }
}