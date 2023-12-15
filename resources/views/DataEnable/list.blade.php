@section('title', "測試開關管理")
@section('content_title', '測試開關管理')
@section('content_title_small', count($data))
@section('content')
    <!-- Main content -->
    <style>
            .tr-odd{background-color: #ccc;}
            .tr-hover{background-color: #0fa;}
            .btn-switch {
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
            }
            .btn-switch-ball {
                color: whitesmoke;
                width: 2rem;
                height: 2rem;
                background: #777;
                border: inset .1rem rgba(153, 153, 153, 0.43);
                border-radius: 50%;
                box-sizing: border-box;
                cursor: pointer;
                transition: .3s;
                box-shadow: 1px 1px 5px #000;
            }
            .on .btn-switch {
                background: #777;
            }
            .on .btn-switch-ball {
                background: #999;
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
                                            <button class="btn-switch">
                                            <div class="btn-switch-ball" data-id="{{ $item->id }}">開</div>
                                            </button>
                                        @else 
                                            <button class="btn-switch on">
                                                <div class="btn-switch-ball" data-id="{{ $item->id }}">關</div>
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
        $('.btn-switch-ball').on('click', function () {
            var $this = $(this);
            var enable = 0;
            var message = "";
            var dataId = $this.data('id');
            if ($this.parent().hasClass('on')) {
                message = "確定要進行啟用嗎?";
                enable = 1;
            } else {
                message = "確定要進行關閉嗎?";
                enable = 0;
            }
            if(confirm(message)){
                $this.parent().toggleClass('on');
                if(enable==1){
                    $this.html("開");
                }else{
                    $this.html("關");
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
                        alert(response.message);

                    },error: function(response) {
                        alert(response.message);
                    }
                });   
            }
            
                    
        });
    });
  </script>
@append
@endsection
@extends('layouts.admin')