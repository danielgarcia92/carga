<?php

namespace App\Http\Controllers;

use App\Airports;
use App\Emails;
use App\Origin;
use App\Upload;
use App\UploadDetails;
use App\CargoAerocharter;
use App\vvCargoAerocharter;
use Illuminate\Http\Request;
use App\Mail\RequestAerocharter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AerocharterController extends Controller
{
    /**  @return void */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function indexAction()
    {
        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            $dateZulu = date("Y-m-d H:i:s", strtotime('+1 hour'));
            date_default_timezone_set("America/Monterrey");
            $from = Airports::where('id', '=', Auth::user()->airports_id)->get('name');

            $cargo = vvCargoAerocharter::where('OUT', '>=', date("Y-m-d"))
                                     ->where('inForm', '=', 0)
                                     ->where('portFrom', '=', $from[0]->name)
                                     ->where('OUTZulu', '>=', $dateZulu )
                                     ->groupBy('IdMensajeRCV', 'flight', 'country_code', 'flight_type', 'OUTZulu')
                                     ->orderBy('OUTZulu', 'DESC')
                                     ->get(['idMensajeRCV', 'flight', 'country_code', 'flight_type', 'OUTZulu']);

            return view('aerocharter.index')
                ->with('title', 'Carga de información Champ')
                ->with(compact('cargo'));
        }

        return redirect()->route('home');
    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function formAction()
    {
        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            $idMensajeRCV = request()->validate([ 'idMensajeRCV' => 'required' ]);

            $data = vvCargoAerocharter::where('idMensajeRCV', '=', $idMensajeRCV)->get();

            return view('aerocharter.form')
                ->with('title', 'Carga de información Champ')
                ->with(compact('data'));
        }

        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function storeAction(Request $request)
    {
        if (Auth::user()->rol == 'aerocharter') {
            $totalPieces = 0;
            $totalVolume = 0.0;
            $totalWeight = 0.0;

            $path = NULL;
            if (request()->file('file'))
                $path = Storage::disk('public')->put('image', request()->file('file'));

            $inter_cargo = NULL;
            if (request()->input('int_cargo'))
                $inter_cargo = request()->input('$inter_cargo');

            foreach ($request->input('pieces') as $r => $piece) {
                if ($request->input('partial')[$r] == 0)
                    $totalPieces += $piece;
                else
                    $totalPieces += $request->input('partial')[$r];
            }

            foreach ($request->input('volume') as $volume)
                $totalVolume += $volume;

            foreach ($request->input('weight') as $weight)
                $totalWeight += $weight;

            $req['from_id'] = Airports::where('name', $request->input('from'))->get();
            $req['to_id'] = Airports::where('name', $request->input('to'))->get();

            if ( $req['from_id']->count() > 0) {
                foreach ($req['from_id'] as $r)
                    $req['from_id'] = $r->id;
            } else
                $req['from_id'] = 0;

            if ( $req['to_id']->count() > 0) {
                foreach ($req['to_id'] as $r)
                    $req['to_id'] = $r->id;
            } else
                $req['to_id'] = 0;

            $data = Upload::updateOrCreate([
                'std'           => $request->input('Std'),
                'std_zulu'      => $request->input('StdZulu'),
                'from_id'       => $req['from_id'],
                'from'          => strtoupper($request->input('from')),
                'to_id'         => $req['to_id'],
                'to'            => strtoupper($request->input('to')),
                'flight_number' => $request->input('flight_number'),
                'rego'          => strtoupper($request->input('rego')),

                'pieces'        => $totalPieces,
                'volume_unit'   => 'MC',
                'volume'        => $totalVolume,
                'weight'        => $totalWeight,

                'country_code'  => $request->input('country_code'),
                'flight_type'   => $request->input('flight_type'),
                'description'   => $request->input('description'),
                'assurance'     => $request->input('assurance'),
                'packing'       => $request->input('packing'),
                'file'          => $path,
                'inter_cargo'   => $inter_cargo,

                'origins_id' => 2,
                'created_by' => Auth::user()->getAuthIdentifier(),
                'send'       => Auth::user()->name,
            ]);

            $items['guide_number'] = $request->get('guide_number');
            $items['pieces'] = $request->get('pieces');
            $items['weight'] = $request->get('weight');
            $items['volume'] = $request->get('volume');
            $items['partial'] = $request->get('partial');
            $items['density'] = $request->get('density');
            $items['nature_goods'] = $request->get('nature_goods');
            $items['route_item'] = $request->get('route_item');

            foreach ($items['guide_number'] as $item => $value) {
                UploadDetails::updateOrCreate([
                    'guide_number' => $items['guide_number'][$item],
                    'pieces'  => $items['pieces'][$item],
                    'weight'  => $items['weight'][$item],
                    'volume'  => $items['volume'][$item],
                    'partial' => $items['partial'][$item],
                    'density' => $items['density'][$item],
                    'nature_goods' => $items['nature_goods'][$item],
                    'route_item' => $items['route_item'][$item],
                    'uploads_id' => $data->id
                ]);
            }

            CargoAerocharter::where('idMensajeRCV', '=', $request->input('idMensajeRCV'))->update(array('inForm' => 1));

            $to = ['ccv@vivaaerobus.com', Auth::user()->email];

            $emails = Emails::where(function($query) use ($req) {
                                $query->where('areas_id', '=', 1)
                                      ->orWhere('areas_id', Auth::user()->areas_id);
                            })
                            ->where(function($query) use ($req) {
                                $query->where('airports_id', '=' , $req['from_id'])
                                      ->orWhere('airports_id', '=' , $req['to_id'])
                                      ->orWhere('airports_id', '=', 1);
                            })
                            ->where('active', 1)
                            ->get('email');

            foreach ($emails as $email)
                array_push($to, $email->email);

            $subject = 'Carga: Solicitud Aerocharter Enviada ' . $data['flight_number'] . ' ' . $data['from'] . '-' . $data['to'] . ' ' . $data['std_zulu'];

            Mail::to($to)->queue(new RequestAerocharter($data, $items, $subject, $path));

            return redirect()->route('aerocharter.success');
        }

        return redirect()->route('home');

    }

    public function requestsAction()
    {
        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {
            $origins = Origin::where('name', '=', Auth::user()->rol)->get('id');

            if (isset($origins[0]->id)) {
                $approved = Upload::sortable(['id' => 'desc'])
                    ->where('origins_id', '=', $origins[0]->id)
                    ->where('created_by', '=', Auth::user()->id)
                    ->where('accept', '=', 1)
                    ->where('std_zulu', '<>', NULL)
                    ->paginate(50);

                $pending = Upload::sortable(['id' => 'desc'])
                    ->where('origins_id', '=', $origins[0]->id)
                    ->where('created_by', '=', Auth::user()->id)
                    ->where('accept', '=', NULL)
                    ->where('std_zulu', '<>', NULL)
                    ->paginate(50);

                $rejected = Upload::sortable(['id' => 'desc'])
                    ->where('origins_id', '=', $origins[0]->id)
                    ->where('created_by', '=', Auth::user()->id)
                    ->where('accept', '=', 0)
                    ->where('std_zulu', '<>', NULL)
                    ->paginate(50);
            }
            else {
                $approved = [];
                $pending  = [];
                $rejected = [];
            }

            return view('aerocharter.requests')
                ->with(compact('approved'))
                ->with(compact('pending'))
                ->with(compact('rejected'))
                ->with('title', 'Mis solicitudes');
        }

        return redirect()->route('home');
    }

    public function detailsAction(Upload $row)
    {
        if (Auth::user()->rol == 'aerocharter' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {
            $details = UploadDetails::where('uploads_id', '=', $row->id)
                                    ->where(function($query) {
                                            $query->where('accept', '=', 1)
                                            ->orWhere('accept', '=', NULL);
                                    })->get();

            return view('aerocharter.details')
                ->with('title', 'Detalles de la carga en vuelo - ')
                ->with(compact(['row', 'details']));
        }

        return redirect()->route('home');
    }

    public function successAction()
    {
        return view('aerocharter.success');
    }

}
