@extends('layouts.app')

@section('content')
    <div class="modal fade" tabindex="-1" id="documentTypeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Document Type</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form method="post" id="documentTypeForm" name="documentTypeForm">
                    @csrf
                    <div class="modal-body">
                        <input id="id" type="hidden" class="form-control" name="id">
                        <div class="row validate">
                            <label for="name" class="form-label required">File Extension</label>
                            <select name="file_extension_id" id="file_extension_id" class="form-select"></select>
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
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Document Type</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Settings</li>
                    <li class="breadcrumb-item text-gray-500">Document Type</li>
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
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Document Type" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#documentTypeModal" id="addNew" name="addNew">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="documentTypesTable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Document Type</th>
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
        $(function() {
            let request = {
                start: 0,
                length: 10
            };
            var isUpdate = false;

            var documentTypesTable = $('#documentTypesTable').DataTable({
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
                    "url": "{{ route('document-type/getData') }}",
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
                        "data": "file_extension",
                        "width": '50%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return data.description + " (." + data.extension + ")";
                        }
                    },
                    {
                        "data": "id",
                        "width": '35%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let isChecked = (row.status) ? "checked" : "";
                            let checkbox = '  <div class="form-check form-switch mb-3">' +
                                '<input type="checkbox" class="form-check-input status" name="status" id="status' +
                                data + '" data-id="' + data + '"  ' + isChecked + '>' +
                                '</div>';
                            return checkbox;
                        }
                    },
                    {
                        "data": "id",
                        "width": '10%',
                        render: function(data, type, row) {
                            var btnDelete = "";
                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btnDelete btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Department"><i class="fa fa-trash"></i></button>';
                            return btnDelete;
                        },
                    },
                ]
            });

            function reloadTable() {
                documentTypesTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
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
            $("#file_extension_id").select2({
                dropdownParent: $('#documentTypeModal'),
                placeholder: "Choose Extension",
                ajax: {
                    url: "{{ route('file-extension/getData') }}",
                    dataType: 'json',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
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
                                    text: this.description + " (." + this.extension +
                                        ")"
                                });
                            })
                        }
                        return result;
                    },
                    cache: false
                },
            });
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#documentTypeForm").valid();
                if (isValid) {
                    if (!isUpdate) {
                        var url = "{{ route('document-type/store') }}";
                    } else {
                        var url = "{{ route('document-type/update') }}";
                    }
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#documentTypeForm')[0]);
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
                            $('#documentTypeModal').modal('hide');
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

            $('#documentTypesTable').on("click", ".status", function() {
                var id = $(this).attr('data-id');
                let req = {
                    "status": this.checked,
                    "id": id,
                };
                var url = "{{ route('document-type/update') }}";
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

            $('#documentTypesTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will delete this data. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('document-type/delete', ['id' => ':id']) }}";
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

            $('#documentTypeForm').validate({
                rules: {
                    file_extension_id: {
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
                $('#file_extension_id').val('').trigger('change');
                isUpdate = false;
            });
        });
    </script>
@endpush
