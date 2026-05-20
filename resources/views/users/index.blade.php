@extends('layouts.app')

@section('title', 'Users Management')
@section('page-title', 'Users Management')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary" id="btnAddUser">
                <i class="fas fa-plus"></i> Add New User
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Users List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit User -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="userId" name="id">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter user name">
                            <span class="error-text" id="error_name"></span>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter email address">
                            <span class="error-text" id="error_email"></span>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone *</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Enter phone number">
                            <span class="error-text" id="error_phone"></span>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="3"
                                placeholder="Enter address"></textarea>
                            <span class="error-text" id="error_address"></span>
                        </div>

                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role *</label>
                            <select class="form-select" id="role_id" name="role_id">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="error-text" id="error_role_id"></span>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <small class="form-text text-muted">Max file size: 2MB. Accepted formats: JPEG, PNG, JPG,
                                GIF</small>
                            <span class="error-text" id="error_photo"></span>
                            <div id="photoPreview" class="mt-2"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btnSaveUser">Save User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View User Details -->
    <div class="modal fade" id="viewUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-center">
                            <img id="viewPhoto" src="" alt="User Photo" class="img-fluid rounded"
                                style="max-width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Name:</strong></td>
                                    <td id="viewName">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td id="viewEmail">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td id="viewPhone">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td id="viewRole">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Address:</strong>
                        <p id="viewAddress" class="mt-2">-</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            const userModal = new bootstrap.Modal(document.getElementById('userModal'));
            const viewUserModal = new bootstrap.Modal(document.getElementById('viewUserModal'));
            let userTable;
            let editingUserId = null;

            // Initialize DataTable
            function initDataTable() {
                if (userTable) {
                    userTable.destroy();
                }

                userTable = $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/users/data',
                        type: 'GET',
                        error: function (xhr) {
                            console.error('Error loading data:', xhr);
                        }
                    },
                    columns: [
                        { data: 'no', name: 'no' },
                        {
                            data: 'photo',
                            name: 'photo',
                            render: function (data) {
                                return '<img src="' + data + '" alt="User Photo" class="img-thumbnail">';
                            }
                        },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'phone', name: 'phone' },
                        { data: 'role', name: 'role' },
                        {
                            data: 'id',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function (data) {
                                return `
                                <button class="btn btn-sm btn-view" onclick="viewUser(${data})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-edit" onclick="editUser(${data})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-delete" onclick="deleteUser(${data})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                            }
                        }
                    ],
                    pageLength: 10,
                    responsive: true
                });
            }

            // Add New User
            $('#btnAddUser').click(function () {
                editingUserId = null;
                $('#userForm')[0].reset();
                clearErrors();
                $('#photoPreview').html('');
                $('#userModalTitle').text('Add New User');
                userModal.show();
            });

            // View User
            window.viewUser = function (id) {
                $.get('/users/' + id, function (response) {
                    $('#viewName').text(response.name);
                    $('#viewEmail').text(response.email);
                    $('#viewPhone').text(response.phone);
                    $('#viewAddress').text(response.address);
                    $('#viewRole').text(response.role_name);

                    if (response.photo) {
                        $('#viewPhoto').attr('src', response.photo);
                    } else {
                        $('#viewPhoto').attr('src', '{{ asset("images/no-image.png") }}');
                    }

                    viewUserModal.show();
                }).fail(function () {
                    Swal.fire('Error', 'Failed to load user details', 'error');
                });
            };

            // Edit User
            window.editUser = function (id) {
                $.get('/users/' + id, function (response) {
                    editingUserId = id;
                    $('#userId').val(response.id);
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#phone').val(response.phone);
                    $('#address').val(response.address);
                    $('#role_id').val(response.role_id);
                    clearErrors();

                    if (response.photo) {
                        $('#photoPreview').html('<img src="' + response.photo + '" alt="User Photo" class="img-thumbnail" style="max-width: 100px; height: 100px; object-fit: cover;">');
                    } else {
                        $('#photoPreview').html('');
                    }

                    $('#userModalTitle').text('Edit User');
                    userModal.show();
                }).fail(function () {
                    Swal.fire('Error', 'Failed to load user data', 'error');
                });
            };

            // Delete User
            window.deleteUser = function (id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this user!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/users/' + id,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                Swal.fire('Deleted!', 'User has been deleted successfully.', 'success');
                                userTable.ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire('Error', 'Failed to delete user', 'error');
                            }
                        });
                    }
                });
            };

            // Save User (Create/Update)
            $('#btnSaveUser').click(function () {
                const formData = new FormData(document.getElementById('userForm'));
                clearErrors();

                const url = editingUserId ? '/users/' + editingUserId : '/users';
                const method = editingUserId ? 'POST' : 'POST';

                if (editingUserId) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        userModal.hide();
                        $('#userForm')[0].reset();
                        userTable.ajax.reload();
                        Swal.fire('Success!', response.message, 'success');
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            displayErrors(errors);
                        } else {
                            Swal.fire('Error', 'An error occurred', 'error');
                        }
                    }
                });
            });

            // Clear error messages
            function clearErrors() {
                $('.error-text').text('');
                $('.form-control, .form-select').removeClass('is-invalid');
            }

            // Display validation errors
            function displayErrors(errors) {
                clearErrors();
                $.each(errors, function (field, messages) {
                    const errorElement = $('#error_' + field);
                    if (errorElement.length) {
                        errorElement.text(messages[0]);
                        $('#' + field).addClass('is-invalid');
                    }
                });
            }

            // Photo preview
            $('#photo').change(function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#photoPreview').html('<img src="' + e.target.result + '" alt="Photo Preview" class="img-thumbnail" style="max-width: 100px; height: 100px; object-fit: cover;">');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Initialize on page load
            initDataTable();
        });
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection