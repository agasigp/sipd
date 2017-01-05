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
                    <form action="{{ route('kaprodi.create') }}" method="get">
                        <div class="row">
                            <div class="col-md-12">
                                @if (! empty($dosen))
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pilih Dosen</label>
                                        <select class="form-control" name="dosen">
                                            @foreach($dosen as $lecturer)
                                                <?php $nilai = ($lecturer->count_kaprodi > 0) ? 'sudah' : 'belum' ?>
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Skor Mahasiswa</th>
                                <th>Skor Teman Sejawat</th>
                                <th>Skor Atasan</th>
                                <th>Skor Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($dosen as $lecturer)
                                <?php
                                $skor_mahasiswa = $lecturer->count_mhs === 0 ? 0 : $lecturer->sum_skor_mhs / ($count_aspek * $lecturer->count_mhs);
                                $skor_dosen = $lecturer->count_dosen === 0 ? 0 : $lecturer->sum_skor_dosen / ($count_aspek * $lecturer->count_dosen);
                                $skor_kaprodi = (is_null($lecturer->sum_skor_kaprodi) ? 0 : $lecturer->sum_skor_kaprodi / $count_aspek);
                                $rata2 = ($skor_kaprodi + $skor_dosen + $skor_mahasiswa)/3;
                                if ($rata2 <= 2) {
                                    $predikat = 'sangat buruk';
                                } elseif ($rata2 <= 3) {
                                    $predikat = 'buruk';
                                } elseif ($rata2 <= 4) {
                                    $predikat = 'cukup';
                                } elseif ($rata2 <= 5) {
                                    $predikat = 'baik';
                                } else {
                                    $predikat = 'sangat baik';
                                }
                                ?>
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $lecturer->name }}</td>
                                    <td>{{ number_format($skor_mahasiswa, 2, ',', '.') }}</td>
                                    <td>{{ number_format($skor_dosen, 2, ',', '.') }}</td>
                                    <td>{{ number_format($skor_kaprodi, 2, ',', '.') }}</td>
                                    <td>{{ number_format($rata2, 2, ',', '.') }} ({{ $predikat }})</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
