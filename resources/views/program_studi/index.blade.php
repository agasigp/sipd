@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}"></script>
@endpush

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
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Program Studi</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="app">
                            <?php $no = 1; ?>
                            @foreach($program_studi as $ps)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $ps->nama }}</td>
                                    <td>{{ $ps->deskripsi }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('program-studi.destroy', $ps->id)}}" accept-charset="UTF-8"  id="form{{ $ps->id }}">
                                            {!! csrf_field() !!}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <div class="btn-group btn-group-xs">
                                                <a class="btn btn-default" href="{{ route('program-studi.edit', $ps->id)}}"><i class="fa fa-pencil fa-fw"></i></a>
                                                <confirm id="{{ $ps->id }}"></confirm>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('program-studi.create') }}" class="btn btn-primary" role="button">Tambah Program Studi</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
