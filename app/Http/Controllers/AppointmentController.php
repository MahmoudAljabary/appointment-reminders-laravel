<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    private $appointment;
    private $validInputConditions = array(
        'name' => 'required',
        'phoneNumber' => 'required|min:5',
        'when' => 'required',
        'delta' => 'required|numeric'
    );

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allAppointments = \App\Appointment::all();
        return response()->view('appointment.index', array('apts' => $allAppointments));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $appointment = new \App\Appointment;
        return \View::make('appointment.new', array('appointment' => $appointment));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validInputConditions);
        $newAppointment = new \App\Appointment;

        $newAppointment->name = $request->input('name');
        $newAppointment->phoneNumber = $request->input('phoneNumber');
        $newAppointment->when = $request->input('when');
        $newAppointment->delta = $request->input('delta');

        $newAppointment->save();
        return redirect()->route('appointment.index');
    }

    /**
     * Delete a resource in storage.
     *
     * @return Response
     */
    public function delete(Request $request) {
        \App\Appointment::find($request->input('id'))->delete();
        return redirect()->route('appointment.index');
    }

    public function change($id) {
        $appointmentToEdit = \App\Appointment::find($id);
        return \View::make('appointment.edit', array('appointment' => $appointmentToEdit));
    }
}
