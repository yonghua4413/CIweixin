<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_rate extends MY_Model{
    private $_table = 't_rate';
    private $_table2 = 't_driver';
    public function __construct() {
        parent::__construct($this->_table);
    }
    /**
     * @desc 获取司机姓名和评论内容
     * @param: string  road_id 查询条件
     * @param: string limit 限制查多少条
      * @return: array
     */
    public function  get_name_content($road_id,$id="",$limit = 6){
        $fieds = "a.id,b.realname,a.content,a.road_id,a.order_id,a.customer_tel,a.create_time";
        $id_where = "";
        if($id){
            $id_where = " and a.id<'".$id."'";
        }
        $sql = "SELECT ".$fieds." FROM ".$this->_table." a LEFT JOIN ".$this->_table2." b ON a.driver_id=b.user_id where a.road_id='".$road_id."'".$id_where." ORDER BY a.create_time desc limit ".$limit ;
        return $this->query_array($sql);
    }

    /**
     * @desc 获取司机个人中心-我的评价列表
     * @param: string  $driver_id 查询条件
     */
    public function  get_comments($driver_id){
        $sql = "SELECT A.customer_id, A.content, B.ride_time, C.start, C.end FROM t_rate A 
                LEFT JOIN t_order B ON B.id = A.order_id 
                LEFT JOIN t_single_road C ON C.id = A.road_id WHERE A.driver_id = $driver_id";
        return $this->query_array($sql);
    }

}
