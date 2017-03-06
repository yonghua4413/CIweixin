<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <a href="/admingroup/add" class="btn btn-w-m btn-primary">添加角色</a>
                    
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号</th>
                        <th>角色名</th>
                        <th>描述</th>
                        <th>管理员数量</th>
                        <th>操作</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as  $key => $val):?>
                    <tr>
                        <td><?php echo $val['id'];?></td>
                        <td><?php echo $val['name'];?></td>
                        <td><?php echo $val['describe'];?></td>
                        <td>
                            <a href="/admin?group_id=<?php echo $val['id'];?>"><?php echo $val['admin_count'];?></a>
                        </td>
                        <td>
                            <a href="/admingroup/edit?id=<?php echo $val['id'];?>"  class="btn btn-outline btn-primary">修改</a>
                            
                            <a data-id="<?php echo $val['id'];?>" title="删除" class="role_del btn btn-outline btn-danger">删除</a>
                            <a href="/admingroup/purview?id=<?php echo $val['id'];?>" class="btn btn-outline btn-primary">分配权限</a>

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
					'<?php echo css_js_url('purview.js', 'admin');?>',
        ], function(a) {
        	a.role_del();
        });
    </script>

</body>

</html>