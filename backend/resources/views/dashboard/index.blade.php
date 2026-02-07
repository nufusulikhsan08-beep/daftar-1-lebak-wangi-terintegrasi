@extends('layouts.app')

@section('title', 'Dashboard - Daftar 1 Digital')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h2 class="card-title mb-0">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </h2>
                <p class="card-text mb-0">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Card: Data Sekolah --}}
    <div class="col-md-3 mb-4">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <div class="display-4 text-primary mb-2">
                    <i class="bi bi-building"></i>
                </div>
                <h5 class="card-title">Data Sekolah</h5>
                <p class="card-text display-6 fw-bold text-primary">
                    {{ $totalSchools }}
                </p>
                <a href="{{ route('schools.index') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>

    {{-- Card: Total Siswa --}}
    <div class="col-md-3 mb-4">
        <div class="card border-success h-100">
            <div class="card-body text-center">
                <div class="display-4 text-success mb-2">
                    <i class="bi bi-people"></i>
                </div>
                <h5 class="card-title">Total Siswa</h5>
                <p class="card-text display-6 fw-bold text-success">
                    {{ $totalStudents }}
                </p>
                <a href="{{ route('schools.students.index', ['schoolId' => auth()->user()->school_id]) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>

    {{-- Card: Total Guru --}}
    <div class="col-md-3 mb-4">
        <div class="card border-info h-100">
            <div class="card-body text-center">
                <div class="display-4 text-info mb-2">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <h5 class="card-title">Total Guru</h5>
                <p class="card-text display-6 fw-bold text-info">
                    {{ $totalTeachers }}
                </p>
                <a href="{{ route('schools.teachers.index', ['schoolId' => auth()->user()->school_id]) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>

    {{-- Card: Laporan Bulanan --}}
    <div class="col-md-3 mb-4">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <div class="display-4 text-warning mb-2">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h5 class="card-title">Laporan Bulan Ini</h5>
                <p class="card-text display-6 fw-bold text-warning">
                    {{ $monthlyReports }}
                </p>
                <a href="{{ route('schools.reports.monthly.index', ['schoolId' => auth()->user()->school_id]) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Statistik Siswa per Kelas</h5>
            </div>
            <div class="card-body">
                <canvas id="studentChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Status Ekonomi Siswa</h5>
            </div>
            <div class="card-body">
                <canvas id="economicChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Laporan Bulanan Terbaru</h5>
            </div>
            <div class="card-body">
                @if($latestReports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bulan/Tahun</th>
                                    <th>Status</th>
                                    <th>Absen Siswa</th>
                                    <th>Absen Guru</th>
                                    <th>Hari Efektif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestReports as $report)
                                    <tr>
                                        <td><strong>{{ $report->month }} {{ $report->year }}</strong></td>
                                        <td>
                                            @if($report->status == 'draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @elseif($report->status == 'submitted')
                                                <span class="badge bg-warning">Dikirim</span>
                                            @else
                                                <span class="badge bg-success">Disetujui</span>
                                            @endif
                                        </td>
                                        <td>{{ $report->student_absent_total }}</td>
                                        <td>{{ $report->teacher_absent_total + $report->non_pns_absent_total }}</td>
                                        <td>{{ $report->effective_days }}</td>
                                        <td>
                                            <a href="{{ route('schools.reports.monthly.show', [auth()->user()->school_id, $report->id]) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Belum ada laporan bulanan.
                        <a href="{{ route('schools.reports.monthly.create', auth()->user()->school_id) }}" 
                           class="btn btn-primary btn-sm mt-2">
                            <i class="bi bi-plus"></i> Buat Laporan Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
$(document).ready(function() {
    // Student Chart
    var ctx1 = document.getElementById('studentChart').getContext('2d');
    var studentChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Kelas I', 'Kelas II', 'Kelas III', 'Kelas IV', 'Kelas V', 'Kelas VI'],
            datasets: [{
                label: 'Laki-laki',
                data: @json($studentStatsByClass['L'] ?? [0,0,0,0,0,0]),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Perempuan',
                data: @json($studentStatsByClass['P'] ?? [0,0,0,0,0,0]),
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }
    });

    // Economic Status Chart
    var ctx2 = document.getElementById('economicChart').getContext('2d');
    var economicChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Mampu', 'Sedang', 'Tidak Mampu'],
            datasets: [{
                data: @json([$economicStats['Mampu'] ?? 0, $economicStats['Sedang'] ?? 0, $economicStats['Tidak Mampu'] ?? 0]),
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush