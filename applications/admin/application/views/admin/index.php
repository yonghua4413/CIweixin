<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <a href="/admin/add" class="btn btn-w-m btn-primary">添加管理员</a>
                    <form role="form" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="exampleInputEmail2" class="sr-only">用户名</label>
                            <select class="form-control" name="field">
                                <option <?php if( isset($field) &&$field == 'name'){echo 'selected';}?> value="name">登录名</option>
                                <option <?php if( isset($field) &&$field == 'fullname'){echo 'selected';}?> value="fullname">姓名</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword2" class="sr-only"></label>
                            <input type="text" name="value" value="<?php if(isset($value)){echo $value;}?>" placeholder="请输入对应信息" id="exampleInputPassword2" class="form-control">
                        </div>
                        <input class="btn btn-white" type="submit" value="查找"/>
                    </form>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号(ID)</th>
                        <th>登陆名</th>
                        <th>姓名</th>
                        <th>Email</th>
                        <th>角色</th>
                        <th>创建者</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    <?php if(isset($admin_list)):?>
                    <?php foreach ($admin_list as  $key => $val):?>
                    <tr>
                        <td><?php echo $val['id'];?></td>
                        <td><?php echo $val['name'];?></td>
                        <td><?php echo $val['fullname'];?></td>
                        <td><?php echo $val['email'];?></td>
                        <td><?php echo $groups[$val['group_id']];?></td>
                        <td><?php echo @$admins[$val['create_admin']];?></td>
                        <td><?php echo $val['create_time'];?></td>
                        <td>
                            <a href="/admin/edit?id=<?php echo $val['id'];?>"  class="btn btn-outline btn-primary">修改</a>
                            <?php
                                if($val['id'] != 1){
                            ?>
                            <a data-id="<?php echo $val['id'];?>" title="删除" class="admin_del btn btn-outline btn-danger">删除</a>
                            <a href="/admin/purview?id=<?php echo $val['id'];?>" class="btn btn-outline btn-primary">分配权限</a>
  
                            <a data-id="<?php echo $val['id'];?>" data-disabled="<?php echo $val['disabled'] == 1 ? 2 : 1 ;?>" class="enable_disabled btn btn-outline btn-primary">
                                <?php if($val['disabled'] == 1){ echo "禁用";}else{echo "启用";}?>
                            </a >
                            <?php }?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </table>
                <!-- page -->
                <div class="row">
                    <nav style="float: right">
                        <ul class="pagination">
                            <li class="disabled"><a>共<?php echo isset($count) ? $count: '0';?>条</a></li>
                            <?php echo isset($pagestr) ? $pagestr : ''?>
                        </ul>
                    </nav>
                </div>
            </div>
            </div>
            <!-- right main -->
                <?php $this->load->view('common/footers');?>
            </div>

        </div>
    </div>
    <?php $this->load->view('common/footer')?>
    <script type="text/javascript">
        //Mainly scripts
	    seajs.use(['bootstrap', 'metisMenu', 'slimscroll', 'leftMenu'], function() {	
        });
        //Custom and plugin javascript
    		seajs.use([
					'<?php echo css_js_url('admin.js', 'admin');?>',
        ], function(a) {
        	a.del();
        	a.enable_disable();
        });
    </script>

</body>

</html>