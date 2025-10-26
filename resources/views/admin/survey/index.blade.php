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

    <div class="mt-3">
        {{ $surveys->links() }}
    </div>
</div>
@endsection
