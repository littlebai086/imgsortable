<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Services\GoogleDriverService;

class GoogleDriveController extends Controller
{
    //
    public function index(){
        $method = "store";
        return view('GoogleDrive.item',compact('method'));
    }

    public function getAllFile(){
        $google_files = Storage::disk('google')->allFiles();
    }

    public function makeDir(Request $request){
        Storage::disk('google')->makeDirectory("Test建立");
    }

    public function getDirId(Request $request){
        $dirs = Storage::disk('google')->directories();
        $firstDir = $dirs[0];
    }

    public function deleteDir(Request $request){
        $dirs = Storage::disk('google')->directories();
        $firstDir = $dirs[0];
        Storage::disk('google')->deleteDirectory($firstDir);
    }

    public function downloadFile(Request $request){
        $files = Storage::disk('google')->files();
        $firstFileName = $files[0];
        $response = Storage::disk('google')->download($firstFileName,"test.jpg");//後面是命名檔案也可以拿掉
        $response->send();
    }

    public function uploadFile(Request $request)
    {
        $path = Storage::disk('google')->put('123.txt',"123456");//建立檔案

        $files = $request->file('multiple_file');
        foreach ($files as $key=>$file){
            if(Storage::disk('google')->put($file->getClientOriginalName(), file_get_contents($file))){
                $detail = Storage::disk("google")->getMetadata($file->getClientOriginalName());
                $google_file_state[$key]["url"] = Storage::disk('google')->url($detail["path"]);
                Storage::disk('google')->setVisibility($detail["path"],'public');//private
                $google_file_state[$key]["visibility"] = Storage::disk('google')->getVisibility($detail["path"]);
            }
        }
        //
        dd($google_file_state);
        // $read = Storage::get('public/test/123.txt');
        // $filesystem->write('public/test/123.txt', $read);
        // dd($fileContent);
        // $path = Storage::disk('google')->put('123.txt',$fileContent);

        // $fileContent = file_get_contents(asset("storage/test/123.txt")); // Replace with the actual path to your file
        // // dd($fileContent);
        // $folderId = '1KNHZJgsg1Vx3-KTlWfprM13sKVvEi5fG'; // Replace with the target folder ID
        // $fileName = '123.txt'; // Replace with the desired file name

        // // $fileId = $this->googleDriveService;
        // $fileId = $this->googleDriveService->uploadFileToFolder($fileContent, $folderId, $fileName,"text/plain");

        // // $fileId 現在包含新上傳檔案的 Google Drive ID
        // return response()->json(['file_id' => $fileId]);
    }
}
