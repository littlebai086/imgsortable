@section('title', "測試開關管理")
@section('content_title', '測試開關管理')
@section('content_title_small', isset($item) ? "Id: $item->id " : "新增")
@section('css')

@endsection
@section('content')
    <style>
        .label{font-size:15px; color:#06f;}
    </style>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-body" style="display: block;">
                            @if($method=="store")
                                <form id="form" method="POST" action="{{ url('/dataenable') }}"  enctype="multipart/form-data">
                            @else
                                <form id="form" method="POST" action="{{ url('/dataenable/'.$item->id) }}"  enctype="multipart/form-data">
                                @method('PUT')
                            @endif
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{isset($item) ? $item->id  : ''}}">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">標題：<font color="red">(必填)</font></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="title" value="@if(isset($item)){{ $item->title }}@endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="enable" class="col-sm-2 control-label">開關</label>
                                    <div class="col-sm-3">
                                    <input type="checkbox" id="enable" name="enable" value="1" @if(isset($item) && $item->enable==1) checked="checked" @endif>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="location='{{ url("/dataenable") }}';" >返回列表</button>
                                <input type="submit" class="btn btn-primary" value="提交">
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
        <div style="height:400px;"></div>
    </section>
@endsection
@section('js')
<script>
</script>
@append
@extends('layouts.admin')