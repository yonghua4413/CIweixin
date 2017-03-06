<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_single_road extends MY_Model{
    private $_table = 't_single_road';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
    /*
     * 获取热门路线最低价格路线
     * return array;
     */
    public function get_single_road($where = array()){
        if(empty($where)){
            return null;
        }
        //获取当前价格最低路线
        $fields = "id ,start,end,price,double_road_id,sum(trade_count) as trade_count ";
        $sql = "select ".$fields." FROM (select * from ".$this->_table." where double_road_id in(".implode(",",array_column($where, 'id')).") order by price asc) as a group by double_road_id";
        return $this->query_array($sql);
   }
    /*
     * 根据城市查询路线
     * @param $keyword
     */
    public  function get_keyword_lines($keyword){
        $fields = "id ,start,end,price,double_road_id,sum(trade_count) as trade_count";
        $sql = "select ".$fields." FROM (select * from t_single_road where start like '%".$keyword."%' or end like '%".$keyword."%'  order by price asc) as a group by double_road_id";
        return $this->query_array($sql);
    }

    /*
     * 统计当前路线订单总数
     */
    public function get_count_road_order($road_id){
        $sql = "SELECT a.`start`,a.end,count(b.id) as num FROM `t_single_road` a LEFT JOIN t_order b on a.id=b.road_id where a.id='".$road_id."' GROUP BY b.road_id";
        return $this->query_array($sql);
    }

    /*
     * 获取路线交易成功 次数
     *
     */
    public function get_sum_road($road_id){
        $this->db->select_sum('trade_count');
        $this->db->where("double_road_id", $road_id);
        $this->db->group_by("double_road_id");
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    /*
     * 根据城市查询路线
     * @param $string
     * return array;
     */
    public function query_array($sql){
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return  $query->result_array();
        }
        else{
            return null;
        }
    }
    
    /**
     * 根据热门双线线路id查询交易次数和最低价格
     * @author chaokai@gz-zc.cn
     */
    public function get_hot_road_info($road_list = array()){
        if(empty($road_list)){
            return false;
        }
        
        //获取线路最低价格
        $single_price_list = $this->get_lists('id,price,double_road_id', array('is_del' => 0,'in' => array('double_road_id' => array_column($road_list, 'id'))));
        foreach ($road_list as $k => $v){
            foreach ($single_price_list as $key => $value){
                if($value['double_road_id'] == $v['id']){
                    if(isset($road_list[$k]['price'])){
                        $value['price'] < $road_list[$k]['price'] && $road_list[$k]['price'] = $value['price'];
                    }else{
                        $road_list[$k]['price'] = $value['price'];
                    }
                }
            }
        }
        //获取交易数量
        $trade_count_list = $this->get_lists('sum(trade_count) trade_all_count, double_road_id', array('is_del' => 0,'in' => array('double_road_id' => array_column($road_list, 'id'))), array(), 0, 0, 'double_road_id');
        foreach ($road_list as $k => $v){
            foreach ($trade_count_list as $key => $value){
                if($value['double_road_id'] == $v['id']){
                    $road_list[$k]['trade_all_count'] = $value['trade_all_count'];
                    break;
                }
            }
        }
        
        return $road_list;
    }
}
