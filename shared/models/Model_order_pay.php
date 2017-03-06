<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_order_pay extends MY_Model{
    private $_table = 't_order_pay';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}