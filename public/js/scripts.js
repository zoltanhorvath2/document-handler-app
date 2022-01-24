$(function(){


    let selectedFolderId;

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
                /* openFolder(data, clickedElement) */
                setFolderID(data)
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
                console.log(data)
            },
            error: function(e){
                console.log("some error occured")
            }
        })
    })




})
