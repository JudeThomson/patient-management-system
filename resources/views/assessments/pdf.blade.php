<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Assessment Report - {{ $assessment->assessment_id }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .logo-placeholder { width: 100px; height: 100px; background: #eee; margin: 0 auto 10px; }
        .org-name { font-size: 18px; font-weight: bold; margin: 0; }
        .org-details { font-size: 12px; margin: 2px 0; }
        h1, h2, h3 { color: #2c3e50; }
        .patient-summary { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; background: #f9f9f9; }
        .summary-grid { display: table; width: 100%; }
        .summary-col { display: table-cell; width: 50%; padding-bottom: 5px; }
        .section { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .pain-card { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; }
        .badge { display: inline-block; padding: 3px 8px; background: #eee; border-radius: 4px; margin-right: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-placeholder">
            <img src="" alt="" class="">
        </div>
        <p class="org-name">SREERAM CANCER TRUST, NAGERCOIL</p>
        <p class="org-details">Pain and Palliative Care</p>
        <p class="org-details"># 3-143 B/1, Anandan Nagar, Near Anandhanpalam, Govt. Medical College Road, Asaripallam, Nagercoil - 629201</p>
        <p class="org-details">Phone: 0000000000 | Email: example@example.com</p>
    </div>

    <h2>Assessment Report</h2>

    <div class="section">
        <div class="summary-grid">
            <div class="summary-col"><strong>Generated Date:</strong> {{ date('d M, Y') }}</div> <br>
            <div class="summary-col"><strong>SCT Number:</strong> {{ $assessment->patient->sct_no ?? '' }}</div>
        </div>
        <div class="summary-grid">
            <div class="summary-col"><strong>Referred by:</strong> {{ $assessment->patient->referred_by ?? '' }}</div>
            <div class="summary-col"><strong>Hosp/Dept.:</strong> {{ $assessment->patient->hospital_department }}</div>
            <div class="summary-col"><strong>Doctor:</strong> {{ $assessment->patient->doctor ?? 'N/A' }}</div>
        </div>

        <h3>Patient Information</h3>
        <div class="summary-grid">
            <div class="summary-col"><strong>1. Name of the patient:</strong> {{ $assessment->patient->name }}</div>
            <div class="summary-col"><strong>2. Diagnosis:</strong> {{ $assessment->patient->diagnosis ?? 'N/A' }}</div>
        </div>
        <div class="summary-grid">
            <div class="summary-col"><strong>3. Address with Pincode:</strong> {{ $assessment->patient->address ?? '' }} {{ $assessment->patient->pincode ?? '' }}</div>
            <div class="summary-col"><strong>4. Phone No:</strong> {{ $assessment->patient->phone ?? '' }}</div>
        </div>
    </div>

    <div class="section">
        <h3>5. Care Giver(s) Details</h3>
        @if($assessment->patient->caregivers->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Relation</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assessment->patient->caregivers as $caregiver)
                        <tr>
                            <td>{{ $caregiver->name }}</td>
                            <td>{{ $caregiver->relation }}</td>
                            <td>{{ $caregiver->contact_no }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No caregiver information available.</p>
        @endif
    </div>
    
    <div class="section">
        <div class="summary-grid">
            <div class="summary-col"><strong>6. Route Map: </strong> {{ $assessment->patient->route_map ?? '' }} </div>
        </div>
    </div>
    <div class="section">
        <h3>7. Symptoms</h3>
        @if($assessment->symptoms->count() > 0)
            @foreach($assessment->symptoms as $symptom)
                <span class="badge">{{ $symptom->symptom_name }}</span>
            @endforeach
        @else
            <p>None</p>
        @endif
    </div>

    <div class="section">
        <h3>8. Distress Meter</h3>
        <p>Distress Score: {{ $assessment->distress_meter }} / 10</p>
    </div>

    <div class="section">
        <h3>9. Presenting Complaints</h3>
        <ul>
            @foreach($assessment->complaints as $complaint)
                <li>{{ $complaint->complaint_text }}</li>
            @endforeach
        </ul>
    </div>

    {{-- <div class="section">
        <h3>10. Body Map: </h3>
        <div class="summary-grid">
            <div class="summary-col"> I HAVE NO IDEA HOW TO DO BODY PAIN MARKING SECTION!!!! </div>
        </div>
    </div> --}}

    @if($assessment->pains->count() > 0)
    <div class="section">
        <h3>10. Pain Evaluation</h3>
        @foreach($assessment->pains as $pain)
            @if(!empty($pain->pain_score) || !empty($pain->quality))
            <div class="pain-card">
                <h4>Pain {{ $pain->pain_label }}</h4>
                <p><strong>Duration:</strong> {{ $pain->duration ?? 'N/A' }} | <strong>Pain Score:</strong> {{ $pain->pain_score ?? 'N/A' }}</p>
                <p><strong>Radiation:</strong> {{ $pain->radiation ?? 'N/A' }} | <strong>Quality:</strong> {{ $pain->quality ?? 'N/A' }}</p>
                <p><strong>Provoking Factors:</strong> {{ $pain->provoking_factors ?? 'N/A' }}</p>
                <p><strong>Palliating Factors:</strong> {{ $pain->palliating_factors ?? 'N/A' }}</p>
                <p><strong>Impact on ADLs:</strong> {{ $pain->impact_on_adls ?? 'N/A' }}</p>
                <p><strong>Impact on Person:</strong> {{ $pain->impact_on_person ?? 'N/A' }}</p>
            </div>
            @endif
        @endforeach
    </div>
    @endif

    <div class="section">
        <h3>11. Medical History</h3>
        <table class="table">
            <thead><tr><th>Item</th><th>Details</th><th>Date</th></tr></thead>
            <tbody>
                @foreach([
                    ['label' => 'Problem Started On', 'details' => 'problem_started_on', 'date' => 'problem_started_on_date'],
                    ['label' => 'Details of Illness / Complaints', 'details' => 'illness_details', 'date' => 'illness_details_date'],
                    ['label' => 'Doctor / Hospital I', 'details' => 'doctor_hospital', 'date' => 'doctor_hospital_date'],
                    ['label' => 'Doctor / Hospital II', 'details' => 'doctor_hospital_2', 'date' => 'doctor_hospital_2_date'],
                    ['label' => 'Doctor / Hospital III', 'details' => 'doctor_hospital_3', 'date' => 'doctor_hospital_3_date'],
                    ['label' => 'Diagnosed At', 'details' => 'diagnosed_at', 'date' => 'diagnosed_at_date'],
                    ['label' => 'Surgery', 'details' => 'surgery', 'date' => 'surgery_date'],
                    ['label' => 'Radiation', 'details' => 'radiation', 'date' => 'radiation_date'],
                    ['label' => 'Chemotherapy', 'details' => 'chemotherapy', 'date' => 'chemotherapy_date'],
                    ['label' => 'Colostomy', 'details' => 'colostomy', 'date' => 'colostomy_date'],
                    ['label' => 'Renal Problems', 'details' => 'renal_problems', 'date' => 'renal_problems_date'],
                    ['label' => 'DM HTN Asthma CAD', 'details' => 'dm_htn_asthma_cad_details', 'date' => 'dm_htn_asthma_cad_date']
                ] as $item)
                    <tr>
                        <td>{{ $item['label'] }}</td>
                        <td>{{ $assessment->medicalHistory->{$item['details']} ?? 'N/A' }}</td>
                        <td>
                            @if($assessment->medicalHistory && $assessment->medicalHistory->{$item['date']})
                                {{ \Carbon\Carbon::parse($assessment->medicalHistory->{$item['date']})->format('d-m-Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>12. Recent Medication</h3>
        <table class="table">
            <tr><th>Medicine</th><th>Details</th></tr>
            <tr><td>Diabetes</td><td>{{ $assessment->medication->diabetes_medicine ?? 'N/A' }}</td></tr>
            <tr><td>BP</td><td>{{ $assessment->medication->bp_medicine ?? 'N/A' }}</td></tr>
            <tr><td>Chemo</td><td>{{ $assessment->medication->chemo_medicine ?? 'N/A' }}</td></tr>
            <tr><td>Pain</td><td>{{ $assessment->medication->pain_medicine ?? 'N/A' }}</td></tr>
        </table>
    </div>
</body>
</html>

