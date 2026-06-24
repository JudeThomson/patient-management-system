@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('patients.show', $patient) }}">{{ $patient->patient_id }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Patient</li>
                </ol>
            </nav>
            <h2 class="h4 medical-blue">Edit Patient Information</h2>
        </div>
    </div>

    <form action="{{ route('patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')
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
                                <label class="form-label">Patient ID</label>
                                <input type="text" class="form-control bg-light" value="{{ $patient->patient_id }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">SCT NO.</label>
                                <input type="text" name="sct_no" class="form-control @error('sct_no') is-invalid @enderror" value="{{ old('sct_no', $patient->sct_no) }}" maxlength="15">
                                <x-input-error :messages="$errors->get('sct_no')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $patient->name) }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Age <span class="text-danger">*</span></label>
                                <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $patient->age) }}" min="1" max="100" step="1">
                                <x-input-error :messages="$errors->get('age')" class="mt-2" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $patient->phone) }}" maxlength="10">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Diagnosis</label>
                                <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3">{{ old('diagnosis', $patient->diagnosis) }}</textarea>
                                <x-input-error :messages="$errors->get('diagnosis')" class="mt-2" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $patient->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Route Map</label>
                                <textarea name="route_map" class="form-control @error('route_map') is-invalid @enderror" rows="2">{{ old('route_map', $patient->route_map) }}</textarea>
                                <x-input-error :messages="$errors->get('route_map')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode', $patient->pincode) }}">
                                <x-input-error :messages="$errors->get('pincode')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Referred By</label>
                                <input type="text" name="referred_by" class="form-control @error('referred_by') is-invalid @enderror" value="{{ old('referred_by', $patient->referred_by) }}">
                                <x-input-error :messages="$errors->get('referred_by')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hospital</label>
                                <input type="text" name="hospital_department" class="form-control @error('hospital_department') is-invalid @enderror" value="{{ old('hospital_department', $patient->hospital_department) }}">
                                <x-input-error :messages="$errors->get('hospital_department')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Doctor</label>
                                <input type="text" name="doctor" class="form-control @error('doctor') is-invalid @enderror" value="{{ old('doctor', $patient->doctor) }}">
                                <x-input-error :messages="$errors->get('doctor')" class="mt-2" />
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
                        <x-input-error :messages="$errors->get('caregivers')" class="mb-3" />
                        @php
                            $caregivers = old('caregivers', $patient->caregivers->toArray());
                        @endphp
                        @foreach($caregivers as $index => $caregiver)
                            <div class="caregiver-item p-3 border rounded-3 mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Caregiver #{{ $index + 1 }}</h6>
                                    <button type="button" class="btn btn-sm btn-link text-danger remove-caregiver {{ $index == 0 ? 'd-none' : '' }}">Remove</button>
                                </div>
                                @if(isset($caregiver['id']))
                                    <input type="hidden" name="caregivers[{{ $index }}][id]" value="{{ $caregiver['id'] }}">
                                @endif
                                <div class="mb-2">
                                    <label class="small fw-bold">Caregiver Name <span class="text-danger">*</span></label>
                                    <input type="text" name="caregivers[{{ $index }}][name]" class="form-control form-control-sm @error('caregivers.'.$index.'.name') is-invalid @enderror" value="{{ $caregiver['name'] }}">
                                    <x-input-error :messages="$errors->get('caregivers.'.$index.'.name')" class="mt-1" />
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Relationship <span class="text-danger">*</span></label>
                                    <input type="text" name="caregivers[{{ $index }}][relation]" class="form-control form-control-sm @error('caregivers.'.$index.'.relation') is-invalid @enderror" value="{{ $caregiver['relation'] }}">
                                    <x-input-error :messages="$errors->get('caregivers.'.$index.'.relation')" class="mt-1" />
                                </div>
                                <div>
                                    <label class="small fw-bold">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="caregivers[{{ $index }}][contact_no]" class="form-control form-control-sm @error('caregivers.'.$index.'.contact_no') is-invalid @enderror" value="{{ $caregiver['contact_no'] }}" maxlength="10">
                                    <x-input-error :messages="$errors->get('caregivers.'.$index.'.contact_no')" class="mt-1" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Update Patient</button>
                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('caregiver-container');
        const addButton = document.getElementById('add-caregiver');
        let caregiverCount = {{ count($caregivers) }};

        addButton.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'caregiver-item p-3 border rounded-3 mb-3 bg-light';
            newItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Caregiver #${caregiverCount + 1}</h6>
                    <button type="button" class="btn btn-sm btn-link text-danger remove-caregiver">Remove</button>
                </div>
                <div class="mb-2">
                    <label class="small fw-bold">Caregiver Name <span class="text-danger">*</span></label>
                    <input type="text" name="caregivers[${caregiverCount}][name]" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                    <label class="small fw-bold">Relationship <span class="text-danger">*</span></label>
                    <input type="text" name="caregivers[${caregiverCount}][relation]" class="form-control form-control-sm">
                </div>
                <div>
                    <label class="small fw-bold">Contact Number <span class="text-danger">*</span></label>
                    <input type="text" name="caregivers[${caregiverCount}][contact_no]" class="form-control form-control-sm" maxlength="10">
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
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                    }
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
