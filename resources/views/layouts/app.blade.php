<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-top: 2rem;
            color: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-left: 3px solid transparent;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar .logo h5 {
            font-weight: 600;
            margin: 0;
        }

        .main-content {
            padding: 2rem;
        }

        .topbar {
            background-color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .topbar h1 {
            font-weight: 600;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
        }

        .stat-card h3 {
            font-weight: 600;
            margin: 0.5rem 0;
        }

        .stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1.5rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            border: none;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #333;
            border: none;
        }

        .btn-edit:hover {
            background-color: #e0a800;
            color: #333;
        }

        .btn-view {
            background-color: #17a2b8;
            color: white;
            border: none;
        }

        .btn-view:hover {
            background-color: #138496;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background-color: #c82333;
            color: white;
        }

        .table-responsive {
            border-radius: 8px;
        }

        .dataTables_wrapper {
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        table thead th {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            font-weight: 600;
            color: #333;
        }

        table tbody td {
            vertical-align: middle;
        }

        .img-thumbnail {
            border-radius: 5px;
            max-width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .success-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                padding: 1rem;
            }

            .sidebar .nav-link {
                padding: 0.75rem 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .stat-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }

            .stat-card .stat-number {
                font-size: 2rem;
            }

            .table {
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.75rem;
            }
        }
    </style>

    @yield('css')
</head>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh;">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar" id="sidebar">
                <div class="logo">
                    <h5><i class="fas fa-chart-pie"></i> Admin Panel</h5>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() === '' ? 'active' : '' }}" href="/">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() === 'roles' ? 'active' : '' }}" href="/roles">
                            <i class="fas fa-shield-alt"></i> Roles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() === 'users' ? 'active' : '' }}" href="/users">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="topbar">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>

                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    @yield('js')
</body>

</html>