<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_tag extends MY_Model{
    private $_table = 't_tag';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}
