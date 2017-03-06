<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
             <div class="ibox-content">
                    <form class="form-horizontal" action="/configes/index" method="post">
                        <p>欢迎登录本站(⊙o⊙)</p>
                        <p>
                            <a href="javascript:;" class="btn btn-w-m btn-primary">前台设置</a>
                        </p>
                                
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">网站名称：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="网站名称" class="form-control" name="web_name" value="<?php echo $list['web_name']?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">网站标语：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="网站标语" class="form-control" name="web_sign" value="<?php echo $list['web_sign']?>">
                            </div>
                        </div>
                        
                    
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">首页SEO标题：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="首页SEO标题" class="form-control" name="seo_title" value="<?php echo $list['seo_title']?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">首页SEO关键字：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="首页SEO关键字" class="form-control" name="seo_keywords" value="<?php echo $list['seo_keywords']?>">
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">首页SEO描述：</label>

                            <div class="col-sm-4">
                                <textarea  class="form-control" name="seo_description" style="height:200px"><?php echo $list['seo_description']?></textarea>
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">统计代码：</label>

                            <div class="col-sm-4">
                                <textarea  class="form-control" name="cnzz" style="height:200px"><?php echo $list['cnzz']?></textarea>
                                
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
 	    seajs.use(['bootstrap', 'metisMenu', 'slimscroll','leftMenu'], function() {	
      });
        //Custom and plugin javascript
		seajs.use(['admin_uploader','jqueryswf','swfupload','jqvalidate'], function(swfupload) {
			swfupload.swfupload(object);
        });
    </script>
    

</body>

</html>