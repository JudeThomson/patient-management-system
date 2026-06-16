@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white p-4 shadow-sm border-0">
                <h2 class="h4 medical-blue mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-muted mb-0">Here is what's happening with your patient records today.</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <div class="card h-100 p-3 shadow-sm border-0">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary-subtle p-3 rounded-3">
                        <i class="fas fa-user-injured text-primary fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Patients</h6>
                        <h3 class="mb-0">{{ number_format($stats['totalPatients']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <div class="card h-100 p-3 shadow-sm border-0">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success-subtle p-3 rounded-3">
                        <i class="fas fa-file-medical text-success fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Assessments</h6>
                        <h3 class="mb-0">{{ number_format($stats['totalAssessments']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
            <div class="card h-100 p-3 shadow-sm border-0">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info-subtle p-3 rounded-3">
                        <i class="fas fa-check-circle text-info fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Completed</h6>
                        <h3 class="mb-0">{{ number_format($stats['completedAssessments']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 p-3 shadow-sm border-0">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning-subtle p-3 rounded-3">
                        <i class="fas fa-edit text-warning fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Drafts</h6>
                        <h3 class="mb-0">{{ number_format($stats['draftAssessments']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Patients -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 h6 fw-bold text-primary">Recent Patients</h5>
                    <a href="{{ route('patients.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-uppercase">
                                    <th class="ps-4">ID</th>
                                    <th>Name</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPatients as $patient)
                                    <tr>
                                        <td class="ps-4 small fw-bold text-primary">{{ $patient->patient_id }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $patient) }}" class="text-decoration-none text-dark fw-medium">
                                                {{ $patient->name }}
                                            </a>
                                        </td>
                                        <td class="small text-muted">{{ $patient->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted small">No patients registered yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Assessments -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 h6 fw-bold text-primary">Recent Assessments</h5>
                    <a href="{{ route('assessments.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-uppercase">
                                    <th class="ps-4">ID</th>
                                    <th>Patient</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAssessments as $assessment)
                                    <tr>
                                        <td class="ps-4 small fw-bold text-primary">{{ $assessment->assessment_id }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $assessment->patient) }}" class="text-decoration-none text-dark fw-medium">
                                                {{ $assessment->patient->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge {{ $assessment->status == 'Completed' ? 'bg-success' : 'bg-warning' }} small">
                                                {{ $assessment->status }}
                                            </span>
                                        </td>
                                        <td class="small text-muted">{{ $assessment->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted small">No assessments recorded yet.</td>
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
@endsection
