<?php

namespace App\Http\Controllers;

use App\Mail\RejectedNotification;
use App\User;
use App\Upload;
use App\Mail\ApprovedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            'accept'           => 'required',
            'approved_by'      => 'required',
            'message_approval' => 'required'
        ], [
            'message_approval.required' => 'El campo Aprobar/Rechazar es obligatorio'
        ]);

        $row->update($data);

        $created_by = User::where('id',$row->created_by)->get('email');

        if ($row->accept == 1)
            Mail::to(['ccv@vivaaerobus.com', $created_by[0]->email])->queue(new ApprovedNotification($row));
        else
            Mail::to(['ccv@vivaaerobus.com', $created_by[0]->email])->queue(new RejectedNotification($row));

        //return redirect()->route('main.index');
    }

    public function destroyAction(Upload $row)
    {
        $row->delete();

        return redirect()->route('main.index');
    }
}
