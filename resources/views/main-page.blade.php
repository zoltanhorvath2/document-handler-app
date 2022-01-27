@extends('layouts.app')

@section('content')
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
                    <button class="btn btn-success mb-2"> <i class="fas fa-upload"></i> Upload document</button>
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
@endsection
