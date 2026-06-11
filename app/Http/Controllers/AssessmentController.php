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
                $assessment->medicalHistory()->create($this->mapMedicalHistoryData($request->medical_history));
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

    public function exportPdf(Assessment $assessment)
    {
        $assessment->load(['patient', 'symptoms', 'complaints', 'pains', 'medicalHistory', 'medication']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('assessments.pdf', compact('assessment'));
        return $pdf->stream('assessment_'.$assessment->assessment_id.'.pdf');
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

            $assessment->medicalHistory()->updateOrCreate([], $this->mapMedicalHistoryData($request->medical_history ?? []));
            $assessment->medication()->updateOrCreate([], $request->medication ?? []);
        });

        return redirect()->route('patients.show', $assessment->patient_id)->with('success', 'Assessment updated successfully.');
    }

    private function mapMedicalHistoryData($medicalHistory)
    {
        $data = [];
        foreach ($medicalHistory as $key => $values) {
            // Special handling for the combined row
            if ($key == 'dm_htn_asthma_cad') {
                $data['dm_htn_asthma_cad_details'] = $values['details'] ?? null;
                $data['dm_htn_asthma_cad_date'] = $values['date'] ?? null;
            } else {
                $data[$key] = $values['details'] ?? null;
                $data[$key . '_date'] = $values['date'] ?? null;
            }
        }
        return $data;
    }
}
