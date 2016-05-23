<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Models\ProgramStudi;

class ProgramStudiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('program_studi.index', ['program_studi' => ProgramStudi::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('program_studi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ProgramStudi::create($request->all());
        Session::flash('success_message', 'Berhasil menambah data.');
        return redirect()->route('program-studi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('program_studi.edit', ['program_studi' => ProgramStudi::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $program_studi = ProgramStudi::findOrFail($id);
        $program_studi->nama = $request->input('nama');
        $program_studi->deskripsi = $request->input('deskripsi');
        $program_studi->save();

        Session::flash('success_message', 'Berhasil merubah data.');
        return redirect()->route('program-studi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProgramStudi::destroy($id);
        Session::flash('success_message', 'Berhasil menghapus data.');
        return redirect()->route('program-studi.index');
    }
}
