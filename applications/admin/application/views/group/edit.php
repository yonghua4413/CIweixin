<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo $title[0];?> > <?php echo $title[1];?></h5>
                            <div class="ibox-tools">
                                <a href="javascript:window.history.go(-1)">
                                    <i class="fa fa-mail-reply"></i> 返回
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal m-t" id="purviewForm" novalidate="novalidate" >
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">角色名：</label>
                                    <div class="col-sm-8">
                                        <input id="name" name="name" value="<?php echo $info['name'];?>" class="form-control" type="text" aria-required="true" aria-invalid="false">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">描述：</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="describe" value="<?php echo $info['describe'];?>" class="form-control" >
                                    </div>
                                </div>
                                
                                <input type="hidden" name="id" value="<?php echo $info['id'];?>" >

                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-3">
                                        <button class="btn btn-primary" type="submit">提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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

        //Custom and plugin javascript
        //Mainly scripts
        seajs.use(['bootstrap', 'metisMenu', 'slimscroll', 'leftMenu'], function() {
        });
        //Custom and plugin javascript
        seajs.use([
					'<?php echo css_js_url('purview.js', 'admin');?>',
					'<?php echo css_js_url('plugins/validate/jquery.validate.min.js', 'admin');?>',
    			'<?php echo css_js_url('plugins/validate/messages_zh.min.js', 'admin');?>', 
        ], function(a) {
        	a.role_edit();
        });
    </script>
    
</body>

</html>