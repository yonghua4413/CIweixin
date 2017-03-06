<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cookie 加密
 */
if ( ! function_exists('encrypt')) {
	function encrypt($array = array()){
		$info = base64_encode(json_encode($array));
		$num = ceil(strlen($info)/1.5);
		$key1 = substr($info,0,$num);
		$result = strtr($info,array($key1=>strrev($key1)));
		$key2 = substr($result, -$num,$num-2);
		$result = strtr($result,array($key2=>strrev($key2)));
		return $result;
	}
}

/**
 * Cookie 解密
 */
if ( ! function_exists('decrypt')) {
	function decrypt($str = ''){
		$num = ceil(strlen($str)/1.5);
		$key2 = substr($str, -$num,$num-2);
		$str = strtr($str,array($key2=>strrev($key2)));
		$key1 = substr($str,0,$num);
		$result = strtr($str,array($key1=>strrev($key1)));
		$info = json_decode(base64_decode($result),true);
		return $info;
	}
}


/**
 *发送短信
 */
if ( ! function_exists('send_msg')) {
    function send_msg($tel, $msg = ''){
        if (empty($tel) || empty($msg)){
            return false;
        }
        $CI=&get_instance();
        $CI->load->library('sms', array(C("sms")));
        if (is_array($tel)){
            $tel = implode(',', $tel);
        }

        try {
            return $CI->sms->send_sms_huaxing($tel, $msg,'');
        }catch (Exception $e) {
            echo $e->getMessage(), "\n";
        }
    }

}


/**
 * 给乘客的微信模板通知
 */
if ( ! function_exists('wechat_template_notice_passenger')) {
    function wechat_template_notice_passenger($receiver_open_id, $url, $first_msg, $driver, $car_info, $driver_evaluation, $driver_order_count){

        if(empty($receiver_open_id) || empty($driver)){
            return false;
        }
        $confige = C('wechat_app');
        $param = array(
            'app_id' => $confige['app_id']['value'],
            'app_secret' => $confige['app_secret']['value'],
            'cache_dir' => APPPATH.'cache/'
        );
        
        $CI = &get_instance();
        $CI->load->library('weixinjssdk', $param);
        $access_token = $CI->weixinjssdk->getAccessToken();
        
        $params =  array(
            "touser" => $receiver_open_id,
            "template_id" => $confige['wechat_template_notice']['passenger']['template_id'],
            "url" => $url,
            "data" => array(
                "first" =>  array(
                    "value" => $first_msg,
                    "color" => "#173177"
                ),
                "keyword1" => array(
                    "value" => $driver,
                    "color" => "#173177"
                ),
                "keyword2" =>  array(
                    "value" => $car_info,
                    "color" => "#173177"
                ),
                "keyword3" =>  array(
                    "value" => $driver_evaluation,
                    "color" => "#173177"
                ),
                "keyword4" =>  array(
                    "value" => $driver_order_count,
                    "color" => "#173177"
                ),
                "remark" => array(
                    "value" => $confige['wechat_template_notice']['passenger']['remark'],
                    "color" => "#173177"
                )
            )
        );
        
        $res = Http::http_post_json(
                'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token,
                json_encode($params)
        );
        $res = json_decode($res, true);
        if(isset($res['errcode']) && $res['errcode'] != 0){
            $CI->weixinjssdk->refresh_token();
            wechat_template_notice_passenger($receiver_open_id, $url, $driver, $car_info, $driver_evaluation, $driver_order_count);
        }
        
        return $res;
    }
}

/**
 * 给司机的微信模板通知
 */
if ( ! function_exists('wechat_template_notice_driver')) {
    function wechat_template_notice_driver($receiver_open_id, $url, $first_msg, $passenger, $passenger_tel, $route, $start, $start_time, $remark = ''){

        if(empty($receiver_open_id) || empty($passenger)){
            return false;
        }
        $confige = C('wechat_app');
        $param = array(
            'app_id' => $confige['app_id']['value'],
            'app_secret' => $confige['app_secret']['value'],
            'cache_dir' => APPPATH.'cache/'
        );

        $CI = &get_instance();
        $CI->load->library('weixinjssdk', $param);
        $access_token = $CI->weixinjssdk->getAccessToken();

        $params =  array(
            "touser" => $receiver_open_id,
            "template_id" => $confige['wechat_template_notice']['driver']['template_id'],
            "url" => $url,
            "data" => array(
                "first" =>  array(
                                "value" => $first_msg,
                                "color" => "#173177"
                ),
                "keyword1" => array(
                                "value" => $passenger,
                                "color" => "#173177"
                ),
                "keyword2" =>  array(
                                "value" => $passenger_tel,
                                "color" => "#173177"
                ),
                "keyword3" =>  array(
                                "value" => $route,
                                "color" => "#173177"
                ),
                "keyword4" =>  array(
                                "value" => $start,
                                "color" => "#173177"
                ),
                "keyword5" =>  array(
                                "value" => $start_time,
                                "color" => "#173177"
                ),
                "remark" => array(
                                "value" => $remark ? $remark : $confige['wechat_template_notice']['driver']['remark'],
                                "color" => "#173177"
                )
            )
        );

        $res = Http::http_post_json(
                'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token,
                json_encode($params)
        );
        $res = json_decode($res, true);
        if(isset($res['errcode']) && $res['errcode'] != 0){
            $CI->weixinjssdk->refresh_token();
            wechat_template_notice_driver($receiver_open_id, $url, $passenger, $passenger_tel, $route, $start, $start_time, $remark);
        }

        return $res;
    }

}


/**
 * 获取随机数
 */
if (! function_exists('get_code')){
    function get_code(){
        return  rand(100000, 999999);
    }
}


/**
 * 更复杂的获取随机数
 */
if (! function_exists('get_complex_code')){
    function  get_complex_code($length = 6){
        $str = '';
        $pa = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for($i=0; $i<$length; $i++){
             $str .= $pa{mt_rand(0,35)};
        }
        return $str;
     }
}


/**
 * 图片上传
 * @param string $file_name
 */
if (! function_exists('upload_file')){
    function upload_file($file_name, $config=''){
        $return_msg = array();
        $CI=&get_instance();
        $CI->load->library('upload', $config);
        if ( ! $CI->upload->do_upload($file_name)){
            $return_msg['flag'] = FALSE;
            $return_msg['data'] = $CI->upload->display_errors();
        }else{
            $return_msg['flag'] = TRUE;
            $return_msg['data'] = $CI->upload->data();
        }
        return $return_msg;
    }
}


/**
 * 获取加密用户密码
 *
 * @param string $file_name
 */
if (! function_exists('get_encode_pwd')){
    function get_encode_pwd($password){
        if (empty($password)){
            return FALSE;
        }
        $password = md5(strtolower($password));
        return $password;
    }
}


/**
 * 将二维数组中的第一维转换为和某个第二维字段值关联
 */
if (! function_exists('change_arr_key_by_somekey')){
    function change_arr_key_by_somekey($arr = array(), $somekey){
        $arr_somekey = array();
        if ($arr){
            foreach ($arr as $key=>$v){
                $arr_somekey[$v[$somekey]] = $v;
            }
        }
        return $arr_somekey;
    }


}



/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 */
if (! function_exists('think_encrypt')){
    function think_encrypt($data, $key = '', $expire = 0) {
        $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
        $data = base64_encode($data);
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }
        $str = sprintf('%010d', $expire ? $expire + time():0);
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
        }
        return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
    }
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 */
if (! function_exists('think_decrypt')){
    function think_decrypt($data, $key = ''){
        $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
        $data   = str_replace(array('-','_'),array('+','/'),$data);
        $mod4   = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        $data   = base64_decode($data);
        $expire = substr($data,0,10);
        $data   = substr($data,10);

        if($expire > 0 && $expire < time()) {
            return '';
        }
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $char   = $str = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }

}


/**
 * 显示图片优化函数
 */
if (! function_exists('optim_image')){
    function optim_image($img_full_url = '', $size = array(0, 0), $type = '', $watermark = FALSE){
        
        //地址为空 或者优化配置关闭直接返回 
        if ($img_full_url == '' || !C('images_optim.optim')){
            return $img_full_url;
        } 
        
        $extension =  substr($img_full_url, strrpos($img_full_url, '.'));
        
        $replace_str = '_t';
        if ($type){
            $replace_str .= $type;
        }
        if ($watermark){
            $replace_str .= '_w';
        }
        if ($size[0] && $size[1]){
            $replace_str .= '_s'.$size[0] . 'x' . $size[1];
        }
        
        $img_full_url = str_replace($extension, $replace_str . $extension,  $img_full_url);
        
        return $img_full_url;
    }
   
}
/**
 * 替换文章内容中图片为全路径
 *
 * @param string $content
 * @return mixed
 */

if (! function_exists('get_full_content_img_url')){
    function get_full_content_img_url($content){
        return  str_replace(array('/../Uploads/image/','/Uploads/image/'),  C('domain.img.url') . '/' . C('domain.img.img_common_dir') . '/', $content);

    }
}


/**
 * 获取css和js的url
 *
 * @param string $css_js_uri css或者js的uri
 *
 * @return string $css_js_url
 */
if (! function_exists('css_js_url')){
    function css_js_url($css_js_uri, $app_type){

        $static_url = C('domain.static.url');
        $type = 'css';
        if (strpos($css_js_uri, '.js') !== FALSE){
            $type = 'js';
        }

        //优先读取压缩过的文件
        $is_merge = FALSE;
        if (strpos($css_js_uri, ",") !== FALSE){
            $is_merge = TRUE;
        }
        $css_js_url_arr = explode(',', $css_js_uri);
        foreach ($css_js_url_arr as $key=>$v){
            if (strpos($v, '.min.') === FALSE)
            {
                $min_css_js_uri = str_replace('.' . $type, '.min.' . $type, $v);
                $min_static_file = C('css_js.static_path').'/' . $app_type . '/' . $type.'/'. $min_css_js_uri;
                if(file_exists($min_static_file)){
                    $css_js_url_arr[$key] = $min_css_js_uri;
                }
            }
        }


        $version = C('css_js_version')[$app_type][$type];
        //从数据库中查询版本号
        $CI = get_instance();
        $CI->db->from('t_version');
        $CI->db->where(['web_type' => $app_type]);
        $result = $CI->db->get();
        $version_result = $result->row();
        if($version_result){
	        $api_version = '';
	        if($type == 'css'){
	        	$api_version = $version_result->css_version_id;
	        }else{
	        	$api_version = $version_result->js_version_id;
	        }
	        $file = BASEPATH.'../shared/config/css_js_version.php';
	        $config_time = 0;
	        if(file_exists($file)){
		        $config_time = filemtime($file);
	        }
	        $database_time = strtotime($version_result->update_time);

	        //比较配置文件和数据库中的版本号，选取较大的一个
	        $version = intval($database_time) >= intval($config_time) ? $api_version :$version;
        }


        $css_js_uri = $type .'/'. implode(','. $type .'/', $css_js_url_arr);
        if ($is_merge){
            $css_js_url = $static_url . '/'. $app_type.'/??'. $css_js_uri . '?v='. $version;
        }else{
            $css_js_url = $static_url . '/'. $app_type.'/'. $css_js_uri . '?v='. $version;
        }

        return $css_js_url;
    }
}

/**
 * 返回CSS和JS导入文件
 *
 * @param string $css_js_uri css或者js的uri
 *
 * @return string $css_js_url
 **/

if (! function_exists('css_js_url_v2')){
    function css_js_url_v2($css_js_uri, $app_type) {
        $type = "css";
        $link_url = "";
        if (strpos($css_js_uri, '.js')){
            $type = 'js';
        }
        if($type == 'css'){
            $link_url = '<link href="%s" rel="stylesheet"> ';
        }
        else{
            $link_url = '<script src="%s"></script>';
        }
        if(@C('css_js.development')){ //线下
            $css_js_url_arr = explode(',', $css_js_uri);
            foreach ($css_js_url_arr as $key=>$v){
                printf($link_url, $string_url =  css_js_url($v, $app_type));
                echo "\n\r";
            }
        }else{ //线上
            $string_url =  css_js_url($css_js_uri, $app_type);
            printf($link_url,$string_url);
            echo "\n\r";
        }

    }
}

/**
 * 获取随机奖品
 *
 * @param array $data  奖品数据
 *
 * @return number  中奖奖项
 */
if (! function_exists('get_rand')){
    function get_rand($data) {
        $result = '';
        $pro_sum = array_sum($data);
        foreach ($data as $key => $pro_cur) {
            $rand_num = mt_rand(1, $pro_sum);
            if ($rand_num <= $pro_cur) {
                $result = $key;
                break;
            } else {
                $pro_sum -= $pro_cur;
            }
        }
        unset ($data);
        return $result;
    }
}

/**
 * 是否移动设备访问
 * @author yuanxiaolin@global28.com
 * @return boolean
 * @ruturn boolean
 */
if(!function_exists('ismobile')){
	function ismobile() {
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
			return true;

		//此条摘自TPM智能切换模板引擎，适合TPM开发
		if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
			return true;
		//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
			//找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
		//判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT'])) {
			$clientkeywords = array(
					'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
			);
			//从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
				return true;
			}
		}
		//协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT'])) {
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
				return true;
			}
		}
		return false;
	}
}


/**
 *  删除非站内链接
 *
 * @access    public
 * @param     string  $body  内容
 * @param     array  $allow_urls  允许的超链接
 * @return    string
 */
if(!function_exists('replace_links')){
    function replace_links($body, $allow_urls=array('global28.com')){
        $host_rule = join('|', $allow_urls);
        $host_rule = preg_replace("#[\n\r]#", '', $host_rule);
        $host_rule = str_replace('.', "\\.", $host_rule);
        $host_rule = str_replace('/', "\\/", $host_rule);
        $arr = '';
        preg_match_all("#<a([^>]*)>(.*)<\/a>#iU", $body, $arr);
        if( is_array($arr[0]) )
        {
            $rparr = array();
            $tgarr = array();
            foreach($arr[0] as $i=>$v)
            {
                if( $host_rule != '' && preg_match('#'.$host_rule.'#i', $arr[1][$i]) )
                {
                    continue;
                } else {
                    $rparr[] = $v;
                    $tgarr[] = $arr[2][$i];
                }
            }
            if( !empty($rparr) )
            {
                $body = str_replace($rparr, $tgarr, $body);
            }
        }
        return $body;
    }
}

/**
 * 获取当前时间
 * @author chaokai@gz-zc.cn
 */
if(!function_exists('now_date')){
    function now_date(){
    	return date('Y-m-d H:i:s');
    }
}

/**
 * 获取客户端ip
 * 
 */
if(!function_exists('get_client_ip')){
    function get_client_ip($type = 0) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

/**
 * 获取客户端ip
 *
 */
if(!function_exists('get_client_ip')){
    function get_client_ip($type = 0) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
if(!function_exists('tp_redirect')){
    function tp_redirect($url, $time=0, $msg='') {
        //多行URL地址支持
        $url        = str_replace(array("\n", "\r"), '', $url);
        if (empty($msg))
            $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
        if (!headers_sent()) {
            // redirect
            if (0 === $time) {
                header('Location: ' . $url);
            } else {
                header("refresh:{$time};url={$url}");
                echo($msg);
            }
            exit();
        } else {
            $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
            if ($time != 0)
                $str .= $msg;
            exit($str);
        }
    }
}


/**
 *递归处理数组（将子分类与上级分类合并）
 *
 *@param string $data
 *@param string $parent
 *@param int page_number
 *@return array
 */
if(!function_exists('class_loop')){
    function class_loop($data,$parent=0){

        $result = array();
        if($data)
        {
            foreach($data as $key=>$val)
            {
                if($val['parent_id']==$parent)
                {
                    $temp = class_loop($data,$val['id']);
                    if($temp) $val['child'] = $temp;
                    $result[] = $val;
                }
            }
        }
        return $result;
    }
}

/**
 *递归处理数组（将子分类与上级分类合并）
 *
 *@param string $data
 *@param string $parent
 *@param int page_number
 *@return array
 */
if(!function_exists('class_loop_list')) {
    function class_loop_list($data, $level = 0)
    {

        $level++;
        $result = array();
        if ($data) {
            foreach ($data as $v) {
                $v['level'] = $level;
                $child = array();
                if (!empty($v['child'])) {
                    $child = $v['child'];
                }
                unset($v['child']);
                $result[] = $v;
                if (!empty($child)) {
                    $result = array_merge($result, class_loop_list($child, $level));
                }
            }
        }
        return $result;
    }
}

/**
 *根据身份证号计算年龄
 *
 *@param string $birthday
 *@return int
 */
if(!function_exists('get_age_by_ID')) {
    function get_age_by_ID($ID){
        if(empty($ID)) return '';
        $date = strtotime(substr($ID, 6, 8));
        $today = strtotime('today');
        $diff = floor(($today-$date)/86400/365);
        $age = strtotime(substr($ID, 6, 8).' +'.$diff.'years') > $today ? ($diff + 1) : $diff;
        return $age;
    }
}


/**
 *身份证验证
 *
 *@param string $idcard
 *@return bool
 */
if(!function_exists('checkIdCard')) {
    function checkIdCard($idcard){

        // 只能是18位
        if(strlen($idcard)!=18){
            return false;
        }

        // 取出本体码
        $idcard_base = substr($idcard, 0, 17);

        // 取出校验码
        $verify_code = substr($idcard, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

        // 根据前17位计算校验码
        $total = 0;
        for($i=0; $i<17; $i++){
            $total += substr($idcard_base, $i, 1)*$factor[$i];
        }

        // 取模
        $mod = $total % 11;

        // 比较校验码
        if($verify_code == $verify_code_list[$mod]){
            return true;
        }else{
            return false;
        }

    }

}

/**
 * 打印标量
 * var 变量名字 is_exit 是否打印变量的同时结束。
 * @param string|array $var 字符串或数组
 * @param bool $is_exit 是否结束
 * @return
 */
if(!function_exists('p')){
    function p( $var = '', $is_exit = true ){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if($is_exit) exit;
    }
}
