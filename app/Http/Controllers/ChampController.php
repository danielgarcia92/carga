<?php

namespace App\Http\Controllers;

use App\Mail\ChampNotification;
use App\Upload;
use App\UploadDetails;
use App\CargoAerocharter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $date = getdate();
        $date = $date["year"] . "-" . $date["mon"] . "-" . $date["mday"]. " 00:00:00.000";

        $cargo = CargoAerocharter::where('STD', '>=', '2020-11-17 00:00:00.000')
                ->where('inForm', '=', 0)
                ->groupBy('IdMensajeRCV', 'flight', 'STD')
                ->orderBy('STD', 'desc')
                ->get(['idMensajeRCV', 'flight', 'STD']);

        if (Auth::user()->rol == 'champ' || Auth::user()->rol == 'admin') {
            return view('champ.index')
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

        if (Auth::user()->rol == 'champ' || Auth::user()->rol == 'admin') {
            return view('champ.form')
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

        foreach ($request->input('piecesNumber') as $piece)
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

        $guideNumber  = $request->get('guideNumber');
        $piecesNumber = $request->get('piecesNumber');
        $weight       = $request->get('weight');
        $volume       = $request->get('volume');
        $natureGoods  = $request->get('natureGoods');
        $routeItem    = $request->get('routeItem');

        foreach ($guideNumber as $item => $value) {
            UploadDetails::updateOrCreate([
                'guide_number'  => $guideNumber[$item],
                'pieces'        => $piecesNumber[$item],
                'weight'        => $weight[$item],
                'volume'        => $volume[$item],
                'nature_goods'  => $natureGoods[$item],
                'route_item'    => $routeItem[$item],
                'uploads_id'    => $data->id
            ]);
        }

        CargoAerocharter::where('idMensajeRCV', '=', $request->input('idMensajeRCV'))->update(array('inForm' => 1));

        Mail::to(Auth::user()->email )->queue(new ChampNotification($data));

        return view('champ.success');
    }
}
