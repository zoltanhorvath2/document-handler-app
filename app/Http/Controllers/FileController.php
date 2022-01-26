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

			return response()->json([
                'code' => 1,
                'success_message'=>'New document has been added.',
                'folder_id' => $request->folder_id
            ]);
        }


    	return response()->json(['code' => 0, 'error_messages'=>$validator->errors()->all()]);

    }

    public function fileProcessor($request){

        if($request->file('file')!=null){

            //Replace all whitespaces from filename
            $inputName = str_replace(' ', '', $request->file->getClientOriginalName());
            $extension = $request->file->getClientOriginalExtension();

            $fileName = explode('.' . $extension, $inputName)[0];

            //Check if the filename exists in the folder alread
            $fileCheck = File::where('folder_id', $request->folder_id)
                    ->where('file_name', 'like', "%$fileName%")
                    ->get()->toArray();

            //Add index to existing filename
            $this->newDocumentName = !empty($fileCheck) ?
            $fileName . '(' . (count($fileCheck) + 1) . ').' . $extension : $inputName;

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

    public function deleteFile(Request $request){
        $fileName = File::find($request->file_id)
            ->value('file_name');

        $folderId = File::find($request->file_id)
            ->value('folder_id');

        $recordDeletion = File::find($request->file_id)->delete();
        $path = public_path('assets/documents/');

        if(file_exists($path . $fileName)){
            $storageDeletion = unlink($path . $fileName);
            if($storageDeletion && $recordDeletion){
                return response()->json(['code' => 1,'folder_id' => $folderId, 'success_message' => 'A fájl törlése sikeres!']);
            }else{
                return response()->json(['code' => 0, 'folder_id' => $folderId,'success_message' => 'A fájl törlése sikertelen!']);
            }
        }else{
            return response()->json(['code' => 0, 'folder_id' => $folderId,'error_message' => 'A fájl nem létezik!']);
        }
    }

}
