<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/03/2018
 * Time: 17:33
 */

/**
 * 检测验证码
 * @param $code 输入的验证码
 * @param string $id 验证码标识,多个验证码时可用
 * @return bool 用户验证码 true or false
 */



function verify_check($code, $id='')
{
    // 实例化验证码类
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

function send_mail($to, $name, $subject = '', $body = '', $attachment = null){

    $config = C('THINK_EMAIL');

    vendor('PHPMailer.PHPMailer'); //从PHPMailer目录导class.phpmailer.php类文件
    vendor('PHPMailer.SMTP');
    $mail = new PHPMailer(); //PHPMailer对象 \Vendor\PHPMailer\

    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码

    $mail->IsSMTP(); // 设定使用SMTP服务

    $mail->SMTPDebug = 1; // 关闭SMTP调试功能

// 1 = errors and messages

// 2 = messages only

    $mail->SMTPAuth = true; // 启用 SMTP 验证功能

    $mail->SMTPSecure = false; // 使用安全协议

    $mail->Host = $config['SMTP_HOST']; // SMTP 服务器

    $mail->Port = $config['SMTP_PORT']; // SMTP服务器的端口号

    $mail->Username = $config['SMTP_USER']; // SMTP服务器用户名

    $mail->Password = $config['SMTP_PASS']; // SMTP服务器密码

    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);

    $replyEmail = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];

    $replyName = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];

    $mail->AddReplyTo($replyEmail, $replyName);

    $mail->Subject = $subject;

    $mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";

    $mail->MsgHTML($body);

    $mail->AddAddress($to, $name);

    if(is_array($attachment)){ // 添加附件

        foreach ($attachment as $file){

            is_file($file) && $mail->AddAttachment($file);

        }

    }

    return $mail->Send() ? true : $mail->ErrorInfo;

}