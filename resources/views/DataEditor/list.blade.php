@section('title', "測試編輯器管理")
@section('content_title', '測試編輯器管理')
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
                        <h3 class="box-title">測試編輯器列表</h3>
                            <span class="pull-right"><button type="button" onclick="location='{{ url('/dataenable/create') }}';" class="btn btn-success pull-right">新增</button></span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="active">
                                    <th style="width:50px;">ID</th>
                                    <th style="width:200px;">標題</th>  
                                    <th style="width:400px;">介紹</th>  
                                </tr>
                                @foreach ($data as $item)
                                <tr id="item-{{$item->id}}" class="draggable">
                                    <td>{{  $item->id }}</td>
                                    <td>
                                        <div>{{ $item->title }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->intro }}</div>
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

  </script>
@append
@endsection
@extends('layouts.admin')