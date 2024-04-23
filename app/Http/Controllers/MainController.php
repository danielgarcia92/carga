<?php

namespace App\Http\Controllers;

use App\User;
use App\Emails;
use App\Upload;
use Carbon\Carbon;
use App\UploadDetails;
use App\Mail\ApprovedViva;
use App\Mail\RejectedViva;
use App\vwUploadsNotification;
use App\Mail\ApprovedAerocharter;
use App\Mail\RejectedAerocharter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    /** @return void */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function indexAction()
    {
        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            date_default_timezone_set('UTC');

            $uploads = vwUploadsNotification::where('OUTZulu', '>=', date("Y-m-d", strtotime("-1 day")))
                    ->where('accept', '=', NULL)
                    ->orderBy('accept', 'ASC')
                    ->orderBy('flight_type', 'ASC')
                    ->orderBy('OUTZulu', 'ASC')
                    ->paginate(50);

            $diff[0] = 'Nada pendiente';
            foreach ($uploads as $key => $upload) {
                $OUTZulu = Carbon::parse($upload->OUTZulu);
                $date = Carbon::now()->setTimezone('UTC');
                $diff[$key]  = $date->diffInMinutes($OUTZulu);
                $diff2[$key] = $date->diffForHumans($OUTZulu);
                if(strpos($diff2[$key], 'after') !== false)
                    $diff[$key] = 'Despegó';
            }

            return view('main.index')
                ->with('title', 'Sistema de Carga-Comat')
                ->with(compact('diff'))
                ->with(compact('uploads'));
        }

        return redirect()->route('home');

    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function approvedAction()
    {
        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            date_default_timezone_set('UTC');

            $uploads = vwUploadsNotification::where('OUTZulu', '>=', date("Y-m-d", strtotime("-1 day")))
                ->where('accept', '=', 1)
                ->orderBy('accept', 'ASC')
                ->orderBy('flight_type', 'ASC')
                ->orderBy('OUTZulu', 'DESC')
                ->paginate(50);

            $diff[0] = 'Nada pendiente';
            foreach ($uploads as $key => $upload) {
                $OUTZulu = Carbon::parse($upload->OUTZulu);
                $date = Carbon::now()->setTimezone('UTC');
                $diff[$key]  = $date->diffInMinutes($OUTZulu);
                $diff2[$key] = $date->diffForHumans($OUTZulu);
                if(strpos($diff2[$key], 'after') !== false)
                    $diff[$key] = 'Despegó';
            }

            return view('main.index')
                ->with('title', 'Sistema de Carga-Comat')
                ->with(compact('diff'))
                ->with(compact('uploads'));
        }

        return redirect()->route('home');

    }

    /** @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse */
    public function rejectedAction()
    {
        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            date_default_timezone_set('UTC');

            $uploads = vwUploadsNotification::where('OUTZulu', '>=', date("Y-m-d", strtotime("-1 day")))
                ->where('accept', '=', 0)
                ->orderBy('accept', 'ASC')
                ->orderBy('flight_type', 'ASC')
                ->orderBy('OUTZulu', 'DESC')
                ->paginate(50);

            $diff[0] = 'Nada pendiente';
            foreach ($uploads as $key => $upload) {
                $OUTZulu = Carbon::parse($upload->OUTZulu);
                $date = Carbon::now()->setTimezone('UTC');
                $diff[$key]  = $date->diffInMinutes($OUTZulu);
                $diff2[$key] = $date->diffForHumans($OUTZulu);
                if(strpos($diff2[$key], 'after') !== false)
                    $diff[$key] = 'Despegó';
            }

            return view('main.index')
                ->with('title', 'Sistema de Carga-Comat')
                ->with(compact('diff'))
                ->with(compact('uploads'));
        }

        return redirect()->route('home');

    }

    public function searchAction()
    {
        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            date_default_timezone_set('UTC');

            if (request()->input('search')){
                $search = request()->input('search');
                $uploads = vwUploadsNotification::where('OUTZulu', '>=', date("Y-m-d"))
                    ->where(function($query) use ($search) {
                        $query->where('flight_number', 'LIKE', '%'.$search.'%')
                            ->orWhere('rego', 'LIKE', '%'.$search.'%');
                    })
                    ->orderBy('accept', 'ASC')
                    ->orderBy('OUTZulu', 'ASC')
                    ->paginate(50);

                $diff[0] = 'Nada pendiente';
                foreach ($uploads as $key => $upload) {
                    $OUTZulu = Carbon::parse($upload->OUTZulu);
                    $date = Carbon::now()->setTimezone('UTC');
                    $diff[$key]  = $date->diffInMinutes($OUTZulu);
                    $diff2[$key] = $date->diffForHumans($OUTZulu);
                    if(strpos($diff2[$key], 'after') !== false)
                        $diff[$key] = 'Despegó';
                }

                return view('main.search')
                    ->with('title', 'Sistema de Carga-Comat')
                    ->with(compact('diff'))
                    ->with(compact('uploads'));
            }

            return redirect()->route('main.index');
        }

        return redirect()->route('home');
    }

    public function formAction(Upload $row)
    {
        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'test' || Auth::user()->rol == 'admin') {

            $details = UploadDetails::where('uploads_id', '=', $row->id)->get();

            return view('main.details')
                ->with('title', 'Detalles de la carga en vuelo - ')
                ->with(compact(['row', 'details']));
        }

        return redirect()->route('home');
    }

    public function updateAction(Upload $row)
    {
        if (Auth::user()->rol == 'approval') {

            $data = request()->validate([
                'accept' => 'required',
                'approved_by' => 'required',
                'message_approval' => 'required'
            ], [
                'message_approval.required' => 'El campo Aprobar/Rechazar es obligatorio'
            ]);

            $row->update($data);

            if ($_REQUEST['origin'] == "ACM") {
                $pieces = 0; $weight = 0; $volume = 0;

                UploadDetails::where('uploads_id', '=', $row->id)->update(['accept' => 0]);

                if ($row->accept == 1) {
                    for ($x=0; $x < count($_REQUEST['chkbx']); $x++) {
                    
                        $items  = UploadDetails::where('guide_number', '=', $_REQUEST['chkbx'][$x])->update(['accept' => 1]);

                        for ($y=0; $y < count($_REQUEST['guideNumber']); $y++) {
                            if ($_REQUEST['guideNumber'][$y] == $_REQUEST['chkbx'][$x]) {
                                $pieces += $_REQUEST['pieces'][$y];
                                $weight += $_REQUEST['weight'][$y];
                                $volume += $_REQUEST['volume'][$y];
                            }
                        }
                    }
                }

                Upload::where('id', '=', $row->id)->update(['pieces' => $pieces, 'weight' => $weight, 'volume' => $volume]);
            }

            $areas_id    = User::where('id', $row->created_by)->get('areas_id');
            $created_by  = User::where('id', $row->created_by)->get('email');
            $approved_name = User::where('id', $row->approved_by)->get('name');
            $items  = UploadDetails::where('uploads_id', '=', $row->id)->where(['accept' => 1])->get();

            $to = ['ccv@vivaaerobus.com', $created_by[0]->email];

            $approved_name = $approved_name[0]->name;

            $emails = Emails::where(function($query) use ($areas_id ) {
                                $query->where('areas_id', '=', 1)
                                    ->orWhere('areas_id', $areas_id[0]->areas_id);
                            })
                            ->where(function($query) use ($row) {
                                $query->where('airports_id', '=' , $row->from_id)
                                      ->orWhere('airports_id', '=' , $row->to_id)
                                      ->orWhere('airports_id', '=', 1);
                            })
                            ->where('active', 1)
                            ->get('email');

            foreach ($emails as $email)
                array_push($to, $email->email);

            if ($row->email1)
                array_push($to, $row->email1);
            if ($row->email2)
                array_push($to, $row->email2);
            if ($row->email3)
                array_push($to, $row->email3);

            if ($row->origins_id == 1 && $row->accept == 1) {
                $subject = 'Comat: Solicitud APROBADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std_zulu;
                Mail::to($to)->queue(new ApprovedViva($row, $subject, $approved_name));
            }
            elseif ($row->origins_id == 1 && $row->accept == 0) {
                $subject = 'Comat: Solicitud RECHAZADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std_zulu;
                Mail::to($to)->queue(new RejectedViva($row, $subject, $approved_name));
            }
            elseif ($row->origins_id == 2 && $row->accept == 1) {
                $subject = 'Carga: Solicitud Aerocharter APROBADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std_zulu;
                Mail::to($to)->queue(new ApprovedAerocharter($row, $items, $subject, $approved_name));
            }
            else {
                $subject = 'Carga: Solicitud Aerocharter RECHAZADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std_zulu;
                Mail::to($to)->queue(new RejectedAerocharter($row, $items, $subject, $approved_name));
            }

            return redirect()->route('main.index');

        }

        return redirect()->route('home');

    }

    public function notificationAction() {
        if (Auth::user()->rol == 'approval' || Auth::user()->rol == 'notification') {

            date_default_timezone_set("America/Monterrey");

            $uploads = vwUploadsNotification::where('accept', '=', NULL)
                ->where('accept', '=', NULL)
                ->where('std', '>=', date("Y-m-d"))
                ->orderBy('OUTZulu', 'ASC')
                ->get();

            date_default_timezone_set('UTC');

            $diff[0] = 'Nada pendiente';
            foreach ($uploads as $key => $upload) {
                $OUTZulu = Carbon::parse($upload->OUTZulu);
                $date = Carbon::now()->setTimezone('UTC');
                $diff[$key]  = $date->diffInMinutes($OUTZulu);
                $diff2[$key] = $date->diffForHumans($OUTZulu);
                if(strpos($diff2[$key], 'after') !== false)
                    $diff[$key] = 'El vuelo ya salió';
            }

            return view('main.notification')
                ->with('title', 'Notificaciones')
                ->with(compact('diff'))
                ->with(compact('uploads'));
        }

        return redirect()->route('home');
    }

}
