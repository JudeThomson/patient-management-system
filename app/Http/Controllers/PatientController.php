<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Caregiver;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('patient_id', 'like', "%{$search}%")
                  ->orWhere('sct_no', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(10)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {

        DB::transaction(function() use ($request) {
            $patient = Patient::create($request->validated());

            foreach ($request->caregivers as $caregiverData) {
                $patient->caregivers()->create($caregiverData);
            }
        });

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load('caregivers');
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $patient->load('caregivers');
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        DB::transaction(function() use ($request, $patient) {
            $patient->update($request->validated());

            // Delete removed caregivers
            $keepIds = collect($request->caregivers)->pluck('id')->filter()->toArray();
            $patient->caregivers()->whereNotIn('id', $keepIds)->delete();

            // Update or create caregivers
            foreach ($request->caregivers as $caregiverData) {
                if (isset($caregiverData['id'])) {
                    $id = $caregiverData['id'];
                    unset($caregiverData['id']);
                    Caregiver::where('id', $id)->update($caregiverData);
                } else {
                    $patient->caregivers()->create($caregiverData);
                }
            }
        });

        return redirect()->route('patients.show', $patient)->with('success', 'Patient information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient record deleted successfully.');
    }
}
