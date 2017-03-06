<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_city extends MY_Model{
    private $_table = 't_city';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}
