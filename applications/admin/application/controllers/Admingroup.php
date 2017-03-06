<?php 
/**
* 管理员角色控制器
* @author nengfu@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Admingroup extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_admins' => 'Madmins',
            'Model_admins_group' => 'Madmins_group',
            'Model_admins_purview' => 'Madmins_purview'
        ]);
        $this->pageconfig = C('page.config_log');
        $this->load->library('pagination');
        $this->data['action'] = 'admin_user_manage';
        $this->data['urls'] = '/admingroup/index';
    }

    /**
     * 用户角色管理
     * nengfu@gz-zc.cn
     */

    public  function index(){
        $data = $this->data;
        $data['title'] = array("管理员管理","角色列表");
        $data['type'] = C("public.type");
        //角色
        $where = array('is_del'=>0);
        
        $list = $this->Madmins_group->get_lists("id,name,describe,purview_ids", $where);
        $data_count = $this->Madmins_group->count($where);
        $data['count'] = $data_count;

        if($list)
        {
            foreach($list as $key=>$v){
               $list[$key]['admin_count'] = $this->Madmins->get_admin_count($v['id']);
             }
             
             $this->pageconfig['base_url'] = "/admingroup/index?";
             $this->pageconfig['total_rows'] = $data_count;
             $this->pagination->initialize($this->pageconfig);
             $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        $data['list'] = $list;
        $this->load->view("group/index",$data);
    }

    /**
     * 添加用户角色
     * nengfu@gz-zc.cn
     */
    public function add(){
        if($this->input->is_ajax_request())
        {
            $data['name'] =  trim($this->input->post("name", TRUE));
            if(empty($data['name'])){
                $this->return_failed('角色名不能为空');
            }
            $count = $this->Madmins_group->count(array('is_del' => 0, 'name' => $data['name']));
            if($count){
                $this->return_failed("角色名称已经存在！");
            }
            $data['describe'] =  trim($this->input->post("describe", TRUE));
            $result_id =  $this->Madmins_group->create($data);
            if($result_id){
                $this->return_success('', '添加成功');
            }else{
                $this->return_failed('添加失败!');
            }
        }


        $data = $this->data;
        
        $data['title'] = array("角色管理","添加角色");
        $this->load->view("group/add",$data);
    }

    /**
     * 校验角色名是否存在
     * nengfu@gz-zc.cn
     */
    public function check_name(){
        if($this->input->is_ajax_request())
        {
            if($this->data['pur_code']){
                $this->return_json(array("code" => 2));
            }
           $name =  trim($this->input->post("name", TRUE));
           $count = $this->Madmins_group->count(array('is_del' => 0, 'name' => $name));
           if($count){
               $this->return_json(array("code" => 0));
           }else{
               $this->return_json(array("code" => 1));
           }

        }
    }

    /**
     * 编辑角色
     * nengfu@gz-zc.cn
     */
    public function edit(){
        $id = (int)$this->input->get_post('id');
        if(IS_POST){
              $_POST['id'] = $id ;
             $res = $this->Madmins_group->replace_into($_POST);
            if($res){
                $this->return_success("","修改成功");
            }else{
                $this->error("修改失败,请重新修改");
            }
        }
        $data = $this->data;
        
        $data['info'] = $this->Madmins_group->get_one("*",array("id"=>$id));
        $data['title'] = array("管理角色","编辑".$data['info']['name'] );
        $this->load->view("group/edit",$data);
    }

    /**
     * 删除角色
     * nengfu@gz-zc.cn
     */
    public  function del(){
        $id = (int)$this->input->get_post('id');
        #不能删除管理员
        $admin_count = $this->Madmins->get_admin_count($id);
        if($admin_count)
        {
            $this->return_failed('该角色下存在管理员,请先删除管理员('.$admin_count.'位)');

        }
        #标记删除
        $res = $this->Madmins_group->update_info(array('is_del'=>1),array('id'=>$id));
        if($res){
            $this->return_success('', '删除成功');
        }else{
            $this->return_failed("删除失败");
        }

    }

   /**
     * 分配权限
     * nengfu@gz-zc.cn
     */
    public function purview(){

        $data = $this->data;
        $id = (int)$this->input->get_post('id');
        #用户组信息
        $group_info = $this->Madmins_group->get_one("*",array("id"=>$id));

        $data['group_info'] = $group_info;
        $data['title'] = array("权限分配","编辑".$data['group_info']['name'] );

        #用户组已有权限
        $purview_ids = explode(',',$group_info['purview_ids']);

        $data['purview_ids'] = $purview_ids;


        if(IS_POST)
        {
            #同步权限给成员
            $new_purview = $this->input->post('purview') ? $this->input->post('purview') : array();

            $del_diff = array_diff($purview_ids, $new_purview); //再原来的基础去掉不要权限
            $add_diff = array_diff($new_purview, $purview_ids); //再原来的基础上增加权限
            $this->Madmins->setDiffPurview($id, $del_diff, $add_diff );

            #保存权限
            $this->Madmins_group->update_info(array("purview_ids"=>implode(',', $new_purview)),array("id"=>$id));
            $this->return_success("","修改成功");
        }

        #所有权限
        $data['id'] = $id;
        $data['list'] = class_loop($this->Madmins_purview->get_all());
        $this->load->view("group/purview",$data);
    }

    
}
