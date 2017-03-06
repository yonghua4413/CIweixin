<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="table-responsive ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post">
                        <input type="hidden" name="id" value="<?php echo $info['id']?>" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label">姓名：</label>
                            <div class="col-sm-3">
                                <input name="realname" value="<?php echo $info['realname']?>" minlength="2" type="text" class="form-control" valType="required" msg="姓名不能为空" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">手机号：</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="tel" value="<?php echo $info['tel']?>" valType="MOBILE" msg="手机号格式不正确"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">车辆品牌：</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="car_brand" value="<?php echo $info['car_brand']?>" valType="required" msg="车辆品牌不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">车辆颜色：</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="car_color" value="<?php echo $info['car_color']?>" valType="required" msg="车辆颜色不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">车牌号码：</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="car_num" value="<?php echo $info['car_num']?>" valType="required" msg="车牌号码不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">驾驶证号码：</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="drive_license_num" value="<?php echo $info['drive_license_num']?>" valType="required" msg="驾驶证不能为空">
                            </div>
                        </div>
                        <div class="form-group">
			                 <label class="col-sm-3 control-label">驾驶证正面照:</label>
			                 <div class="col-sm-9">
				                <ul id="uploader_jsz_img">
	                               <?php if($info['drive_license_front']):?>
                                    <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                                    <a class='close del-pic' href='javascript:;'></a>
                                    <a href="<?php echo $info['drive_license_front'];?>" target="_blank"><img src="<?php echo get_img_url($info['drive_license_front']);?>" style='width:100%;height:100%'/></a>
                                    <input type="hidden" name="jsz_img" value="<?php echo $info['drive_license_front'];?>"/>
                                    </li>
                                    <?php endif;?>
	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
	                                   <a href="javascript:;" class="up-img"  id="btn_jsz_img"><span>+</span><br>添加照片</a>
	                               </li>
	                            </ul>
			                 </div>
		                 </div>
		                 <div class="form-group">
			                 <label class="col-sm-3 control-label">身份证正面照:</label>
			                 <div class="col-sm-9">
				                <ul id="uploader_sfz_img">
				                   <?php if($info['identity_card_front']):?>
                                    <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                                    <a class='close del-pic' href='javascript:;'></a>
                                    <a href="<?php echo $info['identity_card_front'];?>" target="_blank"><img src="<?php echo get_img_url($info['identity_card_front']);?>" style='width:100%;height:100%'/></a>
                                    <input type="hidden" name="sfz_img" value="<?php echo $info['identity_card_front'];?>"/>
                                    </li>
                                    <?php endif;?>
	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
	                                   <a href="javascript:;" class="up-img"  id="btn_sfz_img"><span>+</span><br>添加照片</a>
	                               </li>
	                            </ul>
			                 </div>
		                 </div>
		                 <div class="form-group">
			                 <label class="col-sm-3 control-label">行驶证正面照:</label>
			                 <div class="col-sm-9">
				                <ul id="uploader_xsz_img">
	                               <?php if($info['drive_registration_front']):?>
                                    <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                                    <a class='close del-pic' href='javascript:;'></a>
                                    <a href="<?php echo $info['drive_registration_front'];?>" target="_blank"><img src="<?php echo get_img_url($info['drive_registration_front']);?>" style='width:100%;height:100%'/></a>
                                    <input type="hidden" name="xsz_img" value="<?php echo $info['drive_registration_front'];?>"/>
                                    </li>
                                    <?php endif;?>
	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
	                                   <a href="javascript:;" class="up-img"  id="btn_xsz_img"><span>+</span><br>添加照片</a>
	                               </li>
	                            </ul>
			                 </div>
		                 </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">认证状态：</label>
                            <div class="col-sm-3">
                                <select class="form-control m-b" name="auth_status">
                                    <option <?php if($info['auth_status'] == 0){echo 'selected';}?> value="0">未认证</option>
                                    <option <?php if($info['auth_status'] == 1){echo 'selected';}?> value="1">已认证</option>
                                    <option <?php if($info['auth_status'] == 2){echo 'selected';}?> value="2">认证失败</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">信誉分：</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" value="<?php echo $info['reputation_score']?>" name="reputation_score">
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
        var baseUrl = "<?php echo $domain['admin']['url'];?>";
    	var staticUrl = "<?php echo $domain['static']['url']?>";
    	var uploadUrl = "<?php echo $domain['upload']['url']?>";
	    var object = [
		      {"obj": "#uploader_jsz_img", "btn": "#btn_jsz_img"},
		      {"obj": "#uploader_sfz_img", "btn": "#btn_sfz_img"},
		      {"obj": "#uploader_xsz_img", "btn": "#btn_xsz_img"}
	    ];
	    seajs.use(['bootstrap', 'metisMenu', 'slimscroll'], function() {	
        });
        //Custom and plugin javascript
		seajs.use(['admin_uploader','jqueryswf','swfupload','jqvalidate','<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function(swfupload) {
			swfupload.swfupload(object);
        });
    </script>

</body>

</html>