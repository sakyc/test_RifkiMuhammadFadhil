@extends('layouts.app')

@section('title', 'Roles Management')
@section('page-title', 'Roles Management')

@section('content')
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Roles List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="90%">Role Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox"></i> No roles found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection