@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white p-4 shadow-sm">
                <h2 class="h4 medical-blue mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-muted mb-0">Here is what's happening with your patient records today.</p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary-subtle p-3 rounded-3">
                        <i class="fas fa-user-injured text-primary fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Patients</h6>
                        <h3 class="mb-0">1,284</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success-subtle p-3 rounded-3">
                        <i class="fas fa-clipboard-check text-success fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Assessments</h6>
                        <h3 class="mb-0">8,492</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info-subtle p-3 rounded-3">
                        <i class="fas fa-calendar-check text-info fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Today's Visits</h6>
                        <h3 class="mb-0">24</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning-subtle p-3 rounded-3">
                        <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Pending Reports</h6>
                        <h3 class="mb-0">7</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Recent Patient Activity</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Activity</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>Initial Assessment</td>
                                    <td>10:30 AM</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>Follow-up Visit</td>
                                    <td>09:15 AM</td>
                                    <td><span class="badge bg-primary">In Progress</span></td>
                                </tr>
                                <tr>
                                    <td>Robert Johnson</td>
                                    <td>Blood Test Result</td>
                                    <td>Yesterday</td>
                                    <td><span class="badge bg-warning">Pending Review</span></td>
                                </tr>
                                <tr>
                                    <td>Emily Davis</td>
                                    <td>New Registration</td>
                                    <td>Yesterday</td>
                                    <td><span class="badge bg-success">Verified</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="#" class="btn btn-outline-primary btn-sm">View All Activity</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Upcoming Tasks</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-0 mb-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="task1">
                                    <label class="form-check-label fw-bold" for="task1">Review Dr. Brown's reports</label>
                                    <small class="d-block text-muted">Due today at 4:00 PM</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0 mb-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="task2">
                                    <label class="form-check-label fw-bold" for="task2">Update medical supplies inventory</label>
                                    <small class="d-block text-muted">Due tomorrow</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="task3">
                                    <label class="form-check-label fw-bold" for="task3">Staff meeting</label>
                                    <small class="d-block text-muted">Friday, 10 June</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="#" class="btn btn-outline-secondary btn-sm">Manage Tasks</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
