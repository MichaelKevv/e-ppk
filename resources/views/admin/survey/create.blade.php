@extends('admin.layouts.template')

@section('content')
<div class="container">
    <h2>Tambah Data Survey TAM</h2>
    <form action="{{ route('admin.survey.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Responden</label>
            <input type="text" name="respondent_name" class="form-control" required>
        </div>
        <div class="row">
            @foreach(['perceived_usefulness'=>'Kegunaan','perceived_ease_of_use'=>'Kemudahan','attitude_toward_using'=>'Sikap','behavioral_intention_to_use'=>'Niat Menggunakan','actual_system_use'=>'Penggunaan Nyata'] as $key => $label)
            <div class="col-md-4 mb-3">
                <label>{{ $label }}</label>
                <input type="number" name="{{ $key }}" class="form-control" min="1" max="5" required>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
