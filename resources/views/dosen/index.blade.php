@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (Session::has('info_message'))
        <div class="alert alert-info"><p>{{ Session::get('info_message') }}</p></div>
        @endif
        @if (Session::has('success_message'))
        <div class="alert alert-success"><p>{{ Session::get('success_message') }}</p></div>
        @endif
        <div class="col-md-4 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Penilaian Dosen</div>
                <div class="panel-body">
                    <form action="{{ route('dosen.create') }}" method="get">
                        <div class="row">
                            <div class="col-md-12">
                                @if (! empty($dosen))
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pilih Dosen</label>
                                        <select class="form-control" name="dosen">
                                            @foreach($dosen as $lecturer)
                                                <?php $nilai = (is_null($lecturer->skor)) ? 'belum' : 'sudah' ?>
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
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Info Nilai</div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
