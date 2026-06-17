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
        :root {
            --sidebar-width: 240px;
            --navbar-height: 80px;
            --primary-blue: #0d6efd;
            --dark-text: #111827;
            --gray-text: #4b5563;
            --bg-color: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--dark-text);
        }

        /* Top Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: var(--navbar-height);
            z-index: 1050;
            background-color: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand-container {
            display: flex;
            align-items: center;
            text-decoration: none;
            height: 100%;
        }

        .brand-logo {
            height: 80px;
            width: auto;
            object-fit: contain;
            margin-right: 15px;
        }

        .brand-text {
            font-weight: 700;
            font-size: 28px;
            color: var(--dark-text);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            bottom: 0;
            left: 0;
            z-index: 1040;
            width: var(--sidebar-width);
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.02);
            padding-top: 1.5rem;
            transition: all 0.3s;
        }

        .nav-item {
            padding: 0.125rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--gray-text);
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .nav-link:hover {
            color: var(--primary-blue);
            background-color: #f8fafc;
        }

        .nav-link.active {
            color: var(--primary-blue);
            background-color: #eff6ff;
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
        }

        /* Main Content Styles */
        main {
            margin-left: var(--sidebar-width);
            padding-top: var(--navbar-height);
            min-height: 100vh;
            transition: all 0.3s;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            main {
                margin-left: 0;
            }
            .brand-text {
                font-size: 14px;
            }
            .brand-logo {
                height: 40px;
            }
        }

        /* Utility Classes */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .medical-blue {
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="container-fluid p-0 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="navbar-toggler d-lg-none me-3" type="button" onclick="document.getElementById('sidebarMenu').classList.toggle('show')">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand-container" href="{{ route('dashboard') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="brand-logo">
                    <span class="brand-text">SREERAM CANCER TRUST</span>
                </a>
            </div>
            
            <div class="d-flex align-items-center">
                <span class="text-dark fw-medium d-flex align-items-center">
                    <i class="fas fa-user-circle fs-5 me-2"></i> {{ Auth::user()->name }}
                </span>
                <span class="text-muted mx-3">|</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger fw-medium p-0 text-decoration-none d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar">
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
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container-fluid px-md-4 py-4">
            @yield('content')
        </div>
    </main>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
