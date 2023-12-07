<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectDate;
use Illuminate\Validation\Rule;
use App\Http\Requests\SubjectDateRequest;

class SubjectDateController extends Controller
{
    public function index(Request $request){
        $data = SubjectDate::OrderBy('sort','asc')->get();
        return view('SubjectDate.subject_list', compact('data'));
    }
      
    public function create()
    {        
        $method = "store";
        return view('SubjectDate.subject_item',compact('method'));
    }
    
    public function store(SubjectDateRequest $request){
        $data = array(
            "date" => $request->date,
            "subject" => $request->subject,
            "intro" => $request->intro,
            "start_date" => $request->start_date,
        );
        $tmp_img_sorts = explode(";",$request->tmp_img_sort);
        $SubjectDate = SubjectDate::create($data);
        if ($request->hasFile('multiple_img')) {
            $multiple_imgs = array();
            foreach ($request->file('multiple_img') as $key=>$image) {
                $originalName =  $image->getClientOriginalName();
                $extension =  $image->getClientOriginalExtension();
                $size = $image->getSize();
                $mime = $image->getMimeType();
                $filekey = array_search($originalName, $tmp_img_sorts);
                $fileName = $SubjectDate->id .'_img' .($filekey+1) .'.'.$extension;      
                $filePath_name = $image->storeAs(config('project.subject_date_dir'), $fileName, 'public');
                $multiple_imgs[$filekey] = $filePath_name;
                
            }
            asort($multiple_imgs);
            $SubjectDate->multiple_img = implode(";",$multiple_imgs);
        }
        $SubjectDate->sort = $SubjectDate->id;
        $SubjectDate->save();
        $response = [
            'status' => 'success',
        ];
        $response["message"] = "新增成功";

        // session()->flash('success', '新增成功！');
        return response()->json($response,200);

    }

    public function edit($id)
    {
        $item = SubjectDate::find($id);
        $item->multiple_imgs = explode(";",$item->multiple_img);
        $method = "update";
        return view('SubjectDate.subject_item', compact('item','method'));
    }

    public function update(SubjectDateRequest $request,$id){
        $data = array(
            "date" => $request->date,
            "subject" => $request->subject,
            "intro" => $request->intro,
            "start_date" => $request->start_date,
        );

        $tmp_img_sorts = explode(";",$request->tmp_img_sort);
        $SubjectDate = SubjectDate::find($id);  
        if ($request->hasFile('multiple_img')) {
            $multiple_imgs = array();
            foreach ($request->file('multiple_img') as $key=>$image) {
                $originalName =  $image->getClientOriginalName();
                $extension =  $image->getClientOriginalExtension();
                $size = $image->getSize();
                $mime = $image->getMimeType();
                $filekey = array_search($originalName, $tmp_img_sorts);
                $fileName = $SubjectDate->id .'_img' .($filekey+1) .'.'.$extension;      
                $filePath_name = $image->storeAs(config('project.subject_date_dir'), $fileName, 'public');
                $multiple_imgs[$filekey] = $filePath_name;
                
            }
            asort($multiple_imgs);
            $data["multiple_img"] = implode(";",$multiple_imgs);
            
        }else{
            if($request->input('_method') == 'PUT'){
                $data["multiple_img"] = $request->tmp_img_sort;
            }
        }
        $SubjectDate->update($data);
        $response = [
            'status' => 'success',
        ];
        $response["message"] = "修改成功";

        // session()->flash('success', '新增成功！');
        return response()->json($response,200);
    }

    public function destroy($id)
    {
        $SubjectDate = SubjectDate::find($id);
        if (!$SubjectDate->delete()) {
            // return $this->retJson(503, '操作出錯!');
            $response["status"] = "fail";
            $response["message"] = "操作出錯";
            return response()->json($response,503);
        }
        
        // $SubjectDateGcp = SubjectDate::on('azure_mysql')->find($id);
        // $SubjectDateGcp->videos()->delete();
        // $SubjectDateGcp->delete();
        $response["status"] = "success";
        $response["message"] = "操作成功";
        return response()->json($response,200);
    }

    public function saveorder(Request $request){
        // $data = SubjectDate::find($request->id);
        // $multiple_imgs = explode(";",$data->multiple_img);
        // // 重新排列数组
        // $sortedArray = array_map(function ($index) use ($multiple_imgs) {
        //     return $multiple_imgs[$index];
        // }, $request->item);
        // SubjectDate::where('id', $request->id)->update(['multiple_img' => implode(";",$sortedArray)]);
        // dd($request->item);
        $i = 0;
        foreach ($request->item as $index => $id) {
          $item = SubjectDate::where('id', $id)->first();
          $item->update(array('sort'=>$index));
          $i++;
        }
    }
    
}
