@section('title', "圖片上傳管理")
@section('content_title', '圖片上傳管理')
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
                                <form id="form" action="{{ url('/subjectdate') }}"  enctype="multipart/form-data">
                            @else
                                <form id="form" action="{{ url('/subjectdate/'.$item->id) }}"  enctype="multipart/form-data">
                                @method('PUT')
                            @endif
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{isset($item) ? $item->id  : ''}}">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="date" class="col-sm-2 control-label">日期：<font color="red">(必填)</font></label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="date" name="date" value="@if(isset($item)){{ $item->date }}@endif">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="col-sm-2 control-label">主題：<font color="red">(必填)</font></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="subject" value="@if(isset($item)){{ $item->subject }}@endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="intro" class="col-sm-2 control-label">簡介：<font color="red">(必填)</font></label>
                                    <div class="col-sm-3">
                                        <textarea type="text" class="form-control" id="intro" name="intro" rows="10">@if(isset($item)){{ htmlspecialchars_decode(html_entity_decode($item->intro)) }}@endif</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="multiple_img" class="col-sm-2 control-label">圖片：<font color="red" class="multiple-img-remark" @if(isset($item))style="display: none;"@endif>(必填)</font></label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" id="multiple_img" name="multiple_img[]" multiple>
                                        <input type="hidden" class="form-control" id="tmp_img_sort" name="tmp_img_sort" value="@if(isset($item)){{ $item->multiple_img }}@endif" >
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="start_date" class="col-sm-2 control-label">上架日期：<font color="red">(必填)</font></label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="start_date" value="@if(isset($item)){{ $item->start_date }}@endif">
                                    </div>
                                </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-cancel pull-left" onclick="location='{{ url("/subjectdate") }}';">返回</button>
                                  <input type="submit" class="btn btn-info" value="提交">
                            </div>
                            <table class="table table-bordered" id="imagePreviewContainer">
                                <p class="table-remark" @if(!isset($item))style="display: none;"@endif><font color="red">*拖曳圖片即可進行排序，拖曳排序完成後需按「提交」按鈕，才會進行儲存這次的排序內容。</font></p>
                                <tbody>
                                    @if(isset($item->multiple_imgs))
                                    <tr class="active">
                                        <th style="width:50px;">排序</th>
                                        <th>圖片</th>    
                                    </tr>
                                    @foreach ($item->multiple_imgs as $key=>$url)
                                    <tr id="item-{{$key}}" class="draggable">
                                        <td>{{  $key+1 }}</td>
                                        <td>
                                            <div><a target="_blank" href="{{ asset("storage/{$url}?".date('YmdHis')) }}"><img src = "{{ asset("storage/{$url}?".date('YmdHis')) }}" style="width:200px;"></img></a></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
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
        $('#multiple_img').change(function() {
            
            readURL(this);
            var files = $('#multiple_img')[0].files;
            $("#tmp_img_sort").val("");
            if (files.length > 0) {
                var array = [];
                $.each(files, function(index, file) {
                    var fileName = file.name;
                    array.push(`${fileName}`);
                });
                $('#tmp_img_sort').val(array.join(';'));
            }else{
                $(".multiple-img-remark").show();
            }
        });
        $( "tbody" ).sortable({
            items: 'tr.draggable',
            axis: 'y',
            update: function (event, ui) {
                var serializedString = $(this).sortable('serialize');
                var idArray = serializedString.split('&').map(function(pair) {
                    return pair.split('=')[1];
                });

                // 使用分號拆分成每個鍵值對
                var tmp_img_sort = $('#tmp_img_sort').val().split(';');

                // 使用 map 方法創建包含索引和值的新陣列
                var indexedArray = $.map(tmp_img_sort, function(value, index) {
                    return { index: idArray.indexOf(index.toString()), value: value };
                });

                // 使用 sort 方法，根據每個元素的索引進行排序
                indexedArray.sort(function(a, b) {
                    return a.index - b.index;
                });

                // 提取排序後的值
                var sortedValues = $.map(indexedArray, function(item) {
                    return item.value;
                });
                $("#tmp_img_sort").val(sortedValues.join(';'));              
                
                updateFirstColumn();
            }
        });
        $( "#sortable" ).disableSelection();

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
                                    window.location = "{{ url('subjectdate') }}";
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

    // 更新表格的第一列数据
    function updateFirstColumn() {
        // 获取所有行的第一列
        var firstColumnCells = $("tbody tr td:first-child");

        // 遍历排序后的索引，更新第一列的文本
        $("tbody tr").each(function (index, row) {
            var newIndex = $(row).index();
            var newText = newIndex+1; // 你可以根据需要修改这里的逻辑
            
            $(firstColumnCells[index]).text(newText);
            if(index>0){
                var newId = "item-" + (index-1);
                $(row).attr("id", newId);
            }
        });
    }
    $( "#sortable" ).disableSelection();	
    function readURL(input) {
        $(".table-remark").hide();
        $('#imagePreviewContainer tbody').empty();
        var table = `
                    <tr class="active">
                        <th style="width:50px;">排序</th>
                        <th>圖片</th>    
                    </tr>`;
        if (input.files && input.files.length > 0) {
            $(".table-remark").show();
            for (let i = 0; i < input.files.length; i++) {

                const reader = new FileReader();
                // reader.readAsDataURL(input.files[i]);
                const objectURL = URL.createObjectURL(input.files[i]);
                var sort = i+1;
                table += `
                    <tr id="item-${i}" class="draggable">
                        <td>${sort}</td>
                        <td>
                            <div><img src = "${objectURL}" style="width:200px;"></img></div>
                        </td>
                    </tr>`;
            }
            $('#imagePreviewContainer tbody').append(table);
        }
    }
</script>
@append
@extends('layouts.admin')