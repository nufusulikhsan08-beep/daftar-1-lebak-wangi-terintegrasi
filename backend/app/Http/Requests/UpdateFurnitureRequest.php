<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFurnitureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_name' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'condition_good' => 'nullable|integer|min:0',
            'condition_medium' => 'nullable|integer|min:0',
            'condition_light_damage' => 'nullable|integer|min:0',
            'condition_heavy_damage' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'item_name.required' => 'Nama barang wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 0.',
            'condition_good.integer' => 'Jumlah kondisi baik harus berupa angka.',
            'condition_medium.integer' => 'Jumlah kondisi sedang harus berupa angka.',
            'condition_light_damage.integer' => 'Jumlah kondisi rusak ringan harus berupa angka.',
            'condition_heavy_damage.integer' => 'Jumlah kondisi rusak berat harus berupa angka.',
        ];
    }

    public function attributes(): array
    {
        return [
            'item_name' => 'Nama Barang',
            'quantity' => 'Jumlah',
            'condition_good' => 'Kondisi Baik',
            'condition_medium' => 'Kondisi Sedang',
            'condition_light_damage' => 'Kondisi Rusak Ringan',
            'condition_heavy_damage' => 'Kondisi Rusak Berat',
        ];
    }
}