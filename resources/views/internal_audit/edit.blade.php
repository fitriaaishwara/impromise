@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Edit Internal Audit</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Performance Evaluation</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Internal Audit</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Edit Internal Audit</li>
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
                        <h2 class="fw-bold">Form Internal Audit</h2>
                    </div>
                </div>
                <div class="card-body py-4">
                    <form action="#" method="POST" id="internalAuditForm" name="internalAuditForm">
                        @csrf
                        <input id="id" type="hidden" class="form-control" name="id" value="{{ $id }}">
                        <div class="form-group row mb-5">
                            <label for="name" class="col-md-3 required form-label">Name</label>
                            <div class="col-md-6 validate">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="start_date" class="col-md-3 required form-label">Start Date</label>
                            <div class="col-md-6 validate">
                                <input id="start_date" type="text" class="form-control date"
                                    style="background-color: #fff" name="start_date">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="end_date"class="col-md-3 required form-label">End Date</label>
                            <div class="col-md-6 validate">
                                <input id="end_date" type="text" class="form-control date"
                                    style="background-color: #fff" name="end_date">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label class="col-md-3 required form-label" for="standard_id">Standard</label>
                            @foreach ($groupStandard as $groupName => $data)
                            <div class="col-md-6 row validate">
                                <h4>{{ strtoupper($groupName) }}</h4>
                                @foreach ($data as $value)
                                    <div class="form-check mt-3">
                                        <input type="checkbox" name="standard[]" class="form-check-input"
                                            id="{{ $value->id }}" value="{{ $value->id }}">
                                        <label for="{{ $value->id }}"
                                            class="form-check-label">{{ $value->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group row mb-5">
                            <label class="col-md-3 required form-label" for="auditor">Auditor</label>
                            @foreach ($groupUser as $groupNameUser => $data)
                            <div class="col-md-6 row validate">
                                <h4>{{ strtoupper($groupNameUser) }}</h4>
                                @foreach ($data as $value)
                                    <div class="col-md-6 form-check ml-0 mt-3">
                                        <input type="checkbox" name="groupUser[]" class="form-check-input"
                                            id="{{ $value->id }}" value="{{ $value->id }}">
                                        <label for="{{ $value->id }}"
                                            class="form-check-label">{{ $value->name }}</label>
                                    </div>
                                    <div class="col-md-6 validate mt-3">
                                        <select name="role[{{ $value->id }}]" class="form-control role">
                                            <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                                <option value="1">Lead Auditor</option>
                                                <option value="2">Auditor</option>
                                                <option value="3">Observer</option>
                                                <option value="4">Technical Expert</option>
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group row mb-5">
                            <label for="location" class="col-md-3 form-label">Location<span
                                style="color:red;">*</span></label>
                            <div class="col-md-6 validate">
                                <textarea name="location" id="location" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="note" class="col-md-3 form-label">Note</label>
                            <div class="col-md-6 validate">
                                <textarea name="note" id="note" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="updateBtn" name="updateBtn">Save</button>
                    <a href="{{ route('internal-audit') }}" class="btn btn-secondary btn-sm">Cancel</a>
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

            $('.date').flatpickr({
                dateFormat: "Y-m-d"
            });

            $(".role").select2({
            placeholder: "Select Role"
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
                        // $.each(response.data.standard, function(key, value) {
                        //     $('#standard' + value.name).prop('checked', true);
                        // });
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
