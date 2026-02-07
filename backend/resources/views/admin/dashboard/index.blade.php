@extends('layouts.app')

@section('title', 'Dashboard Admin - Daftar 1 Digital')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h2 class="card-title mb-0">
                    <i class="bi bi-speedometer2"></i> Dashboard Admin
                </h2>
                <p class="card-text mb-0">Monitoring Daftar 1 Digital - Kecamatan Lebak Wangi</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Card: Total Sekolah --}}
    <div class="col-md-3 mb-4">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <div class="display-4 text-primary mb-2">
                    <i class="bi bi-building"></i>
                </div>
                <h5 class="card-title">Total Sekolah</h5>
                <p class="card-text display-6 fw-bold text-primary">
                    {{ $totalSchools }}
                </p>
                <div class="mt-2">
                    <small>Negeri: {{ $schoolsByStatus['negeri'] ?? 0 }}</small><br>
                    <small>Swasta: {{ $schoolsByStatus['swasta'] ?? 0 }}</small>
                </div>
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
                <h5 class="card-title">Total Siswa Aktif</h5>
                <p class="card-text display-6 fw-bold text-success">
                    {{ $totalStudents }}
                </p>
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
            </div>
        </div>
    </div>

    {{-- Card: Laporan Bulan Ini --}}
    <div class="col-md-3 mb-4">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <div class="display-4 text-warning mb-2">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h5 class="card-title">Laporan {{ $currentMonthName }} {{ $currentYear }}</h5>
                <p class="card-text display-6 fw-bold text-warning">
                    {{ $reportsThisMonth }}
                </p>
                <div class="mt-2">
                    <small>Dikirim: {{ $reportsByStatus['submitted'] ?? 0 }}</small><br>
                    <small>Disetujui: {{ $reportsByStatus['approved'] ?? 0 }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Monitoring Laporan Bulanan {{ $currentYear }}</h5>
                <span class="badge bg-light text-dark">{{ $complianceRate }}% Kepatuhan</span>
            </div>
            <div class="card-body">
                <canvas id="monitoringChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Top 5 Sekolah (Siswa Terbanyak)</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($topSchools as $index => $school)
                        <a href="{{ route('admin.schools.detail', $school->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $index + 1 }}. {{ $school->name }}</strong><br>
                                    <small class="text-muted">{{ $school->npsn }}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $school->students_count }} siswa
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Laporan Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recentReports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sekolah</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReports as $index => $report)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $report->school->name }}</strong></td>
                                        <td>{{ $report->month }} {{ $report->year }}</td>
                                        <td>
                                            @if($report->status == 'draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @elseif($report->status == 'submitted')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @else
                                                <span class="badge bg-success">Disetujui</span>
                                            @endif
                                        </td>
                                        <td>{{ $report->submitted_at ? $report->submitted_at->format('d/m/Y H:i') : '-' }}</td>
                                        <td>
                                            <a href="{{ route('schools.reports.monthly.show', [$report->school_id, $report->id]) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            @if($report->status == 'submitted')
                                                <form action="{{ route('admin.reports.monthly.approve', $report->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Setujui laporan ini?')">
                                                        <i class="bi bi-check-circle"></i> Setujui
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Belum ada laporan yang masuk.
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
    // Fetch monitoring data
    $.ajax({
        url: '{{ route('admin.dashboard.monitoring') }}',
        method: 'GET',
        success: function(data) {
            var months = data.map(item => item.month);
            var submitted = data.map(item => item.submitted);
            var approved = data.map(item => item.approved);
            
            var ctx = document.getElementById('monitoringChart').getContext('2d');
            var monitoringChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Dikirim',
                        data: submitted,
                        backgroundColor: 'rgba(255, 193, 7, 0.7)',
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Disetujui',
                        data: approved,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    });
});
</script>
@endpush