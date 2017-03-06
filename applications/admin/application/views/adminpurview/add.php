<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>权限添加</h5>
                            <div class="ibox-tools">
                                <a href="javascript:window.history.go(-1)">
                                    <i class="fa fa-mail-reply"></i> 返回
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal m-t" id="purviewForm" novalidate="novalidate" >
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">上级分类：</label>
                                    <div class="col-sm-8">
                                            <select id='parent_id' class="form-control m-b" name="parent_id">
                                            	<option value="0">顶级权限</option>
                                                {if $parent_purviews}
                                                <?php if($parent_purviews){?>
                                                    <?php foreach($parent_purviews as $id=>$v){?>
                                                        <option value="<?php echo $v['id']?>"
                                            		<?php if($v['id'] == $parent_id){?> selected="true" <?php }?>>
                                                                   <?php echo  str_repeat("——",$v['level']).$v['name'];?>
                                                        </option>
                                                            <?php } ?>
                                                <?php }?>
                                            </select>
                                      </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">权限代码：</label>
                                    <div class="col-sm-8">
                                        <input id="url" name="url" class="form-control" type="text" aria-required="true" aria-invalid="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">权限名称：</label>
                                    <div class="col-sm-8">
                                        <input id="name" name="name" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">排序：</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="sort" name="sort" value=0 class="form-control" >
                                    </div>
                                </div>

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
        	a.add();
        });
    </script>
    
</body>

</html>