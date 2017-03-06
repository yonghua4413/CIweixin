<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <?php if($cartype_name == 'carpool'):?>
                        <a href="/order/<?php echo $cartype_name?>_add" class="btn btn-w-m btn-primary">添加订单</a>
                    <?php endif;?>
                    <form role="form" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="exampleInputPassword2" class="sr-only"></label>
                            <input type="text" name="tel" value="<?php if(isset($tel)){echo $tel;}?>" placeholder="请输入手机号" id="exampleInputPassword2" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword2" class="sr-only"></label>
                            <input type="text" name="name" value="<?php if(isset($name)){echo $name;}?>" placeholder="请输入司机姓名" id="exampleInputPassword2" class="form-control">
                        </div>
                        <div class="form-group">
                          <input id="start" name="start" value="<?php if(isset($start)){echo $start;}?>" placeholder="查询开始时间" class="laydate-icon form-control layer-date">
                          <input id="end" name="end" value="<?php if(isset($end)){echo $end;}?>" placeholder="查询结束时间" class="laydate-icon form-control layer-date">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="order_status">
                              <option value="">--请选择状态--</option>
                              <?php foreach (C('order_status') as $k => $v):?>
                                   <option <?php if(isset($order_status) && $order_status == $v['id']){echo 'selected';}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                              <?php endforeach;?>
                            </select>
                        </div>

                        <input class="btn btn-white" type="submit" value="查找"/>
                    </form>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <?php if($cartype_name == 'agent'):?>
                            <th>编号(ID)</th>
                            <th>司机姓名</th>
                            
                            <th>发货人手机号</th>
                            <th>发货时间</th>
                            <th>发货地点</th>
                            <th>收货人姓名</th>
                            <th>收货人手机号</th>
                            <th>收货人地点</th>
                            <th>路线费用</th>
                            <th>现金支付费用</th>
                            <th>订单状态</th>
                            <th>微信支付费用</th>
                            <th>支付状态</th>
                            <th>类型</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        <?php else:?>
                            <th>编号(ID)</th>
                            <th>司机姓名</th>
                            <th>乘客手机号</th>
                            <th>乘客数量</th>
                            <th>乘车时间</th>
                            <th>起点站</th>
                            <th>乘车地点</th>
                            <th>终点站</th>
                            <th>路线费用</th>
                            <th>现金支付费用</th>
                            <th>订单状态</th>
                            <th>微信支付费用</th>
                            <th>支付状态</th>
                            <th>类型</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        <?php endif;?>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <?php if($cartype_name == 'agent'):?>
                            <td><?php echo $v['id']?></td>
                            <td><?php if(isset($v['realname'])){echo $v['realname'];}?></td>
                            
                            <td><?php if(isset($v['tel'])){echo $v['tel'];}?></td>
                            <td><?php echo $v['ride_time']?></th>
                            <td><?php if(isset($v['start'])){echo $v['start'].' -- ';} echo $v['ride_place'];?></td>
                            
                            <td><?php echo $v['receive_name']?></td>
                            <td><?php echo $v['receive_tel']?></td>
                            <td><?php if(isset($v['end'])){echo $v['end'].' -- ';} echo $v['end_place']?></td>
                            
                            <td><?php echo number_format($v['road_price'],2)?></td>
                            <td><?php echo $v['ride_cost']?></td>
                            <td>
                                <?php foreach (C('order_status') as $kk => $vv):?>
                                    <?php if($vv['id'] == $v['order_status']):?>
                                        <?php echo $vv['name']?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </td>
                            <td><?php echo isset($v['need_pay']) ? $v['need_pay'] : 0?></td>
                            <td><?php echo isset($v['pay_status_text']) ? $v['pay_status_text'] : ''?>
                            <td>
                                <?php foreach (C('cartype') as $kk => $vv):?>
                                    <?php if($vv['id'] == $v['cartype']):?>
                                        <?php echo $vv['name']?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </td>
                            <td><?php echo $v['create_time']?></td>
                            
                        <?php else:?>
                            <td><?php echo $v['id']?></td>
                            <td><?php if(isset($v['realname'])){echo $v['realname'];}?></td>
                            <td><?php if(isset($v['tel'])){echo $v['tel'];}?></td>
                            <td><?php echo $v['people_num']?>人、(儿童 <?php echo $v['child_num']?>人)</td>
                            <td><?php echo $v['ride_time']?></th>
                            <td><?php if(isset($v['start'])){echo $v['start'];}?></td>
                            <td><?php echo $v['ride_place']?></td>
                            <td><?php if(isset($v['end'])){echo $v['end'];}?></td>
                            <td><?php echo number_format($v['road_price'],2)?></td>
                            <td><?php echo $v['ride_cost']?></td>
                            <td>
                                <?php foreach (C('order_status') as $kk => $vv):?>
                                    <?php if($vv['id'] == $v['order_status']):?>
                                        <?php echo $vv['name']?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </td>
                            <td><?php echo isset($v['need_pay']) ? $v['need_pay'] : 0?></td>
                            <td><?php echo isset($v['pay_status_text']) ? $v['pay_status_text'] : ''?>
                            <td>
                                <?php foreach (C('cartype') as $kk => $vv):?>
                                    <?php if($vv['id'] == $v['cartype']):?>
                                        <?php echo $vv['name']?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </td>
                            <td><?php echo $v['create_time']?></td>
                        <?php endif;?>

                        <td>
                            <a href="/order/<?php echo $cartype_name?>_detail?id=<?php echo $v['id']?>" class="btn btn-outline btn-primary">详情</a>
                            <?php if($v['order_status'] ==C('order_status.pcz.id')):?>
                                 <a href="/order/<?php echo $cartype_name?>_set_driver?id=<?php echo $v['id']?>&road_id=<?php echo $v['road_id']?>" class="btn btn-outline btn-warning">派车</a>
                            <?php elseif($v['order_status'] != C('order_status.ywc.id') && $v['order_status'] != C('order_status.pcz.id')):?>
                            <a href="/order/<?php echo $cartype_name?>_finsh?id=<?php echo $v['id']?>" class="btn btn-outline btn-primary">完成</a>
                            <?php endif;?>
                            <a data-url ="/order/<?php echo $cartype_name?>_del?id=<?php echo $v['id']?>" class="btn btn-outline btn-danger del">删除</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </table>
                <!-- page -->
                <div class="row">
                    <nav style="float: right">
                        <ul class="pagination">
                            <li class="disabled"><a>共<?php echo isset($count)?$count:0;?>条</a></li>
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
        //Custom and plugin javascript layer.min.js
		seajs.use(['<?php echo css_js_url('order.js', 'admin')?>', '<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function(a) {
			a.del();
        });
    </script>
    
    <!-- layerDate plugin javascript -->
    <script src="<?php echo css_js_url('/plugins/layer/laydate/laydate.js', 'admin');?>"></script>
    <script>
        //外部js调用
        laydate({
            elem: '#start', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
            event: 'focus' //响应事件。如果没有传入event，则按照默认的click
        });
        laydate({
            elem: '#end', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
            event: 'focus' //响应事件。如果没有传入event，则按照默认的click
        });
    </script>

</body>

</html>