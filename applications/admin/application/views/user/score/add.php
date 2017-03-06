<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="table-responsive ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post">
                        <input type="hidden" name='user_id' value="<?php echo $info['id']?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">手机号：</label>
                            <div class="col-sm-3">
                                <span><?php echo $info['tel']?></sapn>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">当前积分：</label>
                            <div class="col-sm-3">
                                <?php if(isset($score)){echo $score['balance_score'];}else{echo 0;}?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">充值积分：</label>
                            <div class="col-sm-3">
                                <input id="trade_count" type="number" class="form-control" name="score" valType="required" msg="必须为数字">
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