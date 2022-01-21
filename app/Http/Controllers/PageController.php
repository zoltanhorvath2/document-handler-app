<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;

class PageController extends Controller
{
    public function index ()

    {
        $folders = Folder::all();

        $data = [
            'folders' => $folders
        ];

        return view('main-page')->with($data);
    }
}
