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
                ->with('title', 'Sistema de Carga-Comat')
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
        $base = User::where('id',$row->created_by)->get('base');
        $to = ['ccv@vivaaerobus.com', $created_by[0]->email, 'sergio.esquivel@vivaaerobus.com', 'juan.beltran@vivaaerobus.com'];

        if ($base[0]->base == 'CUN' || $row->to == 'CUN')
            array_push($to, RouteServiceProvider::ALMACEN_CUN);

        if ($base[0]->base == 'GDL' || $row->to == 'GLD')
            array_push($to, RouteServiceProvider::ALMACEN_GDL);

        if ($base[0]->base == 'MEX' || $row->to == 'MEX')
            array_push($to, RouteServiceProvider::ALMACEN_MEX);

        if ($base[0]->base == 'MTY' || $row->to == 'MTY')
            array_push($to, RouteServiceProvider::ALMACEN_MTY);

        if ($base[0]->base == 'TIJ' || $row->to == 'TIJ')
            array_push($to, RouteServiceProvider::ALMACEN_TIJ);

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
