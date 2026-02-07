<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $schoolId;

    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }

    public function collection()
    {
        return Student::where('school_id', $this->schoolId)->get();
    }

    public function headings(): array
    {
        return [
            'nis',
            'nisn',
            'nama',
            'jenis_kelamin',
            'kelas',
            'tanggal_lahir',
            'tempat_lahir',
            'alamat',
            'nama_ayah',
            'nama_ibu',
            'nama_wali',
            'status_ekonomi',
            'status_siswa',
            'tanggal_masuk',
            'tanggal_keluar',
            'keterangan',
        ];
    }

    public function map($student): array
    {
        return [
            $student->nis,
            $student->nisn,
            $student->name,
            $student->gender,
            $student->class,
            $student->birth_date ? $student->birth_date->format('Y-m-d') : null,
            $student->birth_place,
            $student->address,
            $student->father_name,
            $student->mother_name,
            $student->guardian_name,
            $student->economic_status,
            $student->status,
            $student->entry_date ? $student->entry_date->format('Y-m-d') : null,
            $student->exit_date ? $student->exit_date->format('Y-m-d') : null,
            $student->notes,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}