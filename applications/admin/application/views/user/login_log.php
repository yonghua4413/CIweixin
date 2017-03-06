<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">
                <p>
                    <form role="form" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="exampleInputPassword2" class="sr-only"></label>
                            <input type="text" name="tel" value="<?php if(isset($tel)){echo $tel;}?>" placeholder="请输入手机号" id="exampleInputPassword2" class="form-control">
                        </div>
                        <input class="btn btn-white" type="submit" value="查找"/>
                    </form>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号(ID)</th>
                        <th>手机号</th>
                        <th>登陆时间</th>
                        <th>登陆ip</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $v['id']?></td>
                        <td><?php if(isset($v['tel'])){echo $v['tel'];}else{echo '';}?></td>
                        <td><?php echo $v['login_time']?></td>
                        <td><?php echo $v['login_ip']?></td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </table>
                <!-- page -->
                <div class="row">
                    <nav style="float: right">
                        <ul class="pagination">
                            <li class="disabled"><a>共<?php echo isset($count) ? $count: '0';?>条</a></li>
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

</body>

</html>