<?php

namespace App\Http\Controllers;

use App\User;
use App\Upload;
use App\UploadDetails;
use App\Mail\ApprovedViva;
use App\Mail\RejectedViva;
use App\Mail\ApprovedAerocharter;
use App\Mail\RejectedAerocharter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    /** @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View */
    public function indexAction()
    {
        $uploads = Upload::sortable()->paginate(1000);

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
        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'admin') {
            $data = request()->validate([
                'accept' => 'required',
                'approved_by' => 'required',
                'message_approval' => 'required'
            ], [
                'message_approval.required' => 'El campo Aprobar/Rechazar es obligatorio'
            ]);

            $row->update($data);

            $created_by = User::where('id', $row->created_by)->get('email');
            $items = UploadDetails::where('uploads_id', '=', $row->id)->get();

            if ($row->origins_id == 1){
                $to = ['ccv@vivaaerobus.com', $created_by[0]->email, 'sergio.esquivel@vivaaerobus.com', 'juan.beltran@vivaaerobus.com'];

                if ($row->email1)
                    array_push($to, $row->email1);
                if ($row->email2)
                    array_push($to, $row->email2);
                if ($row->email3)
                    array_push($to, $row->email3);
                if ($row->from == 'CUN' || $row->to == 'CUN')
                    array_push($to, RouteServiceProvider::ALMACEN_CUN);
                if ($row->from == 'GDL' || $row->to == 'GDL')
                    array_push($to, RouteServiceProvider::ALMACEN_GDL);
                if ($row->from == 'MEX' || $row->to == 'MEX')
                    array_push($to, RouteServiceProvider::ALMACEN_MEX);
                if ($row->from == 'MTY' || $row->to == 'MTY')
                    array_push($to, RouteServiceProvider::ALMACEN_MTY);
                if ($row->from == 'TIJ' || $row->to == 'TIJ')
                    array_push($to, RouteServiceProvider::ALMACEN_TIJ);

                if ($row->accept == 1)
                    Mail::to($to)->queue(new ApprovedViva($row));
                else
                    Mail::to($to)->queue(new RejectedViva($row));

            }else {
                $to = ['ccv@vivaaerobus.com', $created_by[0]->email, 'vivacargo@vivaaerobus.com', 'gfranco@aerocharter.com.mx', 'seguridad.calidad@aerocharter.com.mx', 'smendoza@aerocharter.com.mx'];

                if ($row->from == 'CUN' || $row->to == 'CUN')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_CUN, RouteServiceProvider::MAEROCHARTER_CUN);
                if ($row->from== 'GDL' || $row->to == 'GLD')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_GDL, RouteServiceProvider::MAEROCHARTER_GDL);
                if ($row->from == 'MEX' || $row->to == 'MEX')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_MEX, RouteServiceProvider::MAEROCHARTER_MEX);
                if ($row->from == 'MTY' || $row->to == 'MTY')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_MTY, RouteServiceProvider::MAEROCHARTER_MTY);
                if ($row->from == 'TIJ' || $row->to == 'TIJ')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_TIJ, RouteServiceProvider::MAEROCHARTER_TIJ);
                if ($row->from == 'QRO' || $row->to == 'QRO')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_QRO, RouteServiceProvider::MAEROCHARTER_QRO);
                if ($row->from == 'MID' || $row->to == 'MID')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_MID, RouteServiceProvider::MAEROCHARTER_MID);
                if ($row->from == 'OAX' || $row->to == 'OAX')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_OAX, RouteServiceProvider::MAEROCHARTER_OAX);
                if ($row->from == 'SJD' || $row->to == 'SJD')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_SJD, RouteServiceProvider::MAEROCHARTER_SJD);
                if ($row->from == 'CJS' || $row->to == 'CJS')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_CJS, RouteServiceProvider::MAEROCHARTER_CJS);
                if ($row->from == 'CUL' || $row->to == 'CUL')
                    array_push($to, RouteServiceProvider::SAEROCHARTER_CUL, RouteServiceProvider::MAEROCHARTER_CUL);

                if ($row->accept == 1)
                    Mail::to($to)->queue(new ApprovedAerocharter($row, $items));
                else
                    Mail::to($to)->queue(new RejectedAerocharter($row, $items));
            }

            return redirect()->route('main.index');

        } else {
            return view('/home');
        }
    }

    public function destroyAction(Upload $row)
    {
        $row->delete();

        return redirect()->route('main.index');
    }
}
