@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="stat-card">
                <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <h3>Total Users</h3>
                <div class="stat-number">{{ $totalUsers }}</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-shield-alt" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <h3>Total Roles</h3>
                <div class="stat-number">{{ $totalRoles }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome to Admin Dashboard</h5>
                    <p class="card-text">This is your user management system. Use the sidebar to navigate between Dashboard,
                        Roles, and Users management sections.</p>
                    <p class="card-text">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            You can manage users, view their roles, and handle all CRUD operations from the Users section.
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection