@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">{{ $internalAudit->name }}<a class="text-gray-500 text-hover-primary">&nbsp ({{ date('d F Y', strtotime($internalAudit->start_date))}} - {{ date('d F Y', strtotime($internalAudit->end_date))}})</a></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">

                <div class="card-body py-4">
                    <div class="mb-5 hover-scroll-x">
                        <div class="d-grid">
                            <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" href="{{ url('/internal-audit/detail/'.$internalAudit->id) }}">Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" href="{{ url('schedule/'.$internalAudit->id) }}">Schedule</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" href="{{ url('instrument/'.$internalAudit->id) }}">Instrument</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" href="{{ url('finding/'.$internalAudit->id) }}">Finding</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                            <!--begin::Card-->
                            <div class="card">
                                <!--begin::Card header-->
                                <div class="card-header border-0 pt-6">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <!--begin::Search-->
                                        <div class="d-flex align-items-center position-relative my-1">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" id="search" name="search"
                                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Schedule" />
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--begin::Card title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar">
                                        <!--begin::Toolbar-->
                                        <div class="d-flex justify-content-end">
                                            <!--begin::Add user-->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#scheduleModal" id="addNew" name="addNew">
                                                <i class="ki-duotone ki-plus fs-2"></i>Create</button>
                                            <!--end::Add user-->
                                        </div>
                                        <div class="modal fade" tabindex="-1" id="scheduleModal">
                                            <div class="modal-dialog">a
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Form Schedule</h3>

                                                        <!--begin::Close-->
                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                                    class="path2"></span></i>
                                                        </div>
                                                        <!--end::Close-->
                                                    </div>
                                                    <form method="POST" id="scheduleForm" name="scheduleForm" action="{{ route('schedule/store') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" id="id">
                                                        <input id="internal_audit_id" type="hidden" class="form-control" name="internal_audit_id" value="{{ $internalAudit->id }}">
                                                        <div class="modal-body">
                                                             <div class="form-group row mb-3">
                                                                <label for="department_id" class="col-md-4 form-label required">Department</label>
                                                                <div class="col-md-8 validate">
                                                                    <select name="department_id" id="department_id"
                                                                        class="form-select department_id"></select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row mb-3">
                                                                <label for="date" class="col-md-4 form-label required">Date</label>
                                                                <div class="col-md-8 validate">
                                                                    <input id="date" style="background-color: #fff" type="text" class="form-control date" name="date">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-3">
                                                                <label for="start_time" class="col-md-4 form-label required">Time</label>
                                                                <div class="col-md-4 validate">
                                                                    <input placeholder="Start Time" id="start_time" style="background-color: #fff" type="text" class="form-control time" name="start_time">
                                                                </div>
                                                                <div class="col-md-4 validate">
                                                                    <input placeholder="End Time" id="end_time" style="background-color: #fff" type="text" class="form-control time" name="end_time">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-3">
                                                                <label for="process" class="col-md-4 form-label required">Process</label>
                                                                <div class="col-md-8 validate">
                                                                    <textarea id="process" rows="5" name="process" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-3">
                                                                <label for="auditor_id" class="col-md-4 form-label required">Auditor</label>
                                                                <div class="col-md-8 validate">
                                                                    <div id="auditor_id" class="col-md-6 row validate ml-0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary btn-sm" id="saveBtn"
                                                                name="saveBtn">Save</button>
                                                            <button type="button" class="btn btn-light btn-sm"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="scheduleTable">
                                        <thead>
                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                <th>No</th>
                                                <th>Department</th>
                                                <th>Date/Time</th>
                                                <th>Process</th>
                                                <th>Auditor</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('internal-audit') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            auditor();
            let request = {
                start: 0,
            };
            // var isUpdate = false;

            var dTable = $('#scheduleTable').DataTable({
                ajax: {
                    url: "{{ url ('schedule/dt/' . $internalAudit->id) }}",
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    type : "POST",
                    data: function(d) {
                        d.start = request.start;
                        // d.length = request.length;
                        d.searchkey = request.searchkey;
                    },
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'center'
                    },
                    {
                        data : 'department',
                        name : 'department'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'process',
                        name: 'process'
                    },
                    {
                        data: 'auditor',
                        name: 'auditor',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'center',
                    },
                    ],
            });

            function reloadTable() {
                dTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
                console.log(search);
                request.searchkey = search;
                reloadTable();
            });

            $('.auditor_id').prop('checked', true);

            $(".department_id").select2({
                dropdownParent: $('#scheduleModal'),
                placeholder: "Select Department",
                ajax: {
                    url: "{{ url('department/getData') }}",
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
                }
            });
            $('.date').flatpickr({
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
                var isValid = $("#scheduleForm").valid();
                if (isValid) {
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    if (!isUpdate) {
                        var url = "{{ route('schedule/store') }}";
                    } else {
                        var url = "{{ route('schedule/update') }}";
                    }
                    var formData = new FormData($('#scheduleForm')[0]);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            )
                            $('#saveBtn').text('Save');
                            $('#saveBtn').attr('disabled', false);
                            reloadTable();
                            $('#scheduleModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
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

            $('#scheduleTable').on("click", ".btnEdit", function() {
                $('#scheduleModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('schedule/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $.each(response.data.internal_audit_schedule_auditors, function(key, value) {
                                $('#auditor' + value.user_id).prop('checked',
                                    true);
                            });
                        let department = (response.data.department) ? new Option(response
                            .data.department.name, response.data.department.id, true,
                            true) : null;

                        $('#department_id').append(department).trigger('change');
                        $('#date').val(response.data.date);
                        $('#start_time').val(response.data.start_time);
                        $('#end_time').val(response.data.end_time);
                        $('#process').val(response.data.process);
                        $('#id').val(response.data.id);
                        // $('#name').val(response.data.name);
                        // $('#description').val(response.data.description);

                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            });

            // $('#scheduleTable').on("click", ".btnEdit", function() {
            //     $('#scheduleModal').modal('show');
            //     isUpdate = true;
            //     var id = $(this).attr('data-id');
            //     var url = "{{ route('schedule/show', ['id' => ':id']) }}";
            //     url = url.replace(':id', id);
            //     $.ajax({
            //         type: 'GET',
            //         url: url,
            //         success: function(response) {
            //             $.each(response.data.internal_audit_schedule_auditors, function(key, value) {
            //                     $('#auditor' + value.user_id).prop('checked',
            //                         true);
            //                 });
            //             let department = (response.data.department) ? new Option(response
            //                 .data.department.name, response.data.department.id, true,
            //                 true) : null;

            //             $('#department_id').append(department).trigger('change');
            //             $('#date').val(response.data.date);
            //             $('#start_time').val(response.data.start_time);
            //             $('#end_time').val(response.data.end_time);
            //             $('#process').val(response.data.process);
            //             $('#id').val(response.data.id);
            //             // $('#name').val(response.data.name);
            //             // $('#description').val(response.data.description);

            //         },
            //         error: function() {
            //             Swal.fire(
            //                 'Error',
            //                 'A system error has occurred. please try again later.',
            //                 'error'
            //             )
            //         },
            //     });
            // });

            $('#scheduleTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will delete this schedule. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: !false,
                    buttonsStyling: !true,
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-danger",
                    },
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('schedule/delete', ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    'content'),
                            },
                            url: url,
                            type: "POST",
                            success: function(data) {
                                Swal.fire(
                                    (data.status) ? 'Success' : 'Error',
                                    data.message,
                                    (data.status) ? 'success' : 'error'
                                )
                                reloadTable();
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'A system error has occurred. please try again later.',
                                    icon: 'error',
                                    buttonsStyling: !true,
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    },
                                })
                            }
                        });
                    }
                })
            });

            $('#scheduleForm').validate({
                rules: {
                    department_id: {
                        required: true
                    },
                    date: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    process: {
                        required: true
                    },
                    'auditor_id[]': {
                        required: true
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
                $('#department_id').val('').trigger('change');
                $('#date').val("");
                $('#start_time').val("");
                $('#end_time').val("");
                $('#process').val("");
                $('.auditor_id').prop('checked', false);
                isUpdate = false;
            });

            function auditor() {
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
                    url: "{{ url('user/getData') }}",
                    data: req,
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            let auditor =
                                '<div class="form-check col-md-6 mt-3">' +
                                '<input type="checkbox" name="auditor_id[]" class="form-check-input auditor_id" id="auditor' +
                                value.id + '" value="' + value.id + '">' +
                                '<label for="auditor' + value.id +
                                '" class="form-check-label">' + value.name + '</label>' +
                                '</div>';
                            $('#auditor_id').append(auditor);
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
