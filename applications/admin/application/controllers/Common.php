<?php 
/**
* 首页控制器
* @author jianming@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Common extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_admins' => 'Madmins',
            'Model_venue' => 'Mvenue'
         ]);
        $this->load->library('encryption');

    }
    

    /**
     * 右边内容
     */
    public function index() {

        $data = $this->data;
        $list = $this->Mvenue->lists();
        
        //如果是场馆管理员
        if($data['userInfo']['type'] == C('public.type.venue.id')){
            foreach ($list as $k => $v){
                if($v['id'] == $data['userInfo']['venue_id']){
                    $data['list'][] = $v; 
                    break;
                }
            }
        }else{
            $data['list'] = $list;
        }
        
        $this->load->view("common/index", $data);
    }

    /**
     * 顶部内容
     */
    public function top() {
        $data = $this->data;
        $data['user_info'] = $this->data['userInfo'];
        $now_year = date('Y');
        $data['now_month'] = $now_month = date('m');
        $year = array();
        for ($i = 2016; $i<=$now_year+4; $i++){
            $year[] = $i;
        }
        $data['year'] = $year;
        
        $month = array();
        for($i = 1; $i <= 12; $i++){
            $month[] = $i;
        }
        $data['month'] = $month;
        
        if($this->input->is_ajax_request()){
            $post_data = $this->input->post();
            $this->load->helper('date');
            $day = days_in_month($post_data['month'], $post_data['year']);
            if($day){
                $this->return_success($day);
            }else{
                $this->return_failed();
            }

        }
        
        $this->load->view("common/top",$data);
    }

    /*
     *  菜单
     *  nengfu@gz-zc.cn
     */
    public function left() {
        $data = $this->data;
        $data['menu'] = $this->Madmins->getMenus();
        $data['admin_id'] = urlencode($this->encryption->encrypt($data['userInfo']['id']));
        $this->load->view("common/left",$data);

    }



    /**
     * 底部内容
     */
    public function bottom() {
        $this->load->view("common/bottom");
    }
    
}
