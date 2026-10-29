@extends('admin.layouts.template')
@section('title', 'Feedback & Konseling')

@section('content')
<div x-data="{
    search: '',
    roleFilter: 'all',
    showSurveyModal: false,
    activeFeedback: null,
    openSurvey(item) {
        this.activeFeedback = item;
        this.showSurveyModal = true;
    },
    closeSurvey() {
        this.showSurveyModal = false;
        this.activeFeedback = null;
    }
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold mb-2">
                <i class="fa-solid fa-comments"></i>
                <span>Layanan Dukungan &amp; Tindak Lanjut</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Feedback &amp; Konseling Kasus
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Riwayat pesan tanggapan resmi, arahan bimbingan konseling oleh Guru BK / Dinsos, serta instrumen evaluasi kepuasan layanan (TAM).
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Unduh Laporan PDF -->
            <a href="{{ route('admin.feedback.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all shadow-2xs">
                <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                <span>Unduh Laporan PDF</span>
            </a>

            <!-- Pintasan ke Data Pengaduan untuk Memberi Tanggapan Baru -->
            <a href="{{ route('admin.pengaduan.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Beri Tanggapan di Kasus</span>
            </a>
        </div>
    </div>

    <!-- Stat Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Feedback -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-center text-indigo-600 text-xl font-bold">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Tanggapan</p>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalFeedback }}
                </p>
                <span class="text-[11px] text-indigo-600 font-semibold">
                    Konseling &amp; Tanggapan
                </span>
            </div>
        </div>

        <!-- Total Kasus Terbimbing -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 text-xl font-bold">
                <i class="fa-solid fa-hand-holding-hand"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Kasus Terbimbing</p>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalKasus }} Kasus
                </p>
                <span class="text-[11px] text-emerald-600 font-semibold">
                    Mendapat Pendampingan
                </span>
            </div>
        </div>

        <!-- Tanggapan Bulan Ini -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-200 flex items-center justify-center text-purple-600 text-xl font-bold">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Bulan Ini</p>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalBulanIni }} Pesan
                </p>
                <span class="text-[11px] text-purple-600 font-semibold">
                    Aktivitas Terbaru
                </span>
            </div>
        </div>

        <!-- Total Responden Survey TAM -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold">
                <i class="fa-solid fa-square-poll-vertical"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Survey TAM Terisi</p>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalSurvey }} Responden
                </p>
                <span class="text-[11px] text-amber-600 font-semibold">
                    Evaluasi Penerimaan
                </span>
            </div>
        </div>
    </div>

    <!-- Table Container with Filter & Search -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Filter Header -->
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="search" placeholder="Cari siswa, kasus, tanggapan..."
                           class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 bg-slate-50 focus:bg-white transition-all">
                </div>

                <!-- Role Filter -->
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="text-[11px] font-semibold text-slate-400">Pengirim:</span>
                    <select x-model="roleFilter" class="text-xs rounded-xl border border-slate-200 py-2 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                        <option value="all">Semua Pengirim</option>
                        <option value="siswa">Siswa / Korban</option>
                        <option value="gurubk">Guru BK</option>
                        <option value="dinsos">Dinas Sosial</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>

            <div class="text-xs text-slate-400 font-medium">
                Menampilkan <span class="font-bold text-slate-700">{{ $data->count() }}</span> data tanggapan
            </div>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4 w-12 text-center">#</th>
                        <th class="p-4">Kasus Pengaduan Terkait</th>
                        <th class="p-4">Siswa / Korban</th>
                        <th class="p-4 min-w-72">Pesan Tanggapan &amp; Konseling</th>
                        <th class="p-4">Pemberi Feedback</th>
                        <th class="p-4 text-center">Tanggal</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($data as $idx => $item)
                        @php
                            $roleLower = strtolower($item->user->role ?? '');
                            $roleBadge = match($roleLower) {
                                'siswa' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'gurubk' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'dinsos' => 'bg-purple-50 text-purple-700 border-purple-200',
                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                            };
                            $roleIcon = match($roleLower) {
                                'siswa' => 'fa-graduation-cap text-emerald-500',
                                'gurubk' => 'fa-chalkboard-user text-indigo-500',
                                'dinsos' => 'fa-building-shield text-purple-500',
                                default => 'fa-user-gear text-slate-500',
                            };
                            $statusBadge = match(strtolower($item->status_pengaduan ?? '')) {
                                'selesai', 'ditutup' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'konseling' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'mediasi' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'investigasi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                default => 'bg-slate-100 text-slate-600 border-slate-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            x-show="(roleFilter === 'all' || '{{ $roleLower }}' === roleFilter) && (search === '' || '{{ strtolower(addslashes($item->judul_pengaduan . ' ' . $item->nama_siswa . ' ' . strip_tags($item->isi_tanggapan) . ' ' . $item->nama_pengirim)) }}'.includes(search.toLowerCase()))">
                            <td class="p-4 text-center font-mono text-slate-400 text-[11px]">
                                {{ $idx + 1 }}
                            </td>

                            <!-- Kasus Pengaduan Terkait -->
                            <td class="p-4">
                                <div class="max-w-xs">
                                    <div class="font-bold text-slate-800 text-xs line-clamp-1" title="{{ $item->judul_pengaduan }}">
                                        {{ $item->judul_pengaduan }}
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border uppercase {{ $statusBadge }}">
                                            {{ $item->status_pengaduan ?? 'Laporan' }}
                                        </span>
                                        @if ($item->klasifikasi_pengaduan)
                                            <span class="text-[10px] font-semibold text-slate-400 capitalize">
                                                &bull; {{ $item->klasifikasi_pengaduan }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Siswa / Korban -->
                            <td class="p-4">
                                <div class="font-bold text-slate-800 text-xs">
                                    {{ $item->nama_siswa }}
                                </div>
                                <div class="text-[11px] text-slate-500">
                                    {{ $item->kelas_siswa }} &bull; {{ $item->jurusan_siswa }}
                                </div>
                            </td>

                            <!-- Isi Feedback / Tanggapan -->
                            <td class="p-4">
                                <div class="bg-slate-50/80 p-3 rounded-xl border border-slate-100 max-w-md">
                                    <p class="text-xs text-slate-700 leading-relaxed line-clamp-3">
                                        "{!! strip_tags($item->isi_tanggapan) !!}"
                                    </p>
                                </div>
                            </td>

                            <!-- Pemberi Feedback -->
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-xs">
                                        <i class="fa-solid {{ $roleIcon }}"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-xs">
                                            {{ $item->nama_pengirim }}
                                        </div>
                                        <span class="inline-block px-1.5 py-0.2 rounded text-[10px] font-bold border {{ $roleBadge }}">
                                            {{ $item->role_pengirim }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Tanggal -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="text-xs font-semibold text-slate-700">
                                    {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMM YYYY') }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-mono">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail Thread -->
                                    <a href="{{ route('admin.feedback.show', $item->id_feedback) }}"
                                       title="Lihat Detail & Riwayat Konseling"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition-all border border-indigo-200">
                                        <i class="fa-solid fa-eye text-[11px]"></i>
                                        <span>Detail</span>
                                    </a>

                                    <!-- Berikan Survey TAM -->
                                    <button type="button"
                                            @click="openSurvey({
                                                id_feedback: {{ $item->id_feedback }},
                                                id_pengaduan: {{ $item->id_pengaduan ?? 'null' }},
                                                judul_pengaduan: '{{ addslashes($item->judul_pengaduan) }}',
                                                nama_siswa: '{{ addslashes($item->nama_siswa) }}'
                                            })"
                                            title="Berikan Penilaian Survey TAM"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition-all border border-emerald-200">
                                        <i class="fa-solid fa-square-poll-vertical text-[11px]"></i>
                                        <span>Survey TAM</span>
                                    </button>

                                    <!-- Hapus (khusus admin/petugas) -->
                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'admin_it')
                                        <form action="{{ route('admin.feedback.destroy', $item->id_feedback) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan feedback ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Catatan"
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center text-2xl mx-auto mb-3">
                                    <i class="fa-solid fa-comments"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-600">Belum Ada Data Feedback &amp; Konseling</h4>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Tanggapan konseling akan muncul secara otomatis saat Guru BK atau Dinas Sosial merespons laporan pengaduan siswa.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL SURVEY TAM INTERAKTIF (ALPINE.JS) -->
    @php
        $role = Auth::user()->role ?? 'siswa';
        $pertanyaan = [];

        if ($role == 'siswa') {
            $pertanyaan = [
                'Perceived Usefulness (PU)' => [
                    'Lapora membantu saya melaporkan kasus perundungan dengan lebih mudah dan aman.',
                    'Sistem ini mempercepat proses penanganan laporan saya oleh pihak sekolah atau dinas.',
                    'Saya merasa laporan saya lebih diperhatikan sejak menggunakan Lapora.',
                    'Aplikasi ini membuat saya lebih berani melaporkan perundungan yang terjadi di sekolah.',
                    'Dengan Lapora, saya yakin kasus perundungan bisa diselesaikan dengan lebih cepat.',
                ],
                'Perceived Ease of Use (PEOU)' => [
                    'Tampilan dan menu Lapora mudah saya pahami.',
                    'Saya bisa membuat laporan tanpa kesulitan meskipun baru pertama kali menggunakan aplikasi.',
                    'Proses pengisian laporan di Lapora sederhana dan tidak membingungkan.',
                    'Fitur-fitur yang disediakan mudah digunakan sesuai kebutuhan saya.',
                    'Saya tidak membutuhkan banyak bantuan untuk memahami cara kerja aplikasi ini.',
                ],
                'Behavioral Intention to Use (ITU)' => [
                    'Saya akan menggunakan Lapora lagi jika terjadi kasus perundungan di sekitar saya.',
                    'Saya bersedia membantu teman lain menggunakan Lapora jika mereka menjadi korban.',
                    'Saya berniat merekomendasikan Lapora kepada teman-teman di sekolah.',
                    'Saya akan lebih memilih melapor melalui Lapora daripada secara langsung.',
                    'Saya akan terus menggunakan aplikasi ini karena merasa terbantu.',
                ],
            ];
        } elseif ($role == 'gurubk') {
            $pertanyaan = [
                'Perceived Usefulness (PU)' => [
                    'Lapora membantu saya memantau laporan siswa dengan lebih cepat.',
                    'Aplikasi ini memudahkan saya dalam mengelompokkan laporan berdasarkan tingkat urgensi.',
                    'Saya dapat memberikan tanggapan kepada siswa secara lebih efisien melalui sistem ini.',
                    'Lapora membantu saya mengatur tindak lanjut setiap kasus dengan lebih sistematis.',
                    'Sistem ini mendukung proses bimbingan dan konseling secara digital di sekolah.',
                ],
                'Perceived Ease of Use (PEOU)' => [
                    'Tata letak menu dan fitur pada Lapora mudah saya pahami.',
                    'Saya dapat memberikan tanggapan atau masukan pada laporan siswa tanpa kesulitan.',
                    'Penggunaan sistem ini tidak memerlukan pelatihan yang rumit.',
                    'Fitur notifikasi dan dashboard memudahkan saya memantau laporan baru.',
                    'Saya tidak mengalami kendala berarti saat menggunakan Lapora untuk tugas saya.',
                ],
                'Behavioral Intention to Use (ITU)' => [
                    'Saya berniat menggunakan Lapora secara rutin untuk menangani laporan siswa.',
                    'Saya akan mendorong siswa agar menggunakan Lapora untuk melapor.',
                    'Saya akan merekomendasikan aplikasi ini kepada rekan guru lainnya.',
                    'Saya merasa sistem ini penting untuk digunakan jangka panjang di sekolah.',
                    'Saya akan tetap menggunakan Lapora karena membantu pekerjaan saya.',
                ],
            ];
        } else {
            $pertanyaan = [
                'Perceived Usefulness (PU)' => [
                    'Lapora memudahkan koordinasi antara sekolah dan Dinsos dalam menangani laporan berat.',
                    'Sistem ini membantu saya mendapatkan informasi laporan secara cepat dan lengkap.',
                    'Aplikasi ini meningkatkan efektivitas kerja dalam menindaklanjuti kasus kekerasan anak.',
                    'Fitur klasifikasi tingkat urgensi mempermudah saya menentukan prioritas penanganan.',
                    'Lapora mempercepat proses komunikasi antarinstansi terkait.',
                ],
                'Perceived Ease of Use (PEOU)' => [
                    'Saya mudah memahami fitur-fitur utama pada Lapora.',
                    'Proses verifikasi dan tanggapan laporan dapat dilakukan dengan sederhana.',
                    'Tampilan dashboard memudahkan saya dalam memantau seluruh laporan dari sekolah.',
                    'Aplikasi ini dapat saya gunakan tanpa memerlukan bantuan teknis khusus.',
                    'Saya merasa sistem ini nyaman digunakan untuk pekerjaan saya sehari-hari.',
                ],
                'Behavioral Intention to Use (ITU)' => [
                    'Saya berencana terus menggunakan Lapora untuk menangani laporan kasus di masa depan.',
                    'Saya akan merekomendasikan Lapora kepada sekolah lain di wilayah kerja saya.',
                    'Saya berniat berkolaborasi lebih lanjut dengan sekolah melalui platform ini.',
                    'Saya percaya sistem ini akan menjadi bagian penting dari mekanisme penanganan kasus anak.',
                    'Saya akan menggunakan Lapora setiap kali menerima laporan dari pihak sekolah.',
                ],
            ];
        }

        // Resolusi Nama Responden
        $authUser = Auth::user();
        $respondentName = match($authUser->role) {
            'siswa' => $authUser->siswas->first()?->nama ?? $authUser->name ?? $authUser->username,
            'gurubk' => $authUser->gurubks->first()?->nama ?? $authUser->name ?? $authUser->username,
            'dinsos' => $authUser->dinsos->first()?->nama ?? $authUser->name ?? $authUser->username,
            default => $authUser->admins->first()?->nama ?? $authUser->name ?? $authUser->username,
        };
    @endphp

    <div x-show="showSurveyModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center p-3 sm:p-5"
         style="display: none;">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
             @click="closeSurvey()"
             aria-hidden="true"></div>

        <!-- Modal Dialog Card -->
        <div class="relative bg-white rounded-3xl shadow-2xl max-w-3xl w-full max-h-[92vh] flex flex-col border border-slate-200 overflow-hidden transform transition-all z-10"
             @click.stop>
            <!-- Modal Header (Pinned at Top) -->
            <div class="flex-none bg-gradient-to-r from-indigo-900 via-slate-900 to-indigo-950 p-5 sm:p-6 text-white flex items-center justify-between border-b border-indigo-900/50">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 text-[10px] font-bold uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-square-poll-vertical"></i>
                        <span>Technology Acceptance Model (TAM)</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-extrabold text-white">
                        Survey Kepuasan &amp; Penerimaan Layanan
                    </h3>
                    <p class="text-xs text-slate-300 mt-0.5">
                        Responden: <strong class="text-white">{{ $respondentName }}</strong> &bull; Peran: <span class="capitalize">{{ $role }}</span>
                    </p>
                </div>

                <button type="button" @click="closeSurvey()"
                        class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Form Survey (Flex Column to Fit Card) -->
            <form action="{{ route('admin.survey.store') }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                @csrf
                <input type="hidden" name="id_feedback" :value="activeFeedback ? activeFeedback.id_feedback : ''">
                <input type="hidden" name="id_pengaduan" :value="activeFeedback ? activeFeedback.id_pengaduan : ''">
                <input type="hidden" name="respondent_name" value="{{ $respondentName }}">
                <input type="hidden" name="email" value="{{ $authUser->email }}">

                <!-- Scrollable Body with Likert Questions -->
                <div class="flex-1 min-h-0 overflow-y-auto p-5 sm:p-6 space-y-6 custom-scrollbar bg-slate-50/50">
                    <!-- Petunjuk Skala Likert -->
                    <div class="p-4 bg-indigo-50/70 rounded-2xl border border-indigo-100 flex items-start gap-3 text-xs text-indigo-950">
                        <i class="fa-solid fa-circle-info text-indigo-600 text-base mt-0.5"></i>
                        <div>
                            <h5 class="font-bold mb-1">Petunjuk Pengisian Skala Likert (1 - 5):</h5>
                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-[11px] font-medium text-slate-700 mt-2">
                                <span class="px-2 py-1 bg-white rounded-lg border border-indigo-100 text-center"><strong>1:</strong> Sangat Tidak Setuju</span>
                                <span class="px-2 py-1 bg-white rounded-lg border border-indigo-100 text-center"><strong>2:</strong> Tidak Setuju</span>
                                <span class="px-2 py-1 bg-white rounded-lg border border-indigo-100 text-center"><strong>3:</strong> Netral / Ragu</span>
                                <span class="px-2 py-1 bg-white rounded-lg border border-indigo-100 text-center"><strong>4:</strong> Setuju</span>
                                <span class="px-2 py-1 bg-white rounded-lg border border-indigo-100 text-center"><strong>5:</strong> Sangat Setuju</span>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Pertanyaan Kategori -->
                    @foreach ($pertanyaan as $kategori => $daftar)
                        @php
                            $kategoriSlug = Str::slug($kategori);
                            $kategoriColor = match($loop->iteration) {
                                1 => 'border-indigo-500 text-indigo-600',
                                2 => 'border-emerald-500 text-emerald-600',
                                default => 'border-purple-500 text-purple-600',
                            };
                        @endphp
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4 shadow-2xs">
                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                                <h4 class="text-sm font-extrabold text-slate-800">
                                    {{ $kategori }}
                                </h4>
                            </div>

                            <div class="space-y-4">
                                @foreach ($daftar as $index => $item)
                                    <div class="p-3.5 bg-slate-50/70 rounded-xl border border-slate-100 space-y-2.5">
                                        <p class="text-xs font-semibold text-slate-800 leading-relaxed">
                                            <span class="text-slate-400 font-mono mr-1">{{ $loop->parent->iteration }}.{{ $index + 1 }}</span>
                                            {{ $item }}
                                        </p>

                                        <!-- Radio Options 1-5 -->
                                        <div class="flex items-center justify-between gap-1 sm:gap-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="flex-1 cursor-pointer">
                                                    <input type="radio"
                                                           name="{{ $kategoriSlug }}_{{ $loop->parent->index + 1 }}_{{ $index }}"
                                                           value="{{ $i }}"
                                                           required
                                                           class="peer sr-only">
                                                    <div class="text-center py-2 px-1 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 peer-checked:shadow-sm transition-all hover:bg-slate-100">
                                                        <span>{{ $i }}</span>
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modal Footer (Pinned at Bottom) -->
                <div class="flex-none p-4 sm:p-5 bg-white border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <span class="text-[11px] text-slate-400 font-medium hidden sm:inline">
                        *Seluruh butir pertanyaan evaluasi TAM (1 - 5) wajib diisi sebelum mengirim.
                    </span>
                    <div class="flex items-center justify-end gap-2 w-full sm:w-auto">
                        <button type="button" @click="closeSurvey()"
                                class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            <span>Kirim Penilaian Survey</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
