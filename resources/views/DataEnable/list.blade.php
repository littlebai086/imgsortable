@section('title', "測試開關管理")
@section('content_title', '測試開關管理')
@section('content_title_small', count($data))
@section('content')
    <!-- Main content -->
    <style>
            .tr-odd{background-color: #ccc;}
            .tr-hover{background-color: #0fa;}
            .btn-switch {
                position: relative; /* 將按鈕設置為相對定位 */
                color: whitesmoke;
                width: 6rem;
                height: 2.5rem;
                margin:.1rem;
                padding: .1rem;
                background: #555;
                border: 2px solid #ccc;
                border-radius: 2rem;
                transition: .3s;
                box-shadow: inset 1px 1px 5px #333, .1rem .2rem .5rem #999;
                display: flex; /* 使用 flexbox 進行排列 */
                align-items: center; /* 垂直居中 */
                justify-content: flex-start; /* 左對齊 */
            }
            .on.btn-switch {
                background: #4CAF50;
            }
            .btn-switch-text {
                position: absolute; /* 將 "開" 文字設置為絕對定位 */
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1; /* 將 "開" 文字的 z-index 設置為高於 .btn-switch-ball */
                margin-top: 0.3rem;
                font-size : 16px;
            }
            .btn-switch .btn-switch-text {
                margin-left: 1.5rem; /* 調整文字到圓形元素的間距 */
            }
            .on.btn-switch .btn-switch-text {
                margin-left: -1rem; /* 調整文字到圓形元素的間距 */
            }
            .btn-switch-ball {
                position: absolute; /* 將圓形元素設置為絕對定位 */
                top: 50%;
                left: 20%;
                transform: translate(-50%, -50%);
                color: whitesmoke;
                width: 2rem;
                height: 2rem;
                background: #ccc;
                border: inset .1rem rgba(153, 153, 153, 0.43);
                border-radius: 50%;
                box-sizing: border-box;
                cursor: pointer;
                transition: .3s;
                box-shadow: 1px 1px 5px #000;
            }
            .on .btn-switch-ball {
                /* background: #999; */
                /* outset .1rem rgba(153, 153, 153, 0.43) */
                box-shadow: -1px 1px 5px #000;
                margin-left: calc(100% - 2rem);
            }
    </style>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">測試開關列表</h3>
                            <span class="pull-right"><button type="button" onclick="location='{{ url('/dataenable/create') }}';" class="btn btn-success pull-right">新增</button></span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="active">
                                    <th style="width:50px;">ID</th>
                                    <th style="width:200px;">標題</th>  
                                    <th style="width:400px;">啟用</th>  
                                </tr>
                                @foreach ($data as $item)
                                <tr id="item-{{$item->id}}" class="draggable">
                                    <td>{{  $item->id }}</td>
                                    <td>
                                        <div>{{ $item->title }}</div>
                                    </td>
                                    <td>
                                        <div>
                                        @if($item['enable']==1)  
                                        <button class="btn-switch on">
                                            <div class="btn-switch-text">開</div>
                                            <div class="btn-switch-ball" data-id="{{ $item['id'] }}"></div>
                                        </button>
                                        @else 
                                        <button class="btn-switch">
                                        <div class="btn-switch-text">關</div>
                                            <div class="btn-switch-ball" data-id="{{ $item['id'] }}"></div>
                                        </button>  
                                        @endif
                                        </div>
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
    $('tr').hover(function() {
        $(this).addClass('tr-hover');
    }, function() {
        $(this).removeClass('tr-hover');
    });  

    $(document).ready(function() {
        $('.btn-switch').on('click', function () {
            var $this = $(this);
            var enable = 0;
            var message = "";
            var dataId = $this.find('.btn-switch-ball').data('id');
            if ($this.hasClass('on')) {
                message = "確定要進行關閉嗎?";
                enable = 0;
            } else {
                message = "確定要進行開啟嗎?";
                enable = 1;
            }
            if(confirm(message)){
                $this.toggleClass('on');
                if(enable==1){
                    $this.find('.btn-switch-text').html("開");
                }else{
                    $this.find('.btn-switch-text').html("關");
                }
                $.ajax({
                    data: {
                        id: dataId,
                        enable: enable,
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{url('/dataenable/dataenable_enable')}}",
                    success: function (response) {
                        console.log(response);
                        var message = response.message;
                        

                    },error: function(response) {
                        var message = response.message;
                    }
                });   
                alert(message);
            }
            
                    
        });
    });
  </script>
@append
@endsection
@extends('layouts.admin')