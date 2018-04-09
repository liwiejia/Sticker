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
function test($type){
   /* $verify =  \Vendor\ThinkSDK\ThinkOauth::getInstance($type);
    return $verify->getInstance($type);*/

   // vendor('ThinkSDK.ThinkOauth.class'); //从PHPMailer目录导class.phpmailer.php类文件
    //$sns = new \Vendor\ThinkSDK\ThinkOauth(); //PHPMailer对象 \Vendor\PHPMailer\
   // $sns  = Vendor\ThinkSDK\ThinkOauth::getInstance($type);
    //echo $sns;
    //$mail = new Vendor\ThinkSDK\ThinkOauth(); //PHPMailer对象 \Vendor\PHPMailer\
    import('Vendor.ThinkSDK.ThinkOauth');
    //$mail =new ThinkOauth();
}
function send_mail($to, $name, $subject = '', $body = '', $attachment = null){

    $config = C('THINK_EMAIL');

    vendor('PHPMailer.PHPMailer'); //从PHPMailer目录导class.phpmailer.php类文件
    vendor('PHPMailer.SMTP');
    $mail = new PHPMailer(); //PHPMailer对象 \Vendor\PHPMailer\

    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码

    $mail->IsSMTP(); // 设定使用SMTP服务

    $mail->SMTPDebug = 0; // 关闭SMTP调试功能

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
/**
 * 智能判断输出格式 ajax 输出或 错误或成功跳转
 * @param String $info 提示信息
 * @param mixed $data 要返回的数据
 * @param boolean $status 返回状态
 * @return void
 */
function out($info='',$data = '', $jumpUrl = null) {
    $ajax = IS_AJAX;
    $_ajax = I('is_ajax', '');
    if ($ajax || $_ajax) {
        $data = array('info' => $info, 'data' => $data);
        exit(json_encode($data));
        return true;
    }
    $msg = $data;
    if ($info == 'ok' || $info == 'success' || $info == 'succ') {
        $this->success($msg, $jumpUrl);
        exit;
    }
    if ($info == 'error' || $info == 'fail') {
        $this->error($msg, $jumpUrl);
        exit;
    }
}

/**
 * 加密，解密函数
 * 从dzx1 中 copy
 * @param $string
 * @param $operation
 * @param $key
 * @param $expiry
 */
function auth_code($string, $operation = 'DECODE', $key = 'mycntvalltosun', $expiry = 36000)
{
    $ckey_length = 4;
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {

            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/* 截取html代码 生成摘要
 * @param (string) $body  // 正文
 * @param (int) $size     // 摘要长度
 * @param (int) $format   // 输入格式 id
 */
function substr_html($body, $size, $format = NULL) {
    $_size = mb_strlen($body, "utf-8");
    if($_size <= $size) return $body;
    // 输入格式中有 PHP 过滤器
    /*if(!isset($format) && filter_is_php($format)){
        return $body;
    } */
    $strlen_var = strlen($body);
    // 不包含 html 标签
    if(strpos($body, '<') === false){
        return mb_substr($body, 0, $size);
    }
    // 包含截断标志，优先
    if($e = strpos($body, '<!-- break -->')){
        return mb_substr($body, 0, $e);
    }
    // html 代码标记
    $html_tag = 0;
    // 摘要字符串
    $summary_string = '';
    /**
     * 数组用作记录摘要范围内出现的 html 标签
     * 开始和结束分别保存在 left 和 right 键名下
     * 如字符串为：<h3><p><b>a</b></h3>，假设 p 未闭合
     * 数组则为：array('left' => array('h3', 'p', 'b'), 'right' => 'b', 'h3');
     * 仅补全 html 标签，<? <% 等其它语言标记，会产生不可预知结果
     */
    $html_array = array('left' => array(), 'right' => array());
    for($i = 0; $i < $strlen_var; ++$i) {
        if(!$size){
            break;
        }
        $current_var = substr($body, $i, 1);
        if($current_var == '<'){
            // html 代码开始
            $html_tag = 1;
            $html_array_str = '';
        }else if($html_tag == 1) {
            // 一段 html 代码结束
            if($current_var == '>'){
                // 去除首尾空格，如 <br /  > < img src="" / > 等可能出现首尾空格
                $html_array_str = trim($html_array_str);
                // 判断最后一个字符是否为 /，若是，则标签已闭合，不记录
                if(substr($html_array_str, -1) != '/'){
                    // 判断第一个字符是否 /，若是，则放在 right 单元
                    $f = substr($html_array_str, 0, 1);
                    if($f == '/'){
                        // 去掉 /
                        $html_array['right'][] = str_replace('/', '', $html_array_str);
                    }else if($f != '?'){
                        // 判断是否为 ?，若是，则为 PHP 代码，跳过
                        // 判断是否有半角空格，若有，以空格分割，第一个单元为 html 标签
                        // 如 <h2 class="a"> <p class="a">
                        if(strpos($html_array_str, ' ') !== false){
                            // 分割成2个单元，可能有多个空格，如：<h2 class="" id="">
                            $html_array['left'][] = strtolower(current(explode(' ', $html_array_str, 2)));
                        }else{
                            // 若没有空格，整个字符串为 html 标签，如：<b> <p> 等
                            // 统一转换为小写
                            $html_array['left'][] = strtolower($html_array_str);
                        }
                    }
                }
                // 字符串重置
                $html_array_str = '';
                $html_tag = 0;
            }else{
                // 将< >之间的字符组成一个字符串,用于提取 html 标签
                $html_array_str .= $current_var;
            }
        }else{
            // 非 html 代码才记数
            --$size;
        }

        $ord_var_c = ord($body{$i});
        switch (true) {
            case (($ord_var_c & 0xE0) == 0xC0):
                // 2 字节
                $summary_string .= substr($body, $i, 2);
                $i += 1;
                break;
            case (($ord_var_c & 0xF0) == 0xE0):
                // 3 字节
                $summary_string .= substr($body, $i, 3);
                $i += 2;
                break;
            case (($ord_var_c & 0xF8) == 0xF0):
                // 4 字节
                $summary_string .= substr($body, $i, 4);
                $i += 3;
                break;
            case (($ord_var_c & 0xFC) == 0xF8):
                // 5 字节
                $summary_string .= substr($body, $i, 5);
                $i += 4;
                break;
            case (($ord_var_c & 0xFE) == 0xFC):
                // 6 字节
                $summary_string .= substr($body, $i, 6);
                $i += 5;
                break;
            default:
                // 1 字节
                $summary_string .= $current_var;
        }
    }

    if($html_array['left']){
        // 比对左右 html 标签，不足则补全
        /**
         * 交换 left 顺序，补充的顺序应与 html 出现的顺序相反
         * 如待补全的字符串为：<h2>abc<b>abc<p>abc
         * 补充顺序应为：</p></b></h2>
         */
        $html_array['left'] = array_reverse($html_array['left']);

        foreach($html_array['left'] as $index => $tag){
            // 判断该标签是否出现在 right 中
            $key = array_search($tag, $html_array['right']);
            if($key !== false){
                // 出现，从 right 中删除该单元
                unset($html_array['right'][$key]);
            }else{
                // 没有出现，需要补全
                $summary_string .= '</'.$tag.'>';
            }
        }
    }
    return $summary_string;
}

function rand_int($len = 4){
    $chars = array(
        "1", "2", "3", "4", "5", "6", "7", "8", "9"
    );
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = "";
    for ($i=0; $i<$len; $i++)
    {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return auth_code($output,"11");
}

