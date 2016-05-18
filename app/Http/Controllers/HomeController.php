<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('mahasiswa.index');
        } elseif ($user->hasRole('dosen')) {
            return redirect()->route('dosen.index');
        } elseif ($user->hasRole('kaprodi')) {
            return redirect()->route('kaprodi.index');
        }
    }
}
