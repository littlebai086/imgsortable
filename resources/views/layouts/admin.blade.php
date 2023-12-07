<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title') | {{ Config::get('app.name') }}</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- 在<head>標籤中引入SweetAlert2的CSS文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.css">

    <!-- 在<body>標籤底部引入SweetAlert2的JavaScript文件 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.all.min.js"></script>
    @yield('css')
    <style>

    </style>
</head>
<body>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @yield('content_title')
                <small>@yield('content_title_small')</small>
            </h1>
        </section>
        @yield('content')
    </div>
    @if (session('success'))
    <script>
        Swal.fire(
            '成功',
            "{{ session('success') }}",
            'success'
        );
    </script>
    @endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/common.js') }}"></script>
@yield('js')
</body>
</html>
