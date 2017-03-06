<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
             <div class="ibox-content">
                    <form class="form-horizontal" action="/manual/edit/<?php echo $id?>" method="post">
                        <p>欢迎登录本站(⊙o⊙)</p>
                        
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">手工位置：</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="manual_class_id">
                                    <option value='0'>--请选择--</option>
                                    <?php foreach ($manual_class as $k=>$v) :?>
                                        <option value="<?php echo $v['id']?>" <?php if($v['id']==$manual_class_id):?>selected="true"<?php endif;?>><?php echo $v['name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">标题：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="标题" class="form-control" name="title" value="<?php echo $manual_info['title']?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">链接地址：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="链接地址" class="form-control" name="url" value="<?php echo $manual_info['url']?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
			                 <label class="col-sm-3 control-label">导读图片:</label>
			                 <div class="col-sm-9">
			                     <ul id="uploader_img_url">
                                    <?php if($manual_info['img_url']):?>
                                    <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                                        <a class='close del-pic' href='javascript:;'></a>
                                        <a href="<?php echo $manual_info['img_url'];?>" target="_blank"><img src="<?php echo get_img_url($manual_info['img_url']);?>" style='width:100%;height:100%'/></a>
                                        <input type="hidden" name="img_url" value="<?php echo $manual_info['img_url'];?>"/>
                                    </li>
                                    <?php endif;?>
                                    <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
                                        <a href="javascript:;" class="up-img"  id="btn_img_url"><span>+</span><br>添加照片</a>
                                    </li>
                                </ul>
			                 
			                 </div>
		                 </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">排序：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="排序" class="form-control" name="sort" value="<?php echo $manual_info['sort']?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">简介：</label>

                            <div class="col-sm-4">
                                <textarea  class="form-control" name="summary" style="height:200px"><?php echo $manual_info['summary']?></textarea>
                                
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <button class="btn btn-sm btn-white" type="submit">添加</button>
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
                {"obj": "#uploader_img_url", "btn": "#btn_img_url"},
                {"obj": "#uploader_video", "btn": "#btn_video", "type":'video'},
	    ];
// 	    seajs.use(['bootstrap', 'metisMenu', 'slimscroll'], function() {	
//         });
        //Custom and plugin javascript
		seajs.use(['admin_uploader','jqueryswf','swfupload','jqvalidate'], function(swfupload) {
			swfupload.swfupload(object);
        });
    </script>
    

</body>

</html>