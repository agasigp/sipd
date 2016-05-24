@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}"></script>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (Session::has('info_message'))
            <div class="alert alert-info"><p>{{ Session::get('info_message') }}</p></div>
            @endif
            @if (Session::has('warning_message'))
            <div class="alert alert-warning"><p>{{ Session::get('warning_message') }}</p></div>
            @endif
            @if (Session::has('success_message'))
            <div class="alert alert-success"><p>{{ Session::get('success_message') }}</p></div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">User</div>
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-3" style="border">
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a href="{{ route('user.create')}}" class="btn btn-success"><i class="fa fa-plus fa-fw"></i></a>
                                </div>
                            </div>
                            <div class="col-xs-3" align="center">
                                <form method="get" class="input-group input-group-sm">
                                    <input name="page" type="hidden" value="{{ $users->currentPage()}}" />
                                    <input name="q" type="text" class="form-control" placeholder="Cari" value="{{ $request->input('q')}}" />
                                    <div class="input-group-btn">
                                        <input type="submit" class="btn btn-success" value="Cari">
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-4">
                                <form method="get" class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <a class="btn btn-default" href="{{ str_replace('/?', '?', $users->url(1))}}"
                                           @if($users->currentPage() == 1) disabled @endif>&laquo;</a>
                                        <a class="btn btn-default"
                                           href="{{ str_replace('/?', '?', $users->previousPageUrl())}}"
                                           @if($users->currentPage() == 1) disabled @endif><</a>
                                    </span>
                                    <span class="input-group-addon" id="basic-addon2">page</span>
                                    <input name="page" type="number" style="border-left: 0; border-right: 0;" value="{{ $users->currentPage()}}" min="1" max="{{ $users->lastPage()}}" class="form-control crud-page-number">
                                    <span class="input-group-addon">of {{ $users->lastPage()}}</span>
                                    <span class="input-group-btn">
                                        <a class="btn btn-default" href="{{ str_replace('/?', '?', $users->nextPageUrl())}}{{ (count($request->input('q')) > 0) ? ('&q='.$request->input('q')) : ('')}}"
                                           @if($users->currentPage() == $users->lastPage()) disabled @endif>></a>
                                        <a class="btn btn-default" href="{{ str_replace('/?', '?', $users->url($users->lastPage()))}}{{ (count($request->input('q')) > 0) ? ('&q='.$request->input('q')) : ('')}}"
                                           @if($users->currentPage() == $users->lastPage()) disabled @endif>&raquo;</a>
                                    </span>
                                </form>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group input-group-sm">
                                    Total: {{ $users->total()}} data
                                </div>
                            </div>
                        </div><!-- /.row -->
                        <br />
                        <div class="row">
                            <div class="col-sm-12">
                                @if ( !$users->count() )
                                <div class="alert alert-warning">
                                    <p>Tidak ada data</p>
                                </div>
                                @else
                                <table class="table table-striped table-condensed table-hover table-bordered">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Program Studi</th>
                                        <th>status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <?php
                                        if ($users->currentPage() == 1) {
                                            $no = 1;
                                        } else {
                                            $no = $users->perPage() * ($users->currentPage() - 1) + 1;
                                        }
                                    ?>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>@if (! is_null($user->programStudi)) {{ $user->programStudi->nama }} @endif</td>
                                        <td>{{ $user->status }}</td>
                                        <td align="center">
                                            <form method="POST" action="{{ route('user.destroy', $user->id)}}" accept-charset="UTF-8" id="form{{ $user->id }}">
                                                {!! csrf_field() !!}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <div class="btn-group btn-group-xs">
                                                    <a class="btn btn-default" href="{{ route('user.edit', $user->id)}}"><i class="fa fa-pencil fa-fw"></i></a>
                                                    <button type="button" class="btn btn-default" onclick="deleteUser({{ $user->id }})"><i class="fa fa-trash fa-fw"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        function deleteUser(id)
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
