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
            <div class="panel panel-default">
                <div class="panel-heading">Penilaian Dosen</div>
                <div class="panel-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#dosen" aria-controls="dosen" role="tab" data-toggle="tab">Profil Dosen</a></li>
                        <li role="presentation"><a href="#pedagogik" aria-controls="pedagogik" role="tab" data-toggle="tab">Kompetensi Pedagogik</a></li>
                        <li role="presentation"><a href="#profesional" aria-controls="profesional" role="tab" data-toggle="tab">Kompetensi Profesional</a></li>
                        <li role="presentation"><a href="#kepribadian" aria-controls="kepribadian" role="tab" data-toggle="tab">Komptensi Kepribadian</a></li>
                        <li role="presentation"><a href="#sosial" aria-controls="sosial" role="tab" data-toggle="tab">Kompetensi Sosial</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <form action="{{ route('dosen.store') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="dosen">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Nama</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static">{{ $dosen->name }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-2 control-label">Program Studi</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static">{{ $dosen->programStudi->nama }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-2 control-label">Jabatan</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static">{{ $dosen->status }}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="pedagogik">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aspek</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                    @foreach($aspek_pedagogik as $aspek)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $aspek->nama }}</td>
                                            <td>
                                                <input
                                                    type="number"
                                                    name="skor[]"
                                                    class="form-control"
                                                    required="required"
                                                    value="1"
                                                    min="1" max="7">
                                            </td>
                                        </tr>
                                        <input type="hidden" name="aspek_id[]" value="{{ $aspek->id }}">
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="profesional">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aspek</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($aspek_profesional as $aspek)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $aspek->nama }}</td>
                                            <td>
                                                <input
                                                type="number"
                                                name="skor[]"
                                                class="form-control"
                                                required="required"
                                                value="1"
                                                min="1" max="7">
                                            </td>
                                        </tr>
                                        <input type="hidden" name="aspek_id[]" value="{{ $aspek->id }}">
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="kepribadian">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aspek</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($aspek_kepribadian as $aspek)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $aspek->nama }}</td>
                                            <td>
                                                <input
                                                    type="number"
                                                    name="skor[]"
                                                    class="form-control"
                                                    required="required"
                                                    value="1"
                                                    min="1" max="7">
                                                </td>
                                        </tr>
                                        <input type="hidden" name="aspek_id[]" value="{{ $aspek->id }}">
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="sosial">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aspek</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($aspek_sosial as $aspek)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $aspek->nama }}</td>
                                            <td>
                                                <input
                                                    type="number"
                                                    name="skor[]"
                                                    class="form-control"
                                                    required="required"
                                                    value="1"
                                                    min="1" max="7">
                                            </td>
                                        </tr>
                                        <input type="hidden" name="aspek_id[]" value="{{ $aspek->id }}">
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Simpan">
                            <a href="{{ route('dosen.index') }}" class="btn btn-info" role="button">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
