<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;

class PageController extends Controller
{
    public function index ()

    {
        $folders = Folder::where('parent_id', 0)->get();

        $data = [
            'folders' => $folders
        ];

        return view('main-page')->with($data);
    }
}
