<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Appointments/Index', [
            'appointments' => Appointment::with('user:id,name')->latest()->get(),
        ]);
    }

    public function filter(Request $request): Response
    {
        $query = Appointment::query();

        // Apply filters
        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        if ($request->filled('carBrand')) {
            $query->where('car_brand', 'like', '%'.$request->input('carBrand').'%');
        }

        // Retrieve filtered appointments with user relationship
        $appointments = $query->with('user:id,name')->latest()->get();

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Appointments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'car_brand' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
        ]);

        $validated['status'] = 'Scheduled';
//        Appointment::create($validated);

        $request->user()->appointments()->create($validated);

        return redirect(route('appointments.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment): RedirectResponse
{
    $this->authorize('update', $appointment);

    $validated = $request->validate([
        'date' => 'required|string|max:255',
        'time' => 'required|string|max:255',
        'car_brand' => 'required|string|max:255',
        'issue' => 'required|string|max:255',
    ]);

    if ($request->has('action') && $request->action === 'reschedule') {
        $validated['status'] = 'Scheduled';
    }

    $appointment->update($validated);

    return redirect()->route('appointments.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment, $action = 'edit'): RedirectResponse
    {
        $this->authorize('delete', $appointment);

        if ($action === 'reschedule') {
            $appointment->status = 'Scheduled'; // Set the status to "Scheduled"
        } else {
            $appointment->status = 'Canceled'; // Set the status to "Canceled"
        }

        $appointment->save(); // Save the updated appointment

        return redirect(route('appointments.index'));
    }

}
