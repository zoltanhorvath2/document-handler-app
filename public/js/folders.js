$(function(){


    let parentID;

    //Get all data from clicked folder
    $(document).on('click', '.folder', function(){

        $(this).parent().children().each(function(index, listItem){
            $(listItem).css('background-color', 'white')
        })

        $(this).css('background-color', 'grey');

        let clickedFolderId = $(this).children().first().val()
        let path = window.location.href;
        let clickedElement = this;

        $.ajax({
            dataType: 'json',
            type: 'get',
            url: path + `folders/${clickedFolderId}`,
            success: function (data) {
                openFolder(data, clickedElement)
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
                    <input type="text" hidden value="${ data.subfolders[i].id }}">
                    <i class="fas fa-folder"></i>
                    <a class="text-reset text-decoration-none">${ data.subfolders[i].folder_name }</a>
                </li>
            `)
        }


    }




})
