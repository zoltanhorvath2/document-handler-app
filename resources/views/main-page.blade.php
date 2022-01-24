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
</head>
<body class="vh-100">
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Document Manager App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Documents</a></li>
                    <li class="nav-item "><a class="nav-link" href="#">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Page content-->
<div class="">
    <div class="row">
        {{-- FOLDERS WIDGET --}}
        <div class="d-flex flex-row justify-content-start" id="folders-widget">
            <div class="column" id="category-column">
                <h4>Main Categories</h4>
                <ul class="list-unstyled" id="folder-list-0">
                @foreach ( $folders as $folder )
                    <li class="folder">
                        <input id="folder-id" type="text" hidden value="{{ $folder->id }}">
                        <i class="fas fa-folder"></i>
                        <a class="text-reset text-decoration-none">{{ $folder->folder_name }}</a>
                    </li>
                @endforeach
            </ul>
            </div>
        </div>

        {{-- NEW FOLDER OR DOCUMENT UPLOADER WIDGET --}}
        <div>
            <div id="add-new-folder">
                <h3>Add new document</h3>
                <form action="" method="post" id="file-upload-form">
                    @csrf
                    <input type="file" name="file" id="file">
                    <input type="text" name="folder_id" id="folder_id" hidden value="">
                    <button>Upload document</button>
                    <ul id="error-message" hidden></ul>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="">
    files
</div>
{{-- Jquery Core --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ url("js/app.js") }}"></script>
<script src="{{ url("js/scripts.js") }}"></script>
</body>
</html>
