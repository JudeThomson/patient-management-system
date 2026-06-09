@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="fas fa-tools fa-4x text-muted mb-3"></i>
            <h2 class="h3">Under Construction</h2>
            <p class="text-muted">The <strong>{{ $module }}</strong> module is currently being developed.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection
