<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
             <div class="ibox-content">
                    <form class="form-horizontal" action="/version/add" method="post">
                        <p>欢迎登录本站(⊙o⊙)</p>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">名称：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="名称" class="form-control" name="web_type">
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