@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Edit User</h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Settings</li>

                    <li class="breadcrumb-item text-gray-500">Edit User</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2 class="fw-bold">Form User</h2>
                    </div>
                </div>
                <form action="#" name="userForm" id="userForm" method="POST">
                    @csrf
                    <input id="id" type="hidden" class="form-control" name="id" value="{{ $id }}">
                    <div class="card-body py-4">
                        <div class="form-group row mb-5">
                            <label for="name" class="col-md-3 required form-label">Name</label>
                            <div class="col-md-6 validate">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="username" class="col-md-3 required form-label">Username</label>
                            <div class="col-md-6 validate">
                                <input id="username" type="text" class="form-control" name="username">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="email" class="col-md-3 required form-label">Email</label>
                            <div class="col-md-6 validate">
                                <input id="email" type="email" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="department" class="col-md-3 required form-label">Department</label>
                            <div class="col-md-6 row validate ml-0 departments">

                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="role_id" class="col-md-3 required form-label">Role</label>
                            <div class="col-md-6 validate">
                                <select name="role_id" id="role_id" class="form-select role_id"></select>
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="photo" class="col-md-3 form-label">Photo</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="photo" id="photo">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-sm" name="updateBtn" id="updateBtn">Save</button>
                        <a href="{{ route('user') }}" class="btn btn-secondary btn-sm">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            var id = $('#id').val();
            department();
            show(id);
            $(".role_id").select2({
                placeholder: "Choose Role",
                ajax: {
                    url: "{{ route('role/getData') }}",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    method: 'POST',
                    delay: 250,
                    destroy: true,
                    data: function(params) {
                        var query = {
                            searchkey: params.term || '',
                            start: 0,
                            length: 50
                        }
                        return JSON.stringify(query);
                    },
                    processResults: function(data) {
                        var result = {
                            results: [],
                            more: false
                        };
                        if (data && data.data) {
                            $.each(data.data, function() {
                                result.results.push({
                                    id: this.id,
                                    text: this.name
                                });
                            })
                        }
                        return result;
                    },
                    cache: false
                },
            });
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: !true
            });
            $('#updateBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#userForm").valid();
                if (isValid) {
                    $('#updateBtn').text('Save...');
                    $('#updateBtn').attr('disabled', true);
                    url = "{{ route('user/update') }}";
                    var formData = new FormData($('#userForm')[0]);
                    $.ajax({
                        url: url,
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
                                $('#updateBtn').text('Save');
                                $('#updateBtn').attr('disabled', false);
                                (data.status) ? window.location.href =
                                    "{{ route('user') }}": "";
                            });

                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#updateBtn').text('Save');
                            $('#updateBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#userForm').validate({
                rules: {
                    username: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    'department_id[]': {
                        required: true,
                    },
                    role_id: {
                        required: true,
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

            function department() {
                let req = {
                    "searchkey": '',
                    "start": 0,
                    "length": -1,
                };
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: "{{ route('department/getData') }}",
                    data: req,
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            let departments =
                                '<div class="form-check col-md-6 mt-3">' +
                                '<input type="checkbox" name="department_id[]" class="form-check-input department" id="department' +
                                value.name + '" value="' + value.id + '">' +
                                '<label for="department' + value.name +
                                '" class="form-check-label">' + value.name + '</label>' +
                                '</div>';
                            $('.departments').append(departments);
                        });
                    },
                    error: function(data) {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    }
                });
            }

            function show(id) {
                var url = "{{ route('user/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        var role = (response.data.roles.length > 0) ? new Option(response.data
                            .roles[0].name, response.data.roles[0].name, true, true) : null;
                        $.each(response.data.user_department, function(key, value) {
                            console.log(value);
                            $('#department' + value.department.name).prop('checked', true);
                        });
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#username').val(response.data.username);
                        $('#email').val(response.data.email);
                        $('#role_id').html(role).trigger('change');
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
        });
    </script>
@endpush
