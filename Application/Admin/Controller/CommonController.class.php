<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/03/2018
 * Time: 17:27
 */

namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {
    /* 定义用户id */
    public static $userid = '';

    /**
     * 自动执行
     */
    public function _initialize()
    {
        // 判断用户是否登录
        if (session('uid')) {
            $this->userid = session('uid');
        } else {
            $this->error('对不起,您还没有登录,正跳转至登录面...', U('Login/login'));
        }
    }


}