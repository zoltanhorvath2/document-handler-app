<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>Document Manager App</title>
    <!-- Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ url('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ url('css/app.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
</head>
<body class="vh-100">
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/')}}">Document Manager App</a>
    </div>
</nav>
<!-- Page content-->
<div class="container mt-4">
    <div class="row mt-4">
        {{-- FOLDERS WIDGET --}}
        <div class="d-flex flex-row justify-content-start" id="folders-widget">
            <div class="column me-2 px-2 overflow-scroll" id="category-column">
                <h4>Main Categories</h4>
                <ul class="list-unstyled" id="folder-list-0">
                @foreach ( $folders as $folder )
                    <li class="folder px-1">
                        <input id="folder-id" type="text" hidden value="{{ $folder->id }}">
                        <i class="fas fa-folder me-3"></i>
                        <a class="text-reset text-decoration-none">{{ $folder->folder_name }}</a>
                    </li>
                @endforeach
            </ul>
            </div>
        </div>

        {{-- NEW FOLDER OR DOCUMENT UPLOADER WIDGET --}}
        <div class="my-4">
            <div id="add-new-folder">
                <h3>Add new document</h3>
                <form action=""
                      method="post"
                      id="file-upload-form"
                      class="d-flex flex-column">
                    @csrf
                    <input type="file" name="file" id="file" class="mb-2">
                    <input type="text" name="folder_id" id="folder_id" hidden value="">
                    <button class="btn btn-success"> <i class="fas fa-upload"></i> Upload document</button>
                    <ul id="error-message" hidden></ul>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <table id="files_table" class="display" style="width: 100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Filename</th>
                <th>Filesize (kB)</th>
                <th>Type</th>
                <th>Uploaded At</th>
                <th></th>
            </tr>
            </thead>
            <tbody style="width: 100%">
            </tbody>
        </table>
    </div>
</div>

{{-- Jquery Core --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="{{ url("js/app.js") }}"></script>
<script src="{{ url("js/scripts.js") }}"></script>
</body>
</html>
