@section('title', "Google Drive Api上傳管理")
@section('content_title', 'Google Drive Api上傳管理')
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
                                <form id="form" action="{{ url('/googledrive/upload') }}"  enctype="multipart/form-data">
                            @else
                                <form id="form" action="{{ url('/googledrive/upload/'.$item->id) }}"  enctype="multipart/form-data">
                                @method('PUT')
                            @endif
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{isset($item) ? $item->id  : ''}}">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="multiple_img" class="col-sm-2 control-label">檔案：<font color="red" class="multiple-img-remark" @if(isset($item))style="display: none;"@endif>(必填)</font></label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" id="multiple_file" name="multiple_file[]" multiple>
                                    </div>
                                </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                  <input type="submit" class="btn btn-info" value="提交">
                            </div>
                        </form>
                        <div id="errorContainer" class="alert alert-danger" style="display: none;">
                            <ul></ul>
                        </div>

                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
        <div style="height:400px;"></div>
    </section>
@endsection
@section('js')
<script>
    var id = {{isset($item) ? $item->id  : 0}};
    var method = "{{ $method }}";
    id = id ?? '';
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
                e.preventDefault(); // 阻止表单默认提交行为
                // 使用 .serializeArray() 获取表单字段
                var formData = $(this).serializeArray();
                form = $('#form')[0];
                var formData = new FormData(form); // 获取表单字段
                var formAction = $(this).attr('action');
                var type = "POST";
                // 发送 AJAX 请求
                $.ajax({
                    type: type,
                    data: formData,
                    url: formAction, // 替换为实际的验证路由
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // 验证成功，执行相关操作
                        if(response.status=="success"){
                            Swal.fire({
                                title: '成功',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: '確認',
                                timer: 2000, // 設定計時器為 2000 毫秒（2 秒）
                                showConfirmButton: false // 隱藏確認按鈕
                            }).then((result) => {
                                    // 使用 JavaScript 重新導向到新頁面
                                    // location.reload();
                                    window.location = "{{ url('googledrive') }}";
                            });
                        }
                        console.log(response);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // 验证失败，显示错误消息
                            var errors = xhr.responseJSON;
                            var errorContainer = $('#errorContainer');
                            errorContainer.find('ul').empty(); // 清空之前的错误消息
                            // 构建错误消息并显示
                            $.each(errors.errors, function(key, value) {
                                errorContainer.find('ul').append('<li>' + value + '</li>');
                            });

                            errorContainer.show();
                        } else {
                            // 处理其他错误
                            console.log('An error occurred');
                        }
                    }
                });
            });

    });

    
</script>
@append
@extends('layouts.admin')