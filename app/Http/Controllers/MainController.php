<?php

namespace App\Http\Controllers;

use App\User;
use App\Emails;
use App\Upload;
use App\UploadDetails;
use App\Mail\ApprovedViva;
use App\Mail\RejectedViva;
use App\Mail\ApprovedAerocharter;
use App\Mail\RejectedAerocharter;
use Carbon\Carbon;
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

            $uploads = Upload::sortable(['id' => 'desc'])
                ->where('std_zulu', '<>', NULL)
                ->paginate(50);

            return view('main.index')
                ->with('title', 'Sistema de Carga-Comat')
                ->with(compact('uploads'));
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

            $areas_id    = User::where('id', $row->created_by)->get('areas_id');
            $created_by  = User::where('id', $row->created_by)->get('email');
            $approved_name = User::where('id', $row->approved_by)->get('name');
            $items  = UploadDetails::where('uploads_id', '=', $row->id)->get();

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
                $subject = 'Comat: Solicitud APROBADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std;
                Mail::to($to)->queue(new ApprovedViva($row, $subject, $approved_name));
            }
            elseif ($row->origins_id == 1 && $row->accept == 0) {
                $subject = 'Comat: Solicitud RECHAZADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std;
                Mail::to($to)->queue(new RejectedViva($row, $subject, $approved_name));
            }
            elseif ($row->origins_id == 2 && $row->accept == 1) {
                $subject = 'Carga: Solicitud Aerocharter APROBADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std;
                Mail::to($to)->queue(new ApprovedAerocharter($row, $items, $subject, $approved_name));
            }
            else {
                $subject = 'Carga: Solicitud Aerocharter RECHAZADA ' . $row->flight_number . ' ' . $row->from . '-' . $row->to . ' ' . $row->std;
                Mail::to($to)->queue(new RejectedAerocharter($row, $items, $subject, $approved_name));
            }

            return redirect()->route('main.index');

        }

        return redirect()->route('home');

    }

    public function notificationAction() {
        if (Auth::user()->rol == 'notification') {

            date_default_timezone_set("America/Monterrey");

            $uploads = Upload::sortable(['std_zulu' => 'asc'])
                ->where('accept', '=', NULL)
                ->where('std', '>=', date("Y-m-d"))
                ->get();

            date_default_timezone_set('UTC');
            foreach ($uploads as $key => $upload) {
                $stdZulu = Carbon::parse($upload->std_zulu);
                $date = Carbon::now()->setTimezone('UTC');
                $diff[$key]  = $date->diffInMinutes($stdZulu);
                $diff2[$key] = $date->diffForHumans($stdZulu);
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
