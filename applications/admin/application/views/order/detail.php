<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td class='active'>司机姓名</td>
                        <td><?php if(isset($info['realname'])){echo $info['realname'];}?></td>
                        <td class='active'>司机电话</td>
                        <td><?php if(isset($info['driver_tel'])){echo $info['driver_tel'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>乘客电话</td>
                        <td><?php if(isset($info['customer_tel'])){echo $info['customer_tel'];}?></td>
                        <td class='active'>乘客数量</td>
                        <td><?php if(isset($info['people_num'])){echo '大人（'.$info['people_num'].' 人)';}?><?php echo '小孩（'.$info['child_num'].'人)'; ?></td>
                    </tr>
                    <tr>
                        <td class='active'>出发地</td>
                        <td><?php if(isset($info['start'])){echo $info['start'];}?></td>
                        <td class='active'>目的地</td>
                        <td><?php if(isset($info['end'])){echo $info['end'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>上车地理位置坐标</td>
                        <td><?php if(isset($info['ride_coordinate'])){echo $info['ride_coordinate'];}?></td>
                        <td class='active'>下车地理位置坐标</td>
                        <td><?php if(isset($info['end_coordinate'])){echo $info['end_coordinate'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>乘车地点</td>
                        <td><?php if(isset($info['ride_place'])){echo $info['ride_place'];}?></td>
                        <td class='active'>乘车时间</td>
                        <td><?php if(isset($info['ride_time'])){echo $info['ride_time'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>线路费用</td>
                        <td><?php if(isset($info['road_price'])){echo $info['road_price'];}?></td>
                        <td class='active'>现金支付费用</td>
                        <td><?php if(isset($info['ride_cost'])){echo $info['ride_cost'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>微信支付费用</td>
                        <td><?php if(isset($info['need_pay'])){echo $info['need_pay'];}?></td>
                        <td class='active'>付款状态</td>
                        <td><?php if(isset($info['pay_status_text'])){echo $info['pay_status_text'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>订单状态</td>
                        <td>
                            <?php foreach (C('order_status') as $kk => $vv):?>
                                <?php if($vv['id'] == $info['order_status']):?>
                                    <?php echo $vv['name']?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </td>
                        <td class='active'>订单类型</td>
                        <td>
                             <?php foreach (C('cartype') as $kk => $vv):?>
                                <?php if($vv['id'] == $info['cartype']):?>
                                    <?php echo $vv['name']?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </td>
                    </tr>
                    <tr>
                        <td class='active'>收货人</td>
                        <td><?php if(isset($info['receive_name'])){echo $info['receive_name'];}?></td>
                        <td class='active'>收货人电话</td>
                        <td><?php if(isset($info['receive_tel'])){echo $info['receive_tel'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>创建时间</td>
                        <td><?php if(isset($info['create_time'])){echo $info['create_time'];}?></td>
                        <td class='active'>更新时间</td>
                        <td><?php if(isset($info['update_time'])){echo $info['update_time'];}?></td>
                    </tr>
                    <tr>
                        <td class='active'>订单信息</td>
                        <td><?php if(isset($info['ride_info'])){echo $info['ride_info'];}?></td>
                        <td class='active'></td>
                        <td></td>
                    </tr>
                </table>
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
		seajs.use(['<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function() {
			
        });
    </script>

</body>

</html>