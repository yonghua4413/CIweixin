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
                        <div class="form-group">
                            <label for="exampleInputPassword2" class="sr-only"></label>
                            <input type="text" name="name" value="<?php if(isset($name)){echo $name;}?>" placeholder="请输入姓名" id="exampleInputPassword2" class="form-control">
                        </div>
                        <input class="btn btn-white" type="submit" value="查找"/>
                    </form>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号</th>
                        <th>姓名</th>
                        <th>用户手机</th>
                        <th>积分</th>
                        <th>操作</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $k+1?></td>
                        <td><?php if(isset($v['realname'])){echo $v['realname'];}?></td>
                        <td><?php if(isset($v['tel'])){echo $v['tel'];}else{echo '';}?></td>
                        <td><?php if(isset($v['score'])){echo $v['score'];}?></td>
                        <td>
                            <a href ="/user/score_add?tel=<?php echo $v['tel']?>" class="btn btn-outline btn-primary">
                                                                                积分充值
                            </a>
                            <a href ="/user/score_detail?tel=<?php echo $v['tel']?>" class="btn btn-outline btn-info">
                                                                                积分记录
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