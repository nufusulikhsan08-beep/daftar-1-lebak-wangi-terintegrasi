@extends('layouts.app')

@section('title', 'Buat Laporan Daftar 1 Bulanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-file-earmark-plus"></i> 
                    Form Laporan Daftar 1 Bulanan
                </h4>
                <small class="text-white">Sekolah: {{ $school->name }}</small>
            </div>
            
            <div class="card-body">
                <form action="{{ route('schools.reports.monthly.store', $school->id) }}" method="POST">
                    @csrf
                    
                    {{-- Section: Identitas Sekolah --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-info-circle"></i> Identitas Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Sekolah</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $school->name }}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">NPSN</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $school->npsn }}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control" 
                                           value="{{ ucfirst($school->status) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Periode Laporan --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-calendar"></i> Periode Laporan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bulan <span class="text-danger">*</span></label>
                                    <select name="month" class="form-select @error('month') is-invalid @enderror" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach($months as $index => $month)
                                            <option value="{{ $month }}" 
                                                    @if($index + 1 == $currentMonth) selected @endif>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" 
                                           value="{{ old('year', $currentYear) }}" min="2000" max="{{ date('Y') + 1 }}" required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            @if($existingReport)
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i> 
                                    Laporan untuk periode ini sudah ada. Data akan diperbarui.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Section: Data Siswa per Kelas --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-people"></i> Data Siswa per Kelas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2" class="align-middle">Kelas</th>
                                            <th colspan="2" class="text-center">Jumlah Siswa</th>
                                            <th colspan="4" class="text-center">Perubahan Bulan Ini</th>
                                        </tr>
                                        <tr>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>Akhir Bulan Lalu</th>
                                            <th>Masuk</th>
                                            <th>Keluar</th>
                                            <th>Akhir Bulan Ini</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $kelasList = ['I', 'II', 'III', 'IV', 'V', 'VI'];
                                        @endphp
                                        @foreach($kelasList as $kelas)
                                            <tr>
                                                <td><strong>{{ $kelas }}</strong></td>
                                                <td>
                                                    <input type="number" name="student_changes[{{ $kelas }}][L]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("student_changes.$kelas.L", 0) }}" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" name="student_changes[{{ $kelas }}][P]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("student_changes.$kelas.P", 0) }}" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" name="student_changes[{{ $kelas }}][akhir_lalu]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("student_changes.$kelas.akhir_lalu", 0) }}" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" name="student_changes[{{ $kelas }}][masuk]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("student_changes.$kelas.masuk", 0) }}" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" name="student_changes[{{ $kelas }}][keluar]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("student_changes.$kelas.keluar", 0) }}" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" name="student_changes[{{ $kelas }}][akhir_ini]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("student_changes.$kelas.akhir_ini", 0) }}" min="0">
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        <tr class="table-primary">
                                            <td><strong>JUMLAH</strong></td>
                                            <td><strong id="totalL">0</strong></td>
                                            <td><strong id="totalP">0</strong></td>
                                            <td colspan="4"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Absensi Siswa --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-calendar-x"></i> Absensi Siswa Bulan Ini</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Sakit (S)</label>
                                    <input type="number" name="student_absent_sick" 
                                           class="form-control @error('student_absent_sick') is-invalid @enderror" 
                                           value="{{ old('student_absent_sick', 0) }}" min="0">
                                    @error('student_absent_sick')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Ijin (I)</label>
                                    <input type="number" name="student_absent_permit" 
                                           class="form-control @error('student_absent_permit') is-invalid @enderror" 
                                           value="{{ old('student_absent_permit', 0) }}" min="0">
                                    @error('student_absent_permit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Alpa (A)</label>
                                    <input type="number" name="student_absent_alpha" 
                                           class="form-control @error('student_absent_alpha') is-invalid @enderror" 
                                           value="{{ old('student_absent_alpha', 0) }}" min="0">
                                    @error('student_absent_alpha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="studentAbsentTotal" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Absensi Guru --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-person-x"></i> Absensi Guru/Pegawai Bulan Ini</h6>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Guru ASN</h6>
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Sakit (S)</label>
                                    <input type="number" name="teacher_absent_sick" 
                                           class="form-control @error('teacher_absent_sick') is-invalid @enderror" 
                                           value="{{ old('teacher_absent_sick', 0) }}" min="0">
                                    @error('teacher_absent_sick')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Ijin (I)</label>
                                    <input type="number" name="teacher_absent_permit" 
                                           class="form-control @error('teacher_absent_permit') is-invalid @enderror" 
                                           value="{{ old('teacher_absent_permit', 0) }}" min="0">
                                    @error('teacher_absent_permit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Alpa (A)</label>
                                    <input type="number" name="teacher_absent_alpha" 
                                           class="form-control @error('teacher_absent_alpha') is-invalid @enderror" 
                                           value="{{ old('teacher_absent_alpha', 0) }}" min="0">
                                    @error('teacher_absent_alpha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="teacherAbsentTotal" readonly>
                                </div>
                            </div>

                            <h6 class="mb-3">Guru Sukwan</h6>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Sakit (S)</label>
                                    <input type="number" name="non_pns_absent_sick" 
                                           class="form-control @error('non_pns_absent_sick') is-invalid @enderror" 
                                           value="{{ old('non_pns_absent_sick', 0) }}" min="0">
                                    @error('non_pns_absent_sick')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Ijin (I)</label>
                                    <input type="number" name="non_pns_absent_permit" 
                                           class="form-control @error('non_pns_absent_permit') is-invalid @enderror" 
                                           value="{{ old('non_pns_absent_permit', 0) }}" min="0">
                                    @error('non_pns_absent_permit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Alpa (A)</label>
                                    <input type="number" name="non_pns_absent_alpha" 
                                           class="form-control @error('non_pns_absent_alpha') is-invalid @enderror" 
                                           value="{{ old('non_pns_absent_alpha', 0) }}" min="0">
                                    @error('non_pns_absent_alpha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="nonPnsAbsentTotal" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Hari Efektif --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-calendar-check"></i> Hari Efektif Belajar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Hari Efektif dalam Bulan Ini</label>
                                    <input type="number" name="effective_days" 
                                           class="form-control @error('effective_days') is-invalid @enderror" 
                                           value="{{ old('effective_days', 0) }}" min="0" max="31">
                                    @error('effective_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Status Laporan --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-info-circle"></i> Status Laporan</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="status" id="statusDraft" 
                                       value="draft" checked>
                                <label class="form-check-label" for="statusDraft">
                                    <strong>Draft</strong> - Simpan sebagai draft, bisa diedit lagi nanti
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusSubmitted" 
                                       value="submitted">
                                <label class="form-check-label" for="statusSubmitted">
                                    <strong>Kirim ke Dinas</strong> - Kirim laporan ke Dinas Pendidikan (tidak bisa diedit setelah dikirim)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('schools.reports.monthly.index', $school->id) }}" 
                           class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    // Auto calculate student absent total
    function calculateStudentAbsentTotal() {
        var sick = parseInt($('input[name="student_absent_sick"]').val()) || 0;
        var permit = parseInt($('input[name="student_absent_permit"]').val()) || 0;
        var alpha = parseInt($('input[name="student_absent_alpha"]').val()) || 0;
        var total = sick + permit + alpha;
        $('#studentAbsentTotal').val(total);
    }

    // Auto calculate teacher absent total
    function calculateTeacherAbsentTotal() {
        var sick = parseInt($('input[name="teacher_absent_sick"]').val()) || 0;
        var permit = parseInt($('input[name="teacher_absent_permit"]').val()) || 0;
        var alpha = parseInt($('input[name="teacher_absent_alpha"]').val()) || 0;
        var total = sick + permit + alpha;
        $('#teacherAbsentTotal').val(total);
    }

    // Auto calculate non-PNS absent total
    function calculateNonPnsAbsentTotal() {
        var sick = parseInt($('input[name="non_pns_absent_sick"]').val()) || 0;
        var permit = parseInt($('input[name="non_pns_absent_permit"]').val()) || 0;
        var alpha = parseInt($('input[name="non_pns_absent_alpha"]').val()) || 0;
        var total = sick + permit + alpha;
        $('#nonPnsAbsentTotal').val(total);
    }

    // Auto calculate student totals per class
    function calculateStudentTotals() {
        var totalL = 0, totalP = 0;
        
        @foreach($kelasList as $kelas)
            totalL += parseInt($('input[name="student_changes[{{ $kelas }}][L]"]').val()) || 0;
            totalP += parseInt($('input[name="student_changes[{{ $kelas }}][P]"]').val()) || 0;
        @endforeach
        
        $('#totalL').text(totalL);
        $('#totalP').text(totalP);
    }

    // Event listeners
    $('input[name^="student_absent_"]').on('input', calculateStudentAbsentTotal);
    $('input[name^="teacher_absent_"]').on('input', calculateTeacherAbsentTotal);
    $('input[name^="non_pns_absent_"]').on('input', calculateNonPnsAbsentTotal);
    $('input[name^="student_changes"]').on('input', calculateStudentTotals);

    // Initial calculations
    calculateStudentAbsentTotal();
    calculateTeacherAbsentTotal();
    calculateNonPnsAbsentTotal();
    calculateStudentTotals();
});
</script>
@endpush