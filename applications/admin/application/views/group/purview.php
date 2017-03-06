<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>权限设置</h5>
                            <div class="ibox-tools">
                                    <a href="javascript:window.history.go(-1)">
                                        <i class="fa fa-mail-reply"></i> 返回
                                    </a>

                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                	<thead>
                                	<form method="post" id='purviewForm'>
                                		<tr>
                                			<th width="10%">项目</th>
                                			<th>
                                				<span style="width: 10%; text-align: left;">权限</span>
                                				<span style="width: 90%">子权限</span>
                                			</th>
                                		</tr>
                                	</thead>
                                	<tbody>
                                	<?php if($list){?>
                                		<?php foreach($list as $key=>$val){?>
                                			<tr class="check_body">
                                				<td>
                                					<input type="checkbox" name="purview[]" onclick="selectAll(this,'.1_<?php echo $val['id'];?>');" value="<?php echo $val['id'];?>" <?php if(in_array($val['id'],$purview_ids)){ echo 'checked="true"';}?>/>
                                					<?php echo $val['name'];?>
                                				</td>
                                				<td>
                                					<table id="son_child" width="100%" class="table table-bordered table-striped table-hover">
                                						<?php if(@$val['child']){?>
                                						<?php foreach(@$val['child'] as $k=>$v){?>
                                							<tr>
                                								<td>
                                									<table id="son">
                                										<tr>
                                											<td>
                                												<?php echo $v['name'];?>
                                												<input class="1_<?php echo $val['id'];?>" type="checkbox" name="purview[]" onclick="selectAll(this,'.2_<?php echo $v['id'];?>');" value="<?php echo $v['id'];?>"
                                													<?php if(in_array($v['id'],$purview_ids)){ echo 'checked="true"';}?>/>
                                											</td>
                                											<?php  if(@$v['child']){ ?>
                                												<td>
                                												
                                															<?php
                                															if(@$v['child']){foreach(@$v['child'] as $kk=>$vv){  ?>
                                																
                                																  <div style="margin-left: 20px;">  
                                    																	<?php echo $vv['name']?>
                                    																	<input class="2_<?php echo $v['id'];?> 1_<?php echo $val['id'];?>" type="checkbox" name="purview[]" value="<?php echo $vv['id'];?>"  <?php if(in_array($vv['id'],$purview_ids)){ echo 'checked="true"';}?> />
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
                                	<tr>
                                		<td colspan="2" style="text-align: center;">
                                		  <input type="hidden" name="id" value="<?php echo $id?>">
                                			<input type="checkbox" name="dd" id="all_check">全选
                                			<input id='submit' type="button" value="确定" style=" cursor: pointer; width: 100px; height: 30px; margin-left: 10px; color: #000000;" />
                                		</td>
                                	</tr>
                                	</form>
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
        ], function(a) {
        	a.purview_appoint();
        });

        function selectAll(obj,div_id){
              $(div_id).prop("checked", $(obj).prop("checked"));
        }
        function sel(obj) {
          if (obj.checked) {
              var attr = $(".check_body").find("input");
              for (var i = 0; i <= attr.length; i++) {
                  if (attr[i] != undefined || attr[i] != null)
                      attr[i].checked = true;
              }
          } else {
              var attr = $(".check_body").find("input");
              for (var i = 0; i <= attr.length; i++) {
                  if (attr[i] != undefined || attr[i] != null)
                      attr[i].checked = false;
              }
        
          }
        }
    </script>
    
</body>

</html>