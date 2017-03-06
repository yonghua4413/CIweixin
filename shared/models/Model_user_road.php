<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_user_road extends MY_Model{
    private $_table = 't_user_road';
    
    public function __construct() {
        parent::__construct($this->_table);
    }
    
    /**
     * 判断用户是否已添加线路
     * @author chaokai@gz-zc.cn
     */
    public function is_add($user, $road_list){
        if(empty($road_list)){
            return false;
        }
        $user_road = $this->get_lists('*', array('user_id' => $user['user_id'], 'person_type' => $user['person_type'], 'in' => array('road_id' => array_column($road_list, 'id'), 'is_del'=>0)));
        foreach ($road_list as $k => $v){
            foreach ($user_road as $key => $value){
                if($value['road_id'] == $v['id']){
                    $road_list[$k]['is_add'] = 1;
                    break;
                }
            }
        }
        return $road_list;
    }
}
