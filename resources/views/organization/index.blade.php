@extends('layouts.app')

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Organization</h1>
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
                    <li class="breadcrumb-item text-gray-500">Organization</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Add user-->
            @if ($organizationStandard != null)
            <a href="{{ url('organization/edit/' . $organizationStandard->organization_id) }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i>Edit Organization</a>
            @else
            <a href="{{ route('organization/create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i>Add Organization</a>
            @endif
        <!--end::Add user-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Card-->
            <div class="card">
                {{-- <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <div class="modal fade" tabindex="-1" id="organizationModal">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Form Organization</h3>

                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <form method="post" id="organizationForm" name="organizationForm">
                                    @csrf
                                    <div class="modal-body">
                                        <input id="id" type="hidden" class="form-control" name="id">
                                        <input id="organization_id" type="hidden" class="form-control" name="organization_id">
                                        <input id="standard_id" type="hidden" class="form-control" name="standard_id">
                                        <div class="form-group row mb-3">
                                            <label for="name" class="col-md-4 form-label required">Name</label>
                                            <div class="col-md-8 validate">
                                                <input id="name" type="text" class="form-control"
                                                    name="name">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="address" class="col-md-4 form-label required">Address</label>
                                            <div class="col-md-8 validate">
                                                <textarea id="address" rows="5" name="address" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="scope" class="col-md-4 form-label required">Scope</label>
                                            <div class="col-md-4 validate">
                                                <select name="standard_id" id="standard_id"
                                                    class="form-select standard_id"></select>
                                            </div>
                                            <div class="col-md-4 validate">
                                                <textarea id="scope" rows="4" name="scope" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="structure" class="col-md-4 form-label required">Structure</label>
                                            <div class="col-md-8 validate">
                                                <input id="structure" type="file" class="form-control"
                                                    name="structure">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="business_process" class="col-md-4 form-label required">Business Process</label>
                                            <div class="col-md-8 validate">
                                                <input id="business_process" type="file" class="form-control"
                                                    name="business_process">
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
                </div> --}}
                <!--end::Card toolbar-->
                <!--begin::Card body-->
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="card">
                            <div class="card-body py-4">
                                <form action="#" method="POST" id="internalAuditForm" name="internalAuditForm">
                                    <div class="form-group row mb-5">
                                        <label for="name" class="col-md-3 form-label">Name</label>
                                        <div class="col-md-6">
                                            <a class="text-dark-75 text-hover-primary fs-6 fw-bolder">{{ $organizationStandard->organization->name ?? '' }}</a>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="address" class="col-md-3 form-label">Address</label>
                                        <div class="col-md-6">
                                            <a class="text-dark-75 text-hover-primary fs-6 fw-bolder">{{ $organizationStandard->organization->address ?? '' }}</a>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="scope" class="col-md-3 form-label">Scope</label>
                                        <div class="col-md-6">
                                            <a class="text-dark-75 text-hover-primary fs-6 fw-bolder">{{ $organizationStandard->standard->name ?? '' }}</a></br>
                                            <a class="text-dark-75 text-hover-primary fs-6 fw-bolder">{{ $organizationStandard->scope ?? '' }}</a>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="end_date"class="col-md-3 form-label">Structure</label>
                                        <div class="col-md-6">
                                            <img src="{{ asset('storage/structure/'.$organizationStandard->organization->structure) }}" alt="structure" width="500px">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label for="address" class="col-md-3 form-label">Business Proses</label>
                                        <div class="col-md-6">
                                            <img src ="{{ asset('storage/business_process/'.$organizationStandard->organization->business_process) }}" alt="business_process" width="500px">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('internal-audit') }}" class="btn btn-secondary btn-sm">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
{{-- @push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };

            $(".standard_id").select2({
                dropdownParent: $('#organizationModal'),
                placeholder: "Select Scope",
                ajax: {
                    url: "{{ url('standard/getData') }}",
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

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#organizationForm").valid();
                if (isValid) {
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    if (!isUpdate) {
                        var url = "{{ route('organization/store') }}";
                    } else {
                        var url = "{{ route('organization/update') }}";
                    }
                    var formData = new FormData($('#organizationForm')[0]);
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
                            $('#organizationModal').modal('hide');
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

            $('#organizationTable').on("click", ".btnEdit", function() {
                $('#organizationModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('organization/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        console.log(response);

                        let standard = (response.data.organizationStandard) ? new Option(response
                            .data.organizationStandard.standard.name, response.data.organizationStandard
                            .standard.id, true, true) : null;

                        $('#name').val(response.data.name);
                        $('#address').val(response.data.address);
                        $('#standard_id').append(standard).trigger('change');
                        $('#scope').val(response.data.organizationStandard.scope);

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

            $('#organizationForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    standard_id: {
                        required: true,
                    },
                    scope: {
                        required: true,
                    },
                    structure: {
                        required: true,
                    },
                    business_process: {
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
                $('#name').val("");
                $('address').val("");
                $('standard_id').val('').trigger('change');
                $('scope').val("");
                $('structure').val("");
                $('business_process').val("");
                isUpdate = false;
            });

            $('#btnEdit').on('click', function() {
                $('#organizationModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('organization/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#name').val(response.data.name);
                        $('#address').val(response.data.address);
                        $('#scope').val(response.data.scope);
                        $('status').val(response.data.status);
                        $('#structure').val(response.data.structure);
                        $('business_process').val(response.data.business_process);

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
        });
    </script>
@endpush --}}
