<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/03/2018
 * Time: 17:45
 */

namespace Admin\Controller;
use Think\Controller;

class ForgerController extends Controller {
    /**
     * 找回密码
     */
    public function forger()
    {
        // 判断提交方式 做不同处理
        if (IS_POST) {
            // 实例化User对象
            $user = D('users');

            // 自动验证 创建数据集
            if (!$data = $user->create()) {
                $this->error($user->getError());
            }
exit();
            //插入数据库
            if ($id = $user->add($data)) {
                /* 直接注册用户为超级管理员,子用户采用邀请注册的模式,
                   遂设置公司id等于注册用户id,便于管理公司用户*/
                $user->where("userid = $id")->setField('companyid', $id);
                $this->success('注册成功', U('Index/index'), 2);
            } else {
                $this->error('注册失败');
            }
        } else {
            $this->display();
        }
    }
    public function sendMail(){

            if(IS_POST){
                // 实例化user对象
                $user = D('sendMail');


                // 自动验证 创建数据集
                if (!$data = $user->create()) {
                    $this->error($user->getError());
                }

                // 组合查询条件
                $where = array();
                $where['username'] = $data['username'];

                $result = $user->where($where)->field('userid,username,nickname,email')->find();


                // 验证用户名 对比 邮箱
                if (!$result && $result['email'] != $data['email']) {
                    $this->error('用户名和邮箱不匹配');
                }

                $str ="<div class='header' style='background-color: rgb(117, 212, 183); padding: 10px;'><span class='logo'><img src='__PUBLIC__/Image/logo.png' style='width: 150px;'></span></div><div style='font-size: 14px;padding: 2em;'><br><br>        您好  ".$data['username'].",<br><br><p>您的验证码为：</p><h3 style='font-size: 60px; color: #f00; font-weight: bold;'>".auth_code($data['verify'])."</h3><p>该验证邮件有效期为30分钟，超时请重新发送邮件。</p></div><div style='font-size: 14px; padding: 2em;'>        Regards<br>        Your Sticker Team<br>        ------------------------------------<br><a href=''>www.sticker.com</a><br><div style='color: #999;'><p>发件时间：<span id='stickerTimer' style='border-bottom: 1px dashed rgb(204, 204, 204); position: relative;'  times='".date("G").":".date("i")."' isout='0'>".date("Y")."/".date("m")."/".date("d")."</span>  ".date("G").":".date("i").":".date("s")."</p><p>此邮件为系统自动发出的，请勿直接回复。</p></div></div>";

                // 实例化mail_verify对象
                $mail_verify = M('mail_verify');
                $is_verify = $mail_verify->where($data['name'])->field('time,id')->find();
                if($is_verify){
                    if((time() - $is_verify['time']) < 60){
                        $this->error("您的验证码已经发送。请耐心等待，如果没有收到60s可重发");
                    }else{
                        $mail_verify->where($is_verify['id'])->save($data);
                        send_mail($data['email'],$data['username'],'Sticker-找回密码验证码',$str);
                        $this->success('发送成功，请注意查看邮箱');
                    }
                }

                $data = array_merge($data,$result);

                if ($id = $mail_verify->add($data)) {
                    send_mail($data['email'],$data['username'],'Sticker-找回密码验证码',$str);
                    $this->success('发送成功，请注意查看邮箱');
                } else {
                    $this->error('发送失败');
                }

            }



        }
    public function test(){

    }

}
