@extends('layouts.app')

@section('content')
    <div class="modal fade" tabindex="-1" id="meetingAttendeeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Attendee</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form method="post" id="meetingAttendeeForm" name="meetingAttendeeForm">
                    @csrf
                    <div class="modal-body">
                        <input id="id_meeting_attendee" type="hidden" class="form-control" name="id">
                        <input type="hidden" class="form-control meeting_id" name="meeting_id" value="{{ $id }}">
                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-4 form-label required">Name</label>
                            <div class="col-md-8 validate">
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="role" class="col-md-4 form-label required">Role</label>
                            <div class="col-md-8 validate">
                                <input type="text" class="form-control" name="role" id="role">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="saveMeetingAttendeeBtn"
                            name="saveMeetingAttendeeBtn">Save</button>
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="meetingDetailModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Minutes of Meeting</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form method="post" id="meetingDetailForm" name="meetingDetailForm">
                    @csrf
                    <div class="modal-body">
                        <input id="id" type="hidden" class="form-control" name="id">
                        <input type="hidden" id="meeting_id" class="form-control meeting_id" name="meeting_id"
                            value="{{ $id }}">
                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-4 form-label required">Discussion</label>
                            <div class="col-md-8 validate">
                                <textarea name="discussion" id="discussion" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="department_id" class="col-md-4 form-label required">Department</label>
                            <div class="col-md-8 validate">
                                <select name="department_id" id="department_id" class="form-select department_id"></select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="pic" class="col-md-4 form-label required">PIC</label>
                            <div class="col-md-8 validate">
                                <select id="pic" type="text" class="form-select pic" name="pic">
                                    <option></option>
                                    <option value="1">All</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3" style="display: none;" id="showUser">
                            <label for="user_id" class="col-md-4 form-label required">User</label>
                            <div class="col-md-8 validate">
                                <select id="user_id" type="text" class="form-select user_id"
                                    name="user_id"></select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="last_status" class="col-md-4 form-label required">Status</label>
                            <div class="col-md-8 validate">
                                <select id="last_status" type="text" class="form-select last_status"
                                    name="last_status">
                                    <option></option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3" style="display: none;" id="showDate">
                            <label for="due_date" class="col-md-4 form-label required">Due Date</label>
                            <div class="col-md-8 validate">
                                <input id="due_date" style="background-color: #fff" type="text" class="form-control"
                                    name="due_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="saveMeetingDetailBtn"
                            name="saveMeetingDetailBtn">Save</button>
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Create Minutes of Meeting</h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Performance Evaluation</li>

                    <li class="breadcrumb-item text-gray-500">Create Minutes of Meeting</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2 class="fw-bold">Form Minutes of Meeting</h2>
                    </div>
                </div>
                <div class="card-body py-4">
                    <input type="hidden" class="form-control meeting_id" name="meeting_id" value="{{ $id }}">
                    <div class="form-group row mb-5">
                        <label for="participant" class="col-md-3 form-label">Participant</label>
                        <div id="showAll" class="col-md-4 row validate ml-0">
                        </div>
                        <div id="showParticipant" class="col-md-8 row validate ml-0">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="meeting_type_id" class="col-md-3 form-label">Type</label>
                        <div class="col-md-6 validate">
                            <input disabled id="meeting_type_id" type="text" class="form-control"
                                name="meeting_type_id">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="agenda" class="col-md-3 form-label">Agenda</label>
                        <div class="col-md-6 validate">
                            <input disabled id="agenda" type="text" class="form-control" name="agenda">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="date" class="col-md-3 form-label">Date</label>
                        <div class="col-md-6 validate">
                            <input disabled id="date" type="text" class="form-control" name="date">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="start_time" class="col-md-3 form-label">Time</label>
                        <div class="col-md-3 validate">
                            <input disabled="" id="start_time" type="text" class="form-control"
                                name="start_time">
                        </div>
                        <div class="col-md-3 validate">
                            <input disabled="" id="end_time" type="text" class="form-control" name="end_time">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="location" class="col-md-3 form-label">Location</label>
                        <div class="col-md-6 validate">
                            <textarea disabled name="location" id="location" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="attendee" class="col-md-3 form-label text-md-left">Attendees<span
                                style="color:red;">*</span></label>
                        <div class="col-md-9 validate">
                            <button data-bs-toggle="modal" data-bs-target="#meetingAttendeeModal" type="button"
                                class="btn btn-sm btn-primary" id="meetingAttendeeBtn" name="meetingAttendeeBtn">Add
                                Attendee</button>
                            <div class="table-responsive mt-3">
                                <table class="table align-middle table-row-dashed table-bordered fs-6 gy-5"
                                    id="meetingAttendeeTable" width="100%">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <button data-bs-toggle="modal" data-bs-target="#meetingDetailModal" type="button"
                                class="btn btn-sm btn-primary" id="meetingBtn" name="meetingBtn">Add</button>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table align-middle table-row-dashed table-bordered fs-6 gy-5"
                                id="meetingDetailTable" style="width: 100%;">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th>Discussion</th>
                                        <th>Department</th>
                                        <th>PIC</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('meeting') }}" class="btn btn-secondary btn-sm">Back</a>
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
            var meeting_id = $('.meeting_id').val();
            showMeeting(meeting_id);

            let request = {
                start: 0,
                length: -1,
                meeting_id: meeting_id
            };

            var meetingAttendeeTable = $('#meetingAttendeeTable').DataTable({
                "language": {
                    "paginate": {
                        "next": "<b> > </b>",
                        "previous": "<b> < </b>"
                    }
                },
                "aaSorting": [],
                "autoWidth": false,
                "ordering": false,
                "searching": false,
                "lengthChange": false,
                "info": false,
                "paging": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('meeting-attendee/getData') }}",
                    "type": "POST",
                    "headers": {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + $('#secret').val());
                    },
                    "Content-Type": "application/json",
                    "data": function(data) {
                        request.draw = data.draw;
                        request.start = data.start;
                        request.length = data.length;
                        request.searchkey = data.search.value || "";

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
                        "width": '50%',
                        "defaultContent": "-"
                    },
                    {
                        "data": "role",
                        "width": '35%',
                        "defaultContent": "-"
                    },
                    {
                        "data": "id",
                        "width": '10%',
                        render: function(data, type, row) {
                            var btnEdit = "";
                            var btnDelete = "";
                            btnEdit += '<button name="btnEdit" data-id="' + data +
                                '" type="button" class="btnEdit btn btn-warning btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btnDelete btn btn-danger btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="Delete Department"><i class="fa fa-trash"></i></button>';
                            return btnEdit + " " + btnDelete;
                        },
                    },
                ]
            });

            var meetingDetailTable = $('#meetingDetailTable').DataTable({
                "language": {
                    "paginate": {
                        "next": "<b> > </b>",
                        "previous": "<b> < </b>"
                    }
                },
                "aaSorting": [],
                "autoWidth": false,
                "ordering": false,
                "searching": false,
                "lengthChange": false,
                "info": false,
                "paging": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('meeting-detail/getData') }}",
                    "type": "POST",
                    "headers": {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + $('#secret').val());
                    },
                    "Content-Type": "application/json",
                    "data": function(data) {
                        request.draw = data.draw;
                        request.start = data.start;
                        request.length = data.length;
                        request.searchkey = data.search.value || "";

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
                        "data": "discussion",
                        "width": '40%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data.split("\n").join("<br/>") +
                                "</div>";
                        },
                    },
                    {
                        "data": "departments.name",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "pic",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return (data == '1') ? data : row.users.name;
                        },
                    },
                    {
                        "data": "due_date",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return (data) ? moment(data).locale('id').format("DD MMMM YYYY") : '-';
                        }
                    },
                    {
                        "data": "id",
                        "width": '10%',
                        render: function(data, type, row) {
                            var btnEdit = "";
                            var btnDelete = "";
                            btnEdit += '<button name="btnEdit" data-id="' + data +
                                '" type="button" class="btnEdit btn btn-warning btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btnDelete btn btn-danger btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="Delete Department"><i class="fa fa-trash"></i></button>';
                            return btnEdit + " " + btnDelete;
                        },
                    },
                ]
            });

            function reloadTableAttendee() {
                meetingAttendeeTable.ajax.reload(null, false); //reload datatable ajax
            }

            function reloadTable() {
                meetingDetailTable.ajax.reload(null, false); //reload datatable ajax
            }
            $(".pic").select2({
                dropdownParent: $('#meetingDetailModal'),
                placeholder: "Choose PIC",
            }).on("change", function(e) {
                if ($(this).val() == '1') {
                    $('#showUser').hide();
                    $("#user_id").rules('remove', 'required')
                    $('#user_id').val('').trigger('change');
                } else if ($(this).val() == '2') {
                    $('#showUser').show();
                    $("#user_id").rules("add", {
                        required: true,
                    });
                } else {
                    $('#showUser').hide();
                    $("#user_id").rules('remove', 'required')
                    $('#user_id').val('').trigger('change');
                }
            });
            $(".last_status").select2({
                dropdownParent: $('#meetingDetailModal'),
                placeholder: "Choose Status",
            }).on("change", function(e) {
                if ($(this).val() != '') {
                    if ($(this).val() == 2) {
                        $('#showDate').show();
                        $("#due_date").rules("add", {
                            required: true,
                        });
                    } else {
                        $('#showDate').hide();
                        $("#due_date").rules('remove', 'required')
                        $('#due_date').val("");
                    }
                }
            });
            $('#meetingAttendeeTable').on("click", ".btnEdit", function() {
                $('#meetingAttendeeModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('meeting-attendee/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#name').val(response.data.name);
                        $('#role').val(response.data.role);
                        $('#id_meeting_attendee').val(response.data.id);
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
            $('#meetingAttendeeTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will delete this attendee. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('meeting-attendee/delete', ['id' => ':id']) }}";
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
                                reloadTableAttendee();
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
            $('#meetingDetailTable').on("click", ".btnEdit", function() {
                $('#meetingDetailModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('meeting-detail/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        let department = (response.data.department_id) ? new Option(response
                            .data.departments.name, response.data.departments.id, true, true
                        ) : null;
                        $('#department_id').append(department).trigger('change');
                        $('#discussion').val(response.data.discussion);
                        $('#pic').val(response.data.pic).trigger('change');
                        let user = (response.data.user_id) ? new Option(response.data.users
                            .name,
                            response.data.users.id, true, true) : null;
                        $('#user_id').append(user).trigger('change');
                        $('#last_status').val(response.data.last_status).trigger('change');
                        if (response.data.last_status == 1) {
                            $('#showDate').hide();
                        }
                        $('#due_date').val(response.data.due_date);
                        $('#id').val(response.data.id);
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
            $('#meetingDetailTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will delete this meeting. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('meeting-detail/delete', ['id' => ':id']) }}";
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
            $('#saveMeetingAttendeeBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#meetingAttendeeForm").valid();
                if (isValid) {
                    if (!isUpdate) {
                        var url = "{{ route('meeting-attendee/store') }}";
                    } else {
                        var url = "{{ route('meeting-attendee/update') }}";
                    }
                    $('#saveMeetingAttendeeBtn').text('Save...');
                    $('#saveMeetingAttendeeBtn').attr('disabled', true);
                    var formData = new FormData($('#meetingAttendeeForm')[0]);
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
                            )
                            $('#saveMeetingAttendeeBtn').text('Save');
                            $('#saveMeetingAttendeeBtn').attr('disabled', false);
                            reloadTableAttendee();
                            $('#meetingAttendeeModal').modal('hide');
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#saveMeetingDetailBtn').text('Save');
                            $('#saveMeetingDetailBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#saveMeetingDetailBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#meetingDetailForm").valid();
                if (isValid) {
                    if (!isUpdate) {
                        var url = "{{ route('meeting-detail/store') }}";
                    } else {
                        var url = "{{ route('meeting-detail/update') }}";
                    }
                    $('#saveMeetingDetailBtn').text('Save...');
                    $('#saveMeetingDetailBtn').attr('disabled', true);
                    var formData = new FormData($('#meetingDetailForm')[0]);
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
                            )
                            $('#saveMeetingDetailBtn').text('Save');
                            $('#saveMeetingDetailBtn').attr('disabled', false);
                            reloadTable();
                            $('#meetingDetailModal').modal('hide');
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#saveMeetingDetailBtn').text('Save');
                            $('#saveMeetingDetailBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#meetingAttendeeForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    role: {
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
            $('#meetingDetailForm').validate({
                rules: {
                    discussion: {
                        required: true,
                    },
                    department_id: {
                        required: true,
                    },
                    pic: {
                        required: true,
                    },
                    status: {
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
            $('#meetingBtn').on('click', function() {
                $('#discussion').val('');
                $('#department_id').val('').trigger('change');
                $('#pic').val('').trigger('change');
                $('#user_id').val('').trigger('change');
                $('#status').val('').trigger('change');
                $('#due_date').val('');
                isUpdate = false;
            });
            $('#meetingAttendeeBtn').on('click', function() {
                $('#name').val('');
                $('#role').val('');
                isUpdate = false;
            });
            $('#due_date').flatpickr({
                dateFormat: "Y-m-d"
            });
            $(".department_id").select2({
                dropdownParent: $('#meetingDetailModal'),
                placeholder: "Choose Department",
                ajax: {
                    url: "{{ route('department/getData') }}",
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
            }).change(function() {
                $("#user_id").val("").trigger("change");
            });
            $(".user_id").select2({
                dropdownParent: $('#meetingDetailModal'),
                placeholder: "Choose User",
                ajax: {
                    url: "{{ route('user/getData') }}",
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
                            department_id: $('#department_id').val(),
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

            function showMeeting(meeting_id) {
                let url = "{{ route('meeting/show', ['id' => ':id']) }}";
                url = url.replace(':id', meeting_id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        if (response.data.participant == '1') {
                            $('#showAll').show();
                            $('#showParticipant').hide();
                            let all =
                                '<input disabled="" type="text" class="form-control" value="All">';
                            $('#showAll').append(all);
                        } else if (response.data.participant == '2') {
                            $('#showAll').hide();
                            $('#showParticipant').show();
                            let department = '';
                            $.each(response.data.meeting_participants, function(key, value) {
                                department =
                                    '<div class="form-check col-md-6">' +
                                    '<input disabled type="checkbox" name="department_id[]" checked="" class="form-check-input" id="department' +
                                    value.department_id + '" value="' + value.department_id +
                                    '">' +
                                    '<label for="department_id' + value.department_id +
                                    '" class="form-check-label">' + value.department.name +
                                    '</label>' +
                                    '</div>';
                                $('#showParticipant').append(department);
                            });
                        } else if (response.data.participant == '3') {
                            $('#showAll').hide();
                            $('#showParticipant').show();
                            let user = '';
                            $.each(response.data.meeting_participants, function(key, value) {
                                user = '<div class="form-check col-md-6">' +
                                    '<input disabled type="checkbox" name="user_id[]" checked="" class="form-check-input" id="user' +
                                    value.user_id + '" value="' + value.user_id + '">' +
                                    '<label for="user_id' + value.user_id +
                                    '" class="form-check-label">' + value.user.name +
                                    '</label>' +
                                    '</div>';
                                $('#showParticipant').append(user);
                            });
                        }

                        $('#number').val(response.data.number);
                        $('#meeting_type_id').val(response.data.meeting_type.name)
                        $('#date').val(moment(response.data.date).locale('id').format("DD MMMM YYYY"));
                        $('#start_time').val(response.data.start_time);
                        $('#end_time').val(response.data.end_time);
                        $('#location').val(response.data.location);
                        $('#agenda').val(response.data.agenda);
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
