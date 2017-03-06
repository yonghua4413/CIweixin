<?php
/**
 * 权限管理控制器
 * @author nengfu@gz-zc.cn
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Adminspurview extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_admins_purview' => 'Madmins_purview',
          ]);
        $this->data['action'] = 'admin_user_manage';
        $this->data['urls'] = '/adminspurview/index';

    }


    /**
     * 权限列表
     * nengfu@gz-zc.cn
     */
    public function index() {
        $data = $this->data;

        $data['list'] = class_loop( $this->Madmins_purview->get_all());

        $this->load->view("adminpurview/index", $data);
    }

    /**
     * 编辑
     * nengfu@gz-zc.cn
     */
    public function edit()
    {
        
        $id = (int)$this->input->get('id');

        if(IS_POST)
        {
            $_POST['id'] = (int)$this->input->post('id');
            $_POST['url'] = strtolower(trim(trim($this->input->post('url')), '/'));
            $res = $this->Madmins_purview->replace_into($this->input->post());
            if($res){
                $this->return_success('', "修改成功");
            }else{
                $this->return_failed("修改失败,请重新编辑");
            }
        }

        $data = $this->data;
        //分类信息
        $data['info'] = $this->Madmins_purview->get_one("*", array("id" => $id));
        $data['title'] = array("权限管理", $data['info']['name']);
        #获得一级分类
        $data['parent_purviews']  =  class_loop_list(class_loop($this->Madmins_purview->get_all()));

        $this->load->view("adminpurview/edit", $data);

    }


    /**
     * 删除
     * nengfu@gz-zc.cn
     */
    public function del($id = 0)
    {
        if($id == 0){
            $id = $this->input->post('id');
        }
        $id = (int)$id;

        $info = $this->Madmins_purview->get_child($id);
        if($info)
        {
            $this->return_failed("此权限下存在子权限，请先删除子权限！");
         }
        else
        {
            $res = $this->Madmins_purview->delete(array('id' => $id));
             if($res){
                 $this->return_success("", "删除成功");
             }else{
                 $this->return_failed("删除失败, 请重新删除");
             }
        }
    }

    /**
     * 添加
     * nengfu@gz-zc.cn
     */
    public function add()
    {
       
        $parent_id = $this->input->get('id');
      
        $parent_id = (int)$parent_id;

        $data = $this->data;
        if(IS_POST)
        {
            $info['parent_id'] = (int) trim($this->input->post('parent_id', TRUE));
            $info['url'] = strtolower(trim($this->input->post('url'), '/'));
            $info['name'] = trim($this->input->post('name', TRUE));
            $info['sort'] = (int) trim($this->input->post('sort', TRUE));
            if(empty($info['url'])){
                $this->return_failed('权限代码不能为空！');
            }
            if(empty($info['name'])){
                $this->return_failed('权限名称不能为空！');
            }
            if($info['sort'] < 0){
                $this->return_failed('排序必须大于零');
            }
            $insert_id = $this->Madmins_purview->create($info);
            if($insert_id){
                $this->return_success('', '添加成功');
            }else{
                $this->return_failed('添加失败');
            }
        }

        //分类信息
        #父分类
        $data['parent_id'] = $parent_id;
        $data['title'] = array("权限管理", "添加");

        #获得一级分类
         $data['parent_purviews'] = class_loop_list(class_loop($this->Madmins_purview->get_all()));

        $this->load->view("adminpurview/add", $data);
    }

}
