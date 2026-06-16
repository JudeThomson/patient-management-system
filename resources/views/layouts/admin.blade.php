<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Patient Info') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const validationRules = {
                'name': (val) => val.length >= 3 && /^[a-zA-Z\s]+$/.test(val),
                'caregivers.*.name': (val) => val.length >= 3 && /^[a-zA-Z\s]+$/.test(val),
                'age': (val) => {
                    const n = parseInt(val);
                    return !isNaN(n) && n >= 1 && n <= 100 && /^\d+$/.test(val);
                },
                'phone': (val) => /^\d{10}$/.test(val),
                'caregivers.*.contact_no': (val) => /^\d{10}$/.test(val),
                'address': (val) => val.length >= 5 && val.length <= 500,
                'caregivers.*.relation': (val) => val.length >= 2 && val.length <= 50 && /^[a-zA-Z\s]+$/.test(val),
                'sct_no': (val) => val.length <= 15,
                'gender': (val) => ['Male', 'Female', 'Other'].includes(val),
                'diagnosis': (val) => !val || (val.length >= 3 && val.length <= 255),
                'hospital_department': (val) => !val || (val.length >= 3 && val.length <= 50),
                'route_map': (val) => !val || (val.length >= 3 && val.length <= 500),
                // Assessment Rules
                'assessment_date': (val) => !!val && new Date(val) <= new Date().setHours(23, 59, 59, 999),
                'complaints.*': (val) => !val || (val.length >= 5 && val.length <= 500),
                'medical_history.*.details': (val) => !val || val.length <= 120,
                'medical_history.*.date': (val) => !val || new Date(val) <= new Date().setHours(23, 59, 59, 999),
                'medication.*': (val) => !val || val.length <= 120
            };

            function getRuleKey(name) {
                if (!name) return null;
                
                // 1. Convert all bracketed keys to dots: caregivers.0.name, medical_history.surgery.date
                let key = name.replace(/\[(.*?)\]/g, '.$1').replace(/\.+$/, '');
                
                // 2. Map specific modules to wildcard patterns
                if (key.startsWith('caregivers.')) {
                    return key.replace(/caregivers\.\d+\./, 'caregivers.*.');
                }
                if (key.startsWith('medical_history.')) {
                    if (key.endsWith('.details')) return 'medical_history.*.details';
                    if (key.endsWith('.date')) return 'medical_history.*.date';
                }
                if (key.startsWith('complaints')) {
                    return 'complaints.*';
                }
                if (key.startsWith('medication.')) {
                    return 'medication.*';
                }
                
                return key;
            }

            function clearErrorIfValid(input) {
                if (!input.classList.contains('is-invalid')) return;

                const name = input.getAttribute('name');
                const ruleKey = getRuleKey(name);
                const rule = validationRules[ruleKey];

                if (rule && rule(input.value)) {
                    input.classList.remove('is-invalid');
                    // Find the sibling error message and hide it
                    const parent = input.closest('div') || input.closest('td');
                    const errorContainer = parent ? parent.querySelector('.invalid-feedback') : null;
                    if (errorContainer) {
                        errorContainer.classList.remove('d-block');
                        errorContainer.classList.add('d-none');
                    }

                    // Special case: Medical History Date Alert
                    if (ruleKey === 'medical_history.*.date') {
                        const allDateInputs = document.querySelectorAll('input[name^="medical_history"][name$="[date]"]');
                        let anyInvalid = false;
                        allDateInputs.forEach(el => {
                            if (el.classList.contains('is-invalid')) anyInvalid = true;
                        });
                        if (!anyInvalid) {
                            const alert = document.getElementById('history-date-alert');
                            if (alert) alert.style.display = 'none';
                        }
                    }
                }
            }

            document.addEventListener('input', function(e) {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                    clearErrorIfValid(e.target);
                }
            });

            document.addEventListener('change', function(e) {
                if (e.target.tagName === 'SELECT') {
                    clearErrorIfValid(e.target);
                }
            });
        });
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
            z-index: 1030;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 56px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #fff;
            width: 240px;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 56px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            font-weight: 500;
            color: #4b5563;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover {
            color: #0d6efd;
            background-color: #f8f9fa;
        }
        .sidebar .nav-link.active {
            color: #0d6efd;
            background-color: #e7f1ff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        main {
            margin-left: 240px;
            padding-top: 56px;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                display: none;
            }
            main {
                margin-left: 0;
            }
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .medical-blue {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
                <i class="fas fa-hand-holding-medical"></i> Patient Info
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}" href="{{ route('patients.index') }}">
                                <i class="fas fa-user-injured"></i> Patients
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('assessments.*') ? 'active' : '' }}" href="{{ route('assessments.index') }}">
                                <i class="fas fa-clipboard-check"></i> Assessments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                                <i class="fas fa-chart-line"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <i class="fas fa-users"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="py-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
