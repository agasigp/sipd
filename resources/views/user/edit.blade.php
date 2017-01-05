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
                <div class="panel-heading">Edit User</div>
                <div class="panel-body">
                    <form action="{{ route('user.update', $user->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 form-control-label">Nama</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" placeholder="Nama User" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 form-control-label">Username</label>
                            <div class="col-sm-6">
                                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ $user->username }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 form-control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 form-control-label">Program Studi</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="program_studi">
                                    @foreach($program_studi as $ps)
                                        <?php $selected = ($ps->id == $user->program_studi_id) ? 'selected' : '' ?>
                                        <option value="{{ $ps->id }}" {{ $selected }}>{{ $ps->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 form-control-label">Status</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="roles">
                                    @foreach($roles as $role)
                                        <?php $selected = ($role->id == $user->roles_id) ? 'selected' : '' ?>
                                        <option value="{{ $role->id }}" {{ $selected }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
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
