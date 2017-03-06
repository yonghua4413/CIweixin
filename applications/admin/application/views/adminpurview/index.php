<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>权限设置</h5>
                            <div class="ibox-tools">
                                
                                <a href="/adminspurview/add">
                                    <label>添加权限</label>
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>项目</th>
                                            <th> 权限</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($list){?>
                                        <?php foreach($list as $key=>$val){?>
                                            <tr>
                                                <td>
                                                    <?php echo $val['name'];?>
                                                    <a href="/adminspurview/edit?id=<?php echo $val['id']?>" title="编辑"><i class="fa fa-edit"></i></a>
                                                    <a class="purview_del" data-id="<?php echo $val['id']?>" title="删除"><i class="fa fa-times"></i></a>
                                                    <a href="/adminspurview/add?id=<?php echo $val['id']?>" title="添加"><i class="fa fa-plus"></i></a>
                                                </td>
                                                <td>
                                                    <table id="son_child" class="table table-bordered table-striped table-hover">
                                                        <?php if(@$val['child']){?>
                                                            <?php foreach(@$val['child'] as $k=>$v){?>
                                                                <tr>
                                                                    <td>
                                                                        <table id="son" >
                                                                            <tr>
                                                                                <td>
                                                                                    <?php echo $v['name'];?>
                                                                                    <a href="/adminspurview/edit?id=<?php echo $v['id']?>" title="编辑"><i class="fa fa-edit"></i></a>
                                                                                    <a class="purview_del" data-id="<?php echo $v['id']?>" title="删除"><i class="fa fa-times"></i></a>
                                                                                    <a href="/adminspurview/add?id=<?php echo $v['id']?>" title="添加"><i class="fa fa-plus"></i></a>
                                                                                </td>
                                                                                <?php  if(@$v['child']){ ?>
                                                                                    <td>
                                                                                        <?php
                                                                                        if(@$v['child']){foreach(@$v['child'] as $kk=>$vv){  ?>
                                                                                            <div style="margin-left: 20px;">
                                                                                                    <?php echo $vv['name']?>
                                                                                                    <a href="/adminspurview/edit?id=<?php echo $vv['id']?>" title="编辑"><i class="fa fa-edit"></i></a>
                                                                                                    <a class="purview_del" data-id="<?php echo $vv['id']?>" title="删除"><i class="fa fa-times"></i></a>
                                                                                             </div>   
                                                                                        <?php }}?>
                                                                                    </td>
                                                                                <?php }?>
                            
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                            
                                                    </table>
                                                </td>
                            
                                            </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                            </div>
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
        	a.del();
        });
    </script>
    
</body>

</html>