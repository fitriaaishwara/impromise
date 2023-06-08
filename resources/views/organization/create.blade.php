@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Edit Organization</h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Settings</li>

                    <li class="breadcrumb-item text-gray-500">Edit Organization</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-fluid">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2 class="fw-bold">Form Organization</h2>
                    </div>
                </div>
                <form action="#" name="organizationForm" id="organizationForm" method="POST">
                    @csrf
                    <input id="id" type="hidden" class="form-control" name="id">
                    <div class="card-body py-4">
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
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-sm" name="createBtn" id="createBtn">Save</button>
                            <a href="{{ route('organization') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $(".standard_id").select2({
                placeholder: "Choose Standard",
                ajax: {
                    url: "{{ route('standard/getData') }}",
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
            $('#createBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#organizationForm").valid();
                if (isValid) {
                    $('#createBtn').text('Save...');
                    $('#createBtn').attr('disabled', true);
                    url = "{{ route('organization/create') }}";
                    var formData = new FormData($('#organizationForm')[0]);
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
                                $('#createBtn').text('Save');
                                $('#createBtn').attr('disabled', false);
                                (data.status) ? window.location.href =
                                    "{{ route('organization') }}": "";
                            });
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#createBtn').text('Save');
                            $('#createBtn').attr('disabled', false);
                        }
                    });
                }
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
        });
    </script>
@endpush
