<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <a href="/version/add" class="btn btn-w-m btn-primary">添加</a>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号</th>
                        <th>所属网站类型</th>
                        <th>css版本号</th>
                        <th>js版本号</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach($list as $key => $val):?>
                    <tr <?php if($key%2 !=0 ){ echo 'class="odd"';}?>>
                        <td><?php echo $val['id']?></td>
                        <td><?php echo $val['web_type']?></td>
                        <td><?php echo $val['css_version_id']?></td>
                        <td><?php echo $val['js_version_id']?></td>
                        <td><?php echo $val['create_time']?></td>
                        <td><?php echo $val['update_time']?></td>
                        <td>
                            <a href="/version/refresh/<?php echo $val['id'];?>" class="btn btn-outline btn-primary">刷新</a>   
                            <a href="javascript:;" class="btn btn-outline btn-primary" onClick="delete_data('/version/del/<?php echo $val['id']?>')">删除</a>
                        </td>
                    </tr> 
                    <?php endforeach;?>
                </table>
                <!-- page -->
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
    <script src="<?php echo css_js_url('jquery.min.js', 'common')?>"></script>
    <script src="<?php echo css_js_url('dialog.js', 'common')?>"></script>
    <script>
		var delete_data = function(url){
			var d = dialog({
				title:"提示",
				content:"你确定要删除吗",
				cancelValue:"取消",
				cancel:function(){},
				ok:function(){
					window.location.href=url;
				},
				okValue:"确定"
			})
			d.width(320);
			d.showModal();
			} 

    </script>

</body>

</html>