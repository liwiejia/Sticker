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
            $mail_verify = I('mailVerify');

            // 实例化user对象
            $info = D('forger');

            // 自动验证 创建数据集
            if (!$data = $info->create()) {
                $this->error($info->getError());
            }
            $where = array();
            $where['username'] = $data['username'];
            $where['email'] = $data['email'];
            $verify_table = M('mail_verify');
            $result = $verify_table->where($where)->find();


            if(empty($result)){
                $this->error("未查询到该账号更改密码的记录，请重新发送邮箱验证码");
            }else{

                if(auth_code($result['verify']) != $mail_verify){

                    $this->error("邮箱验证码不正确");
                }
                if((time() - $result['time']) > 60*30){
                    $this->error("验证码过期，请重新发送");
                }
            }
            $result = $info->where("username='".$data['username']."'")->setField($data);;
            if($result) {
                $verify_table->delete($result['id']);
                $this->success('修改成功！');
            }else{
                $this->error('网络错误请稍候重试！');
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
