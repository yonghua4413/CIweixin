<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>管理员修改</h5>
                            <div class="ibox-tools">
                                <a href="javascript:window.history.go(-1)">
                                    <i class="fa fa-mail-reply"></i> 返回
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal m-t" id="signupForm" novalidate="novalidate" >
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">角色：</label>
                                    <div class="col-sm-8">
                                            <select name="group_id" class="form-control m-b" aria-required="true" aria-invalid="true">
                                                <?php foreach($admin_group as $key=>$val){ ?>
                                                    <option <?php if($val['id']==$info['group_id']){ echo "selected";}?>  value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                <?php } ?>
                                            </select>
                                      </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">用户名：</label>
                                    <div class="col-sm-8">
                                        <input id="name" name="name" value="<?php echo $info['name']?>" class="form-control" type="text" aria-required="true" aria-invalid="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">密码：</label>
                                    <div class="col-sm-8">
                                        <input id="password" name="password" class="form-control" type="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">确认密码：</label>
                                    <div class="col-sm-8">
                                        <input id="confirm_password" name="confirm_password" class="form-control" type="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">姓名：</label>
                                    <div class="col-sm-8">
                                        <input id="fullname" name="fullname" value="<?php echo $info['fullname']?>" class="form-control" type="text" aria-required="true" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">电子邮箱：</label>
                                    <div class="col-sm-8">
                                        <input id="email" name="email" value="<?php echo $info['email']?>" class="form-control" type="email" aria-required="false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">手机：</label>
                                    <div class="col-sm-8">
                                        <input id="tel" name="tel" value="<?php echo $info['tel']?>" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">描述：</label>
                                    <div class="col-sm-8">
                                        <input  name="describe" value="<?php echo $info['describe']?>" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">是否启用：</label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline" for="yes">
                                        <input type="radio" <?php if($info['disabled'] == 1){ echo "checked";}?> value="1" id="yes" name="disabled">正常</label>
                                        
                                        <label class="radio-inline" for="no">
                                        <input type="radio" <?php if($info['disabled'] == 2){ echo "checked";}?> value="2" id="no" name="disabled">禁用</label>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $info['id']?>">
                                
                                

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
        //Mainly scripts
        var baseUrl = "<?php echo $domain['admin']['url'];?>";
        var staticUrl = "<?php echo $domain['static']['url']?>";
        var uploadUrl = "<?php /*echo $domain['upload']['url']*/?>";

        //Custom and plugin javascript
        //Mainly scripts
        seajs.use(['bootstrap', 'metisMenu', 'slimscroll', 'leftMenu'], function() {
        });
        //Custom and plugin javascript
        seajs.use([
					'<?php echo css_js_url('admin.js', 'admin');?>',
					'<?php echo css_js_url('plugins/validate/jquery.validate.min.js', 'admin');?>',
    			'<?php echo css_js_url('plugins/validate/messages_zh.min.js', 'admin');?>', 
        ], function(a) {
        	a.edit();
        });
    </script>
    
</body>

</html>