<?php

namespace App\Http\Controllers;

use App\Emails;
use App\Upload;
use App\Airports;
use App\Flights;
use App\Mail\RequestViva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /** @return void */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function indexAction()
    {
        if (Auth::user()->rol == 'viva' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            $dateZuluIni = date("Y-m-d H:i:s", strtotime('+1 hour'));
            $dateZuluFin = date("Y-m-d H:i:s", strtotime('+6 hour'));

            date_default_timezone_set("America/Monterrey");
            $flights= Flights::select('Dep', 'DepZulu', 'OUTZulu', 'Flight', 'PortFrom', 'PortTo', 'Rego')
                            ->whereBetween('SectorDate', [date("Y-m-d"), date("Y-m-d", strtotime("+1 day"))])
                            ->where('OUTZulu', '>=', $dateZuluIni )
                            ->where('OUTZulu', '<=', $dateZuluFin )
                            ->OrderBy('Flight')
                            ->get();

            return view('uploads.index')
                ->with('title', 'Formulario de solicitud')
                ->with(compact('flights'));
        }

        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function storeAction()
    {
        if (Auth::user()->rol == 'viva') {

            $to = ['ccv@vivaaerobus.com', Auth::user()->email];

            $path = NULL;
            if (request()->file('file'))
                $path = Storage::disk('public')->put('image', request()->file('file'));

            $email1 = NULL;
            if (request()->input('email1')) {
                $email1 = request()->input('email1');
                array_push($to, $email1);
            }
            $email2 = NULL;
            if (request()->input('email2')) {
                $email2 = request()->input('email2');
                array_push($to, $email2);
            }
            $email3 = NULL;
            if (request()->input('email3')) {
                $email3 = request()->input('email3');
                array_push($to, $email3);
            }

            $req = request()->validate([
                'std'           => 'required|date',
                'stdZulu'       => 'required|date',
                'from'          => 'required|max:3',
                'to'            => 'required|max:3',
                'flight_number' => 'required|max:5',
                'rego'          => 'required|max:6',
                'pieces'        => 'required',
                'weight'        => 'required',
                'volume'        => 'max:6',
                'send'          => 'required|max:100',
                'description'   => 'required|max:100',
                'assurance'     => 'required|max:100',
                'packing'       => 'required|max:100'
            ], [
                'std.required'           => 'El campo Fecha de vuelo es obligatorio',
                'stdZulu.required'       => 'El campo Fecha de vuelo Zulu es obligatorio',
                'from.required'          => 'El campo Aeropuerto de salida es obligatorio',
                'from.size'              => 'Aeropuerto de salida: máximo 3 dígitos',
                'to.required'            => 'El campo Aeropuerto de llegada es obligatorio',
                'to.size'                => 'Aeropuerto de llegada: máximo 3 dígitos',
                'flight_number.required' => 'El campo Número de vuelo es obligatorio',
                'flight_number.length'   => 'Número de vuelo: máximo 4 dígitos',
                'rego.required'          => 'El campo Matrícula es obligatorio',
                'rego.size'              => 'Matrícula: máximo 6 dígitos',
                'pieces.required'        => 'El campo Número de Piezas es obligatorio',
                'weight.required'        => 'El campo Peso es obligatorio',
                'send.required'          => 'El campo Envía es obligatorio',
                'send.size'              => 'Envía: Máximo 100 caracteres',
                'description.required'   => 'El campo Descripción es obligatorio',
                'description.size'       => 'Descripción: Máximo 100 caracteres',
                'assurance.required'     => 'El campo Método de aseguramiento es obligatorio',
                'assurance.size'         => 'Método de aseguramiento: Máximo 100 caracteres',
                'packing.required'       => 'El campo Embalaje es obligatorio',
                'packing.size'           => 'Embalaje: Máximo 100 caracteres'
            ]);

            $req['from_id'] = Airports::where('name', $req['from'])->get();
            $req['to_id'] = Airports::where('name', $req['to'])->get();

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
                'flight_number' => 'VB' . $req['flight_number'],
                'std'           => date('Y-m-d H:i:s', strtotime($req['std'])),
                'std_zulu'      => date('Y-m-d H:i:s', strtotime($req['stdZulu'])),
                'from_id'       => $req['from_id'],
                'from'          => strtoupper($req['from']),
                'to_id'         => $req['to_id'],
                'to'            => strtoupper($req['to']),
                'rego'          => strtoupper($req['rego']),
                'pieces'        => $req['pieces'],
                'volume'        => $req['volume'],
                'send'          => Auth::user()->name,
                'description'   => $req['description'],
                'assurance'     => $req['assurance'],
                'packing'       => $req['packing'],
                'weight'        => $req['weight'],
                'volume_unit'   => 'MC',
                'origins_id'    => 1,
                'created_by'    => Auth::user()->getAuthIdentifier(),
                'file'          => $path,
                'email1'        => $email1,
                'email2'        => $email2,
                'email3'        => $email3,
                'country_code'  => 'MX',
                'flight_type'   => 'NACIONAL'
            ]);

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

            $subject = 'Comat: Solicitud Enviada ' . 'VB' . $req['flight_number'] . ' ' . $req['from'] . '-' . $req['to'] . ' ' . $req['stdZulu'];

            Mail::to($to)->queue(new RequestViva($data, $subject, $path));

            return redirect()->route('uploads.success');
        }

        return redirect()->route('home');
    }

    public function requestsAction()
    {
        if (Auth::user()->rol == 'viva' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {
            $pending  = Upload::sortable(['id' => 'desc'])->where('created_by', '=', Auth::user()->id)->where('accept', '=', NULL)->where('std_zulu', '<>', NULL)->paginate(50);
            $approved = Upload::sortable(['id' => 'desc'])->where('created_by', '=', Auth::user()->id)->where('accept', '=', 1)->where('std_zulu', '<>', NULL)->paginate(50);
            $rejected = Upload::sortable(['id' => 'desc'])->where('created_by', '=', Auth::user()->id)->where('accept', '=', 0)->where('std_zulu', '<>', NULL)->paginate(50);

            return view('uploads.requests')
                ->with(compact('pending'))
                ->with(compact('approved'))
                ->with(compact('rejected'))
                ->with('title', 'Mis solicitudes');
        }

        return redirect()->route('home');

    }

    public function detailsAction(Upload $row)
    {
        if (Auth::user()->rol == 'viva' || Auth::user()->rol == 'admin') {
            return view('uploads.details')
                ->with('title', 'Detalles de la carga en vuelo - ')
                ->with(compact('row'));
        }

        return redirect()->route('home');

    }

    public function successAction()
    {
        return view('uploads.success');
    }

}
