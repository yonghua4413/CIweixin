<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
             <div class="ibox-content">
                    <form class="form-horizontal" action="/manualclass/edit/<?php echo $info['id']?>" method="post">
                        <p>欢迎登录本站(⊙o⊙)</p>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">分类名称：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="分类名称" class="form-control" name="name" value="<?php echo $info['name']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">排序：</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="排序" class="form-control" name="sort" value="<?php echo $info['sort']?>">
                            </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-sm-3 control-label">是否删除：</label>
                            <div >
                                <input type="radio" value="0" name="is_del" id="optionsRadios1" <?php if($info['is_del']==0):?>checked="true"<?php endif;?>>正常
                                <input type="radio" value="1" name="is_del" id="optionsRadios2" <?php if($info['is_del']==1):?>checked="true"<?php endif;?>>删除
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
	    seajs.use(['bootstrap', 'metisMenu', 'slimscroll'], function() {	
        });
        //Custom and plugin javascript
		seajs.use(['<?php echo css_js_url('hplus.js', 'admin');?>', '<?php echo css_js_url('/plugins/pace/pace.min.js', 'admin');?>'], function() {
			
        });
    </script>

</body>

</html>