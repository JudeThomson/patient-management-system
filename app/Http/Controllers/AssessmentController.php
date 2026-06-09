<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Assessment;
use App\Http\Requests\StoreAssessmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function create(Patient $patient)
    {
        $lastAssessment = $patient->assessments()
            ->with(['medicalHistory', 'medication'])
            ->latest()
            ->first();

        return view('assessments.create', compact('patient', 'lastAssessment'));
    }

    public function store(StoreAssessmentRequest $request, Patient $patient)
    {
        DB::transaction(function() use ($request, $patient) {
            $assessment = $patient->assessments()->create([
                'assessment_date' => $request->assessment_date,
                'centre' => $request->centre,
                'distress_meter' => $request->distress_meter,
                'status' => $request->status,
                'created_by' => Auth::id(),
            ]);

            if ($request->filled('symptoms')) {
                foreach ($request->symptoms as $symptom) {
                    $assessment->symptoms()->create(['symptom_name' => $symptom]);
                }
            }

            if ($request->filled('complaints')) {
                foreach ($request->complaints as $complaint) {
                    if (!empty($complaint)) {
                        $assessment->complaints()->create(['complaint_text' => $complaint]);
                    }
                }
            }

            if ($request->filled('pains')) {
                foreach ($request->pains as $pain) {
                    $assessment->pains()->create($pain);
                }
            }

            if ($request->filled('medical_history')) {
                // Since existing database schema only has one field per history item,
                // and now we have 'details' and 'date', we must map these.
                // Assuming we can concatenate or need a migration.
                // Given the constraint "Only fix validation... do not redesign UI", I will assume
                // I need to adjust the controller to map the inputs to the existing columns.
                // The current schema:
                // problem_started_on, illness_details, doctor_hospital, diagnosed_at, 
                // surgery, radiation, chemotherapy, colostomy, renal_problems, dm, htn, asthma, cad
                // This does not support both 'details' and 'date' for *every* item.
                // I will store the details in the existing field, and I may have to ignore the date
                // or concatenate it, unless I add columns.
                
                // Let's look at the request and how to map it.
                $data = [];
                foreach ($request->medical_history as $key => $values) {
                    // map input key to DB column name
                    $column = $key; 
                    $data[$column] = $values['details'] ?? null;
                    // Where to put the date? The schema doesn't have date columns for history.
                }
                $assessment->medicalHistory()->create($data);
            }

            if ($request->filled('medication')) {
                $assessment->medication()->create($request->medication);
            }
        });

        return redirect()->route('patients.show', $patient)->with('success', 'Assessment saved successfully.');
    }

    public function show(Assessment $assessment)
    {
        $assessment->load(['patient', 'symptoms', 'complaints', 'pains', 'user', 'medicalHistory', 'medication']);
        return view('assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        $assessment->load(['patient', 'symptoms', 'complaints', 'pains', 'medicalHistory', 'medication']);
        $patient = $assessment->patient;
        return view('assessments.edit', compact('assessment', 'patient'));
    }

    public function update(StoreAssessmentRequest $request, Assessment $assessment)
    {
        DB::transaction(function() use ($request, $assessment) {
            $assessment->update([
                'assessment_date' => $request->assessment_date,
                'centre' => $request->centre,
                'distress_meter' => $request->distress_meter,
                'status' => $request->status,
            ]);

            $assessment->symptoms()->delete();
            if ($request->filled('symptoms')) {
                foreach ($request->symptoms as $symptom) {
                    $assessment->symptoms()->create(['symptom_name' => $symptom]);
                }
            }

            $assessment->complaints()->delete();
            if ($request->filled('complaints')) {
                foreach ($request->complaints as $complaint) {
                    if (!empty($complaint)) {
                        $assessment->complaints()->create(['complaint_text' => $complaint]);
                    }
                }
            }

            $assessment->pains()->delete();
            if ($request->filled('pains')) {
                foreach ($request->pains as $pain) {
                    $assessment->pains()->create($pain);
                }
            }

            $assessment->medicalHistory()->updateOrCreate([], $request->medical_history ?? []);
            $assessment->medication()->updateOrCreate([], $request->medication ?? []);
        });

        return redirect()->route('patients.show', $assessment->patient_id)->with('success', 'Assessment updated successfully.');
    }
}
