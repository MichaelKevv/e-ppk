@extends('admin.layouts.template')
@section('title', 'Data Survey TAM')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Survey TAM</li>
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
                        <h6 class="text-white text-capitalize ps-3 mb-0">Data Survey TAM</h6>
                        <div class="d-flex gap-2 me-3">
                            <a href="{{ route('admin.survey.analysis') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-graph-up"></i>
                                <span class="d-none d-md-inline">Lihat Analisis TAM</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <!-- Desktop View -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Perceived Usefulness</th>
                                        <th>Perceived Ease of Use</th>
                                        <th>Behavioral Intention to Use</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($surveys as $survey)
                                    <tr>
                                        <td>{{ $survey->respondent_name }}</td>
                                        <td>{{ $survey->perceived_usefulness }}</td>
                                        <td>{{ $survey->perceived_ease_of_use }}</td>
                                        <td>{{ $survey->behavioral_intention_to_use }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.survey.show', $survey->id) }}" class="btn btn-info btn-sm"
                                                data-bs-toggle="tooltip" title="Detail">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">visibility</i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-bs-toggle="tooltip"
                                                title="Hapus">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                            </button>
                                            <form action="{{ route('admin.survey.destroy', $survey->id) }}" method="POST"
                                                class="d-none deleteForm">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data survey.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="d-md-none">
                        <div class="row px-3">
                            @forelse($surveys as $survey)
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body p-3">
                                        <h6 class="mb-2 text-sm font-weight-bold">{{ $survey->respondent_name }}</h6>
                                        <ul class="list-unstyled mb-3 text-xs">
                                            <li><strong>PU:</strong> {{ $survey->perceived_usefulness }}</li>
                                            <li><strong>PEOU:</strong> {{ $survey->perceived_ease_of_use }}</li>
                                            <li><strong>BI:</strong> {{ $survey->behavioral_intention_to_use }}</li>
                                        </ul>
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.survey.show', $survey->id) }}" class="btn btn-info btn-sm"
                                                data-bs-toggle="tooltip" title="Detail">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">visibility</i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-bs-toggle="tooltip"
                                                title="Hapus">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                            </button>
                                            <form action="{{ route('admin.survey.destroy', $survey->id) }}" method="POST"
                                                class="d-none deleteForm">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center text-muted py-5">
                                        <i class="material-symbols-rounded mb-2"
                                            style="font-size: 48px; opacity: 0.5;">bar_chart</i>
                                        <p class="mb-0">Belum ada data survey.</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if ($surveys->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $surveys->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btnDelete').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.card-body').querySelector('.deleteForm') ||
                this.closest('td').querySelector('.deleteForm');

            Swal.fire({
                title: 'Yakin ingin menghapus data survey ini?',
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
