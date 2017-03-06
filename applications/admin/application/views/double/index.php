<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p><a href="/double/add" class="btn btn-w-m btn-primary">添加线路</a></p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th class="active">序号</th>
                        <th class="active">起点</th>
                        <th class="active">终点</th>
                        <th class="active">线路说明</th>
                        <th class="active">是否热门</th>
                        <th class="active">操作</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $v['id']?></td>
                        <td><?php echo $v['place1']?></td>
                        <td><?php echo $v['place2']?></td>
                        <td><?php echo $v['explain']?></td>
                        <td><?php if($v['is_hot'] == 1){ echo '是';}else{echo '否';}?></td>
                        <td>
                            <a href="/double/modify?id=<?php echo $v['id']?>" class="btn btn-outline btn-primary">修改</a>
                            <a href ="/double/del?id=<?php echo $v['id']?>" class="btn btn-outline btn-danger">删除</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </table>
                <!-- page -->
                <div class="row">
                    <nav style="float: right">
                        <ul class="pagination">
                            <li class="disabled"><a>共<?php echo $count?>条</a></li>
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