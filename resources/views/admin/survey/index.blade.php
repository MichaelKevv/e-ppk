@extends('admin.layouts.template')
@section('title', 'Data Survey TAM')
@section('content')
<div class="container">
    <h2>Data Survey TAM</h2>

    <div class="mb-3">
        <a href="{{ route('admin.survey.create') }}" class="btn btn-primary">Tambah Data</a>
        <a href="{{ route('admin.survey.analysis') }}" class="btn btn-success">Lihat Analisis TAM</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Perceived Usefulness</th>
                <th>Perceived Ease of Use</th>
                <th>Attitude Toward Using</th>
                <th>Behavioral Intention to Use</th>
                <th>Actual System Use</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($surveys as $survey)
            <tr>
                <td>{{ $survey->respondent_name }}</td>
                <td>{{ $survey->perceived_usefulness }}</td>
                <td>{{ $survey->perceived_ease_of_use }}</td>
                <td>{{ $survey->attitude_toward_using }}</td>
                <td>{{ $survey->behavioral_intention_to_use }}</td>
                <td>{{ $survey->actual_system_use }}</td>
                <td>
                    <a href="{{ route('admin.survey.show', $survey->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <form action="{{ route('admin.survey.destroy', $survey->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada data survey.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if ($surveys->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-custom mb-0">
                {{-- Tombol Previous --}}
                @if ($surveys->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $surveys->previousPageUrl() }}" class="page-link" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif
                @foreach ($surveys->links()->elements[0] ?? [] as $page => $url)
                    @if ($page == $surveys->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
                @if ($surveys->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $surveys->nextPageUrl() }}" class="page-link" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>
@push('styles')
<style>
.pagination-custom {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.3rem;
}

.pagination-custom .page-item {
    display: inline-flex;
}

.pagination-custom .page-link {
    border: none;
    border-radius: 6px;
    padding: 8px 14px;
    color: #333;
    font-weight: 500;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pagination-custom .page-link i {
    font-size: 0.85rem;
}

.pagination-custom .page-item.active .page-link {
    background: linear-gradient(90deg, #007bff, #0056b3);
    color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
}

.pagination-custom .page-link:hover {
    background: #f1f5f9;
    color: #007bff;
    transform: translateY(-2px);
}

.pagination-custom .page-item.disabled .page-link {
    background: #f8f9fa;
    color: #ccc;
    box-shadow: none;
}
</style>
@endpush
@endsection
