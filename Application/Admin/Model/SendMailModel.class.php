<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23/03/2018
 * Time: 16:44
 */

namespace Admin\Model;
use Think\Model;

class SendMailModel extends Model {
    /**
     * 自动验证
     * self::EXISTS_VALIDATE 或者0 存在字段就验证（默认）
     * self::MUST_VALIDATE 或者1 必须验证
     * self::VALUE_VALIDATE或者2 值不为空的时候验证
     */
    protected $tableName = 'users';

    protected $_validate = array(
        array('username', 'require', '用户名不能为空！'), //默认情况下用正则进行验证prqs
        array('email', 'require', '邮箱不能为空！'), // 默认情况下用正则进行验证
        //array('verify', 'verify_check', '验证码错误', 0, 'function'), // 判断验证码是否正确
    );

    /**
     * 自动完成
     */
    protected $_auto = array (
        /* 登录的时候自动完成 */
        array('verify', 'rand_int', 1, 'function') , // 对password字段使用md5函数处理
        array('time', 'time', 1, 'function'), // 对lastdate字段在登录的时候写入当前时间戳
        array('ip', 'get_client_ip', 1, 'function'), // 对lastip字段在登录的时候写入当前登录ip地址
    );

}