@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Role</h1>
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
                    <li class="breadcrumb-item text-gray-500">Role</li>
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
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="search" name="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Role" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('role/create') }}" class="btn btn-primary">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Role</a>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="rolesTable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Role Name</th>
                                <th>Description</th>
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

            var rolesTable = $('#rolesTable').DataTable({
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
                    "url": "{{ route('role/getData') }}",
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
                        "width": '30%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "description",
                        "width": '55%',
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
                            let btnChangePassword = "";
                            let btnDelete = "";
                            btnEdit += '<a href="/role/edit/' + data +
                                '" name="btnEdit" data-id="' + data +
                                '" type="button" class="btn btn-warning btn-sm btn-icon btnEdit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';

                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btn btn-danger btn-sm btn-icon btnDelete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                            return btnEdit + " " + btnDelete;
                        },
                    },
                ]
            });


            function reloadTable() {
                rolesTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
                console.log(search);
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

            $('#rolesTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: 'Confirmation',
                    text: "You will delete this role. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, im sure',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('role/delete', ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    'content'),
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
        });
    </script>
@endpush
