@extends('template')
@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">

                    @if (Auth::user()->role == 'kepala_sekolah')
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="bi-people-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Total Siswa
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ $data['totalSiswa'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon green mb-2">
                                                <i class="bi-briefcase-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Total Pengaduan
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ $data['totalPengaduan'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="bi-chat-left-dots-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Total Feedback
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ $data['totalFeedback'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (Auth::user()->role == 'petugas')
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="bi-people-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Total Siswa
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ $data['totalSiswa'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="bi-chat-left-dots-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Pengaduan Blm Dibaca</h6>
                                            <h6 class="font-extrabold mb-0">{{ $data['pengaduanBelumDibaca'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (Auth::user()->role == 'siswa')
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon green mb-2">
                                                <i class="bi-briefcase-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Pengaduan Anda</h6>
                                            <h6 class="font-extrabold mb-0">{{ $data['totalPengaduan'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="bi-chat-left-dots-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Pengaduan Sdh Dibalas</h6>
                                            <h6 class="font-extrabold mb-0">{{ $data['pengaduanFeedback']->count() }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="row">
                    @if (Auth::user()->role == 'kepala_sekolah' || Auth::user()->role == 'petugas')
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Pengaduan oleh Siswa</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-pengaduan-siswa"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Feedback ke Siswa</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-feedback-siswa"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Total Siswa</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-total-siswa"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Pengaduan Anda</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-pengaduan-siswa"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
