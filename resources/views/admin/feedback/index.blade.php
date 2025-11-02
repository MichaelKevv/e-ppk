@extends('admin.layouts.template')
@section('title', 'Feedback')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Feedback</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Data Feedback</h6>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <!-- Desktop View -->
                        <div class="d-none d-md-block">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Siswa</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Kelas</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Jurusan</th>
                                            @endif
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Judul Pengaduan</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Feedback</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Petugas</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $feedback)
                                            <tr>
                                                @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">
                                                                {{ optional($feedback->pengaduan->siswa ?? null)->nama ?? '-' }}
                                                            </h6>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-xs text-secondary mb-0">{{ optional($feedback->pengaduan->siswa ?? null)->kelas ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-xs text-secondary mb-0">{{ optional($feedback->pengaduan->siswa ?? null)->jurusan ?? '-' }}</span>
                                                    </td>
                                                @endif

                                                <td>
                                                    <span class="text-xs font-weight-bold mb-0">
                                                        {{ Str::limit($feedback->judul_pengaduan ?? '-', 70) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="text-xs font-weight-bold mb-0">{!! Str::limit($feedback->isi_tanggapan, 60) !!}</span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="text-xs font-weight-bold mb-0">{{ optional($feedback->user)->username ?? '-' }}</span>
                                                </td>

                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY HH:mm') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex flex-row gap-1">
                                                        <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}"
                                                            class="btn btn-warning btn-sm font-weight-bold text-xs">
                                                            Detail
                                                        </a>
                                                    </div>
                                                    <button class="btn btn-success btn-sm font-weight-bold text-xs"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#surveyModal{{ $feedback->id_feedback }}">
                                                        Berikan Survey
                                                    </button>
                                                </td>
                                            </tr>

                                            @php
                                                $role = Auth::user()->role;
                                                $pertanyaan = [];

                                                if ($role == 'siswa') {
                                                    $pertanyaan = [
                                                        'Perceived Usefulness (PU)' => [
                                                            'SAFESCHOOL membantu saya melaporkan kasus perundungan dengan lebih mudah dan aman.',
                                                            'Sistem ini mempercepat proses penanganan laporan saya oleh pihak sekolah atau dinas.',
                                                            'Saya merasa laporan saya lebih diperhatikan sejak menggunakan SAFESCHOOL.',
                                                            'Aplikasi ini membuat saya lebih berani melaporkan perundungan yang terjadi di sekolah.',
                                                            'Dengan SAFESCHOOL, saya yakin kasus perundungan bisa diselesaikan dengan lebih cepat.',
                                                        ],
                                                        'Perceived Ease of Use (PEOU)' => [
                                                            'Tampilan dan menu SAFESCHOOL mudah saya pahami.',
                                                            'Saya bisa membuat laporan tanpa kesulitan meskipun baru pertama kali menggunakan aplikasi.',
                                                            'Proses pengisian laporan di SAFESCHOOL sederhana dan tidak membingungkan.',
                                                            'Fitur-fitur yang disediakan mudah digunakan sesuai kebutuhan saya.',
                                                            'Saya tidak membutuhkan banyak bantuan untuk memahami cara kerja aplikasi ini.',
                                                        ],
                                                        'Behavioral Intention to Use (ITU)' => [
                                                            'Saya akan menggunakan SAFESCHOOL lagi jika terjadi kasus perundungan di sekitar saya.',
                                                            'Saya bersedia membantu teman lain menggunakan SAFESCHOOL jika mereka menjadi korban.',
                                                            'Saya berniat merekomendasikan SAFESCHOOL kepada teman-teman di sekolah.',
                                                            'Saya akan lebih memilih melapor melalui SAFESCHOOL daripada secara langsung.',
                                                            'Saya akan terus menggunakan aplikasi ini karena merasa terbantu.',
                                                        ],
                                                    ];
                                                } elseif ($role == 'gurubk') {
                                                    $pertanyaan = [
                                                        'Perceived Usefulness (PU)' => [
                                                            'SAFESCHOOL membantu saya memantau laporan siswa dengan lebih cepat.',
                                                            'Aplikasi ini memudahkan saya dalam mengelompokkan laporan berdasarkan tingkat urgensi.',
                                                            'Saya dapat memberikan tanggapan kepada siswa secara lebih efisien melalui sistem ini.',
                                                            'SAFESCHOOL membantu saya mengatur tindak lanjut setiap kasus dengan lebih sistematis.',
                                                            'Sistem ini mendukung proses bimbingan dan konseling secara digital di sekolah.',
                                                        ],
                                                        'Perceived Ease of Use (PEOU)' => [
                                                            'Tata letak menu dan fitur pada SAFESCHOOL mudah saya pahami.',
                                                            'Saya dapat memberikan tanggapan atau masukan pada laporan siswa tanpa kesulitan.',
                                                            'Penggunaan sistem ini tidak memerlukan pelatihan yang rumit.',
                                                            'Fitur notifikasi dan dashboard memudahkan saya memantau laporan baru.',
                                                            'Saya tidak mengalami kendala berarti saat menggunakan SAFESCHOOL untuk tugas saya.',
                                                        ],
                                                        'Behavioral Intention to Use (ITU)' => [
                                                            'Saya berniat menggunakan SAFESCHOOL secara rutin untuk menangani laporan siswa.',
                                                            'Saya akan mendorong siswa agar menggunakan SAFESCHOOL untuk melapor.',
                                                            'Saya akan merekomendasikan aplikasi ini kepada rekan guru lainnya.',
                                                            'Saya merasa sistem ini penting untuk digunakan jangka panjang di sekolah.',
                                                            'Saya akan tetap menggunakan SAFESCHOOL karena membantu pekerjaan saya.',
                                                        ],
                                                    ];
                                                } elseif ($role == 'dinsos') {
                                                    $pertanyaan = [
                                                        'Perceived Usefulness (PU)' => [
                                                            'SAFESCHOOL memudahkan koordinasi antara sekolah dan Dinsos dalam menangani laporan berat.',
                                                            'Sistem ini membantu saya mendapatkan informasi laporan secara cepat dan lengkap.',
                                                            'Aplikasi ini meningkatkan efektivitas kerja dalam menindaklanjuti kasus kekerasan anak.',
                                                            'Fitur klasifikasi tingkat urgensi mempermudah saya menentukan prioritas penanganan.',
                                                            'SAFESCHOOL mempercepat proses komunikasi antarinstansi terkait.',
                                                        ],
                                                        'Perceived Ease of Use (PEOU)' => [
                                                            'Saya mudah memahami fitur-fitur utama pada SAFESCHOOL.',
                                                            'Proses verifikasi dan tanggapan laporan dapat dilakukan dengan sederhana.',
                                                            'Tampilan dashboard memudahkan saya dalam memantau seluruh laporan dari sekolah.',
                                                            'Aplikasi ini dapat saya gunakan tanpa memerlukan bantuan teknis khusus.',
                                                            'Saya merasa sistem ini nyaman digunakan untuk pekerjaan saya sehari-hari.',
                                                        ],
                                                        'Behavioral Intention to Use (ITU)' => [
                                                            'Saya berencana terus menggunakan SAFESCHOOL untuk menangani laporan kasus di masa depan.',
                                                            'Saya akan merekomendasikan SAFESCHOOL kepada sekolah lain di wilayah kerja saya.',
                                                            'Saya berniat berkolaborasi lebih lanjut dengan sekolah melalui platform ini.',
                                                            'Saya percaya sistem ini akan menjadi bagian penting dari mekanisme penanganan kasus anak.',
                                                            'Saya akan menggunakan SAFESCHOOL setiap kali menerima laporan dari pihak sekolah.',
                                                        ],
                                                    ];
                                                } elseif ($role == 'admin') {
                                                    $pertanyaan = [
                                                        'Perceived Usefulness (PU)' => [
                                                            'SAFESCHOOL memudahkan koordinasi antara sekolah dan Dinsos dalam menangani laporan berat.',
                                                            'Sistem ini membantu saya mendapatkan informasi laporan secara cepat dan lengkap.',
                                                            'Aplikasi ini meningkatkan efektivitas kerja dalam menindaklanjuti kasus kekerasan anak.',
                                                            'Fitur klasifikasi tingkat urgensi mempermudah saya menentukan prioritas penanganan.',
                                                            'SAFESCHOOL mempercepat proses komunikasi antarinstansi terkait.',
                                                        ],
                                                        'Perceived Ease of Use (PEOU)' => [
                                                            'Saya mudah memahami fitur-fitur utama pada SAFESCHOOL.',
                                                            'Proses verifikasi dan tanggapan laporan dapat dilakukan dengan sederhana.',
                                                            'Tampilan dashboard memudahkan saya dalam memantau seluruh laporan dari sekolah.',
                                                            'Aplikasi ini dapat saya gunakan tanpa memerlukan bantuan teknis khusus.',
                                                            'Saya merasa sistem ini nyaman digunakan untuk pekerjaan saya sehari-hari.',
                                                        ],
                                                        'Behavioral Intention to Use (ITU)' => [
                                                            'Saya berencana terus menggunakan SAFESCHOOL untuk menangani laporan kasus di masa depan.',
                                                            'Saya akan merekomendasikan SAFESCHOOL kepada sekolah lain di wilayah kerja saya.',
                                                            'Saya berniat berkolaborasi lebih lanjut dengan sekolah melalui platform ini.',
                                                            'Saya percaya sistem ini akan menjadi bagian penting dari mekanisme penanganan kasus anak.',
                                                            'Saya akan menggunakan SAFESCHOOL setiap kali menerima laporan dari pihak sekolah.',
                                                        ],
                                                    ];
                                                }
                                            @endphp

                                            @foreach ($data as $feedback)
                                                <div class="modal fade" id="surveyModal{{ $feedback->id_feedback }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin.survey.store') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id_feedback"
                                                                    value="{{ $feedback->id_feedback }}">
                                                                <input type="hidden" name="id_feedback"
                                                                    value="{{ $feedback->id_pengaduan }}">
                                                                @if (Auth::user()->role == 'siswa')
                                                                    <input type="hidden" name="respondent_name" value="{{ Auth::user()->siswas->first()->nama }}">
                                                                @elseif(Auth::user()->role == 'gurubk')
                                                                    <input type="hidden" name="respondent_name" value="{{ Auth::user()->gurubks->first()->nama }}">
                                                                @elseif(Auth::user()->role == 'dinsos')
                                                                    <input type="hidden" name="respondent_name" value="{{ Auth::user()->dinsos->first()->nama }}">
                                                                @elseif(Auth::user()->role == 'admin')
                                                                    <input type="hidden" name="respondent_name" value="{{ Auth::user()->admins->first()->nama }}">
                                                                @endif
                                                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                                                <div class="modal-header bg-dark text-white">
                                                                    <h6 class="modal-title">Survey Feedback -
                                                                        {{ strtoupper($role) }}</h6>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="text-sm text-muted">
                                                                        Skala Likert: 1 = Sangat Tidak Setuju, 2 = Tidak
                                                                        Setuju, 3 = Netral, 4 = Setuju, 5 = Sangat Setuju
                                                                    </p>
                                                                    <hr>

                                                                    @foreach ($pertanyaan as $kategori => $daftar)
                                                                        <h6 class="text-primary mt-3">{{ $kategori }}
                                                                        </h6>
                                                                        @foreach ($daftar as $index => $item)
                                                                            <div class="mb-2">
                                                                                <label
                                                                                    class="form-label text-sm">{{ $item }}</label>
                                                                                <div class="d-flex gap-2 mt-1">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input class="form-check-input"
                                                                                                type="radio"
                                                                                                name="{{ Str::slug($kategori) }}_{{ $loop->parent->index + 1 }}_{{ $index }}"
                                                                                                value="{{ $i }}"
                                                                                                required>
                                                                                            <label
                                                                                                class="form-check-label">{{ $i }}</label>
                                                                                        </div>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Kirim
                                                                        Survey</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <em>Tidak ada data feedback</em>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mobile View -->
                        <div class="d-md-none">
                            <div class="row px-3">
                                @forelse ($data as $feedback)
                                    <div class="col-12 mb-3">
                                        <div class="card shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="mb-3">
                                                    <h6 class="mb-2 text-sm font-weight-bold text-primary">
                                                        {{ Str::limit($feedback->judul_pengaduan ?? '-', 100) }}
                                                    </h6>

                                                    @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                                            <div>
                                                                <small class="text-muted">Siswa:</small>
                                                                <div class="text-xs font-weight-bold">
                                                                    {{ optional($feedback->pengaduan->siswa ?? null)->nama ?? '-' }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">Kelas:</small>
                                                                <div class="text-xs font-weight-bold">
                                                                    {{ optional($feedback->pengaduan->siswa ?? null)->kelas ?? '-' }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">Jurusan:</small>
                                                                <div class="text-xs font-weight-bold">
                                                                    {{ optional($feedback->pengaduan->siswa ?? null)->jurusan ?? '-' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="mb-3">
                                                    <small class="text-muted">Feedback:</small>
                                                    <div class="text-xs mb-1 p-2 bg-light rounded">
                                                        {!! Str::limit($feedback->isi_tanggapan, 100) !!}
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="d-flex flex-column">
                                                        <small class="text-muted">Petugas:</small>
                                                        <span
                                                            class="text-xs font-weight-bold">{{ optional($feedback->user)->username ?? '-' }}</span>
                                                    </div>

                                                    <div class="d-flex flex-column text-end">
                                                        <small class="text-muted">Tanggal:</small>
                                                        <span class="text-xs font-weight-bold">
                                                            {{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMM YYYY') }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end mt-3">
                                                    <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}"
                                                        class="btn btn-warning btn-sm font-weight-bold text-xs">
                                                        <i class="bi bi-eye me-1"></i> Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center text-muted py-3">
                                        <em>Tidak ada data feedback</em>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
