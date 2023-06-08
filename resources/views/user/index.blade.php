@extends('layouts.app')

@section('content')
    <div class="modal fade" tabindex="-1" id="changePasswordModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Change Password</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form action="{{ route('user/password') }}" method="post" name="changePasswordForm"
                    id="changePasswordForm">
                    @csrf
                    <input id="user_id" type="hidden" class="form-control" name="id" />
                    <div class="modal-body">
                        <div class="form-group row mb-5">
                            <label for="password" class="col-md-4 form-label required">New Password</label>
                            <div class="col-md-8 validate">
                                <input id="password" type="password" class="form-control" name="password" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirm" class="col-md-4 form-label required">Confirm
                                Password</label>
                            <div class="col-md-8 validate">
                                <input id="password_confirm" type="password" class="form-control" name="password_confirm" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="changePasswordBtn"
                            name="changePasswordBtn">Save</button>
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">User</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Settings</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">User</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">

        <div class="content flex-row-fluid" id="kt_content">

            <div class="card">

                <div class="card-header border-0 pt-6">

                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="search" name="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search User" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="card-toolbar">

                        <div class="d-flex justify-content-end">

                            <a href="{{ route('user/create') }}" class="btn btn-primary">
                                <i class="ki-duotone ki-plus fs-2"></i>Add User</a>

                        </div>

                    </div>

                </div>
                <div class="card-body py-4">

                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="usersTable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };

            var usersTable = $('#usersTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="next"></i>',
                        "previous": '<i class="previous"></i>'
                    }
                },
                "aaSorting": [],
                "ordering": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('user/getData') }}",
                    "type": "POST",
                    "headers": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + $('#secret').val());
                    },
                    "Content-Type": "application/json",
                    "data": function(data) {
                        request.draw = data.draw;
                        request.start = data.start;
                        request.length = data.length;
                        return (request);
                    },
                },
                "columns": [{
                        "data": null,
                        "width": '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "name",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "username",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "email",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "roles",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + (data.length > 0) ? data[0].name :
                                '-' + "</div>";
                        }
                    },
                    {
                        "data": "user_department",
                        "width": '10%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let user_department = '';
                            $.each(data, function(key, value) {
                                let no = key + 1;

                                user_department += no + '. ' + value.department.name +
                                    '<br>';
                            });
                            return "<div class='text-wrap'>" + user_department + "</div>";
                        },
                    },
                    {
                        "data": "id",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let isChecked = (row.is_active) ? "checked" : "";
                            let checkbox =
                                '<div class="form-check form-switch form-check-custom form-check-solid">' +
                                '<input type="checkbox" class="form-check-input is_active" name="is_active" id="is_active' +
                                data + '" data-id="' + data + '"  ' + isChecked + '>' +
                                '</div>';
                            return checkbox;
                        },
                    },
                    {
                        "data": "id",
                        "width": "10%",
                        render: function(data, type, row) {
                            let btnEdit = "";
                            let btnChangePassword = "";
                            let btnDelete = "";
                            let btnSend = "";

                            if (!row.email_verified_at) {
                                btnSend += '<button name="btnSend" data-id="' + data +
                                    '" type="button" class="btn btn-primary btn-icon btn-sm btnSend" data-toggle="tooltip" data-placement="top" title="Send Verification User"><i class="fa fa-paper-plane"></i></button>';
                            }
                            btnEdit += '<a href="/user/edit/' + data +
                                '" name="btnEdit" data-id="' + data +
                                '" type="button" class="btn btn-warning btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-user-edit"></i></a>';
                            btnChangePassword +=
                                '<button name="btnChangePassword" data-id="' +
                                data +
                                '" type="button" class="btn btn-dark btn-icon btn-sm btnChangePassword" data-toggle="tooltip" data-placement="top" title="Change Password"><i class="fa fa-user-lock"></i></button>';
                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btn btn-danger btn-icon btn-sm btnDelete" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash"></i></button>';
                            return btnSend + " " + btnEdit + " " + btnChangePassword + " " +
                                btnDelete;
                        },
                    },
                ]
            });


            function reloadTable() {
                usersTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
                console.log(search);
                request.searchkey = search;
                reloadTable();
            });

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: !true
            });

            $('#usersTable').on("click", ".is_active", function() {
                var id = $(this).attr('data-id');
                let req = {
                    "is_active": this.checked,
                    "id": id,
                };
                var url = "{{ route('user/updateActive') }}";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: url,
                    data: req,
                    success: function(response) {
                        toastr.success(response.message)
                    },
                    error: function() {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            });

            $('#usersTable').on("click", ".btnChangePassword", function() {
                $('#password').val("");
                $('#password_confirm').val("");
                $('#changePasswordModal').modal('show');
                let id = $(this).attr('data-id');
                $('#user_id').val(id);
            });
            $('#changePasswordBtn').click(function(e) {
                e.preventDefault();
                let isValid = $("#changePasswordForm").valid();
                let formData = new FormData($('#changePasswordForm')[0]);
                if (isValid) {
                    $('#changePasswordBtn').text('Save...');
                    $('#changePasswordBtn').attr('disabled', true);
                    let url = "{{ route('user/password') }}";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-Token': $('input[name="_token"]').val()
                        },
                        success: function(data) {
                            swalWithBootstrapButtons.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            )
                            $('#changePasswordBtn').text('Save');
                            $('#changePasswordBtn').attr('disabled', false);
                            reloadTable();
                            $('#changePasswordModal').modal('hide');
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#changePasswordBtn').text('Save');
                            $('#changePasswordBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#usersTable').on("click", ".btnDelete", function() {
                let id = $(this).attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will delete this user. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        let url = "{{ route('user/delete', ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            },
                            url: url,
                            type: "POST",
                            success: function(data) {
                                swalWithBootstrapButtons.fire(
                                    (data.status) ? 'Success' : 'Error',
                                    data.message,
                                    (data.status) ? 'success' : 'error'
                                )
                                reloadTable();
                            },
                            error: function(response) {
                                swalWithBootstrapButtons.fire(
                                    'Error',
                                    'A system error has occurred. please try again later.',
                                    'error'
                                )
                            }
                        });
                    }
                })
            });

            $('#usersTable').on("click", ".btnSend", function() {
                var id = $(this).attr('data-id');
                console.log(id);
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will send verification and create password. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('user/send', ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            },
                            url: url,
                            type: "POST",
                            success: function(data) {
                                swalWithBootstrapButtons.fire(
                                    (data.status) ? 'Success' : 'Error',
                                    data.message,
                                    (data.status) ? 'success' : 'error'
                                )
                                reloadTable();
                            },
                            error: function(response) {
                                swalWithBootstrapButtons.fire(
                                    'Error',
                                    'A system error has occurred. please try again later.',
                                    'error'
                                )
                            }
                        });
                    }
                })
            });

            $.validator.addMethod('passwordRule', function(value, element) {
                    return /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/.test(value);
                },
                'Password must contains one lowercase letter, one uppercase letter, one digit, one special character and least eight characters long.'
            );

            $('#changePasswordForm').validate({
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
