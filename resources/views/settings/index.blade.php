@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 medical-blue mb-1">Backup Management</h2>
            <p class="text-muted mb-0">Download a backup of the Patient Info database.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 h6 fw-bold text-primary">Database Backup</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small text-uppercase fw-bold">Backup Type</span>
                            <span class="fw-medium">MySQL Database</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small text-uppercase fw-bold">Current Database</span>
                            <span class="fw-medium text-primary">{{ $dbName }}</span>
                        </div>
                    </div>

                    <div class="alert alert-info small border-0 bg-info-subtle mb-4">
                        <i class="fas fa-info-circle me-1"></i>
                        The backup will include all patient records, assessments, and user accounts. The file will be downloaded in <strong>.sql</strong> format.
                    </div>

                    <form action="{{ route('settings.backup') }}" method="POST">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-download me-2"></i> Download Backup
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light-subtle py-3">
                    <p class="mb-0 small text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Only administrators can perform database backups.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 h6 fw-bold text-secondary">System Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Application Version</span>
                            <span class="badge bg-secondary">v1.0.0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Environment</span>
                            <span class="badge bg-info text-capitalize">{{ app()->environment() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>PHP Version</span>
                            <span class="fw-medium">{{ PHP_VERSION }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Last Backup</span>
                            <span class="text-muted italic">Never performed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
