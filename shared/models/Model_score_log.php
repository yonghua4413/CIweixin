<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_score_log extends MY_Model{
    private $_table = 't_score_log';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}
