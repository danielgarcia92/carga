<?php

namespace App\Http\Controllers;

use App\User;
use App\Emails;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**  @return void */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function usersAction()
    {
        if (Auth::user()->rol == 'admin') {

            $users = User::orderBy('id', 'ASC')->get();

            return view('admin.users')
                ->with('title', 'Actualización de Usuarios')
                ->with(compact('users'));
        }

        return redirect()->route('home');
    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function emailsAction()
    {
        if (Auth::user()->rol == 'admin') {

            $emails = Emails::select('emails.id', 'emails.email', 'areas.name AS area', 'airports.name AS airport', 'emails.active')
                            ->join('areas', 'emails.areas_id', '=', 'areas.id')
                            ->join('airports', 'emails.airports_id', '=', 'airports.id')
                            ->get();

            return view('admin.emails')
                ->with('title', 'Actualización de correos de copia de las solicitudes')
                ->with(compact('emails'));
        }

        return redirect()->route('home');
    }
}
