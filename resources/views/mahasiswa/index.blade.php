@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if (Session::has('info_message'))
            <div class="alert alert-info"><p>{{ Session::get('info_message') }}</p></div>
            @endif
            @if (Session::has('success_message'))
            <div class="alert alert-success"><p>{{ Session::get('success_message') }}</p></div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Penilaian Dosen</div>
                <div class="panel-body">
                    <form action="{{ route('mahasiswa.create') }}" method="get">
                        <div class="row">
                            <div class="col-md-6">
                                @if (! empty($dosen))
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pilih Dosen</label>
                                        <select class="form-control" name="dosen">
                                            @foreach($dosen as $lecturer)
                                                <?php $nilai = ($lecturer->count_mhs) ? 'sudah' : 'belum' ?>
                                                <option value="{{ $lecturer->id }}">{{ $lecturer->name }} ({{ $nilai.' dinilai' }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Pilih</button>
                                @else
                                    Tidak ada dosen untuk diberikan nilai.
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
