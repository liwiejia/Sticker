<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo (L("register_new")); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/Sticker_3.2/Public/Style/Admin/login.css" rel="stylesheet" type="text/css">
    <link href="/Sticker_3.2/Public/Style/Admin/reset.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Sticker_3.2/Public/Js/jquery.min.js"></script>
    <script type="text/javascript" src="/Sticker_3.2/Public/Js/Admin/login.js"></script>
</head>
<body>
<div class="wrapper">
    <div id="count-msg"></div>
    <div class="register">
        <div class="logo">
        </div>
        <form class="form" action="/Sticker_3.2/index.php/Admin/Register/register.html" METHOD="post">
            <div class="input_box">
                <input type="text" name="nickname" placeholder="昵称" id="nickname" >
            </div>
            <div class="input_box">
                <input type="text" name="username" placeholder="<?php echo (L("username")); ?>" id="username" >
            </div>
            <div class="input_box">
                <input type="password" name="password" placeholder="<?php echo (L("password")); ?>" id="password">
            </div>
            <div class="input_box">
                <input type="password" name="repassword" placeholder="确认密码" id="repassword">
            </div>
            <div class="input_box">
                <input type="text" name="email" placeholder="邮箱" id="email" >
            </div>
            <div class="input_box">
                <input type="text" name="mobile" placeholder="手机号码" id="mobile" >
            </div>
            <div class="verify_box">
                <input id="verify" type="text" name="verify" class="verify" placeholder="<?php echo (L("verify")); ?>">
                <img class="verify_img" src="<?php echo U('Login/verify');?>" alt="<?php echo (L("verify")); ?>" onclick="this.src=this.src+'?'+Math.random()">
            </div>
            <button type="submit" id="login-button" ><?php echo (L("registered")); ?></button>
        </form>
        <a href="<?php echo U('Login/login');?>" class="text-center"><?php echo (L("go_login")); ?></a>
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
        document.getElementsByClassName('register')[0].setAttribute("style","margin-top:"+Y+"px");


    }
</script>
<script type="text/javascript" src="/Sticker_3.2/Public/Js/Admin/canvas-particle.js"></script>
</body>
</html>