<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <form role="form" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="exampleInputPassword2" class="sr-only"></label>
                            <input type="text" name="tel" value="<?php if(isset($tel)){echo $tel;}?>" placeholder="请输入手机号" id="exampleInputPassword2" class="form-control">
                        </div>
                        <input class="btn btn-white" type="submit" value="查找"/>
                    </form>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号(ID)</th>
                        <th>头像</th>
                        <th>手机号</th>
                        <th>微信昵称</th>
                        <th>性别</th>
                        <th>创建时间</th>
                        <th>最后登陆</th>
                        <th>操作</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $v['id']?></td>
                        <td><img src="<?php echo get_img_url($v['head_img'])?>" style="width:40px; height:40px;"></td>
                        <td><?php echo $v['tel']?></td>
                        <td><?php echo $v['nickname']?></td>
                        <td><?php echo $v['sex_text']?></td>
                        <td><?php echo $v['create_time']?></td>
                        <td><?php echo $v['update_time']?></td>
                        <td>
                            <a href ="/user/customer_order?customer_id=<?php echo $v['id']?>" class="btn btn-outline btn-primary">
                                                                                订单列表
                            </a>
                            <a href ="/user/customer_change?id=<?php echo $v['id']?>&code=<?php if($v['is_limit'] == 1){echo 0;}else{echo 1;}?>" class="btn btn-outline btn-danger">
                                <?php if($v['is_limit'] == 1){echo '恢复登陆';}else{echo '限制登陆';}?>
                            </a>
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
	    seajs.use(['bootstrap', 'metisMenu', 'slimscroll'], function() {	
        });
        //Custom and plugin javascript
		seajs.use(['<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function() {
			
        });
    </script>

</body>

</html>