@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Create Role</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Role</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Create Role</li>
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
                        <h2 class="fw-bold">Form Role</h2>
                    </div>
                </div>
                <div class="card-body py-4">
                    <form action="{{ route('role/create') }}" method="post" id="roleForm" name="roleForm">
                        @csrf
                        <div class="form-group row mb-5">
                            <label for="name" class="col-md-3 required form-label">Role Name</label>
                            <div class="col-md-6 validate">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="Description" class="col-md-3 form-label">Description</label>
                            <div class="col-md-6 validate">
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label class="col-sm-4 required form-label" for="permission">Permission
                            </label>
                            <div class="row mt-2 validate">
                                @foreach ($groupPermission as $groupName => $data)
                                    <div class="col-md-4 mb-3">
                                        <div style="border: 1px solid #dee2e6; border-radius: 0.25rem; padding: 20px;">
                                            <h4>{{ strtoupper($groupName) }}</h4>
                                            @foreach ($data as $value)
                                                <div class="form-check mt-3">
                                                    <input type="checkbox" name="permission[]" class="form-check-input"
                                                        id="{{ $value->id }}" value="{{ $value->id }}">
                                                    <label for="{{ $value->id }}"
                                                        class="form-check-label">{{ $value->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" name="saveBtn">Save</button>
                    <a href="{{ route('role') }}" class="btn btn-secondary btn-sm">Cancel</a>
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
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#roleForm").valid();
                if (isValid) {
                    var url = "{{ route('role/create') }}";
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#roleForm')[0]);
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
                                $('#saveBtn').text('Save');
                                $('#saveBtn').attr('disabled', false);
                                (data.status) ? window.location.href =
                                    "{{ route('role') }}": '';
                            });

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
            $('#roleForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    'permission[]': {
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
