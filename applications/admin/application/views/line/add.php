<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="table-responsive ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">起点：</label>
                            <div class="col-sm-3">
                                <input id="start" name="start" minlength="2" type="text" class="form-control" valType="required" msg="起始站不能为空" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">终点：</label>
                            <div class="col-sm-3">
                                <input id="end" type="text" class="form-control" name="end" valType="required" msg="终点站不能为空"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">单价：</label>
                            <div class="col-sm-3">
                                <input id="price" type="text" class="form-control" name="price" valType="required" msg="价格不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">交易次数：</label>
                            <div class="col-sm-3">
                                <input id="trade_count" type="number" class="form-control" name="trade_count" valType="required" msg="必须为数字">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">双线路线：</label>
                            <div class="col-sm-3">
                                <select class="form-control m-b" name="double_road_id">
                                    <option>--请选择--</option>
                                    <?php if(isset($double) && count($double) > 0):?>
                                        <?php foreach ($double as $k => $v):?>
                                            <option value="<?php echo $v['id']?>"><?php echo $v['place1']?> <=> <?php echo $v['place2']?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </select>
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

</body>

</html>