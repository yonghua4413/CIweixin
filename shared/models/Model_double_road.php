<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_double_road extends MY_Model{
    private $_table = 't_double_road';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}
