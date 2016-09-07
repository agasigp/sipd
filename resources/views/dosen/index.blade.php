@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (Session::has('info_message'))
            <div class="alert alert-info"><p>{{ Session::get('info_message') }}</p></div>
            @endif
            @if (Session::has('success_message'))
            <div class="alert alert-success"><p>{{ Session::get('success_message') }}</p></div>
            @endif
        </div>
    </div>
    <div class="row">
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
                                                <?php $nilai = ($lecturer->count_mhs > 0) ? 'sudah' : 'belum' ?>
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
                    <ul>
                        <li>Nila rata-rata dari mahasiswa : <b>{{ number_format($skor_mahasiswa, 2, ',', '.') }}</b> dari <b>{{ $count_mahasiswa }}</b> mahasiswa</li>
                        <li>Nila rata-rata dari dosen : <b>{{ number_format($skor_dosen, 2, ',', '.') }}</b> dari <b>{{ $count_dosen }}</b> dosen</li>
                        <li>Nila rata-rata dari kaprodi : <b>{{ number_format($skor_kaprodi, 2, ',', '.') }}</b></li>
                        <li>Nila rata-rata keseluruhan : <b>{{ number_format(($skor_kaprodi + $skor_dosen + $skor_mahasiswa)/3, 2, ',', '.') }}</b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
