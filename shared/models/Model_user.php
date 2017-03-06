<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_user extends MY_Model{
    private $_table = 't_user';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}
