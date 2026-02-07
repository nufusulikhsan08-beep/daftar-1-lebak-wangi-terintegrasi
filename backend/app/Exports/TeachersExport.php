<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeachersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $schoolId;

    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }

    public function collection()
    {
        return Teacher::where('school_id', $this->schoolId)->get();
    }

    public function headings(): array
    {
        return [
            'nama',
            'nip',
            'nuptk',
            'jenis_kelamin',
            'agama',
            'status_kawin',
            'tanggal_lahir',
            'tempat_lahir',
            'ijazah_awal',
            'ijazah_sekarang',
            'jurusan',
            'jabatan',
            'tmt_cpns',
            'tmt_pns',
            'tmt_di_sekolah',
            'mengajar_di_kelas',
            'golongan',
            'tmt_golongan',
            'mk_di_sekolah_thn',
            'mk_di_sekolah_bln',
            'mk_seluruh_thn',
            'mk_seluruh_bln',
            'mk_golongan_thn',
            'mk_golongan_bln',
            'status_kepegawaian',
        ];
    }

    public function map($teacher): array
    {
        return [
            $teacher->name,
            $teacher->nip,
            $teacher->nuptk,
            $teacher->gender,
            $teacher->religion,
            $teacher->marital_status,
            $teacher->birth_date ? $teacher->birth_date->format('Y-m-d') : null,
            $teacher->birth_place,
            $teacher->education_initial,
            $teacher->education_current,
            $teacher->major,
            $teacher->position,
            $teacher->tmt_cpns ? $teacher->tmt_cpns->format('Y-m-d') : null,
            $teacher->tmt_pns ? $teacher->tmt_pns->format('Y-m-d') : null,
            $teacher->tmt_school ? $teacher->tmt_school->format('Y-m-d') : null,
            $teacher->teaching_class,
            $teacher->golongan,
            $teacher->tmt_golongan ? $teacher->tmt_golongan->format('Y-m-d') : null,
            $teacher->mk_school_years,
            $teacher->mk_school_months,
            $teacher->mk_total_years,
            $teacher->mk_total_months,
            $teacher->mk_golongan_years,
            $teacher->mk_golongan_months,
            $teacher->employment_status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}