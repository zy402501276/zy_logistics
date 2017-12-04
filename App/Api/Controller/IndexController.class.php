<?php
namespace Api\Controller;
use Think\Controller;

/**
 * 帮助类
 * @author zhangy
 */
class IndexController extends Controller {
    /**
     * 文件上传规则
     * @time 2017年12月1日16:46:35
     */
    public function uploadFile(){
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728 ; //文件上传的最大文件大小（以字节为单位），0为不限大小
        $upload->exts = array('jpg','png','jpeg');//设置附件上传类型
        $upload->rootPath ='../../Upload/';//文件上传根目录1
        $upload->savePath = '';
        $upload->saveName = uniqid();
        $upload->subName  = array('date','Ymd');
        $info   =   $upload->upload($_FILES);
        if(!$info) {// 上传错误提示错误信息
            $error = $this->error($upload->getError());
            output(-1, '', $error);
        }else{// 上传成功 获取上传文件信息
            foreach($info as $file){
                $result ="./Upload/".$file['savepath'].$file['savename'];
                output(0,$result);
            }
        }

    }
}