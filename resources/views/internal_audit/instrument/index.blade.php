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
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" href="{{ url('schedule/'.$internalAudit->id) }}">Schedule</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" href="{{ url('instrument/'.$internalAudit->id) }}">Instrument</a>
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
                                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Instrument" />
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
                                                data-bs-target="#instrumentModal" id="addNew" name="addNew">
                                                <i class="ki-duotone ki-plus fs-2"></i>Create</button>
                                            <!--end::Add user-->
                                        </div>
                                        <div class="modal fade" tabindex="-1" id="instrumentModal">
                                            <div class="modal-dialog">a
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Form Instrument</h3>

                                                        <!--begin::Close-->
                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                                    class="path2"></span></i>
                                                        </div>
                                                        <!--end::Close-->
                                                    </div>
                                                    <form method="post" id="instrumentForm" name="instrumentForm">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" id="id">
                                                            <input id="internal_audit_schedule_id" type="hidden" class="form-control" name="internal_audit_schedule_id" value="{{ $internalAuditSchedules->id }}">
                                                            <div class="form-group row mb-3">
                                                                <label for="schedule_id" class="col-md-4 form-label required">Schedule</label>
                                                                <div class="col-md-8 validate">
                                                                    <select name="schedule_id" id="schedule_id"
                                                                        class="form-select schedule_id">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-3">
                                                                <label for="clause" class="col-md-4 form-label required">Clause</label>
                                                                <div class="col-md-8 validate">
                                                                    <input id="clause" type="text" class="form-control"
                                                                        name="clause">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-3">
                                                                <label for="question" class="col-md-4 form-label required">Question</label>
                                                                <div class="col-md-8 validate">
                                                                        <textarea id="question" rows="3" name="question" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-3">
                                                                <label for="observation" class="col-md-4 form-label required">Observation</label>
                                                                <div class="col-md-8 validate">
                                                                    <textarea id="observation" rows="5" name="observation" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-3">
                                                                <label for="instrument_status" class="col-md-4 form-label required">Status</label>
                                                                <div class="col-md-8 validate">
                                                                    <select id="instrument_status" type="text" class="form-select instrument_status" name="instrument_status">
                                                                        <option></option>
                                                                        <option value="1">Conformity</option>
                                                                        <option value="2">NC Major</option>
                                                                        <option value="3">NC Minor</option>
                                                                        <option value="4">NC OFI</option>
                                                                    </select>
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
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="instrumentTable">
                                        <thead>
                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                <th>No</th>
                                                <th>Detail</th>
                                                <th>Process</th>
                                                <th>Clause</th>
                                                <th>Question</th>
                                                <th>Observation</th>
                                                <th>Status</th>
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
            let request = {
                start: 0,
            };
            var dTable = $('#instrumentTable').DataTable({
                ajax: {
                    url: "{{ url ('instrument/dt/' . $internalAudit->id) }}",
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
                        data : 'detail',
                        name : 'detail'
                    },
                    {
                        data: 'process',
                        name: 'process'
                    },
                    {
                        data: 'clause',
                        name: 'clause'
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'observation',
                        name: 'observation'
                    },
                    {
                        data: 'instrument_status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge badge-light-success">Conformity</span>';
                            } else if (data == 2) {
                                return '<span class="badge badge-light-danger">NC Major</span>';
                            } else if (data == 3) {
                                return '<span class="badge badge-light-danger">NC Minor</span>';
                            } else if (data == 4) {
                                return '<span class="badge badge-light-danger">NC OFI</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'center'
                    },
                    ],
            });

            function reloadTable() {
                dTable.ajax.reload(null, false); //reload datatable ajax
            }

            $(".schedule_id").select2({
                dropdownParent: $('#instrumentModal'),
                placeholder: "Select Schedule",
                ajax: {
                    url: "{{ url('instrument/getData') }}",
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
                                text: this.department.name+' - '+moment(this.date).locale('id').format("DD MMMM YYYY")+'('+this.start_time+'-'+this.end_time+')'
                                });
                            })
                        }
                        return result;
                    },
                    cache: false
                },
            });

            $(".instrument_status").select2({
                dropdownParent: $('#instrumentModal'),
                placeholder: "Select Status",
            });

            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
                console.log(search);
                request.searchkey = search;
                reloadTable();
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#instrumentForm").valid();
                if (isValid) {
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    if (!isUpdate) {
                        var url = "{{ route('instrument/store') }}";
                    } else {
                        var url = "{{ route('instrument/update') }}";
                    }
                    var formData = new FormData($('#instrumentForm')[0]);
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
                            $('#instrumentModal').modal('hide');
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

            $('#instrumentTable').on("click", ".btnEdit", function() {
                $('#instrumentModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('instrument/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        // console.log(response);
                        let schedule = (response.data.internal_audit_schedule_id) ? new Option(response
                            .data.internal_audit_schedule.department.name+' - '+moment(response.data.internal_audit_schedule.date).locale('id').format("DD MMMM YYYY")+'('+response.data.internal_audit_schedule.start_time+'-'+response.data.internal_audit_schedule.end_time+')', response.data.internal_audit_schedule.id, true,
                            true) : null;

                        $('#schedule_id').append(schedule).trigger('change');
                        $('#clause').val(response.data.clause);
                        $('#question').val(response.data.question);
                        $('#observation').val(response.data.observation);
                        $('#instrument_status').val(response.data.instrument_status).trigger('change');
                        $('#id').val(response.data.id);
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

            $('#instrumentTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will delete this instrument. Are you sure you want to continue?",
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
                        var url = "{{ route('instrument/delete', ['id' => ':id']) }}";
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

            $('#instrumentForm').validate({
                rules: {
                    schedule_id: {
                        required: true,
                    },
                    clause: {
                        required: true,
                    },
                    question: {
                        required: true,
                    },
                    observation: {
                        required: true,
                    },
                    instrument_status: {
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
                $('#schedule_id').val('').trigger('change');
                $('#clause').val('');
                $('#question').val('');
                $('#observation').val('');
                $('#instrument_status').val('').trigger('change');
                isUpdate = false;
            });
        })
    </script>
@endpush
