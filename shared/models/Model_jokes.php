<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_jokes extends MY_Model{
    //段子表
    private $_table = 't_jokes';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
    //随机获取段子表中一条数据
    public function get_rand_data(){
        $sql = "SELECT * FROM  ".$this->_table." WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM ".$this->_table.")))  ORDER BY id LIMIT 1";
        return $this->query_array($sql);
    }
}
