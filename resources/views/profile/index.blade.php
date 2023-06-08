@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">My Profile</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500">My Profile</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ auth()->user()->photo != '' ? asset('storage/images/user/' . auth()->user()->photo) : asset('assets/media/svg/avatars/blank.svg') }}"
                                    alt="image" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2 mt-5">
                                        <h3 class="text-gray-900 fs-2 fw-bold me-1">{{ auth()->user()->name }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>{{ auth()->user()->roles->pluck('name')->implode(',') }}</span>
                                    <span class="d-flex align-items-center text-gray-400 mb-2">
                                        <i class="ki-duotone ki-sms fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                </div>
                <form action="{{ route('profile/update') }}" method="POST" id="userForm" name="userForm">
                    @csrf
                    <input id="id" type="hidden" class="form-control" name="id"
                        value="{{ auth()->user()->id }}">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name</label>
                            <div class="col-lg-8 fv-row validate">
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-lg form-control-solid " />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Username</label>
                            <div class="col-lg-8 fv-row validate">
                                <input type="text" id="username" name="username"
                                    class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                            <div class="col-lg-8 fv-row validate">
                                <input type="email" id="email" name="email"
                                    class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Photo</label>
                            <div class="col-lg-8 fv-row">
                                <input type="file" id="photo" name="photo"
                                    class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn" name="saveBtn">Update</button>
                    </div>
                </form>
            </div>
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Change Password</h3>
                    </div>
                </div>
                <div id="kt_account_settings_signin_method" class="collapse show">
                    <div class="card-body border-top p-9">
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <div class="flex-row-fluid">
                                <form action="{{ route('profile/password') }}" method="POST" id="passwordForm"
                                    name="passwordForm">
                                    @csrf
                                    <input id="id" type="hidden" class="form-control" name="id"
                                        value="{{ auth()->user()->id }}">
                                    <div class="row mb-1">
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0 validate">
                                                <label for="password" class="form-label fs-6 fw-bold mb-3">New
                                                    Password</label>
                                                <input type="password" class="form-control form-control-lg"
                                                    name="password" id="password" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0 validate">
                                                <label for="password_confirm" class="form-label fs-6 fw-bold mb-3">Confirm
                                                    New Password</label>
                                                <input type="password" class="form-control form-control-lg"
                                                    name="password_confirm" id="password_confirm" />
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-text mb-5">Password must be at least 8 character and contain symbols
                                    </div> --}}
                                    <div class="d-flex mt-5">
                                        <button id="passwordBtn" name="passwordBtn" type="button"
                                            class="btn btn-primary me-2 px-6">Update Password</button>
                                        <button type="reset"
                                            class="btn btn-light btn-active-light-primary px-6">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-info',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: !true
        });
        $(function() {
            let id = $('#id').val();
            show(id)

            function show(id) {
                let url = "{{ route('profile/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#username').val(response.data.username);
                        $('#name').val(response.data.name);
                        $('#email').val(response.data.email);

                    },
                    error: function() {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            }

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#userForm").valid();
                if (isValid) {
                    $('#saveBtn').text('Update...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#userForm')[0]);
                    $.ajax({
                        url: "{{ route('profile/update') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            swalWithBootstrapButtons.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            ).then(function(result) {
                                $('#saveBtn').text('Update');
                                $('#saveBtn').attr('disabled', false);
                                location.reload();
                            });
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#saveBtn').text('Save');
                            $('#saveBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#passwordBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#passwordForm").valid();
                if (isValid) {
                    $('#passwordBtn').text('Update Password...');
                    $('#passwordBtn').attr('disabled', true);
                    var formData = new FormData($('#passwordForm')[0]);
                    $.ajax({
                        url: "{{ route('profile/password') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            swalWithBootstrapButtons.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            ).then(function(result) {
                                $('#passwordBtn').text('Update Password');
                                $('#passwordBtn').attr('disabled', false);
                                location.reload();
                            });
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#passwordBtn').text('Update Password');
                            $('#passwordBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    email: {
                        required: true,
                    }
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.validate').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $.validator.addMethod('passwordRule', function(value, element) {
                    return /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/.test(value);
                },
                'Password must contains one lowercase letter, one uppercase letter, one digit, one special character and least eight characters long.'
            );

            $('#passwordForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8,
                        passwordRule: true
                    },
                    password_confirm: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    },
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.validate').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
