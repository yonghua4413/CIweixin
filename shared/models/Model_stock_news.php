<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_stock_news extends MY_Model{
    private $_table = 't_stock_news';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
}
