<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DAFTAR 1 - {{ $school->name }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        
        .container {
            width: 210mm;
            margin: 0 auto;
            padding: 10mm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 5mm;
            border-bottom: 3px double #000;
            padding-bottom: 3mm;
        }
        
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 2mm 0;
        }
        
        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3mm;
            font-size: 11px;
        }
        
        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin: 5mm 0 3mm 0;
            font-size: 13px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            font-size: 10px;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 2mm;
            text-align: center;
        }
        
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .text-left {
            text-align: left;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .bold {
            font-weight: bold;
        }
        
        .signature-section {
            margin-top: 15mm;
            text-align: center;
        }
        
        .signature-box {
            display: inline-block;
            width: 45%;
            text-align: center;
            margin-top: 5mm;
        }
        
        .signature-name {
            margin-top: 25mm;
            font-weight: bold;
        }
        
        .signature-nip {
            margin-top: 2mm;
        }
        
        .footer {
            margin-top: 10mm;
            text-align: center;
            font-size: 9px;
            border-top: 1px solid #000;
            padding-top: 2mm;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <h1>DINAS PENDIDIKAN WILAYAH KECAMATAN LEBAK WANGI</h1>
            <h2>DAFTAR I</h2>
            <div class="header-info">
                <div>
                    <strong>KECAMATAN</strong> : LEBAK WANGI<br>
                    <strong>KABUPATEN</strong> : SERANG<br>
                    <strong>PROPINSI</strong> : BANTEN
                </div>
                <div>
                    <strong>Status</strong> : {{ strtoupper($school->status) }}<br>
                    <strong>NSS</strong> : {{ $school->nss ?? '-' }}<br>
                    <strong>NPSN</strong> : {{ $school->npsn }}
                </div>
            </div>
            <div style="text-align: center; margin-top: 3mm;">
                <strong>LAPORAN BULAN {{ strtoupper($report->month) }} {{ $report->year }}</strong>
            </div>
        </div>

        {{-- Section A: Keadaan Anak Didik --}}
        <div class="section-title">A. KEADAAN ANAK DIDIK:</div>
        
        <table>
            <thead>
                <tr>
                    <th rowspan="3" class="text-center align-middle">URAIAN</th>
                    <th colspan="14" class="text-center">KELAS</th>
                </tr>
                <tr>
                    <th colspan="2">I</th>
                    <th colspan="2">II</th>
                    <th colspan="2">III</th>
                    <th colspan="2">IV</th>
                    <th colspan="2">V</th>
                    <th colspan="2">VI</th>
                    <th colspan="2">JUMLAH</th>
                </tr>
                <tr>
                    <th>1 bag</th>
                    <th>L</th>
                    <th>P</th>
                    <th>1 bag</th>
                    <th>L</th>
                    <th>P</th>
                    <th>1 bag</th>
                    <th>L</th>
                    <th>P</th>
                    <th>1 bag</th>
                    <th>L</th>
                    <th>P</th>
                    <th>1 bag</th>
                    <th>L</th>
                    <th>P</th>
                    <th>1 bag</th>
                    <th>L</th>
                    <th>P</th>
                    <th>6 bag</th>
                    <th>L</th>
                    <th>P</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">Akhir bulan lalu</td>
                    @foreach(['I', 'II', 'III', 'IV', 'V', 'VI'] as $kelas)
                        <td>{{ $studentStats[$kelas]['L'] ?? 0 }}</td>
                        <td>{{ $studentStats[$kelas]['P'] ?? 0 }}</td>
                    @endforeach
                    <td>{{ array_sum(array_column($studentStats, 'L')) }}</td>
                    <td>{{ array_sum(array_column($studentStats, 'P')) }}</td>
                </tr>
                <tr>
                    <td class="text-left">Masuk bulan ini</td>
                    @for($i = 0; $i < 12; $i++)
                        <td>0</td>
                    @endfor
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td class="text-left">Keluar bulan ini</td>
                    @for($i = 0; $i < 12; $i++)
                        <td>0</td>
                    @endfor
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td class="text-left">Akhir bulan ini</td>
                    @foreach(['I', 'II', 'III', 'IV', 'V', 'VI'] as $kelas)
                        <td>{{ $studentStats[$kelas]['L'] ?? 0 }}</td>
                        <td>{{ $studentStats[$kelas]['P'] ?? 0 }}</td>
                    @endforeach
                    <td>{{ array_sum(array_column($studentStats, 'L')) }}</td>
                    <td>{{ array_sum(array_column($studentStats, 'P')) }}</td>
                </tr>
                <tr>
                    <td class="text-left">JMLH SEMUA</td>
                    @foreach(['I', 'II', 'III', 'IV', 'V', 'VI'] as $kelas)
                        <td>{{ ($studentStats[$kelas]['L'] ?? 0) + ($studentStats[$kelas]['P'] ?? 0) }}</td>
                        <td></td>
                        <td></td>
                    @endforeach
                    <td>{{ array_sum(array_column($studentStats, 'L')) + array_sum(array_column($studentStats, 'P')) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        {{-- Section B: Keadaan Inventaris Sekolah --}}
        <div class="section-title">B. KEADAAN INVENTARIS SEKOLAH</div>
        
        {{-- B.a. Tanah --}}
        <div style="margin-bottom: 3mm;"><strong>a. Tanah</strong></div>
        <table style="width: 60%;">
            <tr>
                <th>Milik</th>
                <th>Pemerintah</th>
                <th>Yayasan</th>
                <th>Perorangan</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td></td>
                <td>{{ $school->landAsset->government_owned ?? 0 }}</td>
                <td>{{ $school->landAsset->foundation_owned ?? 0 }}</td>
                <td>{{ $school->landAsset->individual_owned ?? 0 }}</td>
                <td>{{ ($school->landAsset->government_owned ?? 0) + ($school->landAsset->foundation_owned ?? 0) + ($school->landAsset->individual_owned ?? 0) }}</td>
            </tr>
        </table>
        
        <table style="width: 60%; margin-top: 2mm;">
            <tr>
                <th>Luasnya</th>
                <td>{{ $school->landAsset->area_size ?? '-' }} M²</td>
                <th>Thn. Pembelian</th>
                <td>{{ $school->landAsset->purchase_year ?? '-' }}</td>
            </tr>
            <tr>
                <th>Bukti Pemilikan</th>
                <td colspan="3">{{ $school->landAsset->ownership_proof ?? '-' }} {{ $school->landAsset->proof_number ? '(' . $school->landAsset->proof_number . ')' : '' }}</td>
            </tr>
        </table>

        {{-- B.b. Kondisi Bangunan Sekolah --}}
        <div style="margin-top: 5mm; margin-bottom: 3mm;"><strong>b. Kondisi Bangunan Sekolah</strong></div>
        <table>
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">Bangunan/ruang</th>
                    <th colspan="6" class="text-center">Kondisi</th>
                    <th rowspan="2" class="text-center align-middle">Jumlah</th>
                </tr>
                <tr>
                    <th>NSB</th>
                    <th>Baik</th>
                    <th>Rusak ringan</th>
                    <th>Rusak sedang</th>
                    <th>Rusak berat</th>
                    <th>total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($school->buildings as $building)
                    <tr>
                        <td class="text-left">{{ $building->room_type }}</td>
                        <td>{{ $building->condition_non_standard }}</td>
                        <td>{{ $building->condition_good }}</td>
                        <td>{{ $building->condition_light_damage }}</td>
                        <td>{{ $building->condition_medium_damage }}</td>
                        <td>{{ $building->condition_heavy_damage }}</td>
                        <td>{{ $building->condition_non_standard + $building->condition_good + $building->condition_light_damage + $building->condition_medium_damage + $building->condition_heavy_damage }}</td>
                        <td>{{ $building->quantity }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-left bold">Jumlah bangunan kelas : {{ $school->buildings->where('room_type', 'Ruang Kelas')->sum('quantity') }} bagian.</td>
                    <td colspan="6"></td>
                    <td>{{ $school->buildings->sum('quantity') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- B.c. Perkakas Sekolah --}}
        <div style="margin-top: 5mm; margin-bottom: 3mm;"><strong>c. KEADAAN PERKAKAS SEKOLAH :</strong></div>
        <table>
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">Nama perkakas</th>
                    <th colspan="4" class="text-center">KONDISI</th>
                    <th rowspan="2" class="text-center align-middle">JUMLAH</th>
                </tr>
                <tr>
                    <th>Baik</th>
                    <th>sedang</th>
                    <th>Rusak ringan</th>
                    <th>Rusak berat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($school->furniture as $item)
                    <tr>
                        <td class="text-left">{{ $item->item_name }}</td>
                        <td>{{ $item->condition_good }}</td>
                        <td>{{ $item->condition_medium }}</td>
                        <td>{{ $item->condition_light_damage }}</td>
                        <td>{{ $item->condition_heavy_damage }}</td>
                        <td>{{ $item->condition_good + $item->condition_medium + $item->condition_light_damage + $item->condition_heavy_damage }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Absensi dan Hari Efektif --}}
        <div style="margin-top: 5mm;">
            <table style="width: 60%;">
                <tr>
                    <th colspan="2">BANYAKNYA GURU/PENJAGA ASN</th>
                    <th colspan="2">Banyaknya Guru/Penjaga Sukwan</th>
                </tr>
                <tr>
                    <th>Pegawai</th>
                    <th>Lk</th>
                    <th>Pr</th>
                    <th>Jumlah</th>
                </tr>
                <tr>
                    <td>Kep. SD</td>
                    <td>{{ $teachers->where('position', 'Kepala Sekolah')->where('gender', 'L')->count() }}</td>
                    <td>{{ $teachers->where('position', 'Kepala Sekolah')->where('gender', 'P')->count() }}</td>
                    <td>{{ $teachers->where('position', 'Kepala Sekolah')->count() }}</td>
                </tr>
                <tr>
                    <td>Gr. Kelas</td>
                    <td>{{ $teachers->where('position', 'GK')->where('gender', 'L')->count() }}</td>
                    <td>{{ $teachers->where('position', 'GK')->where('gender', 'P')->count() }}</td>
                    <td>{{ $teachers->where('position', 'GK')->count() }}</td>
                </tr>
                <tr>
                    <td>Gr. Penjaskes</td>
                    <td>{{ $teachers->where('position', 'G PJOK')->where('gender', 'L')->count() }}</td>
                    <td>{{ $teachers->where('position', 'G PJOK')->where('gender', 'P')->count() }}</td>
                    <td>{{ $teachers->where('position', 'G PJOK')->count() }}</td>
                </tr>
                <tr>
                    <td>Gr. Agama</td>
                    <td>{{ $teachers->where('position', 'G PAI')->where('gender', 'L')->count() }}</td>
                    <td>{{ $teachers->where('position', 'G PAI')->where('gender', 'P')->count() }}</td>
                    <td>{{ $teachers->where('position', 'G PAI')->count() }}</td>
                </tr>
                <tr>
                    <td>Operator</td>
                    <td>{{ $teachers->where('position', 'OP')->where('gender', 'L')->count() }}</td>
                    <td>{{ $teachers->where('position', 'OP')->where('gender', 'P')->count() }}</td>
                    <td>{{ $teachers->where('position', 'OP')->count() }}</td>
                </tr>
                <tr>
                    <td class="bold">Jumlah</td>
                    <td class="bold">{{ $teachers->where('employment_status', 'ASN')->where('gender', 'L')->count() }}</td>
                    <td class="bold">{{ $teachers->where('employment_status', 'ASN')->where('gender', 'P')->count() }}</td>
                    <td class="bold">{{ $totalASN }}</td>
                </tr>
            </table>
        </div>

        {{-- Section C: Keadaan Guru-Guru --}}
        <div style="page-break-before: always;"></div>
        <div class="section-title">C. KEADAAN GURU-GURU</div>
        
        <table>
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">NO</th>
                    <th rowspan="2" class="text-center align-middle">NAMA GURU-GURU</th>
                    <th rowspan="2" class="text-center align-middle">NIP</th>
                    <th rowspan="2" class="text-center align-middle">L/P</th>
                    <th rowspan="2" class="text-center align-middle">AGAMA</th>
                    <th rowspan="2" class="text-center align-middle">K/TK</th>
                    <th colspan="2" class="text-center">IJAZAH / TAHUN</th>
                    <th rowspan="2" class="text-center align-middle">JABATAN</th>
                    <th colspan="3" class="text-center">TMT</th>
                    <th rowspan="2" class="text-center align-middle">MENGAJAR DI KELAS</th>
                    <th colspan="2" class="text-center">MK di SD ini</th>
                    <th colspan="2" class="text-center">MK Seluruh</th>
                    <th rowspan="2" class="text-center align-middle">GOL (TMT)</th>
                    <th colspan="2" class="text-center">MK GOL</th>
                    <th colspan="4" class="text-center">ABSENSI GURU</th>
                    <th rowspan="2" class="text-center align-middle">KETR</th>
                </tr>
                <tr>
                    <th>Awal PNS</th>
                    <th>Sekarang</th>
                    <th>CPNS</th>
                    <th>PNS/PPPK/PW</th>
                    <th>Di SD ini</th>
                    <th>Thn</th>
                    <th>Bln</th>
                    <th>Thn</th>
                    <th>Bln</th>
                    <th>Thn</th>
                    <th>Bln</th>
                    <th>S</th>
                    <th>I</th>
                    <th>A</th>
                    <th>Jml</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $index => $teacher)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $teacher->name }}</td>
                        <td>{{ $teacher->nip ?? '-' }}</td>
                        <td>{{ $teacher->gender }}</td>
                        <td>{{ $teacher->religion ?? '-' }}</td>
                        <td>{{ $teacher->marital_status ?? '-' }}</td>
                        <td>{{ $teacher->education_initial ?? '-' }}</td>
                        <td>{{ $teacher->education_current ?? '-' }}</td>
                        <td>{{ $teacher->position }}</td>
                        <td>{{ $teacher->tmt_cpns ? \Carbon\Carbon::parse($teacher->tmt_cpns)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $teacher->tmt_pns ? \Carbon\Carbon::parse($teacher->tmt_pns)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $teacher->tmt_school ? \Carbon\Carbon::parse($teacher->tmt_school)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $teacher->teaching_class ?? '-' }}</td>
                        <td>{{ $teacher->mk_school_years }}</td>
                        <td>{{ $teacher->mk_school_months }}</td>
                        <td>{{ $teacher->mk_total_years }}</td>
                        <td>{{ $teacher->mk_total_months }}</td>
                        <td>{{ $teacher->golongan ?? '-' }}</td>
                        <td>{{ $teacher->mk_golongan_years }}</td>
                        <td>{{ $teacher->mk_golongan_months }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ $teacher->employment_status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Signature Section --}}
        <div class="signature-section">
            <div style="text-align: left; margin-bottom: 3mm;">
                <strong>CATATAN UNTUK KOLOM JABATAN</strong><br>
                Nama Guru diurutkan sesuai DUK, kecuali nama Kepala Sekolah (nomor urut 1)<br>
                1. GK = Guru Kelas<br>
                2. G PAI = Guru Pendidikan Agama<br>
                3. G OR = Guru Olahraga<br>
                4. OP = Operator<br>
                5. Pj = Penjaga Sekolah<br>
                Guru GTT atau Guru Sukwan (non PNS) diisikan pada kolom keterangan
            </div>
            
            <div style="margin-top: 10mm;">
                <div style="float: left; width: 45%; text-align: left;">
                    Mengetahui<br>
                    Koordinator Pengawas SD<br>
                    Kecamatan Lebak Wangi
                    <div style="margin-top: 25mm;">
                        <strong>_________________________</strong><br>
                        NIP. _____________________
                    </div>
                </div>
                
                <div style="float: right; width: 45%; text-align: center;">
                    Lebak Wangi, {{ \Carbon\Carbon::parse($report->created_at)->format('d F Y') }}<br>
                    Kepala {{ $school->getFullNameAttribute() }}
                    <div style="margin-top: 25mm;">
                        <strong>{{ $school->principal->name ?? '_________________________' }}</strong><br>
                        NIP. {{ $school->principal->nip ?? '_____________________' }}
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</body>
</html>