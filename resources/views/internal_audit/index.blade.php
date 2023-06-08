@extends('layouts.app')

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Internal Audit</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Performance Evaluation</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Internal Audit</li>
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
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Audit" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Add user-->
                            <a href="{{ route('internal-audit/create') }}" class="btn btn-primary">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Audit</a>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="internalAuditTable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Name</th>
                                <th>Standard</th>
                                <th>Auditor</th>
                                <th>Date</th>
                                <th>Schedule</th>
                                <th>Instrument</th>
                                <th>Finding</th>
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
            };

            var dTable =  $('#internalAuditTable').DataTable({
                ajax: {
                    url: '{{ route("internal-audit/dt") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'standard',
                        name: 'standard',
                    },
                    {
                        data: 'auditor',
                        name: 'auditor',
                    },
                    {
                        data: 'date',
                        name: 'date',
                    },
                    {
                        data: 'schedule',
                        name: 'schedule',
                    },
                    {
                        data: 'instrument',
                        name: 'instrument',
                    },
                    {
                        data: 'finding',
                        name: 'finding',
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'center'},
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

            $('#internalAuditTable').on("click", ".btnDelete", function() {
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
                        var url = "{{ route('internal-audit/delete', ['id' => ':id']) }}";
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

            $('#addNew').on('click', function() {
                $('#name').val("");
                $('#description').val("");
                isUpdate = false;
            });
        });
    </script>
@endpush
