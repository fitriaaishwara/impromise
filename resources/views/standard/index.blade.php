@extends('layouts.app')

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Standard</h1>
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
                    <li class="breadcrumb-item text-gray-500">Standard</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
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
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Standard" />
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
                                data-bs-target="#standardModal" id="addNew" name="addNew">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Standard</button>
                            <!--end::Add user-->
                        </div>
                        <div class="modal fade" tabindex="-1" id="standardModal">
                            <div class="modal-dialog">a
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Form Standard</h3>

                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <form method="post" id="standardForm" name="standardForm">
                                        @csrf
                                        <div class="modal-body">
                                            <input id="id" type="hidden" class="form-control" name="id">
                                            <div class="form-group row mb-3">
                                                <label for="name" class="col-md-4 form-label required">Name</label>
                                                <div class="col-md-8 validate">
                                                    <input id="name" type="text" class="form-control"
                                                        name="name">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label for="description" class="col-md-4 form-label">Description</label>
                                                <div class="col-md-8">
                                                    <textarea id="description" rows="5" name="description" class="form-control"></textarea>
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
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="standardTable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
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
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };

            var standardTable = $('#standardTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="next"></i>',
                        "previous": '<i class="previous"></i>'
                    }
                },
                "aaSorting": [],
                "ordering": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('standard/getData') }}",
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
                        "data": "name",
                        "width": '35%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "description",
                        "width": '50%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + (data) ? data : '-' + "</div>";
                        },
                    },
                    {
                        "data": "id",
                        "width": "10%",
                        render: function(data, type, row) {
                            let btnEdit = "";
                            let btnDelete = "";
                            btnEdit += '<button name="btnEdit" data-id="' + data +
                                '" type="button" class="btn btn-warning btn-icon btn-sm btnEdit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa-solid fa-edit"></i></button>';
                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btnDelete btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Standard"><i class="fa fa-trash"></i></button>';
                            return btnEdit + " " + btnDelete;
                        },
                    },
                ]
            });


            function reloadTable() {
                standardTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
                console.log(search);
                request.searchkey = search;
                reloadTable();
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#standardForm").valid();
                if (isValid) {
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    if (!isUpdate) {
                        var url = "{{ route('standard/store') }}";
                    } else {
                        var url = "{{ route('standard/update') }}";
                    }
                    var formData = new FormData($('#standardForm')[0]);
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
                            $('#standardModal').modal('hide');
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

            $('#standardTable').on("click", ".btnEdit", function() {
                $('#standardModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('standard/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#name').val(response.data.name);
                        $('#description').val(response.data.description);
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

            $('#standardTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will delete this standard. Are you sure you want to continue?",
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
                        var url = "{{ route('standard/delete', ['id' => ':id']) }}";
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

            $('#standardForm').validate({
                rules: {
                    name: {
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
                $('#description').val("");
                isUpdate = false;
            });
        });
    </script>
@endpush
