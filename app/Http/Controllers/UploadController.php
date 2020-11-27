<?php

namespace App\Http\Controllers;

use App\Mail\FormNotification;
use App\Providers\RouteServiceProvider;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UploadController extends Controller
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
        if (Auth::user()->rol == 'viva' || Auth::user()->rol == 'admin') {
            return view('uploads.index')
                ->with('title', 'Carga de información');
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
    public function storeAction()
    {
        $data = request()->validate([
            'std'           => 'required|date',
            'from'          => 'required|max:3',
            'to'            => 'required|max:3',
            'flightNumber'  => 'required|max:4',
            'rego'          => 'required|max:6',
            'pieces'        => 'required',
            'weight'        => 'required',
            'volume'        => 'max:6',
            'send'          => 'required|max:100',
            'description'   => 'required|max:100',
            'assurance'     => 'required|max:100',
            'packing'       => 'required|max:100'
        ], [
            'std.required'          => 'El campo Fecha de vuelo es obligatorio',
            'from.required'         => 'El campo Aeropuerto de salida es obligatorio',
            'from.size'             => 'Aeropuerto de salida: máximo 3 dígitos',
            'to.required'           => 'El campo Aeropuerto de llegada es obligatorio',
            'to.size'               => 'Aeropuerto de llegada: máximo 3 dígitos',
            'flightNumber.required' => 'El campo Número de vuelo es obligatorio',
            'flightNumber.length'   => 'Número de vuelo: máximo 4 dígitos',
            'rego.required'         => 'El campo Matrícula es obligatorio',
            'rego.size'             => 'Matrícula: máximo 6 dígitos',
            'pieces.required'       => 'El campo Número de Piezas es obligatorio',
            'weight.required'       => 'El campo Peso es obligatorio',
            'send.required'         => 'El campo Envía es obligatorio',
            'send.size'             => 'Envía: Máximo 100 caracteres',
            'description.required'  => 'El campo Descripción es obligatorio',
            'description.size'      => 'Descripción: Maximo 100 caracteres',
            'assurance.required'    => 'El campo Método de aseguramiento es obligatorio',
            'assurance.size'        => 'Método de aseguramiento: Maximo 100 caracteres',
            'packing.required'      => 'El campo Embalaje es obligatorio',
            'packing.size'          => 'Embalaje: Maximo 100 caracteres'
        ]);

        Upload::updateOrCreate([
            'flight_number' => 'VB' . $data['flightNumber'],
            'std'           => date('Y-m-d H:i:s', strtotime($data['std'])),
            'from'          => $data['from'],
            'to'            => $data['to'],
            'rego'          => $data['rego'],
            'pieces'        => $data['pieces'],
            'volume'        => $data['volume'],
            'send'          => $data['send'],
            'description'   => $data['description'],
            'assurance'     => $data['assurance'],
            'packing'       => $data['packing'],
            'weight'        => $data['weight'],
            'volume_unit'   => 'MC',
            'origins_id'    => 1,
            'created_by'    => Auth::user()->getAuthIdentifier(),
        ]);

        $to = ['ccv@vivaaerobus.com', Auth::user()->email, 'sergio.esquivel@vivaaerobus.com', 'juan.beltran@vivaaerobus.com'];

        if ($data['from'] == 'CUN' || $data['to'] == 'CUN')
            array_push($to, RouteServiceProvider::ALMACEN_CUN);

        if ($data['from'] == 'GDL' || $data['to'] == 'GLD')
            array_push($to, RouteServiceProvider::ALMACEN_GDL);

        if ($data['from'] == 'MEX' || $data['to'] == 'MEX')
            array_push($to, RouteServiceProvider::ALMACEN_MEX);

        if ($data['from'] == 'MTY' || $data['to'] == 'MTY')
            array_push($to, RouteServiceProvider::ALMACEN_MTY);

        if ($data['from'] == 'TIJ' || $data['to'] == 'TIJ')
            array_push($to, RouteServiceProvider::ALMACEN_TIJ);

        Mail::to($to)->queue(new FormNotification($data));

        return view('uploads.success');
    }

    public function requestsAction()
    {
        $uploads = Upload::where('created_by', '=', Auth::user()->id)->get();

        if (Auth::user()->rol == 'viva' || Auth::user()->rol == 'admin') {
            return view('uploads.requests')
                ->with(compact('uploads'))
                ->with('title', 'Mis solicitudes');
        }
        else {
            return view('/home');
        }
    }

    public function detailsAction(Upload $row)
    {
        if (Auth::user()->rol == 'viva' || Auth::user()->rol == 'admin') {
            return view('uploads.details')
                ->with('title', 'Detalles de la carga en vuelo - ')
                ->with(compact('row'));
        }
        else {
            return view('/home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
        //
    }

}
