<?php

namespace App\Http\Controllers;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class FileController extends Controller
{

    private $newDocumentName;

    public function uploadFile(Request $request){

        $validator = Validator::make($request->all(), [

            'folder_id' => 'required|numeric',
            'file' => 'required|mimes:pdf,txt,doc,docx|max:10000'

        ]);

        if ($validator->passes()) {

            $this->fileProcessor($request);

            $file                 = new File();
            $file->file_name      = $this->newDocumentName;
            $file->file_size      = $request->file->getSize();
            $file->file_extension = $request->file->getClientOriginalExtension();
            $file->folder_id      = $request->folder_id;
            $file->file_url       = asset('assets/documents') . '/' . $this->newDocumentName;
            $file->created_at     = Carbon::now();
            $file->updated_at     = Carbon::now();

            $file->save();

			return response()->json(['code' => 1, 'success_message'=>'New document has been added.']);

        }


    	return response()->json(['code' => 0, 'error_messages'=>$validator->errors()->all()]);

    }

    public function fileProcessor($request){

        if($request->file('file')!=null){

            $term = $request->file->getClientOriginalName();

            $fileCheck = File::where('folder_id', $request->folder_id)
                    ->where('file_name', 'like', "%$term%")
                    ->get()->toArray();

            //Add new image name based on unix timestamp ant normalized audio title
            $this->newDocumentName = !empty($fileCheck) ?
            $request->file->getClientOriginalName() . ' (' . count($fileCheck) . ')' : $request->file->getClientOriginalName();
            //Move audio into public folder
            move_uploaded_file($request->file->getRealPath(), public_path('assets/documents/'. $this->newDocumentName));
            //File::move;

        }else{
            return back()->with(['error_message' => 'Hiba! A hangok feltöltése sikertelen!']);
        }
    }

    public function getByFolder($folder_id, DataTables $dataTables){
        $files = File::where('folder_id', $folder_id)->get();

        return $dataTables->of($files)->toJson();
    }

}
