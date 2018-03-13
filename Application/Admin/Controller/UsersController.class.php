<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/03/2018
 * Time: 17:31
 */

namespace Admin\Controller;
use Think\Controller;

/**
 * Class UsersController
 * @package Home\Controller
 */
class UsersController extends Controller {
    /**
     * get users list
     */
    public function userlist()
    {
        $list = M('users')->where(array('userid' => $this->userid))->find();

        var_dump($list);
    }
}