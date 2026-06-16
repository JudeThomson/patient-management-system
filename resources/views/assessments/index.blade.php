@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 medical-blue mb-1">Assessments</h2>
                <p class="text-muted mb-0 small">Total Assessments: <strong>{{ $totalCount }}</strong></p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Assessment ID</th>
                            <th>Patient Name</th>
                            <th>Assessment Date</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessments as $assessment)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-primary">{{ $assessment->assessment_id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user text-muted small"></i>
                                        </div>
                                        <span class="fw-medium text-dark">{{ $assessment->patient->name }}</span>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($assessment->assessment_date)->format('d M, Y') }}</td>
                                <td>
                                    <span class="badge {{ $assessment->status == 'Completed' ? 'bg-success' : 'bg-warning' }} px-3 py-2">
                                        {{ $assessment->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small"><i class="fas fa-user-md me-1"></i>{{ $assessment->user->name }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="{{ route('assessments.edit', $assessment) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <a href="{{ route('assessments.pdf', $assessment) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Print PDF">
                                            <i class="fas fa-print me-1"></i>Print
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-3">
                                        <i class="fas fa-notes-medical fa-3x opacity-25"></i>
                                    </div>
                                    <p class="mb-0">No assessments found.</p>
                                    <small>Assessments are created through the <a href="{{ route('patients.index') }}">Patients</a> module.</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($assessments->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $assessments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
