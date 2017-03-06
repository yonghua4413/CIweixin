<?php 
/**
* 个人设置控制器
* @author jianming@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_admins' => 'Madmins',
            'Model_admins_group' => 'Madmins_group',
            'Model_admins_purview' => 'Madmins_purview',

        ]);

        $this->pageconfig = C('page.config_log');
        $this->load->library('pagination');

    }
    

    /**
     * 管理员列表
     * nengfu@gz-zc.cn
     */
    public function index() {
        $data = $this->data;
        $data['title'] = array("管理员","管理员列表");
        
        $page =  intval(trim($this->input->get("per_page",true))) ?  :1;
        $size = $this->pageconfig['per_page'];
        $where['is_del'] = 0;
        
        if($this->input->get("group_id", TRUE)){
            $where = array_merge($where, array('group_id' => (int)$this->input->get("group_id", TRUE)));
        }

        $search_field = $this->input->get('field');
        $search_value = trim($this->input->get('value', TRUE));
        
        if ($search_value) {
            $where['like'][$search_field] = $search_value;
            $data['field'] = $search_field;
            $data['value'] = $search_value;
        }

        $data['admin_list'] = $this->Madmins->get_lists('*',$where,array("id"=>"asc"),$size,($page-1)*$size);

        $data_count = $this->Madmins->count($where);
        $data['count'] = $data_count;

        //获取分页
        if(! empty($data['admin_list'])){
            $urls = array();

            if(!empty($search_value)){
                $urls['field'] = $search_field;
                $urls['value'] = $search_value;
            }

            $this->pageconfig['base_url'] = "/admin/index?".http_build_query($urls);
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        
        $data['page'] = $page;
        $data['data_count'] = $data_count;

        $groups = $this->Madmins_group->get_lists("id,name",array('is_del'=>0));
        $data['groups'] = array_column($groups , 'name','id');

        $admins = $this->Madmins->get_admin_list();
        $data['admins'] = array_column($admins , 'fullname','id');

        $this->load->view("admin/index",$data);
    }

    /**
     * 添加管理员
     * nengfu@gz-zc.cn
     */
    public function add($type =0){

        if(IS_POST)
        {
            $name = trim($this->input->post('name', TRUE));
            $fullname = trim($this->input->post('fullname', TRUE));
            $password = trim($this->input->post('password', TRUE));
            $re_password = trim($this->input->post("confirm_password", TRUE));
            if(empty($name)){
                $this->return_json(['msg' => "登陆名不能为空!"]);
            }
            if(empty($fullname)){
                $this->return_json(['msg' => "姓名不能为空!"]);
            }
            $count = $this->Madmins->count(array('is_del'=>0,'name'=>$this->input->post("name", TRUE)));
            if($count){
                $this->return_json(['msg' => "已存在的登陆名，请重新填写！"]);
            }
            if(empty($password)){
                $this->return_json(['msg' => "密码不能为空!"]);
            }
            if(trim($this->input->post("password", TRUE)) != trim($this->input->post("confirm_password", TRUE))){
                $this->return_json(['msg' => "两次密码不一致"]);
            }
            $da =$this->input->post();
            $da['is_del'] = 0;
            $da['create_admin'] =$this->data['userInfo']['id'] ;
            $da['create_time'] = date("Y-m-d H:i:s");
            $da['password'] = md5(trim($this->input->post("password", TRUE)));
            $da['group_id'] = (int) trim($this->input->post('group_id', TRUE));
            
            unset($da['confirm_password']);
            $result_id =  $this->Madmins->create($da);
            if($result_id){
                $this->return_success('',"添加成功");
            }else{
                $this->return_failed("添加管理员失败");
            }

        }

        $data = $this->data;
        $data['title'] = array("管理员","添加管理员");
       //获取角色
        $data['admin_group'] =  $this->Madmins_group->get_lists("id,name",array("is_del"=>0));
        $data['type'] = C('public.type');
        //场馆列表
       
        $this->load->view("admin/add",$data);
    }
    /**
     * 检查管理员名称是否重复
     * @author yonghua@gz-zc.cn
     */
    public function add_check(){
        $name = trim($this->input->post("name",TRUE));
        $count = $this->Madmins->count(array('is_del'=>0,'name'=>$name));
        if($count){
            $this->return_json(['code' => 0 , 'msg' => "登陆名 {$name} 已经存在"]);
        }else{
            $this->return_json(['code' => 1]);
        }
    }
    
    /**
     * 添加管理员
     * nengfu@gz-zc.cn
     */
    public function admin_entry(){
        $data = $this->data;
        $data['title'] = array("管理员","添加管理员");
        $this->load->view("admin/add_type",$data);
    }
    

    /**
     * 删除管理员
     * nengfu@gz-zc.cn
     */
    public function del()
    {
        $id = (int)$this->input->get_post('id');
        #不能删除管理员
        if($id==1)
        {
            $this->return_failed("不能删除超级管理员。");
        }

        #标记删除
        $this->Madmins->update_info(array("is_del" => 1),array("id"=>$id)) ;
        $this->return_success('', "操作成功");
    }

    /**
     * 编辑管理员
     * nengfu@gz-zc.cn
     */
     public function edit($id = 0 )
    {
        $data = $this->data;
        if(IS_POST){
            $add_data = $this->input->post();
            $add_data['id'] = $id = (int)$add_data['id'];
            //获取原来的group_id
            $pwd = $this->input->post("password",'trim');
            $old_group_id = $this->Madmins->get_one("group_id,password,create_time,create_admin",array('id'=>$id));
            if($pwd!='' && md5($pwd) != $old_group_id['password'])
            {
                if(trim($pwd, TRUE)  != trim($add_data["confirm_password"], TRUE)){
                    $this->return_json(['msg' => "两次密码不一致"]);
                }
                $add_data['password'] = md5($this->input->post("password",'trim'));
                unset($add_data["confirm_password"]);
            }
            else
            {
                $add_data['password'] = $old_group_id['password'];
                unset($add_data["confirm_password"]);
            }
            //创建时间
            if($old_group_id['create_time'] != '0000-00-00 00:00:00'){
                $add_data['create_time'] = $old_group_id['create_time'];
            }else{
                $add_data['create_time'] = date('Y-m-d H:i:s');
            }
            //创建者
            if(!empty($old_group_id['create_admin'])){
                $add_data['create_admin'] = $old_group_id['create_admin'];
            }else{
                $add_data['create_admin'] = $data['userInfo']['id'];
            }

            // 修改权限
            if($old_group_id['group_id'] != $this->input->post('group_id') ){
                #获得用户权限
                $purview_ids = $this->Madmins->get_one('purview_ids',array('id'=>$id));#查询某个字段
                $add_data['purview_ids'] = $purview_ids['purview_ids'];

                #获得旧组权限
                $old_group_purview = $this->Madmins_group->get_one('purview_ids',array('id'=>$old_group_id['group_id']));

                #获得新组权限
                $new_group_purview = $this->Madmins_group->get_one('purview_ids',array('id'=>$_POST['group_id']));

                #删除旧组权限
                $add_data['purview_ids'] = $this->Madmins->del_purview($this->input->post('purview_ids'), $old_group_purview['purview_ids']);

                #添加新组权限
                if($new_group_purview['purview_ids'])
                {
                    $add_data['purview_ids'] .= ','.$new_group_purview['purview_ids'];
                }

            }
            
            $res = $this->Madmins->replace_into($add_data);
            if($res){

                $this->return_success('',"修改成功");
            }else{
                $this->return_failed("编辑失败,请重新编辑");
            }


        }

        $data['title'] = array("管理员","编辑管理员");

        //获取角色
        $data['admin_group'] =  $this->Madmins_group->get_lists("id,name",array("is_del"=>0));
        //管理员信息
        $id = (int)$this->input->get("id",true);
        $data['info'] = $this->Madmins->get_one("*",array("id" => $id));

        $this->load->view("admin/edit", $data);
    }

    /**
     * 校验管理员是否存在
     * nengfu@gz-zc.cn
     */
    public function  check_admin(){
        if($this->input->is_ajax_request())
        {
            $name =  $this->input->post("name",true);
            $count = $this->Madmins->count(array('is_del'=>0,'name'=>$name));

            if($count){
                $this->return_json(array("code"=>0));
            }else{
                $this->return_json(array("code"=>1));
            }

        }
    }

    /**
     * 查看管理员
     * nengfu@gz-zc.cn
     */
    public function read($id){
        $data = $this->data;
        $data['info'] = $this->Madmins->get_one("*",array("id"=>$id));
        $data['title'] = array("管理员列表",$data['info']['fullname']);

        $groups = $this->Madmins_group->get_lists("id,name",array('is_del'=>0));
        $data['groups'] = array_column($groups , 'name','id');

        $this->load->view("admin/info",$data);
    }

    /**
     * 管理员权限分配
     * nengfu@gz-zc.cn
     */
    public  function purview(){
        $id = (int)$this->input->get_post('id');
        

        if(IS_POST)
        {
            $new_purview = $this->input->post('purview') ? $this->input->post('purview') : array();
            $this->Madmins->update_info(array("purview_ids"=>implode(',', $new_purview)),array("id"=>$id));
            $this->return_success("", "操作成功");
        }

        $data = $this->data;
        #用户信息
        $data['info'] = $this->Madmins->get_one("*",array("id"=>$id));
        $data['title'] = array("管理员列表",$data['info']['fullname']);

        #用户组已有权限
        $data['purview_ids'] = explode(',',$data['info']['purview_ids']);

        #获取当前用户所在的组的拥有权限
        $data['group_purview_ids'] = $this->Madmins_group->get_group_info($data['info']['group_id']);

        #所有权限
        $list = $this->Madmins_purview->get_group_purview(explode(",",$data['group_purview_ids']['purview_ids']));
        
        $data['list'] = class_loop($list);
        
        $data['id'] = $id;
        
        $this->load->view("admin/purview",$data);
    }

    /**
     * 个人设置
     * nengfu@gz-zc.cn
     */
    public function set_admin(){
        $data = $this->data;
        $data['info'] = $this->Madmins->get_one("password,fullname,tel",array("id"=>$this->data["userInfo"]['id']));
        if(IS_POST){
            $post_data = $_POST;
            if($_POST['password']!='' && md5($_POST['password']) != $data['info']['password'])
            {
                $post_data['password'] = md5($this->input->post("password",'trim'));
            }
            else
            {
                $post_data['password'] = $data['info']['password'];
            }

            $res = $this->Madmins->update_info($post_data, array("id"=>$this->data["userInfo"]['id']));
            if($res){
                $this->success("修改成功", "/admin/set_admin");
            }
            else{
                $this->error("操作失败");
            }
        }
        $this->load->view("admin/usercenter/edit", $data);
    }
    
    /**
     * 管理员的禁用与启用
     * @author yonghua@gz-zc.cn
     */
    public function enable_disable(){
        
        if(IS_POST){
            $id = (int) trim($this->input->post('id', TRUE));
            $disabled = (int) trim($this->input->post('disabled', TRUE));
            if(!empty($id) && !empty($disabled)){
                $res = $this->Madmins->update_info(['disabled' => $disabled], ['id' => $id]);
                if($res){
                    $this->return_success('', "修改成功");
                }
                else{
                    $this->return_failed("操作失败");
                }
            }else{
                $this->return_failed('提交的参数有误');
            }
        }else{
            show_404();
            exit();
        }
    }

}
