<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_type' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'condition_non_standard' => 'nullable|integer|min:0',
            'condition_good' => 'nullable|integer|min:0',
            'condition_light_damage' => 'nullable|integer|min:0',
            'condition_medium_damage' => 'nullable|integer|min:0',
            'condition_heavy_damage' => 'nullable|integer|min:0',
            'age_le_6' => 'nullable|integer|min:0',
            'age_7' => 'nullable|integer|min:0',
            'age_8' => 'nullable|integer|min:0',
            'age_9' => 'nullable|integer|min:0',
            'age_10' => 'nullable|integer|min:0',
            'age_11' => 'nullable|integer|min:0',
            'age_12' => 'nullable|integer|min:0',
            'age_ge_13' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'room_type.required' => 'Jenis ruangan wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 0.',
            'condition_non_standard.integer' => 'Jumlah kondisi non standar harus berupa angka.',
            'condition_good.integer' => 'Jumlah kondisi baik harus berupa angka.',
            'condition_light_damage.integer' => 'Jumlah kondisi rusak ringan harus berupa angka.',
            'condition_medium_damage.integer' => 'Jumlah kondisi rusak sedang harus berupa angka.',
            'condition_heavy_damage.integer' => 'Jumlah kondisi rusak berat harus berupa angka.',
        ];
    }

    public function attributes(): array
    {
        return [
            'room_type' => 'Jenis Ruangan',
            'quantity' => 'Jumlah',
            'condition_non_standard' => 'Kondisi Non Standar',
            'condition_good' => 'Kondisi Baik',
            'condition_light_damage' => 'Kondisi Rusak Ringan',
            'condition_medium_damage' => 'Kondisi Rusak Sedang',
            'condition_heavy_damage' => 'Kondisi Rusak Berat',
            'age_le_6' => 'Usia ≤ 6 Tahun',
            'age_7' => 'Usia 7 Tahun',
            'age_8' => 'Usia 8 Tahun',
            'age_9' => 'Usia 9 Tahun',
            'age_10' => 'Usia 10 Tahun',
            'age_11' => 'Usia 11 Tahun',
            'age_12' => 'Usia 12 Tahun',
            'age_ge_13' => 'Usia ≥ 13 Tahun',
        ];
    }
}