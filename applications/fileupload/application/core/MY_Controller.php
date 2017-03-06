<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
   
	public $data = array();
    public function __construct() {
        parent::__construct();
        
        $_GET = xss_clean($_GET);
        $_POST = xss_clean($_POST);
        
        $this->data['domain'] = C('domain');
        
        
    }
   
    /**
     * 转化为json字符串
     * @author yuanxiaolin@global28.com
     * @param unknown $arr
     * @ruturn return_type
     */
    public function return_json($arr) {
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: X-Requested-With');
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        echo json_encode($arr);exit;
    }

 	/**
 	 * 请求成功返回
 	 * @author yuanxiaolin@global28.com
 	 * @param unknown $data
 	 * @param string $msg
 	 * @ruturn return_type
 	 */
    public function return_success($data = array(),$count =0,$msg = 'request is ok') {
       
		$this->return_json(
                array(
                    'status'=> C('status.success.value'),
                	'data'	=> $data,
                	'data_count' => $count,
                    'msg'   => $msg,
                )
        );
        
    }
    
	/**
	 * 请求失败返回
	 * @author yuanxiaolin@global28.com
	 * @param string $result
	 * @param string $success_msg
	 * @param string $failure_msg
	 * @ruturn return_type
	 */
    public function return_failed ( $msg = 'request failed',$data = '',$status = -1) {
       
        $this->return_json(
            array(
                'status'    => isset($status) ? $status : C('status.failed.value'),
                'msg'       => $msg,
            	'data'		=> $data
            )
        );
    }
    

}













