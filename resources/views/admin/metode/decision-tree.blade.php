@extends('admin.layouts.template')
@section('content')
<h4>Metode Klasifikasi Decision Tree</h4>
<form action="{{ route('admin.decision-tree.proses') }}" method="POST">
    @csrf
    <button class="btn btn-primary">Proses Klasifikasi</button>
</form>

@if(isset($hasil))
<table class="table mt-3">
    <thead>
        <tr>
            <th>ID Pengaduan</th>
            <th>Hasil Klasifikasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hasil as $item)
            <tr>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['klasifikasi'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
