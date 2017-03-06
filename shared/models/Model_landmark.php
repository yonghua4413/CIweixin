<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_landmark extends MY_Model{
    private $_table = 't_landmark';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
