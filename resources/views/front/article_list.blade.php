@extends('front.layouts.template')

@section('content')
<br>
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Semua Artikel</h3>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>

        @if ($articles->count() > 0)
            <div class="row">
                @foreach ($articles as $article)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if ($article->gambar)
                                <img src="{{ asset('storage/artikel/gambar/md/' . $article->gambar) }}" class="card-img-top"
                                     alt="{{ $article->judul }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->judul }}</h5>
                                <p class="card-text text-muted">{{ Str::limit(strip_tags($article->konten), 120) }}</p>
                                <a href="{{ url('artikel/' . $article->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <img src="{{ asset('admin/img/landscape-placeholder.svg') }}" width="200" class="mb-3">
                <h5 class="text-secondary fw-bold">Belum Ada Artikel</h5>
            </div>
        @endif
    </div>
</section>
@endsection
