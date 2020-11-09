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

    /** @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View */
    public function indexAction()
    {
        $uploads = Upload::sortable()->paginate(10000);

        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'admin') {
            return view('main.index')
                ->with('title', 'Sistema de carga')
                ->with(compact('uploads'));
        }
        else {
            return view('/home');
        }
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

        return redirect()->route('main.index');
    }

    public function destroyAction(Upload $row)
    {
        $row->delete();

        return redirect()->route('main.index');
    }
}
