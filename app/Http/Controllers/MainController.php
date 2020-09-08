<?php

namespace App\Http\Controllers;

use App\Upload;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class MainController extends Controller
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

    /** @return \Illuminate\Http\Response */
    public function indexAction()
    {
        $uploads = Upload::all()->sortByDesc("std");

        $user = Auth::user()->rol;

        if ($user != 'request')
        {
            return view('main.index')
                ->with('title', 'Sistema de carga')
                ->with(compact('uploads'));
        }
        else
            return redirect('/');

    }

    public function updateAction(Upload $row)
    {
        $data = request()->validate([
            'accept' => 'required'
        ]);

        $row->update($data);

        return redirect()->route('main.index');
    }

    public function destroyAction(Upload $row)
    {
        $row->delete();

        return redirect()->route('main.index');
    }
}
