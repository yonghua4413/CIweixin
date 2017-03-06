<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="table-responsive ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post">
                        <div class="form-group">
                            <input type="hidden" name="driver_id" value="<?php echo $driver_id;?>" />
                            <label class="col-sm-3 control-label">线路：</label>
                            <div class="col-sm-3">
                                <select class="form-control m-b" name="road_id">
                                    <option value="0">请选择线路</option>
                                    <?php if(isset($road_lists)):?>
                                    <?php foreach ($road_lists as $k => $v):?>
                                    <option value="<?php echo $v['id']?>"><?php echo $v['place1']?> <==> <?php echo $v['place2']?></option>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-3">
                                <input class="btn btn-primary" type="submit" value="添加" />
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
		seajs.use(['<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function() {
        });
    </script>

</body>

</html>