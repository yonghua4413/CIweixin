<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_score extends MY_Model{
    private $_table = 't_score';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}
