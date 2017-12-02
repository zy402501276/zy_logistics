<?php
// +----------------------------------------------------------------------
// | Count.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.tool.pub All rights reserved.
// +----------------------------------------------------------------------
// | Author: shigin <597852546@qq.com> <http://do.org.cn>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
import("Common.Common.constant", APP_PATH, '.php');

/**
 * 基础控制器
 */
class BaseController extends Controller 
{
	// 空白模型对象
    private static $model_ = NULL;

    /**
     * 引用对象[redis]
     * @var $model
     */
    protected $redis       = NULL;
    
    /* 初始化 */
    protected function _initialize() 
    {   
        // ###设置json输出header头
        header("Access-Control-Allow-Origin: *"); 
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Access-Token, x-token");

        // 实例空模型
        if (self::$model_ === NULL) {
            self::$model_ = M();
    	}
    }


    //----------------------------------
    // 事务
    //----------------------------------
    /**
     * 开启事务
     * @author shigin <597852546@qq.com>
     */
    protected function startTrans() 
    {
        // 开启事务
        self::$model_->startTrans();
    }

    /**
     * 结束事务
     * @author shigin <597852546@qq.com>
     */
    protected function endTrans($status) 
    {
        // 判断操作成功
        if ($status) {
            // 提交事务
            self::$model_->commit(); 
        } else {
            // 回滚事务
            self::$model_->rollback(); 
        }
    }


    //----------------------------------
    // 页面输出
    //----------------------------------
    /**
     * 发送响应数据[JSON]
     * @param enum $status 状态
     * @param string $message 消息
     * @param string $key1 键1
     * @param object $value1 值1
     * @param string $key2 键2
     * @param object $value2 值2
     * @param string $key3 键3
     * @param object $value3 值3
     * @return 
     * @author shigin <597852546@qq.com>
     */
    protected function responseJson($status, $message, $key1=NULL, $value1=NULL, $key2=NULL, $value2=NULL, $key3=NULL, $value3=NULL) 
    {
        // ###输出结果
        // 设置错误报告级别
        error_reporting(E_ALL|E_STRICT);
        // 输出至页面
        $data = ['status' => $status, 'message'=>$message];

        if ($key1 !== NULL) {
            $data[$key1] = $value1;
        }
        if ($key2 !== NULL) {
            $data[$key2] = $value2;
        }
        if ($key3 !== NULL) {
            $data[$key3] = $value3;
        }
        try {
            $this->ajaxReturn($data, 'JSON');
        } catch(Exception $oExp) {
            $this->ajaxReturn(array('status' => STATUS_ERROR, 'message'=>($oExp)), 'JSON');
        }
    }

    /**
     * 发送响应数据[JSON][错误]
     * @param string $message 消息
     * @param string $redirect 跳转网页
     * @return 
     * @author shigin <597852546@qq.com>
     */
    protected function responseJsonError($message, $redirect=NULL) 
    {
        $status = STATUS_ERROR;
        $this->responseJson($status, $message, 'redirect', $redirect);
        exit(0);
    }



    //----------------------------------
    // 文件操作
    //----------------------------------
    /**
     * 创建目录
     * @param  string $path 要创建的目录
     * @return boolean 创建状态，true-成功，false-失败
     * @author shigin <597852546@qq.com>
     */
    protected function mkdir($path) {
        $dir = ROOT_PATH . $path;
        if (is_dir($dir)) {
            return true;
        }

        if (mkdir($dir, 0777, true)) {
            return true;
        } else {
            $this->error = "目录 {$path} 创建失败！";
            return false;
        }
    }

    /**
     * 判断文件是否存在
     * @param  string $path 文件路径
     * @return bool y/n
     * @author shigin <597852546@qq.com>
     */
    protected function existsFile($path) {
        return file_exists($path);
    }

    /**
     * 写入文件
     * @param string $path 文件路径
     * @param string $data 文件内容
     * @return 
     * @author shigin <597852546@qq.com>
     */
    protected function writeFile($path, $data) {
        $file = fopen($path, "w") or die("Unable to open file!");
        fwrite($file, $data);
        fclose($file);
    }

    /**
     * 读取文件
     * @param string $path 文件路径
     * @return string 文件内容
     * @author shigin <597852546@qq.com>
     */
    protected function readFile($path) {
        // 读取二进制文件时，需要将第二个参数设置成'rb'
        $handle = fopen($path, "r");
        
        // 通过filesize获得文件大小，将整个文件一下子读到一个字符串中
        $result = fread($handle, filesize($path));
        fclose($handle);

        return $result;
    }

    /**
     * 删除文件
     * @param string $path 文件路径
     * @return bool y/n
     * @author shigin <597852546@qq.com>
     */
    protected function deleteFile($path){
        return @unlink($path); 
    }

    /**
    * 生成随机文件名
    * @param int $length 输出长度
    * @param string $chars 可选的 ，默认为 0123456789
    * @return string 字符串
    */
    function randomFileName($length, $chars='123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ') {
        $result = '';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $result .= $chars[mt_rand(0, $max)];
        }
        return $result;
    }


    /**
     * 根据mime类型获取文件后缀
     * @param   string      mime类型
     * @return  string $ext 文件后缀
     */
    protected function getFileMimeType($mime) {
        static $type_mimes = array (
            'application/vnd.android.package-archive' => 'apk',
            'video/3gpp'                        =>  '3gp', 
            'application/postscript'            =>  'ai', 
            'audio/x-aiff'                      =>  'aif', 
            'audio/x-aiff'                      =>  'aifc', 
            'audio/x-aiff'                      =>  'aiff', 
            'text/plain'                        =>  'asc', 
            'application/atom+xml'              =>  'atom', 
            'audio/basic'                       =>  'au', 
            'video/x-msvideo'                   =>  'avi', 
            'application/x-bcpio'               =>  'bcpio', 
            'application/octet-stream'          =>  'bin', 
            'image/bmp'                         =>  'bmp', 
            'application/x-netcdf'              =>  'cdf', 
            'image/cgm'                         =>  'cgm', 
            'application/octet-stream'          =>  'class', 
            'application/x-cpio'                =>  'cpio', 
            'application/mac-compactpro'        =>  'cpt', 
            'application/x-csh'                 =>  'csh', 
            'text/css'                          =>  'css', 
            'application/x-director'            =>  'dcr', 
            'video/x-dv'                        =>  'dif', 
            'application/x-director'            =>  'dir', 
            'image/vnd.djvu'                    =>  'djv', 
            'image/vnd.djvu'                    =>  'djvu', 
            'application/octet-stream'          =>  'dll', 
            'application/octet-stream'          =>  'dmg', 
            'application/octet-stream'          =>  'dms', 
            'application/msword'                =>  'doc', 
            'application/xml-dtd'               =>  'dtd', 
            'video/x-dv'                        =>  'dv', 
            'application/x-dvi'                 =>  'dvi', 
            'application/x-director'            =>  'dxr', 
            'application/postscript'            =>  'eps', 
            'text/x-setext'                     =>  'etx', 
            'application/octet-stream'          =>  'exe', 
            'application/andrew-inset'          =>  'ez', 
            'video/x-flv'                       =>  'flv', 
            'image/gif'                         =>  'gif', 
            'application/srgs'                  =>  'gram', 
            'application/srgs+xml'              =>  'grxml', 
            'application/x-gtar'                =>  'gtar', 
            'application/x-gzip'                =>  'gz', 
            'application/x-hdf'                 =>  'hdf', 
            'application/mac-binhex40'          =>  'hqx', 
            'text/html'                         =>  'htm', 
            'text/html'                         =>  'html', 
            'x-conference/x-cooltalk'           =>  'ice', 
            'image/x-icon'                      =>  'ico', 
            'text/calendar'                     =>  'ics', 
            'image/ief'                         =>  'ief', 
            'text/calendar'                     =>  'ifb', 
            'model/iges'                        =>  'iges', 
            'model/iges'                        =>  'igs', 
            'application/x-java-jnlp-file'      =>  'jnlp', 
            'image/jp2'                         =>  'jp2', 
            'image/jpeg'                        =>  'jpe', 
            'image/jpeg'                        =>  'jpeg', 
            'image/jpeg'                        =>  'jpg', 
            'application/x-javascript'          =>  'js', 
            'audio/midi'                        =>  'kar', 
            'application/x-latex'               =>  'latex', 
            'application/octet-stream'          =>  'lha', 
            'application/octet-stream'          =>  'lzh', 
            'audio/x-mpegurl'                   =>  'm3u', 
            'audio/mp4a-latm'                   =>  'm4a', 
            'audio/mp4a-latm'                   =>  'm4p', 
            'video/vnd.mpegurl'                 =>  'm4u', 
            'video/x-m4v'                       =>  'm4v', 
            'image/x-macpaint'                  =>  'mac', 
            'application/x-troff-man'           =>  'man', 
            'application/mathml+xml'            =>  'mathml', 
            'application/x-troff-me'            =>  'me', 
            'model/mesh'                        =>  'mesh', 
            'audio/midi'                        =>  'mid', 
            'audio/midi'                        =>  'midi', 
            'application/vnd.mif'               =>  'mif', 
            'video/quicktime'                   =>  'mov', 
            'video/x-sgi-movie'                 =>  'movie', 
            'audio/mpeg'                        =>  'mp2', 
            'audio/mpeg'                        =>  'mp3', 
            'video/mp4'                         =>  'mp4', 
            'video/mpeg'                        =>  'mpe', 
            'video/mpeg'                        =>  'mpeg', 
            'video/mpeg'                        =>  'mpg', 
            'audio/mpeg'                        =>  'mpga', 
            'application/x-troff-ms'            =>  'ms', 
            'model/mesh'                        =>  'msh', 
            'video/vnd.mpegurl'                 =>  'mxu', 
            'application/x-netcdf'              =>  'nc', 
            'application/oda'                   =>  'oda', 
            'application/ogg'                   =>  'ogg', 
            'video/ogv'                         =>  'ogv', 
            'image/x-portable-bitmap'           =>  'pbm', 
            'image/pict'                        =>  'pct', 
            'chemical/x-pdb'                    =>  'pdb', 
            'application/pdf'                   =>  'pdf', 
            'image/x-portable-graymap'          =>  'pgm', 
            'application/x-chess-pgn'           =>  'pgn', 
            'image/pict'                        =>  'pic', 
            'image/pict'                        =>  'pict', 
            'image/png'                         =>  'png', 
            'image/x-portable-anymap'           =>  'pnm', 
            'image/x-macpaint'                  =>  'pnt', 
            'image/x-macpaint'                  =>  'pntg', 
            'image/x-portable-pixmap'           =>  'ppm', 
            'application/vnd.ms-powerpoint'     =>  'ppt', 
            'application/postscript'            =>  'ps', 
            'video/quicktime'                   =>  'qt', 
            'image/x-quicktime'                 =>  'qti', 
            'image/x-quicktime'                 =>  'qtif', 
            'audio/x-pn-realaudio'              =>  'ra', 
            'audio/x-pn-realaudio'              =>  'ram', 
            'image/x-cmu-raster'                =>  'ras', 
            'application/rdf+xml'               =>  'rdf', 
            'image/x-rgb'                       =>  'rgb', 
            'application/vnd.rn-realmedia'      =>  'rm', 
            'application/x-troff'               =>  'roff', 
            'text/rtf'                          =>  'rtf', 
            'text/richtext'                     =>  'rtx', 
            'text/sgml'                         =>  'sgm', 
            'text/sgml'                         =>  'sgml', 
            'application/x-sh'                  =>  'sh', 
            'application/x-shar'                =>  'shar', 
            'model/mesh'                        =>  'silo', 
            'application/x-stuffit'             =>  'sit', 
            'application/x-koan'                =>  'skd', 
            'application/x-koan'                =>  'skm', 
            'application/x-koan'                =>  'skp', 
            'application/x-koan'                =>  'skt', 
            'application/smil'                  =>  'smi', 
            'application/smil'                  =>  'smil', 
            'audio/basic'                       =>  'snd', 
            'application/octet-stream'          =>  'so', 
            'application/x-futuresplash'        =>  'spl', 
            'application/x-wais-source'         =>  'src', 
            'application/x-sv4cpio'             =>  'sv4cpio', 
            'application/x-sv4crc'              =>  'sv4crc', 
            'image/svg+xml'                     =>  'svg', 
            'application/x-shockwave-flash'     =>  'swf', 
            'application/x-troff'               =>  't', 
            'application/x-tar'                 =>  'tar', 
            'application/x-tcl'                 =>  'tcl', 
            'application/x-tex'                 =>  'tex', 
            'application/x-texinfo'             =>  'texi', 
            'application/x-texinfo'             =>  'texinfo', 
            'image/tiff'                        =>  'tif', 
            'image/tiff'                        =>  'tiff', 
            'application/x-troff'               =>  'tr', 
            'text/tab-separated-values'         =>  'tsv', 
            'text/plain'                        =>  'txt', 
            'application/x-ustar'               =>  'ustar', 
            'application/x-cdlink'              =>  'vcd', 
            'model/vrml'                        =>  'vrml', 
            'application/voicexml+xml'          =>  'vxml', 
            'audio/x-wav'                       =>  'wav', 
            'image/vnd.wap.wbmp'                =>  'wbmp', 
            'application/vnd.wap.wbxml'         =>  'wbxml', 
            'video/webm'                        =>  'webm', 
            'text/vnd.wap.wml'                  =>  'wml', 
            'application/vnd.wap.wmlc'          =>  'wmlc', 
            'text/vnd.wap.wmlscript'            =>  'wmls', 
            'application/vnd.wap.wmlscriptc'    =>  'wmlsc', 
            'video/x-ms-wmv'                    =>  'wmv', 
            'model/vrml'                        =>  'wrl', 
            'image/x-xbitmap'                   =>  'xbm', 
            'application/xhtml+xml'             =>  'xht', 
            'application/xhtml+xml'             =>  'xhtml', 
            'application/vnd.ms-excel'          =>  'xls',
            'application/octet-stream'          =>  'xls',
            'application/xml'                   =>  'xml', 
            'image/x-xpixmap'                   =>  'xpm', 
            'application/xml'                   =>  'xsl', 
            'application/xslt+xml'              =>  'xslt', 
            'application/vnd.mozilla.xul+xml'   =>  'xul', 
            'image/x-xwindowdump'               =>  'xwd', 
            'chemical/x-xyz'                    =>  'xyz', 
            'application/zip'                   =>  'zip',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        );
        
        return isset($type_mimes[$mime]) ? $type_mimes[$mime] : 'unknown';
    }



    /**
     * 随机字符
     * @param number $length 长度
     * @param string $type 类型
     * @param number $convert 转换大小写
     * @return string
     */
    function getRandom($length = 6, $type = 'string', $convert = true)
    {
        $config = [
            'number' => '1234567890',
            'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
            'all'    => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ];
        
        if(!isset($config[$type])) $type = 'string';
        $string = $config[$type];
        
        $code   = '';
        $strlen = strlen($string) -1;
        for( $i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        if ($convert) {
            $code = strtolower($code);
        }
        return $code;
    }

    

    //----------------------------------
    // Excel导出
    //----------------------------------
    protected function exportExcel($data=array(), $title=array(), $filename='report') 
    {
        // 输出HTML头部
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        // 输出标题行
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }

        // 输出数据行
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);

            }
            echo implode("\n", $data);
        }
    }

}