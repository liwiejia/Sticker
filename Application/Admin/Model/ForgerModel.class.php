<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23/03/2018
 * Time: 16:44
 */

namespace Admin\Model;
use Think\Model;


class ForgerModel extends Model {
    /**
     * 自动验证
     * self::EXISTS_VALIDATE 或者0 存在字段就验证（默认）
     * self::MUST_VALIDATE 或者1 必须验证
     * self::VALUE_VALIDATE或者2 值不为空的时候验证
     */
    //protected $tableName = 'mail_verify';
    protected $tableName = 'users';
    protected $_validate = array(

        array('username', 'require', '用户名不能为空！'), //默认情况下用正则进行验证
        array('email', 'require', '邮箱不能为空！'), // 默认情况下用正则进行验证
        array('password', 'require', '密码不能为空！'), // 默认情况下用正则进行验证
        array('password', '/^([a-zA-Z0-9@*#]{6,22})$/', '密码格式不正确,请重新输入！', 0),
        array('email', 'email', '邮箱格式不正确'), // 内置正则验证邮箱格式
        array('repassword', 'password', '确认密码不正确', 0, 'confirm'), // 验证确认密码是否和密码一致
        array('verify', 'verify_check', '验证码错误', 0, 'function'), // 判断验证码是否正确
        array('mailVerify', '/^([0-9]{4})$/', '邮箱验证码格式不正确！',  'function'), // 判断验证码是否正确
    );

    /**
     * 自动完成
     */
    protected $_auto = array (
        /* 登录的时候自动完成 */
        array('password', 'md5', 3, 'function') , // 对password字段使用md5函数处理
        array('lastdate', 'time', 1, 'function'), // 对lastdate字段在登录的时候写入当前时间戳
        array('lastip', 'get_client_ip', 1, 'function'), // 对lastip字段在登录的时候写入当前登录ip地址
    );

}
