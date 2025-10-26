@extends('admin.layouts.template')

@section('title', 'Detail Data Survey TAM')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Detail Data Survey TAM</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Responden</th>
                    <td>{{ $survey->respondent_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $survey->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Perceived Usefulness (PU)</th>
                    <td>{{ $survey->perceived_usefulness }}</td>
                </tr>
                <tr>
                    <th>Perceived Ease of Use (PEOU)</th>
                    <td>{{ $survey->perceived_ease_of_use }}</td>
                </tr>
                <tr>
                    <th>Attitude Toward Using (ATU)</th>
                    <td>{{ $survey->attitude_toward_using }}</td>
                </tr>
                <tr>
                    <th>Behavioral Intention to Use (BI)</th>
                    <td>{{ $survey->behavioral_intention_to_use }}</td>
                </tr>
                <tr>
                    <th>Actual System Use (ASU)</th>
                    <td>{{ $survey->actual_system_use }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $survey->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diperbarui</th>
                    <td>{{ $survey->updated_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.survey.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.survey.analysis') }}" class="btn btn-success">
            <i class="fas fa-chart-line"></i> Lihat Analisis TAM
        </a>
    </div>
</div>
@endsection
