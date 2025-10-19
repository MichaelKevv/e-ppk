@extends('admin.layouts.template')
@section('title', 'Decision Tree Result')
@section('content')
<h4>Hasil Klasifikasi Pengaduan Baru</h4>

<table class="table table-bordered mt-3">
    <tr>
        <th>Bentuk Perundungan</th>
        <td>{{ ucfirst($validated['bentuk_perundungan']) }}</td>
    </tr>
    <tr>
        <th>Frekuensi Kejadian</th>
        <td>{{ ucfirst($validated['frekuensi_kejadian']) }}</td>
    </tr>
    <tr>
        <th>Trauma Mental</th>
        <td>{{ $validated['trauma_mental'] ? 'Ya' : 'Tidak' }}</td>
    </tr>
    <tr>
        <th>Luka Fisik</th>
        <td>{{ $validated['luka_fisik'] ? 'Ya' : 'Tidak' }}</td>
    </tr>
    <tr class="table-success">
        <th>Klasifikasi</th>
        <td><strong>{{ $klasifikasi }}</strong></td>
    </tr>
</table>

<a href="{{ route('admin.decision-tree.index') }}" class="btn btn-primary mt-3">Kembali ke Metode Decision Tree</a>
@endsection
    