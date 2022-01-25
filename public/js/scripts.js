$(function(){


    //Setting up csrf tokens to post requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    //Get all data from clicked folder
    $(document).on('click', '.folder', function(){

        $('#error-message').attr('hidden', true)

        $(this).parent().children().each(function(index, listItem){
            $(listItem).css('background-color', 'white')
        })

        $(this).css('background-color', 'grey')

        let clickedFolderId = $(this).children().first().val()
        let path = window.location.href
        let clickedElement = this

        $.ajax({
            dataType: 'json',
            type: 'get',
            url: path + `folders/${clickedFolderId}`,
            success: function (data) {
                openFolder(data, clickedElement)
                setFolderID(data)
                drawDatatable(data.clicked_folder.id)
            },
            error: function(e){
                console.log("some error occured")
            }
        })

    })

    //Open folder with subfolders
    function openFolder(data, clickedElement){

        let widgetColumns = $(clickedElement).parent().parent().parent().children().length
        console.log(widgetColumns)

        if(widgetColumns > 1){
            $("#folders-widget").children().last().remove()
        }


        //Make subfolder container
        $("#folders-widget").append(`
            <div class="column" id="category-column-${data.clicked_folder.id}">
                <input type="text" value="${data.clicked_folder.id}" hidden>
                <h4>${data.clicked_folder.folder_name}</h4>
                <ul class="list-unstyled" id="folder-list-${data.clicked_folder.id}">

                </ul>
            </div>
        `)

        for(let i = 0; i < data.subfolders.length; i++){
            $("#folder-list-" + data.clicked_folder.id).append(`
                <li class="folder">
                    <input id="folder-id" type="text" hidden value="${ data.subfolders[i].id }}">
                    <i class="fas fa-folder"></i>
                    <a class="text-reset text-decoration-none">${ data.subfolders[i].folder_name }</a>
                </li>
            `)
        }


    }

    //Select folder for file upload
    function setFolderID(data){
        $('#folder_id').val(data.clicked_folder.id)
    }

    //Upload document
    $(document).on('submit', '#file-upload-form', function(e){
        e.preventDefault()

        $('#error-message').attr('hidden', true)
        $('#error-message').text('')

        if(!$('#folder_id').val()){
            $('#error-message').append(`
                <li class="alert-danger">Please select a folder for file upload!</li>
            `).attr('hidden', false)
        }

        let path = window.location.href
        $.ajax({
            dataType: 'json',
            type: 'post',
            url: path + `files/upload`,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: new FormData(this),
            success: function (data) {
                if(!data.code){
                    $('#error-message').attr('hidden', false)
                    for(let i = 0; i < data.error_messages.length; i++){
                        $('#error-message').append(`
                            <li class=alert-danger>${data.error_messages[i]}</li>
                        `)
                    }
                }else{
                    $('#error-message').attr('hidden', false)
                    $('#error-message').append(`
                        <li class=alert-success>${data.success_message}</li>
                    `)
                    console.log(data.folder_id)
                    drawDatatable(data.folder_id)
                }
            },
            error: function(e){
                console.log("some error occured")
            }
        })
    })

    //Drawing files table
    function drawDatatable(folderID){
        let path = window.location.href
        var fileTable = $('#files_table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pagingType: "first_last_numbers",
            ajax: path + "files/get-by-folder/" + folderID ,
            columns: [
                { data: 'id', name: 'id'},
                { data: 'file_name', name: 'file_name'},
                { data: 'file_size', name: 'file_size'},
                { data: 'file_extension', name: 'file_extension'},
                { data: 'created_at', name: 'created_at'},
                {
                    "data": null,
                    "defaultContent":
                        "<div class='centered-container'>" +
                            "<button class='btn btn-primary btn-show mr-2'><i class='far fa-eye'></i></button>" +
                            "<button class='btn btn-warning text-light btn-download mr-2'><i class='fas fa-download'></i></button>" +
                            "<button class='btn btn-danger btn-delete mr-2'><i class='far fa-trash-alt'></i></button>" +
                        "</div>",
                    'orderable' : false,
                    'searchable' : false

                }
            ],
            columnDefs: [
                { width: "35px", targets: [0]}
            ],
            scrollX: true,
            select: {
                style: 'os',
                items: 'row',
            }
        })

        //Show file in a modal
        $('#files_table').on('click', '.btn-show', function (){
            const rowData = fileTable.row( $(this).parents('tr') ).data()
            window.open(rowData.file_url)
            return false
        })
    }




})
