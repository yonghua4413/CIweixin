<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_user_tel_verify extends MY_Model {

    private $_table = 't_user_tel_verify';

    public function __construct() {
        parent::__construct($this->_table);
    }
    
    
   /**
    * 获取手机对应的验证码
    * 
    * @return array
    */
   public function get_verify_by_tel($mobile){
        $verify_info = array();
        if (! $mobile){
            return $verify_info;
        }
        
        $field = array('id', 'mobile', 'code', 'add_time');
        $verify_info = $this->Muser_tel_verify->get_one($field, array('mobile'=>$mobile));
        
        return $verify_info;
       
   }
   
   
   
}