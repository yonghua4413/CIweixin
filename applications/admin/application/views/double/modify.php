<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="table-responsive ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">地点1：</label>
                            <div class="col-sm-3">
                                <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
                                <input name="place1" value="<?php echo $info['place1'];?>" minlength="2" type="text" class="form-control" valType="required" msg="地点1不能为空" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">地点2：</label>
                            <div class="col-sm-3">
                                <input type="text" value="<?php echo $info['place2'];?>" class="form-control" name="place2" valType="required" msg="地点2不能为空"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">线路说明：</label>
                            <div class="col-sm-3">
                                <textarea id="ccomment" name="explain" class="form-control"><?php echo $info['explain'];?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">是否热门：</label>
                            <div class="col-sm-3">
                                <select class="form-control m-b" name="is_hot">
                                    <option>--请选择--</option>
                                    <option <?php if($info['is_hot'] == 1){echo 'selected';}?> value="1">是</option>
                                    <option <?php if($info['is_hot'] == 0){echo 'selected';}?> value="0">否</option>
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