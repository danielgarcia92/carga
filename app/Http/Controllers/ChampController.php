<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ChampController extends Controller
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

    /** @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View */
    public function indexAction()
    {
        if (Auth::user()->rol == 'champ' || Auth::user()->rol == 'admin') {
            return view('champ.index')
                ->with('title', 'Carga de información Champ');
        }
        else {
            return view('/home');
        }
    }
}
