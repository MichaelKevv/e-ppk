@extends('admin.layouts.template')
@section('title', 'Analisis Survey TAM')

@section('content')
<div class="container">
    <h2>Analisis Hasil TAM</h2>

    <div class="alert alert-info mt-3">
        <strong>Total Data yang Diproses:</strong> {{ $totalSurvey }} responden
    </div>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Perceived Usefulness (PU)</th>
            <td>{{ number_format($avgPU, 2) }}</td>
        </tr>
        <tr>
            <th>Perceived Ease of Use (PEOU)</th>
            <td>{{ number_format($avgPEOU, 2) }}</td>
        </tr>
        <tr>
            <th>Attitude Toward Using (ATU)</th>
            <td>{{ number_format($avgATU, 2) }}</td>
        </tr>
        <tr>
            <th>Behavioral Intention to Use (BI)</th>
            <td>{{ number_format($avgBI, 2) }}</td>
        </tr>
        <tr>
            <th>Actual System Use (ASU)</th>
            <td>{{ number_format($avgASU, 2) }}</td>
        </tr>
    </table>
</div>
@endsection
