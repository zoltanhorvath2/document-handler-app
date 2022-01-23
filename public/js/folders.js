$(function(){

    //Get all data from clicked folder
    $(document).on('click', '.folder', function(){

        let clickedFolderId = $(this).children().first().val()
        let path = window.location.href;

        $.ajax({
            dataType: 'json',
            type: 'get',
            url: path + `folders/${clickedFolderId}`,
            success: function (data) {
                openFolder(data)
            },
            error: function(e){
                console.log("some error occured")
            }
        })

    })

    //Open folder with subfolders
    function openFolder(data){
        $("#folders-widget").append(`
            <div class="">
            <h4>${data.clicked_folder.folder_name}</h4>
            <ul class="list-unstyled" id="parent-folder-${data.clicked_folder.id}">

            </ul>
            </div>
        `)
        for(let i = 0; i <= data.lenght; i++){
            $(`parent-folder-${data.clicked_folder.id}`).append(`
                buzi vagy
            `)
        }

    }



})
