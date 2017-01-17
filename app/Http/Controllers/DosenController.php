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
        $this->middleware(['auth', 'role:dosen']);
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
            users.status = 'dosen' AND
            users.id <> ?
        ORDER BY name ASC
        ", [
            auth()->user()->id,
            $this->getSemester(),
            date('Y'),
            auth()->user()->program_studi_id,
            auth()->user()->id
        ]);

        $count_mahasiswa = DB::select("
            SELECT COUNT(id) AS count FROM penilaian
            WHERE user_id IN
                (SELECT id FROM users WHERE status = 'mahasiswa' AND program_studi_id = ?)
            AND user2_id = ? AND semester = ? AND tahun = ?", [
                auth()->user()->program_studi_id,
                auth()->user()->id,
                $this->getSemester(),
                date('Y')
            ])[0];

        $sum_skor_mahasiswa = DB::select("
            SELECT SUM(skor) AS skor FROM penilaian
            WHERE user_id IN
                (SELECT id FROM users WHERE status = 'mahasiswa' AND program_studi_id = ?)
            AND user2_id = ?
            AND semester = ?
            AND tahun =  ?
        ", [
            auth()->user()->program_studi_id,
            auth()->user()->id,
            $this->getSemester(),
            date('Y')
        ])[0];

        $count_dosen = DB::select("
            SELECT COUNT(id) AS count FROM penilaian
            WHERE user_id IN
                (SELECT id FROM users WHERE status = 'dosen' AND program_studi_id = ? AND id <> ?)
            AND user2_id = ? AND semester = ? AND tahun = ?", [
                auth()->user()->program_studi_id,
                auth()->user()->id,
                auth()->user()->id,
                $this->getSemester(),
                date('Y')
            ])[0];

        $sum_skor_dosen = DB::select("
            SELECT SUM(skor) AS skor FROM penilaian
            WHERE user_id IN
                (SELECT id FROM users WHERE status = 'dosen' AND program_studi_id = ? AND id <> ?)
            AND user2_id = ? AND semester = ? AND tahun =  ?
        ", [
            auth()->user()->program_studi_id,
            auth()->user()->id,
            auth()->user()->id,
            $this->getSemester(),
            date('Y')
        ])[0];

        $sum_skor_kaprodi = DB::select("
            SELECT SUM(skor) AS skor FROM penilaian
            WHERE user_id IN
                (SELECT id FROM users WHERE status = 'kaprodi' AND program_studi_id = ?)
            AND user2_id = ? AND semester = ? AND tahun =  ?
        ", [
            auth()->user()->program_studi_id,
            auth()->user()->id,
            $this->getSemester(),
            date('Y')
        ])[0];

        $count_aspek = Aspek::where('roles_id', auth()->user()->roles_id)->count();
        $skor_mahasiswa = $count_mahasiswa->count === 0 ? 0 : $sum_skor_mahasiswa->skor / ($count_aspek * $count_mahasiswa->count);
        $skor_dosen = $count_dosen->count === 0 ? 0 : $sum_skor_dosen->skor / ($count_aspek * $count_dosen->count);
        $skor_kaprodi = (is_null($sum_skor_kaprodi->skor) ? 0 : $sum_skor_kaprodi->skor / $count_aspek);

        return view('dosen.index', [
            'dosen' => $dosen,
            'count_mahasiswa' => $count_mahasiswa->count,
            'skor_mahasiswa' => $skor_mahasiswa,
            'count_dosen' => $count_dosen->count,
            'skor_dosen' => $skor_dosen,
            'skor_kaprodi' => $skor_kaprodi
        ]);
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
        $sum_skor = array_sum($request->input('skor'));

        $penilaian = DB::table('penilaian')->insert([
            'user_id' => auth()->user()->id,
            'user2_id' => $request->input('dosen_id'),
            'semester' => $this->getSemester(),
            'tahun' => date('Y'),
            'skor' => $sum_skor
        ]);

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
