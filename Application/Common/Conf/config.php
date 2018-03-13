<?php
return array(
    //'配置项'=>'配置值'
    // 允许访问的模块列表
    'MODULE_ALLOW_LIST'    =>    array('Admin','Index','Home',),
    'DEFAULT_MODULE'       =>    'Index',

    'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息

    // 添加数据库配置信息
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_DSN' => 'mysql://root:root@localhost:3306/sticker',//数据库类型://用户名:密码@数据库地址:数据库端口/数据库名
    //修改定界符
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',

);
?>