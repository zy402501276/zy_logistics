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
       // $tranSaction = D()->startTrans();
        try{
            $user = D('User');
            $data['account'] = '小野君3';
            $data['userName'] = '18649717819';
            $data['pwd'] = 'zhangye';

            if($user->create($data,1)){
                $user->add($data);
            }else{
                throw new Exception($user->getError());
            }
            $tranSaction->commit();
            return ['state' => 1 ,'message'=>'修改成功'];
        }catch (Exception $e){
           // $tranSaction->rollBack();
            return ['state' => 0 ,'message'=>$e->getMessage()];
        }
    }
}