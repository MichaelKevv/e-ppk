@extends('admin.layouts.template')
@section('title', 'Decision Tree')
@section('content')
<h4>Analisis Decision Tree (ID3)</h4>

<form action="{{ route('admin.decision-tree.proses') }}" method="POST" class="mb-4">
    @csrf
    <button class="btn btn-primary">Hitung ID3</button>
</form>

@if(isset($entropyTotal))
<div class="card p-3 mb-4">
    <h6>Entropi Total: {{ $entropyTotal }}</h6>
    <ul>
        @foreach($gainList as $attr => $gain)
        <li>{{ $attr }} = <b>{{ $gain }}</b></li>
        @endforeach
    </ul>
    <h6 class="text-success">Node Utama: {{ $rootNode }}</h6>
</div>
@endif

<hr>
<h5>🔮 Klasifikasi Pengaduan Baru</h5>
<form action="{{ route('admin.decision-tree.classify') }}" method="POST" class="mt-3">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <label>Bentuk Perundungan</label>
            <select name="bentuk_perundungan" class="form-control" required>
                <option value="">--Pilih--</option>
                <option value="fisik">Fisik</option>
                <option value="verbal">Verbal</option>
                <option value="seksual">Seksual</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Frekuensi Kejadian</label>
            <select name="frekuensi_kejadian" class="form-control" required>
                <option value="">--Pilih--</option>
                <option value="jarang">Jarang</option>
                <option value="sering">Sering</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Trauma Mental</label>
            <select name="trauma_mental" class="form-control" required>
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Luka Fisik</label>
            <select name="luka_fisik" class="form-control" required>
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
            </select>
        </div>
    </div>
    <button class="btn btn-success mt-3">Prediksi Klasifikasi</button>
</form>
@endsection
