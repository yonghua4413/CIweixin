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
                            <input type="text" name="name" value="<?php if(isset($name)){echo $name;}?>" placeholder="请输入司机姓名" id="exampleInputPassword2" class="form-control">
                        </div>
                        <input class="btn btn-white" type="submit" value="查找"/>
                    </form>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号(ID)</th>
                        <th>线路id</th>
                        <th>司机姓名</th>
                        <th>用户手机</th>
                        <th>评价总分</th>
                        <th>评价内容</th>
                        <th>创建时间</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $v['id']?></td>
                        <td><?php echo $v['road_id']?></td>
                        <td><?php if(isset($v['driver_name'])){echo $v['driver_name'];}else{echo '';}?></td>
                        <td><?php echo $v['customer_tel']?></td>
                        <td><?php echo $v['rate_score']?></td>
                        <td><?php echo $v['content']?></td>
                        <td><?php echo date("Y-m-d H:i:s", $v['create_time'])?></td>
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