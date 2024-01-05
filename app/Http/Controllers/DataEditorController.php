<?php

namespace App\Http\Controllers;

use App\Models\DataEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DataEditorRequest;

class DataEditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DataEditor::get();
        return view('DataEditor.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $method = "store";
        return view('DataEditor.item',compact('method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataEditorRequest $request)
    {
        $data = array(
            "title" => $request->title,
            "intro" => $request->intro,
        );

        $DataEnable = DataEditor::create($data);

        $response = [
            'status' => 'success',
        ];
        $response["message"] = "新增成功";

        // session()->flash('success', '新增成功！');
        // return response()->json($response,200);
        return redirect()->route('dataeditor.index'); // 替換成你的 index 路由名稱

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload(Request $request)
    {
        $messages = [
            'file.max' => '圖片檔案不能大於2000KB',
        ];
        $validator = Validator::make($request->all(), [
            'file' => 'max:2000',
        ], $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
    
        $fileName = date("Ymd") . $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs('uploads', $fileName, 'public');
        return response()->json(['location' => "/imgsortable/storage/$path"]);
    }
}
