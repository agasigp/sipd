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
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($program_studi as $ps)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $ps->nama }}</td>
                                    <td>{{ $ps->deskripsi }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('program-studi.destroy', $ps->id)}}" accept-charset="UTF-8" class="ng-pristine ng-valid" id="form{{ $no }}">
                                            {!! csrf_field() !!}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <div class="btn-group btn-group-xs">
                                                <a class="btn btn-default" href="{{ route('program-studi.edit', $ps->id)}}"><i class="fa fa-pencil fa-fw"></i></a>
                                                <button type="button" class="btn btn-default" onclick="deleteProgramStudi({{ $ps->id }})"><i class="fa fa-trash fa-fw"></i></button>
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
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        function deleteProgramStudi(id)
        {
            var id = id;
            swal({
                title: "Anda Yakin Ingin Menghapus?",
                text: "Anda yakin ingin menghapus data ini?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya!",
                closeOnConfirm: true
            }, function() {
                $("#form" + id).submit();
            });
        }
    </script>
@endpush
