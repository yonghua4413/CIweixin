<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="table-responsive ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">线路：</label>
                            <div class="col-sm-3">
                            <input type="hidden" name="id" value="<?php echo $id;?>" /> 
                                <input name="road" type="text" value="<?php if(isset($road['start'])){echo $road['start'];}?> --> <?php if(isset($road['end'])){echo $road['end'];}?>" class="form-control" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">司机：</label>
                            <div class="col-sm-3">
                                <select class="form-control m-b" name="driver_id">
                                    <option>--请选择司机--</option>
                                    <?php if(isset($driver) && count($driver) > 0):?>
                                        <?php foreach ($driver as $k => $v):?>
                                            <option value="<?php echo $v['user_id']?>"><?php echo $v['realname']?></option>
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