<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="table-responsive ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">乘客手机号：</label>
                            <div class="col-sm-3">
                                <input name="tel" type="text" class="form-control" valType="MOBILE" msg="手机号格式不正确" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">路线：</label>
                            <div class="col-sm-3">
                                <select class="form-control m-b" name="road_id">
                                    <option>--请选择路线--</option>
                                    <?php if(isset($single) && count($single) > 0):?>
                                        <?php foreach ($single as $k => $v):?>
                                            <option value="<?php echo $v['id']?>"><?php echo $v['start']?> --> <?php echo $v['end']?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">订单类型：</label>
                            <div class="col-sm-3">
                                <select class="form-control m-b" name="cartype">
                                    <option>--请选择类型--</option>
                                            <?php foreach (C('cartype') as $k => $v):?>
                                                <?php if($v['id'] == $cartype_id):?>
                                                    <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">乘客数量：</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="people_num" valType="required" msg="乘客数量不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">儿童数：</label>
                            <div class="col-sm-3">
                                <input  type="text" class="form-control" name="child_num" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">上车时间：</label>
                            <div class="col-sm-3">
                            <input id="start" name="ride_time" value="<?php echo date('Y-m-d H:i:s');?>" class="laydate-icon form-control layer-date" valType="required" msg="上车时间必填">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">上车地点：</label>
                            <div class="col-sm-3">
                                <input id="end" type="text" class="form-control" name="ride_place" valType="required" msg="乘车地点必选"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">乘车信息：</label>
                            <div class="col-sm-3">
                            <textarea id="ccomment" name="ride_info" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-3">
                                <input class="btn btn-primary" type="submit" value="提交" />
                            </div>
                        </div>
                    </form>
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
		seajs.use(['jqvalidate','<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function() {
			
        });
    </script>
    <!-- layerDate plugin javascript -->
    <script src="<?php echo css_js_url('/plugins/layer/laydate/laydate.js', 'admin');?>"></script>
    <script>
        //外部js调用
        laydate({
            elem: '#start', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
            event: 'focus', //响应事件。如果没有传入event，则按照默认的click
            format: 'YYYY-MM-DD hh:mm:ss',
            istime: true
        });
    </script>

</body>

</html>