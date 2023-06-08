@extends('layouts.app')

@section('content')
    <div class="modal fade" tabindex="-1" id="meetingModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Meeting</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form method="post" id="meetingForm" name="meetingForm">
                    @csrf
                    <div class="modal-body">
                        <input id="id" type="hidden" class="form-control" name="id">
                        <div class="form-group row mb-3">
                            <label for="participant" class="col-md-4 form-label required">Participant</label>
                            <div class="col-md-8 validate">
                                <select id="participant" type="text" class="form-select participant" name="participant">
                                    <option></option>
                                    <option value="1">All</option>
                                    <option value="2">Department</option>
                                    <option value="3">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3" style="display: none;" id="showUser">
                            <label for="user_id" class="col-md-12 form-label required">User</label>
                            <div id="user_id" class="col-md-12 row validate ml-0">
                            </div>
                        </div>
                        <div class="form-group row mb-3" style="display: none;" id="showDepartment">
                            <label for="department_id" class="col-md-12 form-label required">Department</label>
                            <div id="department_id" class="col-md-12 row validate ml-0">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="participant" class="col-md-4 form-label required">Type</label>
                            <div class="col-md-8 validate">
                                <select name="meeting_type_id" id="meeting_type_id"
                                    class="form-select meeting_type_id"></select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="agenda" class="col-md-4 form-label required">Agenda</label>
                            <div class="col-md-8 validate">
                                <input type="text" class="form-control" name="agenda" id="agenda">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="participant" class="col-md-4 form-label required">Date</label>
                            <div class="col-md-8 validate">
                                <input type="text" class="form-control date" name="date" id="date">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="time" class="col-md-4 form-label required">Time</label>
                            <div class="col-md-4 validate">
                                <input placeholder="Start Time" id="start_time" type="text" class="form-control time"
                                    name="start_time">
                            </div>
                            <div class="col-md-4 validate">
                                <input placeholder="End Time" id="end_time" type="text" class="form-control time"
                                    name="end_time">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="location" class="col-md-4 form-label required">Location</label>
                            <div class="col-md-8 validate">
                                <textarea id="location" rows="5" name="location" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="saveBtn" name="saveBtn">Save</button>
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Meeting</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Performance Evaluation</li>
                    <li class="breadcrumb-item text-gray-500">Meeting</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="search" name="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Meeting" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#meetingModal" id="addNew" name="addNew">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="meetingsTable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Type</th>
                                <th>Agenda</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Participant</th>
                                <th>Status</th>
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
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-info',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: !true
        });
        $(function() {
            var user_id = "{{ Auth::user()->id }}";
            department();
            user();
            let request = {
                start: 0,
                length: 10
            };
            var isUpdate = false;

            var meetingsTable = $('#meetingsTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="next"></i>',
                        "previous": '<i class="previous"></i>'
                    }
                },
                "aaSorting": [],
                "autoWidth": false,
                "ordering": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('meeting/getData') }}",
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
                        "data": "meeting_type.name",
                        "width": '10%',
                        "defaultContent": "-",
                    },
                    {
                        "data": "agenda",
                        "width": '20%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "date",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let date = moment(data).locale('id').format("DD MMMM YYYY");
                            return date + '<br>' + row.start_time + '-' + row.end_time;
                        }
                    },
                    {
                        "data": "location",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "participant",
                        "width": '15%',
                        render: function(data, type, row) {
                            let participant = '';
                            if (data == '1') {
                                participant = 'All';
                            } else if (data == '2') {
                                $.each(row.meeting_participants, function(key, value) {
                                    let no = key + 1;
                                    participant += no + '. ' + value.department.name +
                                        '<br>';
                                });
                            } else if (data == '3') {
                                $.each(row.meeting_participants, function(key, value) {
                                    let no = key + 1;
                                    participant += no + '. ' + value.user.name + '<br>';
                                });
                            }
                            return participant;
                        }
                    },
                    {
                        "data": "id",
                        "width": '10%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let status = 'Open : ' + row.meeting_open + '<br>Close : ' + row
                                .meeting_close + '';
                            return status
                        }
                    },

                    {
                        "data": "id",
                        "width": '10%',
                        render: function(data, type, row) {
                            var btnSend = "";
                            var btnEdit = "";
                            var btnDelete = "";
                            var btnDownload = "";
                            var btnMoM = "";
                            if (row.created_by == user_id) {
                                let urlMoM = "{{ route('meeting/mom', ['id' => ':id']) }}";
                                urlMoM = urlMoM.replace(':id', data);
                                btnMoM += '<a href="' + urlMoM + '" name="btnMoM" data-id="' +
                                    data +
                                    '" type="button" class="btn btn-primary btn-icon btn-sm btnMoM" data-toggle="tooltip" data-placement="top" title="Add MoM"><i class="fa fa-plus"></i></a>';
                                if (row.send == 0) {
                                    btnSend += '<button data-id="' + data +
                                        '" type="button" class="btnSend btn btn-primary btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Send"><i class="fa fa-paper-plane"></i></button>';
                                }

                                btnEdit += '<button id="btnEdit" name="btnEdit" data-id="' +
                                    data +
                                    '" type="button" class="btn btn-warning btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                                btnDelete +=
                                    '<button id="btnDelete" name="btnDelete" data-id="' +
                                    data +
                                    '" type="button" class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Department"><i class="fa fa-trash"></i></button>';
                            }
                            let urlDownload =
                                "{{ route('meeting/download', ['id' => ':id']) }}";
                            urlDownload = urlDownload.replace(':id', data);
                            btnDownload += '<a href="' + urlDownload +
                                '" target="_blank" name="btnDownload" data-id="' + data +
                                '" type="button" class="btn btn-dark btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></a>';
                            return btnMoM + " " + btnSend + " " + btnEdit + " " + btnDelete + " " +
                                btnDownload;
                        },
                    },
                ]
            });

            function reloadTable() {
                meetingsTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
                request.searchkey = search;
                reloadTable();
            });
            $(".participant").select2({
                dropdownParent: $('#meetingModal'),
                placeholder: "Choose Participant",
            }).on("change", function(e) {
                if ($(this).val() == '1') {
                    $('#showDepartment').hide();
                    $(".department_id").rules('remove', 'required')
                    $('.department_id').prop('checked', false);
                    $('#showUser').hide();
                    $(".user_id").rules('remove', 'required')
                    $('.user_id').prop('checked', false);
                } else if ($(this).val() == '2') {
                    $('#showDepartment').show();
                    $(".department_id").rules("add", {
                        required: true,
                    });
                    $('#showUser').hide();
                    $(".user_id").rules('remove', 'required')
                    $('.user_id').prop('checked', false);
                } else if ($(this).val() == '3') {
                    $('#showUser').show();
                    $(".user_id").rules("add", {
                        required: true,
                    });
                    $('#showDepartment').hide();
                    $(".department_id").rules('remove', 'required')
                    $('.department_id').prop('checked', false);
                } else {
                    $('#showDepartment').hide();
                    $(".department_id").rules('remove', 'required')
                    $('.department_id').prop('checked', false);
                    $('#showUser').hide();
                    $(".user_id").rules('remove', 'required')
                    $('.user_id').prop('checked', false);
                }
            });
            $(".meeting_type_id").select2({
                dropdownParent: $('#meetingModal'),
                placeholder: "Choose Type",
                ajax: {
                    url: "{{ route('meeting-type/getData') }}",
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
            $('#date').flatpickr({
                dateFormat: "Y-m-d"
            });
            $('.time').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#meetingForm").valid();
                if (isValid) {
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    if (!isUpdate) {
                        var url = "{{ route('meeting/store') }}";
                    } else {
                        var url = "{{ route('meeting/update') }}";
                    }
                    var formData = new FormData($('#meetingForm')[0]);
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
                            $('#saveBtn').text('Save');
                            $('#saveBtn').attr('disabled', false);
                            reloadTable();
                            $('#meetingModal').modal('hide');
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
            $('#meetingsTable').on("click", ".btnSend", function() {
                var id = $(this).attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will send this meeting. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('meeting/send', ['id' => ':id']) }}";
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
            $('#meetingsTable').on("click", "#btnEdit", function() {
                $('#meetingModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('meeting/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        if (response.data.participant == '2') {
                            $.each(response.data.meeting_participants, function(key, value) {
                                $('#department' + value.department_id).prop('checked',
                                    true);
                            });
                        } else if (response.data.participant == '3') {
                            $.each(response.data.meeting_participants, function(key, value) {
                                $('#user' + value.user_id).prop('checked', true);
                            });
                        }

                        $('#participant').val(response.data.participant).trigger('change');
                        let meeting_type = (response.data.meeting_type) ? new Option(response
                            .data.meeting_type.name, response.data.meeting_type.id, true,
                            true) : null;

                        $('#meeting_type_id').append(meeting_type).trigger('change');
                        $('#type').val(response.data.type).trigger('change');
                        $('#date').val(response.data.date);
                        $('#start_time').val(response.data.start_time);
                        $('#end_time').val(response.data.end_time);
                        $('#location').val(response.data.location);
                        $('#agenda').val(response.data.agenda);
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
            $('#meetingsTable').on("click", "#btnDelete", function() {
                var id = $(this).attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will delete this invitation. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('meeting/delete', ['id' => ':id']) }}";
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

            $('#meetingForm').validate({
                rules: {
                    participant: {
                        required: true,
                    },
                    meeting_type_id: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    start_time: {
                        required: true,
                    },
                    end_time: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    agenda: {
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

            $('#addNew').on('click', function() {
                $('.department_id').prop('checked', false);
                $('.user_id').prop('checked', false);
                $('#participant').val('').trigger('change');
                $('#meeting_type_id').val('').trigger('change');
                $('#agenda').val('');
                $('#date').val('');
                $('#start_time').val('');
                $('#end_time').val('');
                $('#location').val('');
                isUpdate = false;
            });

            function department() {
                let req = {
                    "searchkey": '',
                    "start": 0,
                    "length": -1
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
                            let department =
                                '<div class="form-check col-md-6 mt-3 mb-3">' +
                                '<input type="checkbox" name="department_id[]" class="form-check-input department_id" id="department' +
                                value.id + '" value="' + value.id + '">' +
                                '<label for="department' + value.id +
                                '" class="form-check-label">' + value.name + '</label>' +
                                '</div>';
                            $('#department_id').append(department);
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

            function user() {
                let req = {
                    "searchkey": '',
                    "start": 0,
                    "length": -1
                };
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: "{{ route('user/getData') }}",
                    data: req,
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            let user_id =
                                '<div class="form-check col-md-6 mt-3 mb-3">' +
                                '<input type="checkbox" name="user_id[]" class="form-check-input user_id" id="user' +
                                value.id + '" value="' + value.id + '">' +
                                '<label for="user' + value.id +
                                '" class="form-check-label">' + value.name + '</label>' +
                                '</div>';
                            $('#user_id').append(user_id);
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
        });
    </script>
@endpush
