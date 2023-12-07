$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('._delete_').click(function () {
        var _this = $(this);
        var _errmsg = _this.attr('data-errmsg');
        if(_errmsg == 'undefined'){
            _errmsg = '確定要刪除嗎？';
        }
        if(!confirm(_errmsg)) {
            return false;
        }
        var _url = _this.attr('data-url');
        var _refresh_url = _this.attr('data-refresh-url');
        $.ajax({
            type: "DELETE",
            url: _url, // 替换为实际的验证路由
            processData: false,
            contentType: false,
            success: function(response) {
                // 验证成功，执行相关操作
    
                console.log(response);
    
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
                         if (_refresh_url !== null && _refresh_url !== undefined && _refresh_url !== '') {
                            window.location.href=_refresh_url;
                            return;
                        }
                        location.reload();
                    });
                }else if(response.status=="fail"){
                    Swal.fire({
                        title: '錯誤',
                        html: `<p>${response.message}</p>`,
                        icon: 'error',
                        confirmButtonText: '確認',
                        timer: 2000, // 設定計時器為 2000 毫秒（2 秒）
                        showConfirmButton: false // 隱藏確認按鈕
                    });
                }
            },
            error: function(response) {
                // 验证失败，显示错误消息
                var errors = response.responseJSON;
                Swal.fire({
                    title: '錯誤',
                    html: `<p>${errors.message}</p>`,
                    icon: 'error',
                    confirmButtonText: '確認',
                    timer: 2000, // 設定計時器為 2000 毫秒（2 秒）
                    showConfirmButton: false // 隱藏確認按鈕
                });
            }
        });
    });
});

