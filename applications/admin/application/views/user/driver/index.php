<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <a href="/user/driver_add" class="btn btn-w-m btn-primary">添加司机</a>
                    <form role="form" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="exampleInputEmail2" class="sr-only">用户名</label>
                            <select class="form-control" name="field">
                                <option <?php if( isset($field) &&$field == 'realname'){echo 'selected';}?> value="realname">姓名</option>
                                <option <?php if( isset($field) &&$field == 'tel'){echo 'selected';}?> value="tel">电话</option>
                                <option <?php if( isset($field) &&$field == 'car_brand'){echo 'selected';}?> value="car_brand">车辆品牌</option>
                                <option <?php if( isset($field) &&$field == 'car_num'){echo 'selected';}?> value="car_num">车牌号</option>
                                <option <?php if( isset($field) &&$field == 'drive_license_num'){echo 'selected';}?> value="drive_license_num">驾驶证号</option>
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
                        <th>姓名</th>
                        <th>手机号</th>
                        <th>车辆品牌</th>
                        <th>车牌号</th>
                        <th>车辆颜色</th>
                        <th>驾驶证号</th>
                        <th>信誉分</th>
                        <th>认证状态</th>
                        <th>操作</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $v['id']?></td>
                        <td><?php echo $v['realname']?></td>
                        <td><?php echo $v['tel']?></td>
                        <td><?php echo $v['car_brand']?></td>
                        <td><?php echo $v['car_num']?></td>
                        <td><?php echo $v['car_color']?></td>
                        <td><?php echo $v['drive_license_num']?></td>
                        <td><?php echo $v['reputation_score']?></td>
                        <td><?php if($v['auth_status'] == 0){echo '未认证';}elseif($v['auth_status'] == 1){echo '已认证';}elseif($v['auth_status'] == 2){echo '认证失败';}else{echo '未知';}?></td>
                        <td>
                            <a href="/user/driver_modify?id=<?php echo $v['id']?>" class="btn btn-outline btn-primary">修改</a>
                            <a href ="/user/driver_del?id=<?php echo $v['id']?>" class="btn btn-outline btn-danger">删除</a>
                            <a href="/user/driver_lines?id=<?php echo $v['user_id']?>" class="btn btn-outline btn-primary">线路</a>
                            <a href="/user/driver_order?driver_id=<?php echo $v['user_id']?>" class="btn btn-outline btn-primary">订单</a>
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