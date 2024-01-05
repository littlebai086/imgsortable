@section('title', "測試編輯器管理")
@section('content_title', '測試編輯器管理')
@section('content_title_small', isset($item) ? "Id: $item->id " : "新增")
@section('js_head')
<script>
    tinymce.init({
        selector: 'textarea#mytextarea',
        convert_urls: false,
        language: 'zh_TW',
        plugins: "a11ychecker advcode casechange export emoticons formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste preview table advtable tableofcontents tinycomments tinymcespellchecker",
        toolbar: "image preview table media" +
            "undo redo | styles | bold italic | forecolor backcolor emoticons |" +
            "alignleft aligncenter alignright alignjustify | " +
            "outdent indent | numlist bullist | emoticons", // 工具欄
        toolbar_mode: "floating",
        tinycomments_mode: "embedded",
        tinycomments_author: "Author name",
        language: "zh_TW", // 介面語言
        mobile: {
            menubar: true,
        },
        image_title: true,
        file_picker_types: 'image',
        images_upload_url: "{{url("/dataeditor/upload")}}",
        images_upload_base_path: "/",
        relative_urls: false, // 更改後編輯頁面才看的到圖片
    });

</script>
@endsection
@section('css')
<style>
    .label {
        font-size: 15px;
        color: #06f;
    }
</style>
@endsection

@section('content')

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body" style="display: block;">
                    @if($method=="store")
                    <form id="form" method="POST" action="{{ url('/dataeditor') }}" enctype="multipart/form-data">
                        @else
                        <form id="form" method="POST" action="{{ url('/dataeditor/'.$item->id) }}" enctype="multipart/form-data">
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
                                    <textarea id="mytextarea">Hello, World!</textarea>
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="location='{{ url("/dataeditor") }}';">返回列表</button>
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