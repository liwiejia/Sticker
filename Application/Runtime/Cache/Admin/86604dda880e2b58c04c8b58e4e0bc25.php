<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>忘记密码</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/Sticker_3.2/Public/Style/Admin/login.css" rel="stylesheet" type="text/css">
    <link href="/Sticker_3.2/Public/Style/Admin/reset.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Sticker_3.2/Public/Js/jquery.min.js"></script>
    <script type="text/javascript" src="/Sticker_3.2/Public/Js/Admin/login.js"></script>
</head>
<body>
<div class="wrapper">
    <div id="count-msg"></div>
    <div class="forger">
        <div class="logo">
        </div>
        <form class="form" action="/Sticker_3.2/index.php/Admin/Forger/Forger.html" METHOD="post">
            <div class="input_box">
                <input type="text" name="username" placeholder="账号" id="username" foucs-message="请输入您要找回去密码的用户名" lost-message="用户名格式不正确（请输入需包含字母数字中的一种或两种,长度为4-22位）">
            </div>
            <div class="input_box">
                <input type="text" name="email" placeholder="请输入邮箱" id="email" foucs-message="请输入改账号绑定的邮箱" lost-message="邮箱格式不正确">
            </div>
            <div class="verify_box">
                <input id="verify" type="text" name="verify" class="verify" placeholder="验证码" foucs-message="请输入验证码" lost-message="验证码格式不正确（长度为4位）">
                <img class="verify_img" src="<?php echo U('Login/verify');?>" alt="<?php echo (L("verify")); ?>" onclick="this.src=this.src+'?'+Math.random()">
            </div>
            <div class="mail_box">
                <input id="mailVerify" type="text" name="mailVerify" class="mailVerify" placeholder="请输入邮箱验证码" foucs-message="请输入您邮箱收到验证码" lost-message="邮箱验证码格式不正确（长度为6位）">
                <button type="button" id="sendMail" onclick="" >发送验证码</button>
            </div>
            <div class="input_box">
                <input id="password" type="password" name="password" class="password" placeholder="新密码" foucs-message="请输入新密码" lost-message="验证码格式不正确（长度为4位）">
            </div>
            <div class="input_box">
                <input id="repassword" type="password" name="repassword" class="repassword" placeholder="确认密码" foucs-message="确认新密码" lost-message="两次输入的密码不符">
            </div>
            <button type="submit" id="login-button" >提交</button>
        </form>
        <a href="<?php echo U('Login/login');?>" class="text-center">登录</a> |
        <a href="<?php echo U('Register/register');?>" class="text-center">注册新用户</a>
    </div>
</div>
<script type="text/javascript">
    // 获取mail 验证码
    $("#sendMail").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        var data = new Object();
        data.username = $("input[name='username']").val();
        data.email = $("input[name='email']").val();
        data.verify = $("input[name='verify']").val();

        /*if (data.username == '') {
            $("input[name='adminname']").focus();
            lump_error("请输入用户名！");
            return false;
        }
        if (data.password == '') {
            $("input[name='password']").focus();
            lump_error("请输入密码！");
            return false;
        }
        if (data.verify == '') {
            $("input[name='verify']").focus();
            lump_error("请输入验证码！");
            return false;
        }
        $("#count-msg").hide();*/

        var url = "./sendMail";
        $.post(url, data , function(json){
            if (json.status) {
                showInfor(json.info);
               // window.location.href = "/Sticker_3.2/index.php/Admin/Index/index";
            }else {
                showInfor(json.info);
                $(".verify_img").trigger('click');
                return false;
            }
        }, 'json');
        return false;
    });
    $(".form").submit(function(e){
        e.preventDefault();
        e.stopPropagation();
        var data = new Object();
        data.username = $("input[name='username']").val();
        data.email = $("input[name='email']").val();
        data.verify = $("input[name='verify']").val();

        /*if (data.username == '') {
         $("input[name='adminname']").focus();
         lump_error("请输入用户名！");
         return false;
         }
         if (data.password == '') {
         $("input[name='password']").focus();
         lump_error("请输入密码！");
         return false;
         }
         if (data.verify == '') {
         $("input[name='verify']").focus();
         lump_error("请输入验证码！");
         return false;
         }
         $("#count-msg").hide();*/

        var url =  $(this).attr('action');
        $.post(url, data , function(json){
            if (json.status) {
                showInfor(json.info);
                // window.location.href = "/Sticker_3.2/index.php/Admin/Index/index";
            }else {
                showInfor(json.info);
                $(".verify_img").trigger('click');
                return false;
            }
        }, 'json');
        return false;
    });
    window.onload = function() {
        var config = {
            vx : 4,
            vy : 4,
            height : 2,
            width : 2,
            count : 110,
            color : "121, 162, 185",
            stroke : "100, 200, 180",
            dist : 6000,
            e_dist : 20000,
            max_conn : 10
        }
        CanvasParticle(config);
        var H = $(".forger").height()>650 ?( $(".register").height() +150):$(window).height();
        var W = $(window).width();
        var Y =(H-$(".forger").height())/1.8;
        document.getElementsByClassName('wrapper')[0].setAttribute("style","widht:"+W+"px;height:"+H+"px");
        document.getElementsByClassName('forger')[0].setAttribute("style","margin-top:"+Y+"px");


    }
</script>
<script type="text/javascript" src="/Sticker_3.2/Public/Js/Admin/canvas-particle.js"></script>
</body>
</html>