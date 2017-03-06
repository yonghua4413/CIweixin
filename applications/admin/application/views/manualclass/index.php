<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <a href="/manualclass/add" class="btn btn-w-m btn-primary">添加手工位分类</a>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                		<th>分类ID</th>
                		<th>分类名称</th>
                		<th>状态</th>
                		<th>添加人</th>
                		<th>添加时间</th>
                		<th>操作</th>
        	        </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $v['id']?></td>
                        <td><?php echo $v['name']?></td>
                        <td><?php if ($v['is_del']==0):?>正常
                		<?php else:?>删除
                		<?php endif;?>
                		</td>
                		<td><?php echo $admins[$v['create_user']];?></td>
                        <td><?php echo $v['create_time']?></td>
                        <td><a href="/manualclass/edit/<?php echo $v['id']?>" class="btn btn-outline btn-primary">修改</a> 
                             <a href="/manual/add/<?php echo $v['id']?>" class="btn btn-outline btn-primary">添加手工内容</a></td>
                        </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </table>
                <!-- page -->
                <div class="row">
                    <nav style="float: right">
                        <ul class="pagination">
                            <li class="disabled"><a>共<?php echo isset($data_count) ? $data_count: '0';?>条</a></li>
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
	    seajs.use(['bootstrap', 'metisMenu', 'slimscroll'], function() {	
        });
        //Custom and plugin javascript
		seajs.use(['<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function() {
			
        });
    </script>

</body>

</html>