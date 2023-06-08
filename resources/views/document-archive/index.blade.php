@extends('layouts.app')

@section('content')
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Document Archive</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Settings</li>
                    <li class="breadcrumb-item text-gray-500">Document Archive</li>
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
                                class="form-control form-control-solid w-250px ps-13"
                                placeholder="Search Document Archive" />
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="archivesTable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Name</th>
                                <th>Document Number</th>
                                <th>Effective Date</th>
                                <th>Revisi</th>
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
            var isUpdate = false;

            var archivesTable = $('#archivesTable').DataTable({
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
                    "url": "{{ route('document-archive/getData') }}",
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
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "name",
                        "defaultContent": "-"
                    },
                    {
                        "data": "no_document",
                        "defaultContent": "-"
                    },
                    {
                        "data": "date",
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return moment(data).locale('id').format("DD MMMM YYYY")
                        }
                    },
                    {
                        "data": "revisi",
                        "defaultContent": "-"
                    },
                    {
                        "data": "description",
                        "defaultContent": "-"
                    },
                    {
                        "data": "id",
                        render: function(data, type, row) {
                            let urlDownload =
                                "{{ route('document-archive/download', ['id' => ':id']) }}";
                            let urlStream =
                                "{{ route('document-archive/stream', ['id' => ':id']) }}";
                            urlDownload = urlDownload.replace(':id', row.id);
                            urlStream = urlStream.replace(':id', row.id);
                            let extension = row.extension;
                            let btnView = '';
                            if (extension == 'png' || extension == 'jpg' || extension == 'jpeg') {
                                let fileLocation = row.attachment.path + row.attachment.name + '.' +
                                    row.attachment.extension;
                                $("#showImage").attr("src", "/storage/" + fileLocation);
                                btnView =
                                    '<a href="javascript:void(0)" class="btn btn-info btn-icon btn-sm"  data-toggle="modal" data-target="#openDocumentModal"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                            } else {
                                btnView = '<a target="_blank" href="' + urlStream +
                                    '" type="button" class="btn btn-info btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Open"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                            }

                            var btnDownload = "";
                            btnDownload += '<a target="_blank" href="' + urlDownload +
                                '" id="btnDownload" name="btnDownload" data-id="' + data +
                                '" type="button" class="btn btn-dark btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></a>';
                            return btnView + " " + btnDownload;
                        },
                    },
                ]
            });

            function reloadTable() {
                archivesTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#search").on("keyup", function(event) {
                let search = $("#search").val();
                request.searchkey = search;
                reloadTable();
            });
        });
    </script>
@endpush
