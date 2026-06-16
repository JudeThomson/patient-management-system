@extends('layouts.admin')

@section('content')

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('patients.show', $patient) }}">{{ $patient->patient_id }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Assessment</li>
                </ol>
            </nav>
            <h2 class="h4 medical-blue mb-0">Patient Assessment</h2>
        </div>
    </div>

    <form action="{{ route('patients.assessments.store', $patient) }}" method="POST" novalidate>
        @csrf
        
        <!-- Section 1: Assessment Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-info-circle me-2"></i>Assessment Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Assessment Date <span class="text-danger">*</span></label>
                        <input type="date" name="assessment_date" class="form-control @error('assessment_date') is-invalid @enderror" value="{{ old('assessment_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}">
                        <x-input-error :messages="$errors->get('assessment_date')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Past Medical History Redesigned as Table -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-history me-2"></i>Past Medical History</h5>
            </div>
            <div class="card-body p-0">
                @php
                    $hasHistoryDateErrors = false;
                    foreach ($errors->keys() as $errorKey) {
                        if (str_starts_with($errorKey, 'medical_history.') && str_ends_with($errorKey, '.date')) {
                            $hasHistoryDateErrors = true;
                            break;
                        }
                    }
                @endphp

                @if($hasHistoryDateErrors)
                    <div id="history-date-alert" class="alert alert-danger py-2 mb-0 rounded-0 border-0 border-bottom">
                        <small><i class="fas fa-exclamation-triangle me-2"></i>Please enter a valid date. Future dates are not allowed.</small>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 30%;">Past Medical History</th>
                                <th>Details</th>
                                <th style="width: 20%;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $historyItems = [
                                    'problem_started_on' => 'Problem Started On',
                                    'illness_details' => 'Details of Illness / Complaints',
                                    'doctor_hospital' => 'Doctor / Hospital I',
                                    'doctor_hospital_2' => 'Doctor / Hospital II',
                                    'doctor_hospital_3' => 'Doctor / Hospital III',
                                    'diagnosed_at' => 'Diagnosed At',
                                    'surgery' => 'Surgery',
                                    'radiation' => 'Radiation',
                                    'chemotherapy' => 'Chemotherapy',
                                    'colostomy' => 'Colostomy',
                                    'renal_problems' => 'Renal Problems',
                                    'dm_htn_asthma_cad' => 'DM HTN Asthma CAD'
                                ];
                            @endphp
                            @foreach($historyItems as $key => $label)
                            <tr>
                                <td class="fw-bold">{{ $label }}</td>
                                <td>
                                    <input type="text" name="medical_history[{{ $key }}][details]" class="form-control @error('medical_history.'.$key.'.details') is-invalid @enderror" value="{{ old('medical_history.'.$key.'.details', $lastAssessment?->medicalHistory?->{$key === 'dm_htn_asthma_cad' ? 'dm_htn_asthma_cad_details' : $key} ?? '') }}" maxlength="120">
                                    <x-input-error :messages="$errors->get('medical_history.'.$key.'.details')" class="mt-1" />
                                </td>
                                <td>
                                    <input type="date" name="medical_history[{{ $key }}][date]" class="form-control @error('medical_history.'.$key.'.date') is-invalid @enderror" value="{{ old('medical_history.'.$key.'.date', $lastAssessment?->medicalHistory?->{$key.'_date'} ?? '') }}" max="{{ date('Y-m-d') }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Medication -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-pills me-2"></i>Recent Medication</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Diabetes Medicine</label>
                        <textarea name="medication[diabetes_medicine]" class="form-control @error('medication.diabetes_medicine') is-invalid @enderror" rows="2" maxlength="120">{{ old('medication.diabetes_medicine', $lastAssessment?->medication?->diabetes_medicine ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('medication.diabetes_medicine')" class="mt-2" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">BP Medicine</label>
                        <textarea name="medication[bp_medicine]" class="form-control @error('medication.bp_medicine') is-invalid @enderror" rows="2" maxlength="120">{{ old('medication.bp_medicine', $lastAssessment?->medication?->bp_medicine ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('medication.bp_medicine')" class="mt-2" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Chemo Medicine</label>
                        <textarea name="medication[chemo_medicine]" class="form-control @error('medication.chemo_medicine') is-invalid @enderror" rows="2" maxlength="120">{{ old('medication.chemo_medicine', $lastAssessment?->medication?->chemo_medicine ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('medication.chemo_medicine')" class="mt-2" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pain Medicine</label>
                        <textarea name="medication[pain_medicine]" class="form-control @error('medication.pain_medicine') is-invalid @enderror" rows="2" maxlength="120">{{ old('medication.pain_medicine', $lastAssessment?->medication?->pain_medicine ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('medication.pain_medicine')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Symptoms -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-notes-medical me-2"></i>Symptoms Check</h5>
            </div>
            <div class="card-body">
                <x-input-error :messages="$errors->get('symptoms')" class="mb-3" />
                <div class="row">
                    @php
                        $symptoms = [
                            'Nausea', 'Vomiting', 'Swallowing Difficulty', 'Heart Burn', 
                            'Constipation', 'Cough', 'Sore Mouth', 'Swelling', 
                            'Ulcer', 'Bleeding', 'Lymphoedema', 'Urinary Symptoms', 
                            'Delirium', 'Breathlessness', 'Tiredness', 'Sleeplessness', 'Drowsiness'
                        ];
                    @endphp
                    @foreach($symptoms as $symptom)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="{{ $symptom }}" id="symp_{{ $loop->index }}" {{ is_array(old('symptoms')) && in_array($symptom, old('symptoms')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="symp_{{ $loop->index }}">
                                    {{ $symptom }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section 3: Distress Meter -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-tachometer-alt me-2"></i>Distress Meter</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <label for="distress_meter" class="form-label fw-bold mb-3">Distress Level: <span id="distress_value" class="h4 text-danger">{{ old('distress_meter', 0) }}</span> / 10</label>
                        <input type="range" class="form-range" min="0" max="10" step="1" name="distress_meter" id="distress_meter" value="{{ old('distress_meter', 0) }}">
                        <x-input-error :messages="$errors->get('distress_meter')" class="mt-2" />
                        <div class="d-flex justify-content-between px-2 text-muted small">
                            <span>No Distress (0)</span>
                            <span>Moderate (5)</span>
                            <span>Extreme (10)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Presenting Complaints -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-comment-medical me-2"></i>Presenting Complaints</h5>
            </div>
            <div class="card-body">
                <x-input-error :messages="$errors->get('complaints')" class="mb-3" />
                <div class="mb-3">
                    <label class="form-label fw-bold">Complaint 1</label>
                    <input type="text" name="complaints[]" class="form-control @error('complaints.0') is-invalid @enderror" value="{{ old('complaints.0') }}" maxlength="500">
                    <x-input-error :messages="$errors->get('complaints.0')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Complaint 2</label>
                    <input type="text" name="complaints[]" class="form-control @error('complaints.1') is-invalid @enderror" value="{{ old('complaints.1') }}" maxlength="500">
                    <x-input-error :messages="$errors->get('complaints.1')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Complaint 3</label>
                    <input type="text" name="complaints[]" class="form-control @error('complaints.2') is-invalid @enderror" value="{{ old('complaints.2') }}" maxlength="500">
                    <x-input-error :messages="$errors->get('complaints.2')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Section 5: Pain Assessment -->
        <h5 class="mb-3 text-primary"><i class="fas fa-pills me-2"></i>Pain Assessment</h5>
        <div class="row g-4 mb-4">
            @foreach(['A', 'B', 'C', 'D'] as $label)
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-3">
                            <h6 class="mb-0">Pain {{ $label }}</h6>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="pains[{{ $label }}][pain_label]" value="{{ $label }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Duration</label>
                                    <input type="text" name="pains[{{ $label }}][duration]" class="form-control form-control-sm @error('pains.'.$label.'.duration') is-invalid @enderror" value="{{ old('pains.'.$label.'.duration') }}">
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.duration')" class="mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Frequency</label>
                                    <select name="pains[{{ $label }}][continuous_intermittent]" class="form-select form-select-sm @error('pains.'.$label.'.continuous_intermittent') is-invalid @enderror">
                                        <option value="">Select...</option>
                                        <option value="Continuous" {{ old('pains.'.$label.'.continuous_intermittent') == 'Continuous' ? 'selected' : '' }}>Continuous</option>
                                        <option value="Intermittent" {{ old('pains.'.$label.'.continuous_intermittent') == 'Intermittent' ? 'selected' : '' }}>Intermittent</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.continuous_intermittent')" class="mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Pain Score (0-10)</label>
                                    <input type="number" name="pains[{{ $label }}][pain_score]" class="form-control form-control-sm @error('pains.'.$label.'.pain_score') is-invalid @enderror" min="0" max="10" value="{{ old('pains.'.$label.'.pain_score') }}">
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.pain_score')" class="mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Radiation</label>
                                    <input type="text" name="pains[{{ $label }}][radiation]" class="form-control form-control-sm @error('pains.'.$label.'.radiation') is-invalid @enderror" value="{{ old('pains.'.$label.'.radiation') }}">
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.radiation')" class="mt-1" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Quality</label>
                                    <input type="text" name="pains[{{ $label }}][quality]" class="form-control form-control-sm @error('pains.'.$label.'.quality') is-invalid @enderror" placeholder="e.g. Sharp, Dull, Burning" value="{{ old('pains.'.$label.'.quality') }}">
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.quality')" class="mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Provoking Factors</label>
                                    <textarea name="pains[{{ $label }}][provoking_factors]" class="form-control form-control-sm @error('pains.'.$label.'.provoking_factors') is-invalid @enderror" rows="2">{{ old('pains.'.$label.'.provoking_factors') }}</textarea>
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.provoking_factors')" class="mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Palliating Factors</label>
                                    <textarea name="pains[{{ $label }}][palliating_factors]" class="form-control form-control-sm @error('pains.'.$label.'.palliating_factors') is-invalid @enderror" rows="2">{{ old('pains.'.$label.'.palliating_factors') }}</textarea>
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.palliating_factors')" class="mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Impact on ADLs</label>
                                    <textarea name="pains[{{ $label }}][impact_on_adls]" class="form-control form-control-sm @error('pains.'.$label.'.impact_on_adls') is-invalid @enderror" rows="2">{{ old('pains.'.$label.'.impact_on_adls') }}</textarea>
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.impact_on_adls')" class="mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Impact on Person</label>
                                    <textarea name="pains[{{ $label }}][impact_on_person]" class="form-control form-control-sm @error('pains.'.$label.'.impact_on_person') is-invalid @enderror" rows="2">{{ old('pains.'.$label.'.impact_on_person') }}</textarea>
                                    <x-input-error :messages="$errors->get('pains.'.$label.'.impact_on_person')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="Draft" id="statusDraft" {{ old('status', 'Draft') == 'Draft' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="statusDraft">Save as Draft</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="Completed" id="statusCompleted" {{ old('status') == 'Completed' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="statusCompleted">Mark as Completed</label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('status')" class="ms-3" />
                <div class="d-flex gap-2">
                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-lg px-5">Save Assessment</button>
                </div>
            </div>
        </div>
    </form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('distress_meter');
        const output = document.getElementById('distress_value');
        
        output.textContent = slider.value;
        
        slider.oninput = function() {
            output.textContent = this.value;
            if (this.value >= 7) {
                output.className = 'h4 text-danger';
            } else if (this.value >= 4) {
                output.className = 'h4 text-warning';
            } else {
                output.className = 'h4 text-success';
            }
        }
    });
</script>
@endsection
