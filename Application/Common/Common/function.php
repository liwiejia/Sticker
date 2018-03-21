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
/**
 * 发送mail
 * @param $to 输入的验证码
 * @param $name 验证码标识,多个验证码时可用
 * @return
 */
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
/**
 * 生成二维码
 * phpqrcode.php提供了一个关键的png()方法，
 * @param $value  生成二位的的信息文本；
 * @param $outfile  是否输出二维码图片 文件，默认否；
 * @param $errorCorrentionLevel  容错率，也就是有被覆盖的区域还能识别，分别是 L（QR_ECLEVEL_L，7%），                               *  M（QR_ECLEVEL_M， 15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）；
 * @param $matrixPoinSize  生成图片大小，默认是3；
 * @param $margin  二维码周围边框空白区域间距值；
 * @param $saveandprint  是否保存二维码并 显示。
 */
function make_qrcode($value,$errorCorrentionLevel,$matrixPoinSize){
    //引入php QR库文件
    vendor('phpqrcode.phpqrcode');
    //本地文档相对路径
    $url = './Public/Image/';

    //如不加logo，下面logo code 注释掉，输出$url.qrcode.png即可。
    $logo =$url.'logo_RQ.jpg'; //logo

    //已经生成的二维码
    $QR = $url . 'qrcode/' . md5($value) . '.png';

    //生成二维码,第二个参数为二维码保存路径
    QRcode::png($value,$QR,$errorCorrentionLevel,$matrixPoinSize,2);

    if($logo !== FALSE){
        $QR = imagecreatefromstring(file_get_contents($QR));
        $logo = imagecreatefromstring(file_get_contents($logo));
        $QR_width = imagesx($QR);//二维码图片宽度
        $QR_height = imagesy($QR);//二维码图片高度
        $logo_width = imagesx($logo);//logo图片宽度
        $logo_height = imagesy($logo);//logo图片高度
        $logo_qr_width = $QR_width / 5;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;
        $from_width = ($QR_width - $logo_qr_width) / 2;
//重新组合图片并调整大小
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
            $logo_qr_height, $logo_width, $logo_height);
    }
    //新图片
    $img = $url . 'qrcode/' . md5($value) . '_logo.png';
    //输出图片

    imagepng($QR, $img);

    if(file_get_contents($img))
        return __ROOT__.'/Public/Image/qrcode/' . md5($value) . '_logo.png';
    else
        return __ROOT__.'/Public/Image/error.png';;

}
/**
 * 验证手机号是否正确
 * 移动：134、135、136、137、138、139、150、151、152、157、158、159、182、183、184、187、188、178(4G)、147(上网卡)、148、172、198；
 * 联通：130、131、132、155、156、185、186、176(4G)、145(上网卡)；146、166、171、175
 * 电信：133、153、180、181、189 、177(4G)；149、173、174、199
 * 卫星通信：1349
 * 虚拟运营商：170
 * http://www.cnblogs.com/zengxiangzhan/p/phone.html
 * @author lan
 * @param $mobile
 * @return bool
 */
function isMobile($mobile='') {
    return preg_match('#^13[\d]{9}$|^14[5,6,7,8,9]{1}\d{8}$|^15[^4]{1}\d{8}$|^16[6]{1}\d{8}$|^17[0,1,2,3,4,5,6,7,8]{1}\d{8}$|^18[\d]{9}$|^19[8,9]{1}\d{8}$#', $mobile) ? true : false;
}
/**
 * 验证密码是否正确
 * 密码由6-16位大小写字母、数字和下划线组成
 * @author lan
 * @param string $password
 * @return bool
 */
function isPassword($password=''){
    return preg_match("/^[0-9a-zA-Z_]{6,16}$/", $password) ? true : false;
}
/**
 * 验证邮箱是否正确
 * @author lan
 * @param string $email
 * @return bool
 */
function isEmail($email=''){
    return preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email) ? true : false;
}
/**
 * 验证用户名是否正确
 * 用户名由6-24位字母、数字组成，首位不能是数字
 * @param string $username
 * @return bool
 */
function isUserName($username=''){
    return preg_match("/^[a-zA-Z]{1}[0-9a-zA-Z]{5,23}$/", $username) ? true : false;
}
/**
 * 验证身份证号码格式是否正确
 * 仅支持二代身份证
 * @author chiopin
 * @param string $idcard 身份证号码
 * @return boolean
 */
function isIdCard($idcard=''){
    // 只能是18位
    if(strlen($idcard)!=18){
        return false;
    }

    $vCity = array(
        '11','12','13','14','15','21','22',
        '23','31','32','33','34','35','36',
        '37','41','42','43','44','45','46',
        '50','51','52','53','54','61','62',
        '63','64','65','71','81','82','91'
    );

    if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $idcard)) return false;

    if (!in_array(substr($idcard, 0, 2), $vCity)) return false;

    // 取出本体码
    $idcard_base = substr($idcard, 0, 17);

    // 取出校验码
    $verify_code = substr($idcard, 17, 1);

    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

    // 校验码对应值
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

    // 根据前17位计算校验码
    $total = 0;
    for($i=0; $i<17; $i++){
        $total += substr($idcard_base, $i, 1)*$factor[$i];
    }

    // 取模
    $mod = $total % 11;

    // 比较校验码
    if($verify_code == $verify_code_list[$mod]){
        return true;
    }else{
        return false;
    }
}