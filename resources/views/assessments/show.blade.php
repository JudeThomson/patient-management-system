@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('patients.show', $assessment->patient) }}">{{ $assessment->patient->patient_id }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Assessment</li>
                </ol>
            </nav>
            <div class="btn-group">
                <a href="{{ route('assessments.edit', $assessment) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('patients.show', $assessment->patient) }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <!-- Assessment Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">Assessment Details - {{ $assessment->assessment_id }}</h5>
                    <span class="badge {{ $assessment->status == 'Completed' ? 'bg-success' : 'bg-warning' }} px-3 py-2">
                        {{ $assessment->status }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="small text-muted d-block text-uppercase fw-bold">Assessment Date</label>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($assessment->assessment_date)->format('d M, Y') }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted d-block text-uppercase fw-bold">Created By</label>
                            <span class="fw-bold">{{ $assessment->user->name }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted d-block text-uppercase fw-bold">Status</label>
                            <span class="badge {{ $assessment->status == 'Completed' ? 'bg-success' : 'bg-warning' }} px-3 py-1">
                                {{ $assessment->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Medical History -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-history me-2"></i>Medical History</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($assessment->medicalHistory)
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Past Medical History</th>
                                            <th>Details</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $historyItems = [
                                                'problem_started_on' => ['label' => 'Problem Started On', 'details' => 'problem_started_on', 'date' => 'problem_started_on_date'],
                                                'illness_details' => ['label' => 'Details of Illness / Complaints', 'details' => 'illness_details', 'date' => 'illness_details_date'],
                                                'doctor_hospital' => ['label' => 'Doctor / Hospital I', 'details' => 'doctor_hospital', 'date' => 'doctor_hospital_date'],
                                                'doctor_hospital_2' => ['label' => 'Doctor / Hospital II', 'details' => 'doctor_hospital_2', 'date' => 'doctor_hospital_2_date'],
                                                'doctor_hospital_3' => ['label' => 'Doctor / Hospital III', 'details' => 'doctor_hospital_3', 'date' => 'doctor_hospital_3_date'],
                                                'diagnosed_at' => ['label' => 'Diagnosed At', 'details' => 'diagnosed_at', 'date' => 'diagnosed_at_date'],
                                                'surgery' => ['label' => 'Surgery', 'details' => 'surgery', 'date' => 'surgery_date'],
                                                'radiation' => ['label' => 'Radiation', 'details' => 'radiation', 'date' => 'radiation_date'],
                                                'chemotherapy' => ['label' => 'Chemotherapy', 'details' => 'chemotherapy', 'date' => 'chemotherapy_date'],
                                                'colostomy' => ['label' => 'Colostomy', 'details' => 'colostomy', 'date' => 'colostomy_date'],
                                                'renal_problems' => ['label' => 'Renal Problems', 'details' => 'renal_problems', 'date' => 'renal_problems_date'],
                                                'dm_htn_asthma_cad' => ['label' => 'DM HTN Asthma CAD', 'details' => 'dm_htn_asthma_cad_details', 'date' => 'dm_htn_asthma_cad_date']
                                            ];
                                        @endphp
                                        @foreach($historyItems as $key => $item)
                                            <tr>
                                                <td class="fw-bold">{{ $item['label'] }}</td>
                                                <td>{{ $assessment->medicalHistory->{$item['details']} ?? 'N/A' }}</td>
                                                <td>
                                                    @if($assessment->medicalHistory && $assessment->medicalHistory->{$item['date']})
                                                        {{ $assessment->medicalHistory->{$item['date']}->format('d-m-Y') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted p-3 mb-0">No medical history recorded.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Medication -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-pills me-2"></i>Recent Medication</h5>
                        </div>
                        <div class="card-body">
                            @if($assessment->medication)
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Diabetes Medicine</label>
                                        <p class="mb-0 bg-light p-2 rounded-2">{{ $assessment->medication->diabetes_medicine ?? 'None' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">BP Medicine</label>
                                        <p class="mb-0 bg-light p-2 rounded-2">{{ $assessment->medication->bp_medicine ?? 'None' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Chemo Medicine</label>
                                        <p class="mb-0 bg-light p-2 rounded-2">{{ $assessment->medication->chemo_medicine ?? 'None' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Pain Medicine</label>
                                        <p class="mb-0 bg-light p-2 rounded-2">{{ $assessment->medication->pain_medicine ?? 'None' }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted mb-0">No medication recorded.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Symptoms -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Symptoms Reported</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($assessment->symptoms as $symptom)
                                    <span class="badge bg-info-subtle text-info px-3 py-2">{{ $symptom->symptom_name }}</span>
                                @empty
                                    <p class="text-muted mb-0">No symptoms reported.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Complaints -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Presenting Complaints</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse($assessment->complaints as $complaint)
                                    <li class="list-group-item px-0">{{ $complaint->complaint_text }}</li>
                                @empty
                                    <li class="list-group-item px-0 text-muted">No complaints recorded.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Pain Assessment Summary -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pain Assessment Summary</h5>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('assessments.pdf', $assessment) }}" target="_blank" class="btn btn-outline-secondary">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="painAccordion">
                                @foreach(['A', 'B', 'C', 'D'] as $label)
                                    @php $pain = $assessment->pains->where('pain_label', $label)->first(); @endphp
                                    <div class="accordion-item border-0 mb-2 shadow-sm">
                                        <h2 class="accordion-header" id="heading{{ $label }}">
                                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $label }}" aria-expanded="false">
                                                <span class="fw-bold me-3">Pain {{ $label }}</span>
                                                @if($pain && $pain->pain_score !== null)
                                                    <span class="badge bg-primary">Score: {{ $pain->pain_score }}</span>
                                                @else
                                                    <span class="text-muted small">Not recorded</span>
                                                @endif
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $label }}" class="accordion-collapse collapse" data-bs-parent="#painAccordion">
                                            <div class="accordion-body bg-light rounded-bottom-3">
                                                @if($pain)
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Duration</small>
                                                            <span>{{ $pain->duration ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Frequency</small>
                                                            <span>{{ $pain->continuous_intermittent ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Radiation</small>
                                                            <span>{{ $pain->radiation ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Quality</small>
                                                            <span>{{ $pain->quality ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <small class="text-muted d-block">Provoking Factors</small>
                                                            <p class="mb-0 small">{{ $pain->provoking_factors ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <small class="text-muted d-block">Palliating Factors</small>
                                                            <p class="mb-0 small">{{ $pain->palliating_factors ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <small class="text-muted d-block">Impact on ADLs</small>
                                                            <p class="mb-0 small">{{ $pain->impact_on_adls ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <small class="text-muted d-block">Impact on Person</small>
                                                            <p class="mb-0 small">{{ $pain->impact_on_person ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-muted mb-0">No data for this pain type.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
