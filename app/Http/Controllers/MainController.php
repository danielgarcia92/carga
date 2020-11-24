<?php

namespace App\Http\Controllers;

use App\Mail\RejectedNotification;
use App\Providers\RouteServiceProvider;
use App\UploadDetails;
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

    public function formAction(Upload $row)
    {
        $details = UploadDetails::where('uploads_id', '=', $row->id)->get();

        return view('main.details')
            ->with('title', 'Detalles de la carga en vuelo - ')
            ->with(compact(['row', 'details']));
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
        $area = User::where('id',$row->created_by)->get('area');
        $to = ['ccv@vivaaerobus.com', $created_by[0]->email, 'sergio.esquivel@vivaaerobus.com', 'juan.beltran@vivaaerobus.com'];

        if ($area[0]->area == 'CUN')
            array_push($to, RouteServiceProvider::CUN);
        elseif ($area[0]->area == 'GDL')
            array_push($to, RouteServiceProvider::GDL);
        elseif ($area[0]->area == 'MEX')
            array_push($to, RouteServiceProvider::MEX);
        elseif ($area[0]->area == 'MTY')
            array_push($to, RouteServiceProvider::MTY);
        elseif ($area[0]->area == 'TIJ')
            array_push($to, RouteServiceProvider::TIJ);

        if ($row->accept == 1)
            Mail::to($to)->queue(new ApprovedNotification($row));
        else
            Mail::to($to)->queue(new RejectedNotification($row));

        return redirect()->route('main.index');
    }

    public function destroyAction(Upload $row)
    {
        $row->delete();

        return redirect()->route('main.index');
    }
}
