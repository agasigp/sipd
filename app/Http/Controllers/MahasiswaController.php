<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Session;
use App\Models\User;
use App\Models\Aspek;

class MahasiswaController extends Controller
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
        $dosen = DB::select("
        SELECT
            @id:=users.id,
            (SELECT COUNT(id) FROM penilaian
            WHERE user_id = ?
            AND user2_id = @id AND semester = ? AND tahun = ?)
            AS count_mhs,
            users.id,
            users.program_studi_id,
            users.name,
            users.status
        FROM users
        WHERE users.program_studi_id = ? AND
            users.status = 'dosen'
        ORDER BY name ASC
        ", [
            auth()->user()->id,
            $this->getSemester(),
            date('Y'),
            auth()->user()->program_studi_id
        ]);

        return view('mahasiswa.index', compact('dosen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $skor = DB::table('penilaian')
            ->where('user2_id', $request->input('dosen'))
            ->where('user_id', auth()->user()->id)
            ->where('semester', $this->getSemester())
            ->where('tahun', date('Y'))
            ->count();

        $dosen = User::findOrFail($request->input('dosen'));
        if ($skor > 0) {
            Session::flash(
                'info_message',
                "Anda telah memberikan penilaian kepada $dosen->name. Silahkan pilih dosen yang lain"
            );
            return redirect()->route('mahasiswa.index');
        }

        $aspek_pedagogik = Aspek::where('kompetensi_id', 1)->where('roles_id', auth()->user()->roles_id)->get();
        $aspek_profesional = Aspek::where('kompetensi_id', 2)->where('roles_id', auth()->user()->roles_id)->get();
        $aspek_kepribadian = Aspek::where('kompetensi_id', 3)->where('roles_id', auth()->user()->roles_id)->get();
        $aspek_sosial = Aspek::where('kompetensi_id', 4)->where('roles_id', auth()->user()->roles_id)->get();

        return view('mahasiswa.input', [
            'aspek_pedagogik' => $aspek_pedagogik,
            'aspek_profesional' => $aspek_profesional,
            'aspek_kepribadian' => $aspek_kepribadian,
            'aspek_sosial' => $aspek_sosial,
            'dosen' => User::findOrFail($request->input('dosen'))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sum_skor = array_sum($request->input('skor'));

        $penilaian = DB::table('penilaian')->insert([
            'user_id' => auth()->user()->id,
            'user2_id' => $request->input('dosen_id'),
            'semester' => $this->getSemester(),
            'tahun' => date('Y'),
            'skor' => $sum_skor
        ]);

        Session::flash('success_message', 'Terima kasih telah memberikan penilaian');

        return redirect()->route('mahasiswa.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getSemester()
    {
        return (int) date('n') > 6 ? 1 : 2;
    }
}
