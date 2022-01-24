<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function getOneFolder($id){
        $subfolders = Folder::where('parent_id', $id)->get();
        $clickedFolder = Folder::find($id);

        $data = [
            "subfolders" => $subfolders,
            "clicked_folder" => $clickedFolder ?? '',
        ];

        return response()->json($data);
    }

}
