@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Patient Details</li>
                </ol>
            </nav>
            <div class="btn-group">
                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Patient
                </a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <!-- Patient Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-4">
                    <h4 class="mb-1 text-center">{{ $patient->name }}</h4>
                    <p class="text-center text-muted mb-3">{{ $patient->patient_id }}</p>
                    <div class="mb-3">
                        <label><b>Gender: </b></label>
                        <span class="fw-bold">{{ $patient->gender ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <label><b>Age: </b></label>
                        <span class="fw-bold">{{ $patient->age ?? 'N/A' }} Years</span>
                    </div>                    
                    <div class="mb-3">
                        <label><b>SCT No: </b></label>
                        <span class="fw-bold">{{ $patient->sct_no ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label class="fw-bold"><b>Referred By: </b></label>
                        <span class="fw-bold">{{ $patient->referred_by ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            <style>
                label,.fw-bold {
                    font-size: 18px;
                }
            </style>
            <!-- Caregivers Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Caregivers</h5>
                </div>
                @foreach($patient->caregivers as $caregiver)
                <div class="card-footer bg-white border-top-0 px-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="mb-3">
                        <label><b>Caregiver Name: </b></label>
                        <span class="fw-bold">{{ $caregiver->name }}</span>
                    </div>
                    <div class="mb-3">
                        <label><b>Relation: </b></label>
                        <span class="fw-bold">{{ $caregiver->relation ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label class="fw-bold"><b>Contact No: </b></label>
                        <span class="fw-bold">{{ $caregiver->contact_no ?? 'N/A' }}</span>
                    </div>
                </div>
                 @endforeach
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Detailed Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Medical Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="fw-bold d-block mb-1">Diagnosis</label>
                            <div class="p-3 rounded-3">
                                {{ $patient->diagnosis ?? 'No diagnosis recorded.' }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold d-block mb-1">Hospital</label>
                            <span class="">{{ $patient->hospital_department ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold d-block mb-1">Doctor</label>
                            <span class="">{{ $patient->doctor ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold d-block mb-1">Pincode</label>
                            <span class="">{{ $patient->pincode ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-12">
                            <label class="fw-bold d-block mb-1">Address</label>
                            <p class="mb-0">{{ $patient->address ?? 'No address recorded.' }}</p>
                        </div>
                        <div class="col-md-12">
                            <label class="fw-bold d-block mb-1">Route Map</label>
                            <p class="mb-0">{{ $patient->route_map ?? 'No route map recorded.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment History Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Assessment History</h5>
                    <a href="{{ route('patients.assessments.create', $patient) }}" class="btn btn-sm btn-primary">New Assessment</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Assessment ID</th>
                                    <th>Date</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->assessments as $assessment)
                                    <tr>
                                        <td class="ps-4 fw-bold ">{{ $assessment->assessment_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($assessment->assessment_date)->format('d M, Y') }}</td>
                                        <td>{{ $assessment->user->name }}</td>
                                        <td>
                                            <span class="badge {{ $assessment->status == 'Completed' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $assessment->status }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="fas fa-eye">View</i>
                                                </a>
                                                <a href="{{ route('assessments.edit', $assessment) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit">Edit</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-clipboard-list fa-3x text-light mb-3 d-block"></i>
                                            No assessments available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete patient <strong>{{ $patient->name }}</strong>? This action will also delete all associated caregiver records.
                <p class="text-danger mt-2 small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('patients.destroy', $patient) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
