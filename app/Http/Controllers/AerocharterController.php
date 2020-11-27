<?php

namespace App\Http\Controllers;

use App\Mail\AerocharterNotification;
use App\Origin;
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
            'flight_number' => $request->input('flightNumber'),
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

        $items['guideNumber']  = $request->get('guideNumber');
        $items['piecesNumber'] = $request->get('pieces');
        $items['weight']       = $request->get('weight');
        $items['volume']       = $request->get('volume');
        $items['natureGoods']  = $request->get('natureGoods');
        $items['routeItem']    = $request->get('routeItem');

        foreach ($items['guideNumber'] as $item => $value) {
            UploadDetails::updateOrCreate([
                'guide_number'  => $items['guideNumber'][$item],
                'pieces'        => $items['piecesNumber'][$item],
                'weight'        => $items['weight'][$item],
                'volume'        => $items['volume'][$item],
                'nature_goods'  => $items['natureGoods'][$item],
                'route_item'    => $items['routeItem'][$item],
                'uploads_id'    => $data->id
            ]);
        }

        CargoAerocharter::where('idMensajeRCV', '=', $request->input('idMensajeRCV'))->update(array('inForm' => 1));

        $to = ['ccv@vivaaerobus.com', Auth::user()->email, 'vivacargo@vivaaerobus.com'];
        Mail::to( $to )->queue(new AerocharterNotification($data, $items));

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
        }
        else {
            return view('/home');
        }
    }
}
