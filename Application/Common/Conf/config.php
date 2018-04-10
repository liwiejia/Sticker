<?php
$config_all =  array(


    //'配置项'=>'配置值'

    //url访问模式为rewrite模式
    'URL_MODEL'=>'2',




    // 允许访问的模块列表
    'MODULE_ALLOW_LIST'    =>    array('Admin','Index','Home',),
    'DEFAULT_MODULE'       =>    'Index',

    'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息

    //定义命名空间
     'AUTOLOAD_NAMESPACE' => array(
         'Workernam'     => APP_PATH.'workerman',
     ),

    'THINK_EMAIL' => array(
        'SMTP_HOST'   => 'smtp.126.com', //SMTP服务器
        'SMTP_PORT'   => '25', //SMTP服务器端口
        'SMTP_USER'   => 'liweijia0511@126.com', //SMTP服务器用户名
        'SMTP_PASS'   => 'AISHI0405', //SMTP服务器密码
        'FROM_EMAIL'  => 'liweijia0511@126.com', //发件人EMAIL
        'FROM_NAME'   => 'Sticker', //发件人名称
        'REPLY_EMAIL' => 'liweijia0511@126.com', //回复EMAIL（留空则为发件人EMAIL）
        'REPLY_NAME'  => 'Sticker', //回复名称（留空则为发件人名称）
    ),


    // 添加数据库配置信息
    'DB_PREFIX' => '', // 数据库表前缀
    //'DB_DSN' => 'mysql://root:root@localhost:3306/sticker',//数据库类型://用户名:密码@数据库地址:数据库端口/数据库名



    //修改定界符
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',

    'LANG_SWITCH_ON' => true,   // 开启语言包功能
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST'        => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量


    /* 加载扩展配置文件 */
    'LOAD_EXT_CONFIG' => 'sdk_config',


);

switch ($_SERVER['SERVER_NAME']) {
    case 'localhost':
        $env = 'dev';
        break;

    default:
        $env = 'dev';
        break;
}
$config_env = require $env.'_config.php';

return array_merge($config_all, $config_env);
?>