@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Patient</li>
                </ol>
            </nav>
            <h2 class="h4 medical-blue">Patient Registration</h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Patient Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Patient Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">SCT Number</label>
                                <input type="text" name="sct_no" class="form-control" value="{{ old('sct_no') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Age <span class="text-danger">*</span></label>
                                <input type="number" name="age" class="form-control" value="{{ old('age') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Diagnosis</label>
                                <textarea name="diagnosis" class="form-control" rows="3">{{ old('diagnosis') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Route Map</label>
                                <textarea name="route_map" class="form-control" rows="2">{{ old('route_map') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Referred By</label>
                                <input type="text" name="referred_by" class="form-control" value="{{ old('referred_by') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hospital / Department</label>
                                <input type="text" name="hospital_department" class="form-control" value="{{ old('hospital_department') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Caregivers -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Caregivers</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-caregiver">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </div>
                    <div class="card-body" id="caregiver-container">
                        @if(old('caregivers'))
                            @foreach(old('caregivers') as $index => $caregiver)
                                <div class="caregiver-item p-3 border rounded-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Caregiver #{{ $index + 1 }}</h6>
                                        <button type="button" class="btn btn-sm btn-link text-danger remove-caregiver {{ $index == 0 ? 'd-none' : '' }}">Remove</button>
                                    </div>
                                    <div class="mb-2">
                                        <label class="small fw-bold">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="caregivers[{{ $index }}][name]" class="form-control form-control-sm" value="{{ $caregiver['name'] }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="small fw-bold">Relation <span class="text-danger">*</span></label>
                                        <input type="text" name="caregivers[{{ $index }}][relation]" class="form-control form-control-sm" value="{{ $caregiver['relation'] }}" required>
                                    </div>
                                    <div>
                                        <label class="small fw-bold">Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" name="caregivers[{{ $index }}][contact_no]" class="form-control form-control-sm" value="{{ $caregiver['contact_no'] }}" required>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="caregiver-item p-3 border rounded-3 mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Caregiver #1</h6>
                                    <button type="button" class="btn btn-sm btn-link text-danger remove-caregiver d-none">Remove</button>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="caregivers[0][name]" class="form-control form-control-sm" required>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Relation <span class="text-danger">*</span></label>
                                    <input type="text" name="caregivers[0][relation]" class="form-control form-control-sm" required>
                                </div>
                                <div>
                                    <label class="small fw-bold">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="caregivers[0][contact_no]" class="form-control form-control-sm" required>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Register Patient</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('caregiver-container');
        const addButton = document.getElementById('add-caregiver');
        let caregiverCount = {{ old('caregivers') ? count(old('caregivers')) : 1 }};

        addButton.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'caregiver-item p-3 border rounded-3 mb-3 bg-light';
            newItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Caregiver #${caregiverCount + 1}</h6>
                    <button type="button" class="btn btn-sm btn-link text-danger remove-caregiver">Remove</button>
                </div>
                <div class="mb-2">
                    <label class="small fw-bold">Name <span class="text-danger">*</span></label>
                    <input type="text" name="caregivers[${caregiverCount}][name]" class="form-control form-control-sm" required>
                </div>
                <div class="mb-2">
                    <label class="small fw-bold">Relation <span class="text-danger">*</span></label>
                    <input type="text" name="caregivers[${caregiverCount}][relation]" class="form-control form-control-sm" required>
                </div>
                <div>
                    <label class="small fw-bold">Contact Number <span class="text-danger">*</span></label>
                    <input type="text" name="caregivers[${caregiverCount}][contact_no]" class="form-control form-control-sm" required>
                </div>
            `;
            container.appendChild(newItem);
            caregiverCount++;
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-caregiver')) {
                e.target.closest('.caregiver-item').remove();
                reindexCaregivers();
            }
        });

        function reindexCaregivers() {
            const items = container.querySelectorAll('.caregiver-item');
            caregiverCount = items.length;
            items.forEach((item, index) => {
                item.querySelector('h6').textContent = `Caregiver #${index + 1}`;
                const inputs = item.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                });
                
                const removeBtn = item.querySelector('.remove-caregiver');
                if (index === 0) {
                    removeBtn.classList.add('d-none');
                } else {
                    removeBtn.classList.remove('d-none');
                }
            });
        }
    });
</script>
@endsection
