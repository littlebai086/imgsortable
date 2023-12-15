<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataEnable;
use App\Http\Requests\DataEnableRequest;

class DataEnableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DataEnable::get();
        return view('dataenable.list', compact('data'));
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
        return view('dataenable.item',compact('method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataEnableRequest $request)
    {
        $data = array(
            "title" => $request->title,
            "enable" => $request->enable,
        );

        $DataEnable = DataEnable::create($data);

        $response = [
            'status' => 'success',
        ];
        $response["message"] = "新增成功";

        // session()->flash('success', '新增成功！');
        // return response()->json($response,200);
        return redirect()->route('dataenable.index'); // 替換成你的 index 路由名稱
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
        $item = DataEnable::find($id);
        $method = "update";
        return view('dataenable.item',compact('item','method'));
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
    public function update(DataEnableRequest $request, $id)
    {
        $data = array(
            "title" => $request->title,
            "enable" => $request->enable,
        );
        $DataEnable = DataEnable::find($id);
        $DataEnable = $DataEnable->update($data);

        $response = [
            'status' => 'success',
        ];
        $response["message"] = "新增成功";

        // session()->flash('success', '新增成功！');
        return response()->json($response,200);
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

    public function dataenable_enable(Request $request)
    {
        $DataEnable = DataEnable::find($request->id);
        switch ($request->enable) {
            case 0:
                $DataEnable->enable = 0;
                break;
            case 1:
                $DataEnable->enable = 1;
                break;
            default:
                $DataEnable->enable = 0;
        }
        if (!$DataEnable->save()) {
            $response = [
                "status" => "fail",
                "message" => "啟用修改失敗!!"
            ];
            return response()->json($response,503);
        }
        $response = [
            "status" => "success",
            "message" => "操作成功!"
        ];
        return response()->json($response,200);
    }
}
