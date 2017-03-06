<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <a href="/manual/add" class="btn btn-w-m btn-primary">添加手工位内容</a>
                    <form role="form" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="exampleInputEmail2" class="sr-only">分类</label>
                            <select class="form-control" name="manual_class_id">
                                <option value='0'>请选择手工位类别</option>
                                <?php foreach ($manual_class_lists as $k=>$v):?>
                                <option value="<?php echo $k?>" <?php if($manual_class_id == $k):?>selected<?php endif;?> ><?php echo $v?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="exampleInputPassword2" class="sr-only"></label>
                            <input type="text" name="title" <?php if(isset($title)): ?>value="<?php echo $title?>"<?php endif;?> placeholder="按照标题查找" id="exampleInputPassword2" class="form-control">
                        </div>
                        <input class="btn btn-white" type="submit" value="查找"/>
                    </form>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>ID</th>
                		<th>标题</th>
                		<th>简介</th>
                		<th>导读图</th>
                		<th>链接地址</th>
                		<th>删除状态</th>
                		<th>最后修改人</th>
                		<th>最后修改时间</th>
                		<th>排序</th>
                		<th>操作</th>
        	        </tr>
                    <?php if(isset($list)):?>
                	<?php foreach ($list as $k=>$v):?>
                            <tr <?php if($k%2 !=0 ){ echo 'class="odd"';}?>>
                                <td><?php echo $v['id']?></td>
                                <td><?php echo $v['title']?></td>
                                <td style="width: 40px"><?php echo $v['summary']?></td>
                                <td><a href="<?php echo $v['img_url'];?>" target="_blank"><img src="<?php echo get_img_url($v['img_url']);?>" style="width: 200px; "></a></td>
                                <td style="width: 40px"><?php echo $v['url']?></td>
                                <td><?php if ($v['is_del']==0):?><span>正常</span>
                        		<?php else:?><span style="color:red;font-weight:bold;">删除</span>
                        		<?php endif;?>
                        		</td>
                                <td><?php echo $admins[$v['create_user']];?></td>
                                <td><?php echo $v['update_time']?></td>
                                <td><?php echo $v['sort']?></td>
                                <td><a href="/manual/edit/<?php echo $v['id']?>" class="btn btn-outline btn-primary">修改</a> 
                                <a href="javascript:;" class="btn btn-outline btn-primary delete"  data-id="<?php echo $v['id']?>"  onClick="delete_data('/manual/del/<?php echo $v['id']?>')">删除</a>
                                </td>
                            </tr> 
                          <?php endforeach;?>
                	<?php endif;?> 
                </table>
                <!-- page -->
                <div class="row">
                    <nav style="float: right">
                        <ul class="pagination">
                            <li class="disabled"><a>共<?php echo isset($data_count) ? $data_count: '0';?>条</a></li>
                            <?php echo isset($pagestr) ? $pagestr : ''?>
                        </ul>
                    </nav>
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