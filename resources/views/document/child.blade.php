@extends('layouts.app')

@section('content')
    <style>
        .dropbtn {
            background-color: #3498DB;
            color: white;
            padding: 40px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #2980B9;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 150px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 5px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
    </style>
    <div class="modal fade" tabindex="-1" id="folderModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Folder</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form method="post" id="folderForm" name="folderForm">
                    @csrf
                    <div class="modal-body">
                        <input id="id" type="hidden" class="form-control" name="id">
                        <input type="hidden" id="parent_id" name="parent_id" value="{{ $id }}">
                        <div class="form-group row mb-5">
                            <label for="name" class="col-md-4 form-label required">Folder Name</label>
                            <div class="col-md-8 validate">
                                <input id="name" type="text" class="form-control" name="name" />
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="name" class="col-md-4 form-label">Description</label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>
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
    <div class="modal fade" tabindex="-1" id="uploadModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Upload</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('document/store') }}" id="uploadForm" name="uploadForm">
                        @csrf
                        <input type="hidden" id="folder_id" name="folder_id" value="{{ $id }}">
                        <div class="row mb-4">
                            <label for="nameDocument" class="col-sm-3 form-label required">Document Name</label>
                            <div class="col-sm-9 validate">
                                <input id="nameDocument" type="text" class="form-control" name="nameDocument">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="no_document" class="col-sm-3 form-label required">Document Number</label>
                            <div class="col-sm-9 validate">
                                <input id="no_document" type="text" class="form-control" name="no_document">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="date" class="col-sm-3 form-label required">Effective Date</label>
                            <div class="col-sm-9 validate">
                                <input id="date" type="text" class="form-control" name="date">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="revisi" class="col-sm-3 form-label required">Revisi</label>
                            <div class="col-sm-9 validate">
                                <input id="revisi" type="number" min="0" class="form-control" name="revisi">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="description" class="col-sm-3 form-label">Description</label>
                            <div class="col-sm-9 validate">
                                <textarea class="form-control" rows="5" id="descriptionDocument" name="descriptionDocument"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="file" class="col-sm-3 form-label required">File</label>
                            <div class="col-sm-9 validate">
                                <input id="file" type="file" class="form-control" name="file">
                            </div>
                        </div>
                        <div class="alert alert-dark alert-dismissible" role="alert">
                            <h5 class="alert-heading mb-0">Note!</h5>
                            <hr class="mb-3 mt-3">
                            <p class="mb-0 documentType">
                            </p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="uploadBtn" name="uploadBtn">Save</button>
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="openDocumentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">View Document</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="image">
                        <center>
                            <img id="showImage" src="" style="width:100%; height:100%;">
                        </center>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="updateDocumentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Update</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form method="POST" id="updateDocumentForm" name="updateDocumentForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="folder_id" value="{{ $id }}">
                        <input type="hidden" id="id_document" name="id">
                        <div class="row mb-4">
                            <label for="updateNameDocument" class="col-md-4 form-label required">Document
                                Name</label>
                            <div class="col-md-8">
                                <input id="updateNameDocument" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="updateNoDocument" class="col-md-4 form-label required">Document
                                Number</label>
                            <div class="col-md-8">
                                <input id="updateNoDocument" type="text" class="form-control" name="no_document">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="updateDateDocument" class="col-md-4 form-label required">Effective
                                Date</label>
                            <div class="col-md-8">
                                <input id="updateDateDocument" type="text" class="form-control" name="date">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="updateRevisiDocument" class="col-md-4 form-label required">Revisi<span
                                    style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <input id="updateRevisiDocument" type="number" min="0" class="form-control"
                                    name="revisi">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="updateDescriptionDocument" class="col-md-4 form-label">Description</label>
                            <div class="col-md-8">
                                <textarea style="height: 100px;" id="updateDescriptionDocument" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="updateFileDocument" class="col-md-4 form-label required">File</label>
                            <div class="col-md-8">
                                <input id="updateFileDocument" type="file" class="form-control" name="file">
                            </div>
                        </div>
                        <div class="alert alert-dark">
                            <div class="alert-body">
                                <div class="alert-title">Note!</div>
                                <p class="mb-0 documentType">
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="updateBtn"
                        name="updateBtn">Update</button>
                    <button type="button" class="btn btn-sm btn-primary" id="archiveBtn" name="archiveBtn">Update &
                        Archive</button>
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="propertiesModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Description Folder</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Folder
                                                    Name</strong></td>
                                            <td>:</td>
                                            <td align="left" id="nameFolder">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Size</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="sizeFolder">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Contents</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="containsFolder">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Description</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="descriptionfolder">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Creator</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="userFolder">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Created</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="dateFolder">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="propertiesDocumentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Description Document</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Document
                                                    Name</strong></td>
                                            <td>:</td>
                                            <td align="left" id="showNameDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Document
                                                    Number</strong></td>
                                            <td>:</td>
                                            <td align="left" id="showNumberDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Effective
                                                    Date</strong></td>
                                            <td>:</td>
                                            <td align="left" id="showEffectiveDateDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Revisi</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="showRevisiDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Extension</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="extension">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Size</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="sizeDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Download</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="downloadDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Description</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="showDescriptionDocument">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Creator</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="userDocument">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td style="width: 170px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Created</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="dateDocument">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Document</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">File Manager</li>
                    <li class="breadcrumb-item text-gray-500">Document</li>
                    <li id="parentName" class="breadcrumb-item text-gray-500"></li>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#folderModal" id="addNew" name="addNew">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Folder</button>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <a href="javascript:history.back()">
                                <button type="button" class="btn btn-sm btn-dark">
                                    <i class="ki-duotone ki-double-left">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                    </i>&nbsp;Back
                                </button>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#uploadModal" id="addNewDocument" name="addNewDocument">
                                <i class="fa fa-upload"></i>&nbsp;Upload
                            </a>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-5 ml-md-4">
                                <input type="text" placeholder="Search" name="nameFilter" id="nameFilter"
                                    class="form-control form-control-sm">
                                <div class="input-group-prepend">
                                    <button id="btnFilter" class="btn btn-info waves-effect waves-light btn-sm"><span
                                            class="btn-label"><i class="fa fa-search"></i></span>&nbsp;Search</button>
                                    <button id="btnReset" class="btn btn-danger btn-sm waves-effect waves-light"><span
                                            class="btn-label"><i class="fa fa-sync"></i></span>&nbsp;Refresh</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row" id="listFolder">
                        </div>
                    </div>
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
            var parent_id = $("#parent_id").val();
            var request = {
                "parent_id": parent_id
            };
            var countFolder = 0;
            var countDocument = 0;
            showParentDocument(parent_id);
            showDocumentType();
            $.when(getFolder()).then(getDocument());

            function showParentDocument(parent_id) {
                var url = "{{ route('folder/show', ['id' => ':id']) }}";
                url = url.replace(':id', parent_id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $("#parentName").text(response.data.name);
                    },
                    error: function() {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            }

            function showDocumentType() {
                var url = "{{ route('document-type/getDataActive') }}"
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        let type = ''
                        response.data.forEach((value, key, array) => {
                            if (key == (array.length - 1)) {
                                type += value.file_extension.extension.toUpperCase();
                            } else {
                                type += value.file_extension.extension.toUpperCase() + ", ";
                            }
                        });
                        $(".documentType").text('- The maximum file size is 15 MB with the format ' +
                            type + '.');
                    },
                    error: function() {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            }

            function getFolder() {
                var url = "{{ route('folder/getDataChild') }}";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: url,
                    data: request,
                    success: function(response) {
                        let data = response.data;
                        if (data.length > 0) {
                            countFolder = data.length;
                            $('#listFolder').append(folder(data));
                        } else {
                            countFolder = 0;
                        }
                    },
                    error: function(data) {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    }
                });
            }

            function getDocument() {
                var url = "{{ route('document/getData') }}";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: url,
                    data: request,
                    success: function(response) {
                        let data = response.data;
                        if (data.length > 0) {
                            countDocument = data.length;
                            $('#listFolder').append(document(data));
                        } else {
                            countDocument = 0;
                        }
                        cek();
                    },
                    error: function(data) {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    }
                });
            }

            function folder(data) {
                let html = ''
                $.each(data, function(key, value) {
                    let editSubFolder = '';
                    let deleteSubFolder = '';
                    editSubFolder = '<a href="javascript:void(0)" onclick="edit(' + value.id +
                        ')"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;&nbsp;Edit</a>';
                    deleteSubFolder = '<a href="javascript:void(0)" onclick="remove(' + value.id +
                        ')"><i class="fa fa-trash-alt" aria-hidden="true"></i>&nbsp;&nbsp;Delete</a>';
                    html += '<div class="col-md-2 countFolder" align="center" id="tr_' + value.id + '">' +
                        '<div class="dropdown" align="left">' +
                        '<div id="popUpMenu' + value.id + '" class="dropdown-content">' +
                        '<a href="/document/child/' + value.id +
                        '"><i class="fa fa-external-link-alt" aria-hidden="true"></i>&nbsp;&nbsp;Open</a>' +
                        editSubFolder +
                        deleteSubFolder +
                        '<a href="javascript:void(0)" onclick="properties(' + value.id +
                        ')"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;Properties</a>' +
                        '</div>' +
                        '</div>' +
                        '<img class="card-img-top img-responsive bounce-over" onclick="double_click(' +
                        value.id + ')" oncontextmenu="right_click(' + value.id +
                        ')" style="cursor: pointer;" alt="' + value.name +
                        '" src="{{ URL::asset('assets/media/file_manager/folder.png') }}">' +
                        '<div class="el-card-content">' +
                        '<p>' +
                        '<a data-type="text">' + value.name + '</a>' +
                        '</p>' +
                        '</div>' +
                        '</div>';
                });
                return html;
            }

            function document(data) {
                let html = ''
                $.each(data, function(key, value) {
                    let urlStream = "https://docs.google.com/viewerng/viewer?url={!! asset('storage/link') !!}";
                    let path = value.attachment.path + '' + value.attachment.name + '.' + value.attachment
                        .extension
                    urlStream = urlStream.replace('link', path);
                    let id = value.id;
                    let extension = value.extension;
                    let urlDownload = "{{ route('document/download', ['id' => ':id']) }}";
                    // let urlStream = "{{ route('document/stream', ['id' => ':id']) }}";
                    urlDownload = urlDownload.replace(':id', id);
                    // urlStream = urlStream.replace(':id',id);
                    let openDocument = '';
                    let editDocument = '';
                    let downloadDocument = '';
                    let deleteDocument = '';

                    if (extension == 'png' || extension == 'jpg' || extension == 'jpeg') {
                        let fileLocation = value.attachment.path + value.attachment.name + '.' + value
                            .attachment.extension;
                        $("#showImage").attr("src", "/storage/" + fileLocation);
                        openDocument =
                            '<a href="javascript:void(0)"  data-toggle="modal" data-target="#openDocumentModal"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;Open</a>';
                    } else {
                        openDocument = '<a target="_blank" href="' + urlStream +
                            '"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;Open</a>';
                    }
                    editDocument = '<a href="javascript:void(0)" onclick="updateDocument(' + value.id +
                        ')"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;&nbsp;Edit</a>';
                    downloadDocument = '<a target="_blank" href="' + urlDownload +
                        '"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Download</a>';
                    deleteDocument = '<a href="javascript:void(0)" onclick="removeDocument(' + value
                        .id +
                        ')"><i class="fa fa-trash-alt" aria-hidden="true"></i>&nbsp;&nbsp;Delete</a>';

                    html += '<div class="col-md-2 countDocument" align="center" id="tr_document' + value
                        .id + '">' +
                        '<div class="dropdown" align="left">' +
                        '<div id="popUpMenuDocument' + value.id + '" class="dropdown-content">' +
                        openDocument +
                        editDocument +
                        downloadDocument +
                        deleteDocument +
                        '<a href="javascript:void(0)" onclick="propertiesDocument(' + value.id +
                        ')"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;Properties</a>' +
                        '</div>' +
                        '</div>' +
                        '<img class="card-img-top img-responsive bounce-over" ondblclick="double_click_document(' +
                        value.id + ')" oncontextmenu="right_click_document(' + value.id +
                        ')" style="cursor: pointer;" alt="' + value.name +
                        '" src="/assets/media/extensions/' + value.extension + '.png"">' +
                        '<div class="el-card-content">' +
                        '<p>' +
                        '<a data-type="text">' + value.name + '</a>' +
                        '</p>' +
                        '</div>' +
                        '</div>';
                });
                return html;
            }

            function cek() {
                if (countFolder == 0 && countDocument == 0) {
                    let html =
                        '<div class="alert alert-danger col-md-12 mt-5" style="text-align: center;">Document is Empty</div>';
                    $('#listFolder').append(html);
                }
            }

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#folderForm").valid();
                if (isValid) {
                    if (!isUpdate) {
                        var url = "{{ route('folder/store') }}";
                    } else {
                        var url = "{{ route('folder/update') }}";
                    }
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#folderForm')[0]);
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
                            $("#listFolder").children().remove();
                            getFolder();
                            getDocument();
                            $('#folderModal').modal('hide');
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
            $('#uploadBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#uploadForm").valid();
                if (isValid) {
                    var url = "{{ route('document/store') }}";
                    $('#uploadBtn').text('Save...');
                    $('#uploadBtn').attr('disabled', true);
                    var formData = new FormData($('#uploadForm')[0]);
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
                            $('#uploadBtn').text('Save');
                            $('#uploadBtn').attr('disabled', false);
                            $("#listFolder").children().remove();
                            getFolder();
                            getDocument();
                            $('#uploadModal').modal('hide');
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#uploadBtn').text('Save');
                            $('#uploadBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#updateBtn').click(function(e) {
                e.preventDefault();
                $("#updateFileDocument").rules('remove', 'required');
                var isValid = $("#updateDocumentForm").valid();
                if (isValid) {
                    var url = "{{ route('document/update') }}";
                    $('#updateBtn').text('Update...');
                    $('#updateBtn').attr('disabled', true);
                    var formData = new FormData($('#updateDocumentForm')[0]);
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
                            $('#updateBtn').text('Update');
                            $('#updateBtn').attr('disabled', false);
                            $("#listFolder").children().remove();
                            getFolder();
                            getDocument();
                            $('#updateDocumentModal').modal('hide');
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#updateBtn').text('Update');
                            $('#updateBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#archiveBtn').click(function(e) {
                e.preventDefault();
                $("#updateFileDocument").rules("add", {
                    required: true,
                });
                var isValid = $("#updateDocumentForm").valid();
                if (isValid) {
                    var url = "{{ route('document/archive') }}";
                    $('#archiveBtn').text('Archive...');
                    $('#archiveBtn').attr('disabled', true);
                    var formData = new FormData($('#updateDocumentForm')[0]);
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
                            $('#archiveBtn').text('Update & Archive');
                            $('#archiveBtn').attr('disabled', false);
                            $("#listFolder").children().remove();
                            getFolder();
                            getDocument();
                            $('#updateDocumentModal').modal('hide');
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#archiveBtn').text('Archive');
                            $('#archiveBtn').attr('disabled', false);
                        }
                    });
                }
            });

            $('#date').flatpickr({
                defaultDate: date,
                dateFormat: "Y-m-d"
            });
            $('#updateDateDocument').flatpickr({
                defaultDate: updateDateDocument,
                dateFormat: "Y-m-d"
            });

            $('#folderForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-md-8').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $('#uploadForm').validate({
                rules: {
                    nameDocument: {
                        required: true,
                    },
                    no_document: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    revisi: {
                        required: true,
                    },
                    file: {
                        required: true,
                    },
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-md-8').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $('#updateDocumentForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    no_document: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    revisi: {
                        required: true,
                    },
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-md-8').append(error);
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
            $('#addNewDocument').on('click', function() {
                $('#nameDocument').val("");
                $('#descriptionDocument').val("");
                $('#file').val("");
                isUpdate = false;
            });
            $('#btnFilter').click(function() {
                request.name = $("#nameFilter").val();
                $("#listFolder").children().remove();
                $.when(getFolder()).then(getDocument());
            });
            $('#btnReset').click(function() {
                request.name = "";
                $('#nameFilter').val("");
                $("#listFolder").children().remove();
                $.when(getFolder()).then(getDocument());
            });
        });

        function double_click(id) {
            window.location.href = "/document/child/" + id;
        }

        function double_click_document(id) {
            window.open("/document/stream/" + id);
        }

        function right_click(id) {
            document.getElementById("popUpMenu" + id).classList.toggle("show");
        }

        function right_click_document(id) {
            document.getElementById("popUpMenuDocument" + id).classList.toggle("show");
        }

        function edit(id) {
            $('#folderModal').modal('show');
            isUpdate = true;
            var url = "{{ route('folder/show', ['id' => ':id']) }}";
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
                    swalWithBootstrapButtons.fire(
                        'Error',
                        'A system error has occurred. please try again later.',
                        'error'
                    )
                },
            });
        }

        function remove(id) {
            swalWithBootstrapButtons.fire({
                title: 'Confirmation',
                text: "You will delete this folder. Are you sure you want to continue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, I'm sure",
                cancelButtonText: 'No'
            }).then(function(result) {
                if (result.value) {
                    var url = "{{ route('folder/delete', ['id' => ':id']) }}";
                    url = url.replace(':id', id);
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: url,
                        type: "POST",
                        success: function(data) {
                            swalWithBootstrapButtons.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            )
                            $("#tr_" + id).remove();
                            const countFolder = document.querySelectorAll(".countFolder");
                            const countDocument = document.querySelectorAll(".countDocument");
                            if (countFolder.length == 0 && countDocument.length == 0) {
                                let html =
                                    '<div class="alert alert-danger col-md-12" style="text-align: center;">Document is Empty</div>';
                                $('#listFolder').append(html);
                            }
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
        }

        function removeDocument(id) {
            swalWithBootstrapButtons.fire({
                title: 'Confirmation',
                text: "You will delete this document. Are you sure you want to continue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, I'm sure",
                cancelButtonText: 'No'
            }).then(function(result) {
                if (result.value) {
                    var url = "{{ route('document/delete', ['id' => ':id']) }}";
                    url = url.replace(':id', id);
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: url,
                        type: "POST",
                        success: function(data) {
                            swalWithBootstrapButtons.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            )
                            $("#tr_document" + id).remove();
                            const countFolder = document.querySelectorAll(".countFolder");
                            const countDocument = document.querySelectorAll(".countDocument");
                            if (countFolder.length == 0 && countDocument.length == 0) {
                                let html =
                                    '<div class="alert alert-danger col-md-12" style="text-align: center;">Document is Empty</div>';
                                $('#listFolder').append(html);
                            }
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
        }

        function properties(id) {
            $('#propertiesModal').modal('show');
            isUpdate = true;
            var url = "{{ route('folder/show', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#nameFolder').text(response.data.name);
                    $('#sizeFolder').text(bytesToSize((response.data.size_sum) ? response.data.size_sum : 0));
                    $('#containsFolder').text(response.data.total_child + " Folder & " + response.data
                        .total_document + " Document");
                    $('#descriptionfolder').text((response.data.description) ? response.data.description : "-");
                    $('#userFolder').text(response.data.created_by.name);
                    $('#dateFolder').text(moment(response.data.created_at).locale('id').format("DD MMMM YYYY"));
                },
                error: function() {
                    swalWithBootstrapButtons.fire(
                        'Error',
                        'A system error has occurred. please try again later.',
                        'error'
                    )
                },
            });
        }

        function updateDocument(id) {
            $('#updateDocumentModal').modal('show');
            isUpdate = true;
            var url = "{{ route('document/show', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#id_document').val(response.data.id);
                    $('#updateNameDocument').val(response.data.name);
                    $('#updateNoDocument').val(response.data.no_document);
                    $('#updateDateDocument').val(response.data.date);
                    $('#updateRevisiDocument').val(response.data.revisi);
                    $('#updateDescriptionDocument').val(response.data.description);
                    $('#updateFileDocument').val('');
                },
                error: function() {
                    swalWithBootstrapButtons.fire(
                        'Error',
                        'A system error has occurred. please try again later.',
                        'error'
                    )
                },
            });
        }

        function propertiesDocument(id) {
            $('#propertiesDocumentModal').modal('show');
            isUpdate = true;
            var url = "{{ route('document/show', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#showNameDocument').text(response.data.name);
                    $('#showNumberDocument').text(response.data.no_document);
                    $('#showEffectiveDateDocument').text(moment(response.data.date).locale('id').format(
                        "DD MMMM YYYY"));
                    $('#showRevisiDocument').text(response.data.revisi);
                    $('#extension').text(response.data.extension);
                    $('#sizeDocument').text(bytesToSize(response.data.size));
                    $('#downloadDocument').text(response.data.download);
                    $('#showDescriptionDocument').text((response.data.description) ? response.data.description :
                        "-");
                    $('#userDocument').text(response.data.created_by.name);
                    $('#dateDocument').text(moment(response.data.created_at).locale('id').format(
                        "DD MMMM YYYY"));
                },
                error: function() {
                    swalWithBootstrapButtons.fire(
                        'Error',
                        'A system error has occurred. please try again later.',
                        'error'
                    )
                },
            });
        }

        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Byte';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1000)));
            return Math.round(bytes / Math.pow(1000, i), 2) + ' ' + sizes[i];
        }
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
        window.onload = function() {
            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
            }, false);
            document.addEventListener("keydown", function(e) {
                //document.onkeydown = function(e) {
                // "I" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                    disabledEvent(e);
                }
                // "J" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                    disabledEvent(e);
                }
                // "S" key + macOS
                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                    disabledEvent(e);
                }
                // "U" key
                if (e.ctrlKey && e.keyCode == 85) {
                    disabledEvent(e);
                }
                // "F12" key
                if (event.keyCode == 123) {
                    disabledEvent(e);
                }
            }, false);

            function disabledEvent(e) {
                if (e.stopPropagation) {
                    e.stopPropagation();
                } else if (window.event) {
                    window.event.cancelBubble = true;
                }
                e.preventDefault();
                return false;
            }
        };
    </script>
@endpush
