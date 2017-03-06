<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_driver extends MY_Model{
    private $_table = 't_driver';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
    
    /**
     * 获取司机信息
     * @param int $id 司机user_id
     * @author chaokai@gz-zc.cn
     */
    public function get_driver_info($id){
        $driver = $this->get_one('*', array('user_id' => $id));
        return $driver;
    }
    
    /**
     * 更新司机信息
     * @author chaokai@gz-zc.cn
     */
    public function update_driver(){
        
    }
}
