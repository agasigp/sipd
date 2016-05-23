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
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Program Studi</div>
                <div class="panel-body">
                    <form action="{{ route('program-studi.update', $program_studi->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 form-control-label">Nama</label>
                            <div class="col-sm-6">
                                <input type="text" name="nama" class="form-control" placeholder="Nama Program Studi" value="{{ $program_studi->nama }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 form-control-label">Deskripsi</label>
                            <div class="col-sm-6">
                                <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" value="{{ $program_studi->deskripsi }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-primary" value="Simpan">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
