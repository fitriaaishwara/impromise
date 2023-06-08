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
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" href="{{ url('/internal-audit/detail/'.$internalAudit->id) }}">Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" href="{{ url('schedule/'.$internalAudit->id) }}">Schedule</a>
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
                            <div class="card-body py-4">
                                <form action="#" method="POST" id="internalAuditForm" name="internalAuditForm">
                                    @csrf
                                    <input id="id" type="hidden" class="form-control" name="id" value="{{ $id }}">
                                    <div class="form-group row mb-5">
                                        <label for="name" class="col-md-3 required form-label">Name</label>
                                        <div class="col-md-6 validate">
                                            <input id="name" type="text" class="form-control" name="name" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="start_date" class="col-md-3 required form-label">Start Date</label>
                                        <div class="col-md-6 validate">
                                            <input id="start_date" type="text" class="form-control date"
                                                style="background-color: #fff" name="start_date" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="end_date"class="col-md-3 required form-label">End Date</label>
                                        <div class="col-md-6 validate">
                                            <input id="end_date" type="text" class="form-control date"
                                                style="background-color: #fff" name="end_date" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label class="col-md-3 required form-label" for="standard">Standard</label>
                                        </label>
                                        <div class="col-md-6 validate">
                                                <div class="col-md-6 row validate ml-0 standard">

                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label class="col-md-3 required form-label" for="user_id">Auditor</label>
                                        </label>
                                        <div class="col-md-6 row">
                                            <div class="col-md-12 validate row">
                                                <h4></h4>
                                                    <div class="col-md-6 form-check mt-3">
                                                        <input type="checkbox" name="" class="form-check-input"
                                                            id="" value="">
                                                        <label for=""
                                                            class="form-check-label"></label>
                                                    </div>
                                                    <div class="col-md-6 validate mt-3"">
                                                        <select name="role[]" class="form-control role">
                                                            <option></option>
                                                                <option value="1">Lead Auditor</option>
                                                                <option value="2">Auditor</option>
                                                                <option value="3">Observer</option>
                                                                <option value="4">Technical Expert</option>
                                                        </select>
                                                    </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="location" class="col-md-3 form-label">Location<span
                                            style="color:red;">*</span></label>
                                        <div class="col-md-6 validate">
                                            <textarea name="location" id="location" class="form-control" rows="4" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="note" class="col-md-3 form-label">Note</label>
                                        <div class="col-md-6 validate">
                                            <textarea name="note" id="note" class="form-control" rows="5" disabled></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
            var id = $('#id').val();
            // standard_id();
            show(id);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: !true
            });

            $('#updateBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#internalAuditForm").valid();
                if (isValid) {
                    $('#updateBtn').text('Save...');
                    $('#updateBtn').attr('disabled', true);
                    url = "{{ route('internal-audit/update') }}";
                    var formData = new FormData($('#internalAuditForm')[0]);
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
                                    "{{ route('internal-audit') }}": "";
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
            $('#internalAuditForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    start_date: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },
                    // 'standard_id[]': {
                    //     required: true,
                    // },
                    // 'groupUser[]': {
                    //     required: true,
                    // },
                    location: {
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

            // function standard() {
            //     let req = {
            //         "searchkey": '',
            //         "start": 0,
            //         "length": -1,
            //     };
            //     $.ajax({
            //         headers: {
            //             'X-CSRF-Token': $('input[name="_token"]').val()
            //         },
            //         type: "POST",
            //         url: "{{ route('standard/getData') }}",
            //         data: req,
            //         success: function(response) {
            //             $.each(response.data, function(key, value) {
            //                 let standards =
            //                     '<div class="form-check col-md-6 mt-3">' +
            //                     '<input type="checkbox" name="standard_id[]" class="form-check-input standard" id="standard' +
            //                     value.name + '" value="' + value.id + '">' +
            //                     '<label for="standard' + value.name +
            //                     '" class="form-check-label">' + value.name + '</label>' +
            //                     '</div>';
            //                 $('.standards').append(standards);
            //             });
            //         },
            //         error: function(data) {
            //             swalWithBootstrapButtons.fire(
            //                 'Error',
            //                 'A system error has occurred. please try again later.',
            //                 'error'
            //             )
            //         }
            //     });
            // }
            $('.date').flatpickr({
                dateFormat: "Y-m-d"
            });
            function show(id) {
                var url = "{{ route('internal-audit/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#start_date').val(response.data.start_date);
                        $('#end_date').val(response.data.end_date);
                        $('#location').val(response.data.location);
                        $('#note').val(response.data.note);
                        $.each(response.data.internal_audit_standards, function(key, value) {
                            $('#standard' + value.name).prop('checked', true);
                        });
                        // $.each(response.data.groupUser, function(key, value) {
                        //     $('#groupUser' + value.name).prop('checked', true);
                        //     $('#role' + value.name).val(value.pivot.role);
                        // });
                    },
                    error: function() {
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
