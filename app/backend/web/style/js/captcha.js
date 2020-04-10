$(function () {
    //解决验证码不刷新的问题
    changeVerifyCode();
    $('#captchaimg').click(function () {
        changeVerifyCode();
    });
});
//更改或者重新加载验证码
function changeVerifyCode() {
//项目URL
    $.ajax({
        //使用ajax请求site/captcha方法，加上refresh参数，接口返回json数据
        url:"/login/captcha?refresh",
        dataType: 'json',
        cache: false,
        success: function (data) {
            //将验证码图片中的图片地址更换
            $("#captchaimg").attr('src', data['url']);
        }
    });
}