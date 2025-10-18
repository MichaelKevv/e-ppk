@extends('admin.layouts.template')
@section('content')
<h4>Evaluasi Model TAM (Technology Acceptance Model)</h4>
<form action="{{ route('admin.tam.hitung') }}" method="POST">
    @csrf
    <button class="btn btn-success">Hitung Nilai TAM</button>
</form>

@if(isset($hasil))
<div class="mt-3">
    <p>Perceived Usefulness (PU): <b>{{ $hasil['PU'] }}</b></p>
    <p>Perceived Ease of Use (PEOU): <b>{{ $hasil['PEOU'] }}</b></p>
    <p>Attitude Toward Using (ATT): <b>{{ $hasil['ATT'] }}</b></p>
    <p>Behavioral Intention (BI): <b>{{ $hasil['BI'] }}</b></p>
</div>
@endif
@endsection
