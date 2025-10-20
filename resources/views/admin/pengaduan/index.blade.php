@extends('admin.layouts.template')
@section('title', 'Pengaduan')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pengaduan</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-3 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 text-white">Data Pengaduan</h6>
                                <p class="text-sm mb-0 text-white">Kelola semua pengaduan perundungan yang masuk</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary">
                                    <i class="bi bi-list-ul me-1"></i>
                                    Total: {{ $data->count() }}
                                </span>
                                @if(Auth::user()->role == 'siswa' || Auth::user()->role == 'admin')
                                <a href="{{ route('admin.pengaduan.create') }}" class="btn btn-primary btn-sm">
                                    Buat Pengaduan Baru
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 pt-0">
                        <!-- Filter Section -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="ms-0">Status</label>
                                    <select class="form-control form-select-sm" id="filterStatus">
                                        <option value="">Semua Status</option>
                                        <option value="dibuka">Baru</option>
                                        <option value="diproses">Diproses</option>
                                        <option value="ditutup">Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="ms-0">Klasifikasi</label>
                                    <select class="form-control form-select-sm" id="filterKlasifikasi">
                                        <option value="">Semua Klasifikasi</option>
                                        <option value="ringan">Ringan</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="berat">Berat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static">
                                    <label class="ms-0">Pencarian</label>
                                    <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Cari berdasarkan bentuk perundungan atau lokasi...">
                                </div>
                            </div>
                        </div>

                        <!-- Desktop View -->
                        <div class="d-none d-lg-block">
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center mb-0" id="pengaduanTable">
                                    <thead>
                                        <tr>
                                            @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah' || Auth::user()->role == 'admin')
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <span>Pelapor</span>
                                                        <i class="bi bi-arrow-down-up text-xs ms-1 opacity-6"></i>
                                                    </div>
                                                </th>
                                            @endif
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                <div class="d-flex align-items-center">
                                                    <span>Jenis Kasus</span>
                                                </div>
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Frekuensi
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Tingkat
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Tanggal
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Status
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $pengaduan)
                                            <tr class="pengaduan-row">
                                                @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah' || Auth::user()->role == 'admin')
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm me-3">
                                                                <div class="bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                                    <i class="bi bi-person-fill text-xs"></i>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <h6 class="mb-0 text-sm">{{ $pengaduan->siswa->nama ?? 'N/A' }}</h6>
                                                                <p class="text-xs text-secondary mb-0">{{ $pengaduan->siswa->kelas ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-sm font-weight-bold mb-0 text-capitalize">
                                                            {{ str_replace('_', ' ', $pengaduan->bentuk_perundungan) }}
                                                        </span>
                                                        @if($pengaduan->lokasi)
                                                        <span class="text-xs text-secondary">
                                                            <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($pengaduan->lokasi, 30) }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-sm text-capitalize">
                                                        {{ str_replace('_', ' ', $pengaduan->frekuensi_kejadian) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm 
                                                        @if($pengaduan->klasifikasi == 'ringan') bg-success
                                                        @elseif($pengaduan->klasifikasi == 'sedang') bg-warning
                                                        @else bg-danger
                                                        @endif">
                                                        <i class="bi bi-flag me-1"></i>{{ $pengaduan->klasifikasi }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-sm font-weight-bold">
                                                        {{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMM YYYY') }}
                                                    </span>
                                                    <br>
                                                    <span class="text-xs text-secondary">
                                                        {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('H:i') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm 
                                                        @if($pengaduan->status == 'ditutup') bg-secondary
                                                        @elseif($pengaduan->status == 'diproses') bg-info
                                                        @else bg-primary
                                                        @endif">
                                                        @if($pengaduan->status == 'ditutup')
                                                            <i class="bi bi-check-circle me-1"></i>
                                                        @elseif($pengaduan->status == 'diproses')
                                                            <i class="bi bi-clock me-1"></i>
                                                        @else
                                                            <i class="bi bi-eye me-1"></i>
                                                        @endif
                                                        {{ $pengaduan->status ?? 'dibuka' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                           class="btn btn-info btn-sm px-3 py-1"
                                                           data-bs-toggle="tooltip" data-bs-title="Lihat Detail">
                                                            Detail
                                                        </a>
                                                        
                                                        <!-- Aksi untuk Siswa dan Admin -->
                                                        @if (Auth::user()->role == 'siswa' || Auth::user()->role == 'admin')
                                                            <a href="{{ route('admin.pengaduan.edit', $pengaduan->id_pengaduan) }}"
                                                               class="btn btn-warning btn-sm px-3 py-1"
                                                               data-bs-toggle="tooltip" data-bs-title="Edit Pengaduan">
                                                                Edit
                                                            </a>
                                                            
                                                            <a href="{{ route('admin.pengaduan.destroy', $pengaduan->id_pengaduan) }}"
                                                               class="btn btn-danger btn-sm px-3 py-1"
                                                               data-confirm-delete="true"
                                                               data-bs-toggle="tooltip" data-bs-title="Hapus Pengaduan">
                                                               Hapus
                                                            </a>
                                                            
                                                            @if ($pengaduan->status != 'ditutup')
                                                                <form action="{{ route('admin.pengaduan.selesai', $pengaduan->id_pengaduan) }}"
                                                                      method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" 
                                                                            class="btn btn-success btn-sm px-3 py-1"
                                                                            data-bs-toggle="tooltip" 
                                                                            data-bs-title="Tandai Selesai"
                                                                            onclick="return confirm('Tandai pengaduan sebagai selesai?')">
                                                                        Tandai Selesai
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endif

                                                        <!-- Aksi untuk Petugas dan Kepala Sekolah (hanya lihat detail) -->
                                                        @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                                            @if(Auth::user()->role == 'petugas' && $pengaduan->status != 'ditutup')
                                                                <a href="{{ url('feedback/create/' . $pengaduan->id_pengaduan) }}"
                                                                   class="btn btn-success btn-sm px-3 py-1"
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-title="Berikan Feedback">
                                                                    <i class="bi bi-chat-dots"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ in_array(Auth::user()->role, ['siswa', 'admin']) ? 6 : 7 }}" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                                                        <h6 class="text-muted">Belum ada pengaduan</h6>
                                                        @if(Auth::user()->role == 'siswa' || Auth::user()->role == 'admin')
                                                        <p class="text-sm text-muted mb-3">Mulai buat pengaduan pertama Anda</p>
                                                        <a href="{{ route('admin.pengaduan.create') }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-plus-circle me-1"></i>
                                                            Buat Pengaduan
                                                        </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Summary Info -->
                            @if($data->count() > 0)
                            <div class="card-footer px-3 border-0 bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-sm text-secondary mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Menampilkan {{ $data->count() }} pengaduan
                                    </p>
                                    <div class="text-sm text-secondary">
                                        @php
                                            $statusCounts = $data->groupBy('status')->map->count();
                                        @endphp
                                        <span class="me-3">
                                            <i class="bi bi-circle-fill text-primary me-1"></i>Baru: {{ $statusCounts['dibuka'] ?? 0 }}
                                        </span>
                                        <span class="me-3">
                                            <i class="bi bi-circle-fill text-info me-1"></i>Diproses: {{ $statusCounts['diproses'] ?? 0 }}
                                        </span>
                                        <span>
                                            <i class="bi bi-circle-fill text-secondary me-1"></i>Selesai: {{ $statusCounts['ditutup'] ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Mobile View -->
                        <div class="d-lg-none">
                            <div class="row g-3">
                                @forelse ($data as $pengaduan)
                                <div class="col-12 pengaduan-mobile">
                                    <div class="card card-mobile shadow-sm border-0">
                                        <div class="card-body">
                                            <!-- Header -->
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="flex-grow-1 me-2">
                                                    <h6 class="card-title mb-1 text-capitalize text-primary">
                                                        {{ str_replace('_', ' ', $pengaduan->bentuk_perundungan) }}
                                                    </h6>
                                                    @if($pengaduan->lokasi)
                                                    <p class="text-xs text-muted mb-0">
                                                        <i class="bi bi-geo-alt me-1"></i>{{ $pengaduan->lokasi }}
                                                    </p>
                                                    @endif
                                                </div>
                                                <span class="badge 
                                                    @if($pengaduan->status == 'ditutup') bg-secondary
                                                    @elseif($pengaduan->status == 'diproses') bg-info
                                                    @else bg-primary
                                                    @endif">
                                                    {{ $pengaduan->status ?? 'dibuka' }}
                                                </span>
                                            </div>
                                            
                                            <!-- Info Siswa -->
                                            @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah' || Auth::user()->role == 'admin')
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-person-fill text-xs"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $pengaduan->siswa->nama ?? 'N/A' }}</p>
                                                    <p class="text-xs text-muted mb-0">{{ $pengaduan->siswa->kelas ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <!-- Detail Info -->
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <div class="bg-light rounded p-2 text-center">
                                                        <p class="text-xs text-muted mb-1">Frekuensi</p>
                                                        <p class="text-sm font-weight-bold mb-0 text-capitalize">
                                                            {{ str_replace('_', ' ', $pengaduan->frekuensi_kejadian) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="bg-light rounded p-2 text-center">
                                                        <p class="text-xs text-muted mb-1">Tingkat</p>
                                                        <span class="badge 
                                                            @if($pengaduan->klasifikasi == 'ringan') bg-success
                                                            @elseif($pengaduan->klasifikasi == 'sedang') bg-warning
                                                            @else bg-danger
                                                            @endif">
                                                            {{ $pengaduan->klasifikasi }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Timestamp -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="text-xs text-muted">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMM YYYY HH:mm') }}
                                                </span>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="d-flex gap-2 flex-wrap">
                                                <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                   class="btn btn-outline-info btn-sm flex-fill">
                                                    Detail
                                                </a>
                                                
                                                <!-- Aksi untuk Siswa dan Admin -->
                                                @if (Auth::user()->role == 'siswa' || Auth::user()->role == 'admin')
                                                    <a href="{{ route('admin.pengaduan.edit', $pengaduan->id_pengaduan) }}"
                                                       class="btn btn-outline-warning btn-sm">
                                                        Edit
                                                    </a>
                                                    
                                                    <a href="{{ route('admin.pengaduan.destroy', $pengaduan->id_pengaduan) }}"
                                                       class="btn btn-outline-danger btn-sm"
                                                       data-confirm-delete="true">
                                                        Hapus
                                                    </a>
                                                    
                                                    @if ($pengaduan->status != 'ditutup')
                                                        <form action="{{ route('admin.pengaduan.selesai', $pengaduan->id_pengaduan) }}"
                                                              method="POST" class="d-inline flex-fill">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" 
                                                                    class="btn btn-outline-success btn-sm w-100"
                                                                    onclick="return confirm('Tandai pengaduan sebagai selesai?')">
                                                                Selesai
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif

                                                <!-- Aksi untuk Petugas -->
                                                @if (Auth::user()->role == 'petugas' && $pengaduan->status != 'ditutup')
                                                    <a href="{{ url('feedback/create/' . $pengaduan->id_pengaduan) }}"
                                                       class="btn btn-outline-success btn-sm flex-fill">
                                                        Feedback
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="card card-mobile border-0">
                                        <div class="card-body text-center py-5">
                                            <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                                            <h6 class="text-muted">Belum ada pengaduan</h6>
                                            @if(Auth::user()->role == 'siswa' || Auth::user()->role == 'admin')
                                            <p class="text-sm text-muted mb-3">Mulai buat pengaduan pertama Anda</p>
                                            <a href="{{ route('admin.pengaduan.create') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                Buat Pengaduan
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                            
                            <!-- Mobile Summary -->
                            @if($data->count() > 0)
                            <div class="mt-4 p-3 bg-light rounded">
                                <div class="text-center">
                                    <p class="text-sm text-muted mb-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Total {{ $data->count() }} pengaduan
                                    </p>
                                    <div class="d-flex justify-content-around">
                                        <div class="text-center">
                                            <span class="badge bg-primary">{{ $data->where('status', 'dibuka')->count() }}</span>
                                            <p class="text-xs text-muted mt-1 mb-0">Baru</p>
                                        </div>
                                        <div class="text-center">
                                            <span class="badge bg-info">{{ $data->where('status', 'diproses')->count() }}</span>
                                            <p class="text-xs text-muted mt-1 mb-0">Diproses</p>
                                        </div>
                                        <div class="text-center">
                                            <span class="badge bg-secondary">{{ $data->where('status', 'ditutup')->count() }}</span>
                                            <p class="text-xs text-muted mt-1 mb-0">Selesai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.card-header {
    background: linear-gradient(195deg, #42424a, #191919);
    border-radius: 12px 12px 0 0 !important;
}

.card-mobile {
    border-left: 4px solid #e91e63;
    transition: all 0.3s ease;
}

.card-mobile:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.table th {
    border-bottom: 2px solid #f0f2f5;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
}

.pengaduan-row:hover {
    background-color: #f8f9fa;
}

.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
}

.badge {
    font-size: 0.7rem;
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.btn-sm {
    border-radius: 8px;
    font-size: 0.75rem;
}

/* Custom scrollbar for table */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Filter section styling */
.input-group-static label {
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.form-control-sm {
    border-radius: 8px;
    border: 1px solid #d2d6da;
}

/* Empty state styling */
.empty-state {
    padding: 3rem 1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .btn-group-mobile {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-group-mobile .btn {
        flex: 1;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Delete confirmation
    const deleteButtons = document.querySelectorAll('a[data-confirm-delete="true"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute('href');
            
            Swal.fire({
                title: 'Hapus Pengaduan?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e91e63',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Simple filtering functionality
    const filterStatus = document.getElementById('filterStatus');
    const filterKlasifikasi = document.getElementById('filterKlasifikasi');
    const searchInput = document.getElementById('searchInput');
    const pengaduanRows = document.querySelectorAll('.pengaduan-row');
    const pengaduanMobile = document.querySelectorAll('.pengaduan-mobile');

    function filterPengaduan() {
        const statusValue = filterStatus.value.toLowerCase();
        const klasifikasiValue = filterKlasifikasi.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        // Filter desktop rows
        pengaduanRows.forEach(row => {
            let showRow = true;

            // Filter by status
            if (statusValue) {
                const statusBadge = row.querySelector('.badge');
                if (statusBadge && !statusBadge.textContent.toLowerCase().includes(statusValue)) {
                    showRow = false;
                }
            }

            // Filter by klasifikasi
            if (klasifikasiValue && showRow) {
                const klasifikasiBadge = row.querySelector('.bg-success, .bg-warning, .bg-danger');
                if (klasifikasiBadge && !klasifikasiBadge.textContent.toLowerCase().includes(klasifikasiValue)) {
                    showRow = false;
                }
            }

            // Filter by search
            if (searchValue && showRow) {
                const rowText = row.textContent.toLowerCase();
                if (!rowText.includes(searchValue)) {
                    showRow = false;
                }
            }

            // Show/hide row
            row.style.display = showRow ? '' : 'none';
        });

        // Filter mobile cards
        pengaduanMobile.forEach(card => {
            let showCard = true;

            // Filter by status
            if (statusValue) {
                const statusBadge = card.querySelector('.badge');
                if (statusBadge && !statusBadge.textContent.toLowerCase().includes(statusValue)) {
                    showCard = false;
                }
            }

            // Filter by klasifikasi
            if (klasifikasiValue && showCard) {
                const klasifikasiBadge = card.querySelector('.bg-success, .bg-warning, .bg-danger');
                if (klasifikasiBadge && !klasifikasiBadge.textContent.toLowerCase().includes(klasifikasiValue)) {
                    showCard = false;
                }
            }

            // Filter by search
            if (searchValue && showCard) {
                const cardText = card.textContent.toLowerCase();
                if (!cardText.includes(searchValue)) {
                    showCard = false;
                }
            }

            // Show/hide card
            card.style.display = showCard ? '' : 'none';
        });
    }

    // Add event listeners for filters
    if (filterStatus) filterStatus.addEventListener('change', filterPengaduan);
    if (filterKlasifikasi) filterKlasifikasi.addEventListener('change', filterPengaduan);
    if (searchInput) searchInput.addEventListener('input', filterPengaduan);

    // Auto-hide filters on mobile after selection
    if (window.innerWidth < 992) {
        [filterStatus, filterKlasifikasi].forEach(select => {
            if (select) {
                select.addEventListener('change', function() {
                    this.blur();
                });
            }
        });
    }
});
</script>
@endpush