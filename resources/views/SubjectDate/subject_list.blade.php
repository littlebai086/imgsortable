@section('title', "圖片上傳管理")
@section('content_title', '圖片上傳管理')
@section('content_title_small', count($data))
@section('content')
    <!-- Main content -->
    <style>
            .tr-odd{background-color: #ccc;}
            .tr-hover{background-color: #0fa;}
    </style>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">主題列表</h3>
                            <span class="pull-right"><button type="button" onclick="location='{{ url('/subjectdate/create') }}';" class="btn btn-success pull-right">新增</button></span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="active">
                                    <th style="width:50px;">ID</th>
                                    <th style="width:200px;">日期</th>  
                                    <th style="width:400px;">主題</th>  
                                    <th>簡介</th>
                                    <th style="width:200px;">上架日期</th>                               
                                    <th style="width:200px;">操作</th>
                                </tr>
                                @foreach ($data as $item)
                                <tr id="item-{{$item->id}}" class="draggable">
                                    <td>{{  $item->id }}</td>
                                    <td>
                                        <div>{{ $item->date }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->subject }}</div>
                                    </td>
                                    <td>
                                        <div><pre>{!! $item->intro !!}</pre></div>
                                    </td>
                                    <td>
                                        <div>{{ $item->start_date }}</div>
                                    </td>
                                    <td>
                                        <!-- <button><a href="{{ url('/subjectdate')}}/{{$item['id']}}/editimgsort">圖片排序</a></button> -->
                                        <a class="btn btn-primary" role="button" href="{{ url('/subjectdate')}}/{{$item->id}}/edit">編輯</a>
                                        <a class="btn btn-secondary _delete_" role="button" href="#" class="_delete_" data-url="{{ url('/subjectdate')}}/{{$item->id}}" data-errmsg="確定要刪除 {{$item->subject}} 嗎？">刪除</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@section('js')
    <script>
$(function () {
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    
    // $('._delete_').click(function () {
    //     var _this = $(this);
    //     var _errmsg = _this.attr('data-errmsg');
    //     if(_errmsg == 'undefined'){
    //         _errmsg = '確定要刪除嗎？';
    //     }
    //     if(!confirm(_errmsg)) {
    //         return false;
    //     }
    //     var _url = _this.attr('data-url');
    //     var _refresh_url = _this.attr('data-refresh-url');
    //     $.ajax({
    //         type: "DELETE",
    //         url: _url, // 替换为实际的验证路由
    //         processData: false,
    //         contentType: false,
    //         success: function(response) {
    //             // 验证成功，执行相关操作

    //             console.log(response);

    //             if(response.status=="success"){
    //                 Swal.fire({
    //                     title: '成功',
    //                     text: response.message,
    //                     icon: 'success',
    //                     confirmButtonText: '確認',
    //                     timer: 2000, // 設定計時器為 2000 毫秒（2 秒）
    //                     showConfirmButton: false // 隱藏確認按鈕
    //                 }).then((result) => {
    //                     // 使用 JavaScript 重新導向到新頁面
    //                      // location.reload();
    //                     window.location = "{{ url('subjectdate') }}";
    //                 });
    //             }else if(response.status=="fail"){
    //                 Swal.fire({
    //                     title: '錯誤',
    //                     html: `<p>${response.message}</p>`,
    //                     icon: 'error',
    //                     confirmButtonText: '確認',
    //                     timer: 2000, // 設定計時器為 2000 毫秒（2 秒）
    //                     showConfirmButton: false // 隱藏確認按鈕
    //                 });
    //             }
    //         },
    //         error: function(response) {
    //             // 验证失败，显示错误消息
    //             var errors = response.responseJSON;
    //             Swal.fire({
    //                 title: '錯誤',
    //                 html: `<p>${errors.message}</p>`,
    //                 icon: 'error',
    //                 confirmButtonText: '確認',
    //                 timer: 2000, // 設定計時器為 2000 毫秒（2 秒）
    //                 showConfirmButton: false // 隱藏確認按鈕
    //             });
    //         }
    //     });
        // $.post(_url, {_method: 'DELETE'}, function (response) {
        //     console.log(response);
        //     alert(response.message);
        //     if (response.status == 200) {
        //         alert(response.message);
        //         if (_refresh_url !== null && _refresh_url !== undefined && _refresh_url !== '') {
        //             window.location.href=_refresh_url;
        //             return;
        //         }
        //         location.reload();
        //         return;
        //     } else {
        //         alert(response.message);
        //         return;
        //     }
        // }).fail(function(data) {
        //     console.log(data);
        //     console.log(123);
        //     var status = data.status;
        //     alert(data.message);
        // });
    // });
});
    </script>
    <script>        
    $('tr').hover(function() {
        $(this).addClass('tr-hover');
    }, function() {
        $(this).removeClass('tr-hover');
    });  

    $(document).ready(function() {
        

        $( "tbody" ).sortable({
            items: 'tr.draggable',
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                // POST to server using $.post or $.ajax
                var csrfToken = "{{ csrf_token() }}";
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: '{{url('/subjectdate/group/saveorder')}}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        // updateFirstColumn();
                        location.href = location.href;
                    }
                });
            }
        });
        $( "#sortable" ).disableSelection();
    });
  </script>
@append
@endsection
@extends('layouts.admin')