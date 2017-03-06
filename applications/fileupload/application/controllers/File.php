<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 公共文件上传服务接口
 * 
 * @author jianming@gz-zc.cn
 *
 */
class File extends MY_Controller{

    public function __construct(){
            parent::__construct();
            //ajax 文件上传判断来源请求 设置跨域
            $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
            $allow_origin =  array_column(array_reverse($this->data['domain']),  'url');
            if(in_array($origin, $allow_origin)){
                header('Access-Control-Allow-Origin:'.$origin);
                header('Access-Control-Allow-Credentials:true');
                header('Access-Control-Allow-Headers: Content-Type,Accept,X-Requested-With,X_Requested_With');  
            }
            
            $this->avatar_config = C('avatar');
    }

    
    
    /**
     * 指定上传文件的服务器端程序
     */
    public function upload_php(){
        $file_dir = $this->input->post('type') == 'image' ? 'image/' : 'video/';
        $config = array(
            'upload_path'   => '../../uploads/'.$file_dir,
            'allowed_types' => 'gif|jpg|jpeg|png|bmp|swf|flv|doc|docx|xls|xlsx|ppt|mp4',
//             'max_size'     => 1024*20,
            'encrypt_name' => TRUE,
            'remove_spaces'=> TRUE,
            'use_time_dir'  => TRUE,      //是否按上传时间分目录存放
            'time_method_by_day'=> TRUE, //分目录存放的方式：按天
        );
        if($file_dir == 'video/'){
            $config['max_size'] = 1024*50;
        }else{
            $config['max_size'] = 1024*5;
        }
        
        $this->load->library('upload', $config);
         
        if ( ! $this->upload->do_upload('Filedata')){
            $error = $this->upload->display_errors();
            echo json_encode(array('error' => 1, 'message' => '上传错误！'.$error));
        } else {
            $data = $this->upload->data();
            echo json_encode(array('error' => 0, 'url' => $data['file_name'],'full_url' => $this->data['domain']['img']['url'].'/'.$file_dir.'/'.$data['file_name']));
        }
        exit();
    }
    
    
    
    /**
     * 处理nginx upload module上传成功后返回的文件数据
     * 
     * @author jianming@gz-zc.cn
     */
    public function upload(){
            $file_path = $_POST['file_path'];
        	if (is_file($file_path)) 
        	{
        	    $file_dir = $this->input->post('type');
        	    $is_editor = $this->input->post('source') == 'editor' ? true : false;
    			//上传的文件夹
    			$folder =  C('upload.folder');
    			
    			if (! in_array($file_dir, $folder)) {
    			    if($is_editor) {
    			        die('error|上传参数错误');
    			    }
    				$this->return_json(array('error' => 1, 'message' => "上传参数错误！"));
    			}
    
        		//允许上传的文件扩展名字典
    			$ext_arr =  array_merge(C('upload.ext.img') ,C('upload.ext.other'), C('upload.ext.video'));
    			
    			//获得文件扩展名
    			$temp_arr = explode(".", $_POST['file_name']);
    			$file_ext = strtolower(trim(array_pop($temp_arr)));
    
    			//如果扩展名不在允许上传的扩展名内，则从服务器删掉该文件
    			if (!in_array('.'.$file_ext, $ext_arr)) {
    				unlink($file_path);
    				$is_editor && die('error|不允许上传的文件类型');
    				$this->return_json(array('error' => 1, 'message' => "不允许上传的文件类型！"));
    			}
    			
    			//如果文件超过限制大小，则从服务器删除该文件
    			if($file_dir == 'image'){
    			    $max_size = 1024 * 1024 * 2;
    			}else if($file_dir == 'video'){
    			    $max_size = 1024 * 1024 * 50;
    			}
    			if($max_size < $this->input->post('file_size')){
    			    unlink($file_path);
    			    $is_editor && die('error|文件大小超过限制');
    			    $this->return_json(array('error' => 1, 'message' => '文件大小超过限制'));
    			}
    
    			$src = $file_path;
    			
    			$date = date('Ymd');
    			$dir = C('upload.upload_dir').'/'.$file_dir.'/'.$date;
    			//如果目录不存在，则创建目录
    			if (!is_dir($dir))
    			{
    			    mkdir($dir, 0777);
    			}
    			
			    //新的文件名
			    $new_file_name = md5(date("YmdHis").rand(10000, 99999)).'.'.$file_ext;
			    
			    $result = rename($file_path, $dir.'/'.$new_file_name);                                       //把nginx上传的文件移动到自定义的目录
			    if ($result == false)
			    {
			        unlink($file_path);
			        $is_editor && die('error|上传失败');
			        $this->return_json(array('error' => 1, 'message' => '上传失败！'));
			    }
			    	
			    $is_editor && die($this->data['domain']['img']['url'].'/'.$file_dir.'/'.$date.'/'.$new_file_name);
			    $this->return_json(array('error' => 0, 'url' => $date.'/'.$new_file_name, 'full_url' => $this->data['domain']['img']['url'].'/'.$file_dir.'/'.$date.'/'.$new_file_name ));
    			}
    			
    			
    		else 
    		{
    			$this->return_json(array('error' => 1, 'message' => '上传失败！'));
    		}
    }
    
    
    
    /**
     * 处理nginx upload module上传成功后返回的文件数据 水印处理
     *
     * @author songchi@gz-zc.cn
     */
    public function upload_shuiyin(){
        $file_path = $_POST['file_path'];
        if (is_file($file_path))
        {
            $file_dir = $this->input->post('type');
            //上传的文件夹
            $folder =  C('upload.folder');
             
            if (! in_array($file_dir, $folder)) {
                $this->return_json(array('error' => 1, 'message' => "上传参数错误！"));
            }
    
            //允许上传的文件扩展名字典
            $ext_arr =  array_merge(C('upload.ext.img') ,C('upload.ext.other'), C('upload.ext.video'));
             
            //获得文件扩展名
            $temp_arr = explode(".", $_POST['file_name']);
            $file_ext = strtolower(trim(array_pop($temp_arr)));
    
            //如果扩展名不在允许上传的扩展名内，则从服务器删掉该文件
            if (!in_array('.'.$file_ext, $ext_arr)) {
                unlink($file_path);
                $this->return_json(array('error' => 1, 'message' => "不允许上传的文件类型！"));
            }
             
            //如果文件超过限制大小，则从服务器删除该文件
            if($file_dir == 'image'){
                $max_size = 1024 * 1024 * 2;
            }else if($file_dir == 'video'){
                $max_size = 1024 * 1024 * 50;
            }
            if($max_size < $this->input->post('file_size')){
                unlink($file_path);
                $this->return_json(array('error' => 1, 'message' => '文件大小超过限制'));
            }
    
            $src = $file_path;
             
            $date = date('Ymd');
            $dir = C('upload.upload_dir').'/'.$file_dir.'/'.$date;
             
            //如果目录不存在，则创建目录
            if (!is_dir($dir))
            {
                mkdir($dir, 0777);
            }
             
            //如果是视频
            if($file_dir == 'image'){
                	
                //新的文件名
                $new_file_name = md5(date("YmdHis").rand(10000, 99999)).'.'.$file_ext;
                	
                $depart = explode('.', $new_file_name);
                $result = rename($file_path, $dir.'/'.$new_file_name);                                       //把nginx上传的文件移动到自定义的目录
                if ($result == false)
                {
                    unlink($file_path);
                    $this->return_json(array('error' => 1, 'message' => '上传失败！'));
                }
                $new_img_path = $this->data['domain']['img']['url'].'/'.$file_dir.'/'.$date.'/'.$new_file_name;
    
                //     			    $new_img_name = $this->resizeimg($new_img_path,600,400,'ys_'.$rand1.'_'.$depart[0], $file_ext); //$file_ext 上面获取的文件后缀名
                $new_file_name_ys = md5(date("YmdHis").rand(10000, 99999));
                $new_img_name = $this->resizeimg($new_img_path,600,400,$new_file_name_ys, $file_ext);
                $new_img_name = rename($new_img_name, $dir.'/'.$new_img_name);
                	
                //水印测试
                $new_file_name_sy = md5(date("YmdHis").rand(10000, 99999));
                $sy_img_url = $this->shuiyin($this->data['domain']['img']['url'].'/image/'.$date.'/'.$new_file_name_ys.'.'.$file_ext, $file_ext, $new_file_name_sy);
                $sy_img_name = rename($sy_img_url, $dir.'/'.$sy_img_url.'.'.$file_ext);
                	
                $this->return_json(array('error' => 0, 'url' => $date.'/'.$new_file_name, 'full_url' => $this->data['domain']['img']['url'].'/'.$file_dir.'/'.$date.'/'.$new_file_name, 'ys_url'=>$date.'/'.$new_file_name_ys.'.'.$file_ext, 'sy_url'=>$date.'/'.$new_file_name_sy.'.'.$file_ext));
                	
            }else{
                //新的文件名
                $new_file_name = md5(date("YmdHis").rand(10000, 99999)).'.'.$file_ext;
                	
                $result = rename($file_path, $dir.'/'.$new_file_name);                                       //把nginx上传的文件移动到自定义的目录
                if ($result == false)
                {
                    unlink($file_path);
                    $this->return_json(array('error' => 1, 'message' => '上传失败！'));
                }
    
                $this->return_json(array('error' => 0, 'url' => $date.'/'.$new_file_name, 'full_url' => $this->data['domain']['img']['url'].'/'.$file_dir.'/'.$date.'/'.$new_file_name ));
            }
             
             
        }
        else
        {
            $this->return_json(array('error' => 1, 'message' => '上传失败！'));
        }
    }
    
    
    

    //图片缩放
    public function resizeimg($im, $maxwidth ,$maxheight, $name, $filetype){
        
        switch ($filetype) {
            case "jpeg" :
                $im = imagecreatefromjpeg($im);
                break;
            case "jpg" :
                $im = imagecreatefromjpeg($im);
                break;
            case "gif" :
                $im = imagecreatefromgif($im);
                break;
            case "wbmp" :
                $im = imagecreatefromwbmp($im);
                break;
            case "png" :
                $im = imagecreatefrompng($im);
                break;
        }
        
        $pic_width = imagesx($im);
        $pic_height = imagesy($im);

        if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
        {
            if($maxwidth && $pic_width>$maxwidth)   //原图宽度大于最大宽度
            {
                $widthratio = $maxwidth/$pic_width;
                $resizewidth_tag = true;
            }
    
            if($maxheight && $pic_height>$maxheight) //原图高度度大于最大高度
            {
                $heightratio = $maxheight/$pic_height;
                $resizeheight_tag = true;
            }
    
            if($resizewidth_tag && $resizeheight_tag)   //如果新图片的宽度和高度都比原图小
            {
                if($widthratio<$heightratio)        //那个比较小就说明它的长度要长，就取哪条，以长边为准缩放保证图片不被压缩
                    $ratio = $widthratio;
                else
                    $ratio = $heightratio;
            }
    
            if($resizewidth_tag && !$resizeheight_tag)
                $ratio = $widthratio;
            if($resizeheight_tag && !$resizewidth_tag)
                $ratio = $heightratio;
    
            $newwidth = $pic_width * $ratio;            //原图的宽度*要缩放的比例
            $newheight = $pic_height * $ratio;          //原图高度*要缩放的比例
            
            //3:1压缩
//             $newwidth = $pic_width * 0.3333;            
//             $newheight = $pic_height * 0.3333;
            
            if(function_exists("imagecopyresampled"))
            {
                $newim = imagecreatetruecolor($newwidth,$newheight);    //生成一张要生成的黑色背景图 ，比例为计算出来的新图片比例
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);  //复制按比例缩放的原图到 ，新的黑色背景中。
            }
            else
            {
                $newim = imagecreate($newwidth,$newheight);
                imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }
    
            $name = $name.'.'.$filetype;
            imagejpeg($newim,$name);
            imagedestroy($newim);
            return $name;
        }
        else
        {
            $newwidth = $pic_width * 1;            //原图的宽度*要缩放的比例
            $newheight = $pic_height * 1;
            if(function_exists("imagecopyresampled"))
            {   
                $newim = imagecreatetruecolor($newwidth,$newheight);    //生成一张要生成的黑色背景图 ，比例为计算出来的新图片比例
              
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);  //复制按比例缩放的原图到 ，新的黑色背景中。
            }
            else
            {
                $newim = imagecreate($newwidth,$newheight);
                imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }
            
            //原图宽和高都比规定的宽高都小
            $name = $name.'.'.$filetype;
            imagejpeg($im,$name);
            return $name;
        }
    }
    
    public function shuiyin($im, $filetype, $name){
        //将图片作为画布
        $ename = getimagesize($im);
        $ename=explode('/',$ename['mime']);
        $ext=$ename[1];
        
        switch ($ext) {
            case "jpeg" :
                $img = imagecreatefromjpeg($im);
                break;
            case "jpg" :
                $img = imagecreatefromjpeg($im);
                break;
            case "gif" :
                $img = imagecreatefromgif($im);
                break;
            case "wbmp" :
                $img = imagecreatefromwbmp($im);
                break;
            case "png" :
                $img = imagecreatefrompng($im);
                break;
        }
        //获取图片宽高
        $pic_width = imagesx($img);
        $pic_height = imagesy($img);
    	//水印图片
    	$sy_img = $this->data['domain']['static']['url'].'/www/images/shuiyin.png';
    	$watermark = imagecreatefrompng($sy_img);
    	//添加水印
    	//左上角
//     	imagecopy($img,$watermark,0,0,0,0,128,35);
    	//右下角
//     	imagecopy($img,$watermark,$pic_width-130,$pic_height-40,0,0,128,35);
    	//居中
    	imagecopy($img,$watermark,($pic_width-130)/2,($pic_height-40)/2,0,0,128,35);
//     	imagecopymerge($img,$watermark,0,0,0,0,128,35,100);
    	
    	imagejpeg($img, $name);

    	return $name;
    	//销毁图像
    	imagedestroy($img);
    }
    
    
    public function shuiyin1($im, $filetype, $name){
        //将图片作为画布
        $ename = getimagesize($im);
        $ename=explode('/',$ename['mime']);
        $ext=$ename[1];
    
        switch ($ext) {
            case "jpeg" :
                $img = imagecreatefromjpeg($im);
                break;
            case "jpg" :
                $img = imagecreatefromjpeg($im);
                break;
            case "gif" :
                $img = imagecreatefromgif($im);
                break;
            case "wbmp" :
                $img = imagecreatefromwbmp($im);
                break;
            case "png" :
                $img = imagecreatefrompng($im);
                break;
        }
        
        
        
        $stamp = imagecreatetruecolor(120, 50);
//         imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
        imagefilledrectangle($stamp, 0, 0, 125, 75, 0xFFFFFF);
        imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
//         $im = imagecreatefromjpeg('photo.jpeg');
        imagestring($stamp, 5, 15, 15, 'bainian.com', 0x0000FF);
        imagestring($stamp, 3, 15, 32, '(c) 2016-7', 0x0000FF);
        
        // 设置水印图像的位置和大小
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        
        // 以 50% 的透明度合并水印和图像
        imagecopymerge($img, $stamp, imagesx($img) - $sx - $marge_right, imagesy($img) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);
        
        // 将图像保存到文件，并释放内存
        $name='sy_'.$name;
        imagejpeg($img, $name);
        return $name;
//         imagepng($img, 'photo_stamp.png');
        imagedestroy($img);
    
    }
    
    
    /**
     * 头像上传
     */
    public function set_portrait(){
        $portrait_config = C('upload.portraint');
        $portrait = upload_file('portrait',  $portrait_config);
        if ($portrait['flag']){
            $save_data['portrait'] = $portrait['data']['file_name'];
            list($width, $height) = getimagesize($this->avatar_config['path']. $save_data['portrait']);
            if ($width > $this->avatar_config['resize']['width'] || $height >$this->avatar_config['resize']['height']){
                //压缩到裁剪框制定大小(600x300)
                $this->load->library('image_lib');
                $config['image_library'] = $this->avatar_config['image_library'];
                $config['quality'] = $this->avatar_config['quality'];
                $config['source_image'] = $this->avatar_config['path']. $save_data['portrait'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] =  $this->avatar_config['resize']['width'];
                $config['height'] = $this->avatar_config['resize']['height'];
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }
            list($width, $height) = getimagesize($this->avatar_config['path']. $save_data['portrait']);
            $this->return_json(array('status'=>0,'width'=> $width,'height'=>$height,'url'=> $this->data['domain']['img']['url'] .'/portrait/'.$portrait['data']['file_name']));
        }else{
            $this->return_json(array('status'=>1,'width'=> 0,'height'=>0,'url'=>'','msg'=>'图片只能是：'.$portrait_config['allowed_types'].'类型,大小不能超过：'.$portrait_config['max_size'].'kb，宽高不能超过:'.$portrait_config['max_width'].'X'.$portrait_config['max_height']));
        }
    }
    
    
    /**
     * 头像裁剪
     */
    public function cut_img(){
        $x = (int) $this->input->post('x');
        $y = (int) $this->input->post('y');
        $w = (int) $this->input->post('w');
        $h = (int) $this->input->post('h');
        $img_url = $this->input->post('img_url');
        if (empty($img_url) || ! $w){
            $this->return_json("参数错误");
        }
    
        $this->load->library('image_lib');
        $file_name = substr($img_url, strpos($img_url, "/portrait")+9);
        $url = '/uploads/'.substr($img_url, strpos($img_url, '/portrait'));
        $source_file = $this->avatar_config['path'].$file_name;
    
        list($width, $height) = getimagesize($source_file);
        if ($width > $w || $height > $h){
            $config['image_library'] = $this->avatar_config['image_library'];
            $config['quality'] = $this->avatar_config['quality'];
            $config['source_image'] = $source_file;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $w ;
            $config['height'] = $h ;
            $config['x_axis'] = $x;
            $config['y_axis'] = $y;
    
            $this->image_lib->initialize($config);
    
            $this->image_lib->crop();
        }
    
        $this->return_json(array('status'=>0,'url'=> $url, 'full_url' => get_portrait_url($file_name), 'msg'=>'保存成功'));
    }
    
    
    /**
     * ueditor 配置项
     */
    public function config() {
        $config_arr = array(
                        /* 上传图片配置项 */
                        "imageActionName" => "file/ueditor_upload",
                        "imageFieldName" => "upfile", /* 提交的图片表单名称 */
                        "imageAllowFiles" => C('upload.ext.img'),
    
                        /* 上传文件配置 */
                        "fileActionName" => "file/ueditor_upload",
                        "fileFieldName" => "upfile", /* 提交的文件表单名称 */
                        "fileAllowFiles" =>  array_merge(C('upload.ext.img') ,C('upload.ext.other'))
        );
        $config_json = json_encode($config_arr);
        if (preg_match("/^[\w_]+$/", $_GET["callback"]))
        {
            echo htmlspecialchars($_GET["callback"]).'('.$config_json.')';
        }
        else
        {
            echo $config_json;
        }
        exit();
    }
    
    /**
     * ueditor 文件上传
     */
    public function ueditor_upload() {
        $ue_config = C('upload.ue_config');
        $upfile = upload_file('upfile',  $ue_config);
        if ($upfile['flag'])
        {
            $this->return_json(array('state'=>'SUCCESS','url'=> $this->data['domain']['img']['url'] .'/image/'.$upfile['data']['file_name']));
        }
        else
        {
            $this->return_json(array('state'=>strip_tags($upfile['data']),'url'=>''));
        }
    }
    
    
}
/* End of file File.php */