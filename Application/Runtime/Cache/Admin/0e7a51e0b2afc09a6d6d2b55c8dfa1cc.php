<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<style>
   .header{
       background-color: rgb(117, 212, 183);
       padding: 10px;
   }
    .footer,.text{
        font-size: 14px;
        padding: 2em;
    }
</style>
<body>

    <div class="header">
        <span class="logo">
            <img src="/Sticker_3.2/Public/Image/logo.png" style="width: 150px;">
        </span>
    </div>
    <div class="text">
        <br>
        <br>
        您好 <?php echo ($name); ?>,
        <br>
        <br>
        <p>您的验证码为：</p>
        <h3 style="font-size: 60px; color: #f00; font-weight: bold;"><?php echo ($verify); ?></h3>
        <p>该验证邮件有效期为30分钟，超时请重新发送邮件。</p>
    </div>
    <div class="footer">
        Regards
        <br>
        Your Sticker Team
        <br>
        ------------------------------------
        <br>
        <a href="">www.sticker.com</a>
        <br>
        <div style="color: #999;">
            <p>发件时间：<span id="stickerTimer" style="border-bottom: 1px dashed rgb(204, 204, 204); position: relative;"  times="  <?php echo ($data["g"]); ?>:<?php echo ($data["i"]); ?>" isout="0"><?php echo ($data["y"]); ?>/<?php echo ($data["m"]); ?>/<?php echo ($data["d"]); ?></span> <?php echo ($data["g"]); ?>:<?php echo ($data["i"]); ?>:<?php echo ($data["s"]); ?></p>
            <p>此邮件为系统自动发出的，请勿直接回复。</p>
        </div>
    </div>

</body>
</html>