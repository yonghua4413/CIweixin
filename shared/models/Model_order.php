<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_order extends MY_Model{
    private $_table = 't_order';
    
    public function __construct() {
        parent::__construct($this->_table);
        
        $this->load->model(array(
                        'Model_driver' => 'Mdriver',
                        'Model_user' => 'Muser',
                        'Model_single_road' => 'Msingle_road',
                        'Model_order_pay' => 'Morder_pay'
        ));
    }
    
    /**
     * 订单详情
     * @author chaokai@gz-zc.cn
     */
    public function info($id){
        
        $info = $this->get_one('*', array('id' => $id));
        if(!$info){
            return false;
        }
        
        $pay_info = $this->Morder_pay->get_one('*', array('order_id' => $id));
        if($pay_info){
            $info['need_pay'] = $pay_info['need_pay'];
            $info['pay_status'] = $pay_info['pay_status'];
        }
        //线路始终点
        $road = $this->Msingle_road->get_one('id,start,end', array('id' => $info['road_id']));
        $info['start'] = $road['start'];
        $info['end'] = $road['end'];
        
        //司机信息
        $driver_id = $info['driver_id'];
        $driver = $this->Mdriver->get_one('*', array('user_id' => $driver_id));
        //司机微信信息
        $driver_weixin = $this->Muser->get_one('*', array('id' => $driver_id));
        if($driver_weixin){
            $driver['head_img'] = $driver_weixin['head_img'];
        }
        
        $info['driver'] = $driver;
        
        //乘客信息
        $customer_id = $info['customer_id'];
        $customer = $this->Muser->get_one('*', array('id' => $customer_id));
        //乘客出行次数
        $customer['order_count'] = $this->count(array('customer_id' => $customer_id));
        $info['customer'] = $customer;
        
        //乘车详情
        $car_type = array_column(C('car_type'), 'name', 'id');
        if($info['cartype'] == C('car_type')['specialcar']['id']){
            $info['detail'] = '';
        }elseif($info['cartype'] == C('car_type')['sharingcar']['id']){
            $info['detail'] = '成人：'.$info['people_num'].' 儿童：'.$info['child_num'];
        }elseif($info['cartype'] == C('car_type')['agencycar']['id']){
            $info['detail'] = '收件人姓名：'.$info['receive_name'].'；电话：'.$info['receive_tel'];
        }
        $info['cartype_text'] = $car_type[$info['cartype']];
        return $info;
    }
}
