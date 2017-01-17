<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use DB;
use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\Role;
use App\Models\Penilaian;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('programStudi')
            ->where('name', 'LIKE', '%'.$request->input('q').'%')
            ->orderBy('name')
            ->paginate(50);

        return view('user.index', compact('users', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create', ['roles' => Role::all(), 'program_studi' => ProgramStudi::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = null;
        $role = null;
        switch ($request->input('roles')) {
            case '1':
                $status = 'admin';
                $role = Role::where('name', 'administrator')->first();
                break;
            case '2':
                $status = 'kaprodi';
                $role = Role::where('name', 'kaprodi')->first();
                break;
            case '3':
                $status = 'dosen';
                $role = Role::where('name', 'dosen')->first();
                break;
            case '4':
                $status = 'mahasiswa';
                $role = Role::where('name', 'mahasiswa')->first();
                break;
            default:
                # code...
                break;
        }
        $user = new User;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->roles_id = $request->input('roles');
        $user->program_studi_id = $request->input('program_studi');
        $user->status = $status;
        $user->save();

        $user->attachRole($role);

        Session::flash('success_message', 'Berhasil menambah data.');
        return redirect()->route('user.index');
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
        return view('user.edit', [
            'user' => User::findOrFail($id),
            'program_studi' => ProgramStudi::all(),
            'roles' => Role::all()
        ]);
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
        $status = null;
        switch ($request->input('roles')) {
            case '1':
                $status = 'administrator';
                break;
            case '2':
                $status = 'kaprodi';
                break;
            case '3':
                $status = 'dosen';
                break;
            case '4':
                $status = 'mahasiswa';
                break;
            default:
                # code...
                break;
        }

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->roles_id = $request->input('roles');
        $user->program_studi_id = $request->input('program_studi');
        $user->status = $status;
        $user->save();

        Session::flash('success_message', 'Berhasil merubah data.');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count_user = DB::table('penilaian')
            ->where('tahun', date('Y'))
            ->orWhere(function ($query) {
                $query->orWhere('user_id', auth()->user()->id)->orWhere('user2_id', auth()->user()->id);
            })
            ->count();

        if ($count_user > 0) {
            Session::flash('warning_message', 'User tidak bisa dihapus.');
            return redirect()->route('user.index');
        }

        User::destroy($id);
        Session::flash('success_message', 'Berhasil menghapus data.');
        return redirect()->route('user.index');
    }
}
