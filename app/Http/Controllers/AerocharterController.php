<?php

namespace App\Http\Controllers;

use App\Mail\RequestAerocharter;
use App\Origin;
use App\Providers\RouteServiceProvider;
use App\Upload;
use App\UploadDetails;
use App\CargoAerocharter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AerocharterController extends Controller
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
        $date = getdate();
        $date = $date["year"] . "-" . $date["mon"] . "-" . $date["mday"]. " 00:00:00.000";

        $cargo = CargoAerocharter::where('STD', '>=', '2020-11-17 00:00:00.000')
                ->where('inForm', '=', 0)
                ->groupBy('IdMensajeRCV', 'flight', 'STD')
                ->orderBy('STD', 'desc')
                ->get(['idMensajeRCV', 'flight', 'STD']);

        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'admin') {
            return view('aerocharter.index')
                ->with('title', 'Carga de información Champ')
                ->with(compact('cargo'));
        }
        else {
            return view('/home');
        }
    }

    /** @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View */
    public function formAction()
    {
        $idMensajeRCV = request()->validate([
            'idMensajeRCV' => 'required'
        ], [
            'idMensajeRCV.required' => 'El campo idMensajeRCV es obligatorio'
        ]);

        $data = CargoAerocharter::where('idMensajeRCV', '=', $idMensajeRCV)->get();

        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'admin') {
            return view('aerocharter.form')
                ->with('title', 'Carga de información Champ')
                ->with(compact('data'));
        }
        else {
            return view('/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function storeAction(Request $request)
    {
        $totalPieces = 0;
        $totalVolume = 0.0;
        $totalWeight = 0.0;

        foreach ($request->input('pieces') as $piece)
            $totalPieces += $piece;

        foreach ($request->input('volume') as $volume)
            $totalVolume += $volume;

        foreach ($request->input('weight') as $weight)
            $totalWeight += $weight;

        $data = Upload::updateOrCreate([
            'std'           => $request->input('std'),
            'from'          => $request->input('from'),
            'to'            => $request->input('to'),
            'flight_number' => $request->input('flight_number'),
            'rego'          => $request->input('rego'),

            'pieces'        => $totalPieces,
            'volume_unit'   => 'MC',
            'volume'        => $totalVolume,
            'weight'        => $totalWeight,

            'description'   => $request->input('description'),
            'assurance'     => $request->input('assurance'),
            'packing'       => $request->input('packing'),

            'origins_id'    => 2,
            'created_by'    => Auth::user()->getAuthIdentifier(),
        ]);

        $items['guide_number']  = $request->get('guide_number');
        $items['pieces']        = $request->get('pieces');
        $items['weight']        = $request->get('weight');
        $items['volume']        = $request->get('volume');
        $items['nature_goods']  = $request->get('nature_goods');
        $items['route_item']    = $request->get('route_item');

        foreach ($items['guide_number'] as $item => $value) {
            UploadDetails::updateOrCreate([
                'guide_number'  => $items['guide_number'][$item],
                'pieces'        => $items['pieces'][$item],
                'weight'        => $items['weight'][$item],
                'volume'        => $items['volume'][$item],
                'nature_goods'  => $items['nature_goods'][$item],
                'route_item'    => $items['route_item'][$item],
                'uploads_id'    => $data->id
            ]);
        }

        CargoAerocharter::where('idMensajeRCV', '=', $request->input('idMensajeRCV'))->update(array('inForm' => 1));

        $to = ['ccv@vivaaerobus.com', Auth::user()->email, 'vivacargo@vivaaerobus.com', 'gfranco@aerocharter.com.mx', 'seguridad.calidad@aerocharter.com.mx', 'smendoza@aerocharter.com.mx'];

        if ($data['from'] == 'CUN' || $data['to'] == 'CUN')
            array_push($to, RouteServiceProvider::SAEROCHARTER_CUN, RouteServiceProvider::MAEROCHARTER_CUN);
        if ($data['from'] == 'GDL' || $data['to'] == 'GLD')
            array_push($to, RouteServiceProvider::SAEROCHARTER_GDL, RouteServiceProvider::MAEROCHARTER_GDL);
        if ($data['from'] == 'MEX' || $data['to'] == 'MEX')
            array_push($to, RouteServiceProvider::SAEROCHARTER_MEX, RouteServiceProvider::MAEROCHARTER_MEX);
        if ($data['from'] == 'MTY' || $data['to'] == 'MTY')
            array_push($to, RouteServiceProvider::SAEROCHARTER_MTY, RouteServiceProvider::MAEROCHARTER_MTY);
        if ($data['from'] == 'TIJ' || $data['to'] == 'TIJ')
            array_push($to, RouteServiceProvider::SAEROCHARTER_TIJ, RouteServiceProvider::MAEROCHARTER_TIJ);
        if ($data['from'] == 'QRO' || $data['to'] == 'QRO')
            array_push($to, RouteServiceProvider::SAEROCHARTER_QRO, RouteServiceProvider::MAEROCHARTER_QRO);
        if ($data['from'] == 'MID' || $data['to'] == 'MID')
            array_push($to, RouteServiceProvider::SAEROCHARTER_MID, RouteServiceProvider::MAEROCHARTER_MID);
        if ($data['from'] == 'OAX' || $data['to'] == 'OAX')
            array_push($to, RouteServiceProvider::SAEROCHARTER_OAX, RouteServiceProvider::MAEROCHARTER_OAX);
        if ($data['from'] == 'SJD' || $data['to'] == 'SJD')
            array_push($to, RouteServiceProvider::SAEROCHARTER_SJD, RouteServiceProvider::MAEROCHARTER_SJD);
        if ($data['from'] == 'CJS' || $data['to'] == 'CJS')
            array_push($to, RouteServiceProvider::SAEROCHARTER_CJS, RouteServiceProvider::MAEROCHARTER_CJS);
        if ($data['from'] == 'CUL' || $data['to'] == 'CUL')
            array_push($to, RouteServiceProvider::SAEROCHARTER_CUL, RouteServiceProvider::MAEROCHARTER_CUL);

        Mail::to( $to )->queue(new RequestAerocharter($data, $items));

        return view('aerocharter.success');
    }

    public function requestsAction()
    {
        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'admin') {
            $origins = Origin::where('name', '=', Auth::user()->rol)->get('id');

            if (isset($origins[0]->id))
                $uploads = Upload::where('origins_id', '=', $origins[0]->id)->get();
            else
                $uploads = [];

            return view('aerocharter.requests')
                ->with(compact('uploads'))
                ->with('title', 'Mis solicitudes');
        }
        else {
            return view('/home');
        }
    }

    public function detailsAction(Upload $row)
    {
        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'admin') {
            $details = UploadDetails::where('uploads_id', '=', $row->id)->get();

            return view('aerocharter.details')
                ->with('title', 'Detalles de la carga en vuelo - ')
                ->with(compact(['row', 'details']));
        } else {
            return view('/home');
        }
    }
}
