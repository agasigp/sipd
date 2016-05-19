<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Session;
use App\Models\User;
use App\Models\Aspek;

class DosenController extends Controller
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
                (select sum(nilai)
                    FROM penilaian WHERE user2_id = @id AND semester = ? AND tahun = ? AND user_id = ?)
                AS skor,
                users.id,
                users.program_studi_id,
                users.name,
                users.status
            FROM users
            WHERE users.status = 'dosen' AND
            users.program_studi_id = ? AND
            users.id <> ?
            ORDER BY name ASC
        ", [
            $this->getSemester(), date('Y'),
            auth()->user()->id,
            auth()->user()->program_studi_id,
            auth()->user()->id
        ]);

        return view('dosen.index', compact('dosen'));
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
            ->sum('nilai');

        $dosen = User::findOrFail($request->input('dosen'));
        if ($skor > 0) {
            Session::flash(
                'info_message',
                "Anda telah memberikan penilaian kepada $dosen->name. Silahkan pilih dosen yang lain"
            );
            return redirect()->route('dosen.index');
        }

        $aspek_pedagogik = Aspek::where('kompetensi_id', 1)->where('roles_id', auth()->user()->roles_id)->get();
        $aspek_profesional = Aspek::where('kompetensi_id', 2)->where('roles_id', auth()->user()->roles_id)->get();
        $aspek_kepribadian = Aspek::where('kompetensi_id', 3)->where('roles_id', auth()->user()->roles_id)->get();
        $aspek_sosial = Aspek::where('kompetensi_id', 4)->where('roles_id', auth()->user()->roles_id)->get();

        return view('dosen.input', [
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
        $data = [];
        foreach ($request->input('skor') as $key => $val) {
            array_push($data, [
                'aspek_id' => $request->input('aspek_id')[$key],
                'user_id' => auth()->user()->id,
                'user2_id' => $request->input('dosen_id'),
                'nilai' => $val,
                'semester' => $this->getSemester(),
                'tahun' => date('Y')
            ]);
        }

        DB::table('penilaian')->insert($data);
        Session::flash('success_message', 'Terima kasih telah memberikan penilaian');
        return redirect()->route('dosen.index');
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
