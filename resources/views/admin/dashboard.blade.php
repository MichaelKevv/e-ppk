@extends('admin.layouts.template')
@section('title', 'Dashboard')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div id="content" class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
                <p class="mb-4">
                    Selamat datang di Sistem Informasi Pengaduan Perundungan (SIPERU). Pantau statistik dan aktivitas terbaru di sini.
                </p>
            </div>

            @if(Auth::user()->role == 'siswa')
                <!-- Dashboard untuk Siswa -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Total Pengaduan</p>
                                    <h4 class="mb-0">{{ $data['totalPengaduan'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">report</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">Jumlah pengaduan yang telah dibuat</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Dalam Proses</p>
                                    <h4 class="mb-0">{{ $data['pengaduanDiproses'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-warning shadow-warning shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">pending</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">Pengaduan sedang diproses</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Selesai</p>
                                    <h4 class="mb-0">{{ $data['pengaduanSelesai'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">check_circle</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">Pengaduan telah diselesaikan</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Feedback</p>
                                    <h4 class="mb-0">{{ $data['feedbackDiterima'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">feedback</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">Feedback yang diterima</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Dashboard untuk Admin/Petugas/Kepala Sekolah -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Total Siswa</p>
                                    <h4 class="mb-0">{{ $data['totalSiswa'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">school</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">Jumlah siswa terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Total Pengaduan</p>
                                    <h4 class="mb-0">{{ $data['totalPengaduan'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-warning shadow-warning shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">report</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">
                                <span class="text-success">{{ $data['pengaduanBulanIni'] ?? 0 }}</span> pengaduan bulan ini
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Total Feedback</p>
                                    <h4 class="mb-0">{{ $data['totalFeedback'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">feedback</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">
                                <span class="text-success">{{ $data['feedbackBulanIni'] ?? 0 }}</span> feedback bulan ini
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Total Artikel</p>
                                    <h4 class="mb-0">{{ $data['totalArtikel'] ?? 0 }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">article</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">Artikel edukasi perundungan</p>
                        </div>
                    </div>
                </div>

                <!-- Statistik Tambahan untuk Admin -->
                <div class="col-12 mt-4">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header p-2 ps-3">
                                    <h6 class="mb-0">Status Pengaduan</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Baru</span>
                                        <span class="badge bg-primary">{{ $data['pengaduanBaru'] ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Diproses</span>
                                        <span class="badge bg-warning">{{ $data['pengaduanDiproses'] ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Selesai</span>
                                        <span class="badge bg-success">{{ $data['pengaduanSelesai'] ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header p-2 ps-3">
                                    <h6 class="mb-0">Klasifikasi Pengaduan</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Ringan</span>
                                        <span class="badge bg-success">{{ $data['pengaduanRingan'] ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Sedang</span>
                                        <span class="badge bg-warning">{{ $data['pengaduanSedang'] ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Berat</span>
                                        <span class="badge bg-danger">{{ $data['pengaduanBerat'] ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header p-2 ps-3">
                                    <h6 class="mb-0">Aksi Cepat</h6>
                                </div>
                                <div class="card-body p-3">
                                    <a href="{{ route('admin.pengaduan.create') }}" class="btn btn-primary btn-sm w-100 mb-2">
                                        <i class="material-symbols-rounded opacity-10 me-1" style="font-size: 16px;">add</i>
                                        Buat Pengaduan
                                    </a>
                                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-info btn-sm w-100 mb-2">
                                        <i class="material-symbols-rounded opacity-10 me-1" style="font-size: 16px;">list</i>
                                        Lihat Semua Pengaduan
                                    </a>
                                    @if(Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                    <a href="{{ route('admin.pengaduan.export') }}" class="btn btn-success btn-sm w-100">
                                        <i class="material-symbols-rounded opacity-10 me-1" style="font-size: 16px;">download</i>
                                        Export Laporan
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Chart Section -->
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <h6 class="mb-0">Statistik Pengaduan Tahun {{ date('Y') }}</h6>
                    </div>
                    <br>
                    <br>
                    <br>
        @include('admin.includes.footer')
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart
    const ctx = document.getElementById('pengaduanChart').getContext('2d');
    
    // Ambil data dari controller via AJAX - PERBAIKI ROUTE DI SINI
   fetch('/dashboard/pengaduan-data')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const pengaduanChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Jumlah Pengaduan',
                        data: data,
                        borderColor: '#e91e63',
                        backgroundColor: 'rgba(233, 30, 99, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Grafik Pengaduan Per Bulan'
                        }
                    },
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
        })
        .catch(error => {
            console.error('Error loading chart data:', error);
            // Fallback data jika API error
            const fallbackData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            const pengaduanChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Jumlah Pengaduan',
                        data: fallbackData,
                        borderColor: '#e91e63',
                        backgroundColor: 'rgba(233, 30, 99, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Grafik Pengaduan Per Bulan'
                        }
                    },
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
        });

    // Auto refresh stats setiap 30 detik
    setInterval(function() {
       fetch('/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                console.log('Stats updated:', data);
            })
            .catch(error => console.error('Error updating stats:', error));
    }, 30000);
});
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
.icon-shape {
    border-radius: 12px;
}
.bg-gradient-primary { background: linear-gradient(195deg, #49a3f1, #1A73E8); }
.bg-gradient-warning { background: linear-gradient(195deg, #FB8C00, #FF9800); }
.bg-gradient-success { background: linear-gradient(195deg, #66BB6A, #4CAF50); }
.bg-gradient-info { background: linear-gradient(195deg, #26C6DA, #00ACC1); }
</style>
@endpush