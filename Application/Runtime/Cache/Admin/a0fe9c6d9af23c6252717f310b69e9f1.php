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
        <form class="form" action="/Sticker_3.2/index.php/Admin/Forger/forger.html" METHOD="post">
            <div class="input_box">
                <input type="text" name="username" placeholder="账号" id="username" >
            </div>
            <div class="input_box">
                <input type="text" name="username" placeholder="请输入邮箱" id="username" >
            </div>
            <div class="verify_box">
                <input id="verify" type="text" name="verify" class="verify" placeholder="验证码">
                <img class="verify_img" src="<?php echo U('Login/verify');?>" alt="<?php echo (L("verify")); ?>" onclick="this.src=this.src+'?'+Math.random()">
            </div>
            <div class="mail_box">
                <input id="mailVerify" type="text" name="mailVerify" class="mailVerify" placeholder="请输入邮箱验证码">
                <button type="button" id="sendMail" onclick="" >发送验证码</button>
            </div>
            <div class="input_box">
                <input id="password" type="password" name="password" class="password" placeholder="新密码">
            </div>
            <div class="input_box">
                <input id="repassword" type="password" name="repassword" class="repassword" placeholder="确认密码">
            </div>
            <button type="submit" id="login-button" >提交</button>
        </form>
        <a href="<?php echo U('Login/login');?>" class="text-center">登录</a> |
        <a href="<?php echo U('Register/register');?>" class="text-center">注册新用户</a>
    </div>
</div>
<script type="text/javascript">
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
        var H = $(window).height();
        var W = $(window).width();
        var Y =(H-650)/1.8;
        document.getElementsByClassName('wrapper')[0].setAttribute("style","widht:"+W+"px;height:"+H+"px");
        document.getElementsByClassName('forger')[0].setAttribute("style","margin-top:"+Y+"px");


    }
</script>
<script type="text/javascript" src="/Sticker_3.2/Public/Js/Admin/canvas-particle.js"></script>
</body>
</html>