<?php
/**
 * 用户模块服务层
 * @time 2017年12月2日14:59:44
 * @author zhangye
 */
namespace Api\Service;
use Pheanstalk\Exception;
use Think\Model;
class UserService extends Model{

    /**
     * 用户注册
     * @author: zy
     * @param $post array 原始数据
     * @return array
     */
    public function register($post){
        try{
            $user = D('User');
           // $data['account'] = trim($post['account']);
            $data['userName'] = trim($post['username']);
            $data['pwd'] = trim($post['password']);
            $data['role'] = isset($post['role'])?$post['role']:0;
//            $data['email'] = trim(isset($post['email']));
//            $data['mobile'] = trim(isset($post['mobile']));
            $result = $user->userValidate($data);
            if($result['state']){
                $data['pwd'] = md5($post['pwd'].$user::PWD_KEY);
                $data['state'] = $user::STATE_ON;
                $data['createTime'] = $data['updateTime'] = time();
                $user->add($data);
                return ['state'=>true,'message'=>'注册成功'];
            }else{
                //throw new Exception($result['message']);
                return ['state'=>false,'message'=>$result['msg']];
            }
        }catch (Exception $e){
            return ['state' => false ,'message'=>$e->getMessage()];
        }
    }
}