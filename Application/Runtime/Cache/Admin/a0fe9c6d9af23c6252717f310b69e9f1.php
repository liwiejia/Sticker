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
    <div class="container">
        <div class="logo">
        </div>
        <form class="form" action="/Sticker_3.2/index.php/Admin/Forger/forger.html" METHOD="post">
            <input type="text" name="username" placeholder="账号" id="username" >
            <input type="text" name="username" placeholder="请输入邮箱" id="username" >
            <div class="verify_box">
                <input id="verify" type="text" name="verify" class="verify" placeholder="<?php echo (L("verify")); ?>">
                <img class="verify_img" src="<?php echo U(verify);?>" alt="<?php echo (L("verify")); ?>" onclick="this.src=this.src+'?'+Math.random()">
            </div>
            <div class="mail_box">
                <input id="mailVerify" type="text" name="mailVerify" class="mailVerify" placeholder="请输入邮箱验证码">
                <button type="button" id="" onclick="" >发送验证码</button>
            </div>
                <input id="password" type="text" name="password" class="password" placeholder="新密码">
                <input id="repassword" type="text" name="repassword" class="repassword" placeholder="确认密码">
            <button type="submit" id="login-button" >提交</button>
        </form>
        <a href="login.html" class="text-center">登录</a> |
        <a href="register.html" class="text-center"><?php echo (L("register_new")); ?></a>
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
        var Y =(H-500)/1.8;
        document.getElementsByClassName('wrapper')[0].setAttribute("style","widht:"+W+"px;height:"+H+"px");
        document.getElementsByClassName('container')[0].setAttribute("style","margin-top:"+Y+"px");


    }
</script>
<script type="text/javascript" src="/Sticker_3.2/Public/Js/Admin/canvas-particle.js"></script>
</body>
</html>