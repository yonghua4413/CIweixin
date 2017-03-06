<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class=row>
            <div class="table-responsive ibox-content">

                <table class="table table-bordered table-hover">
                    <tr>
                        <th>编号(id)</th>
                        <th>姓名</th>
                        <th>用户手机</th>
                        <th>积分</th>
                        <th>时间</th>
                    </tr>
                    <?php if(isset($list)):?>
                    <?php foreach ($list as $k => $v):?>
                    <tr>
                        <td><?php echo $v['id']?></td>
                        <td><?php if(isset($realname)){echo $realname;}?></td>
                        <td><?php if(isset($v['tel'])){echo $v['tel'];}else{echo '';}?></td>
                        <td><?php if(isset($v['spend_score'])){echo $v['spend_score'];}?></td>
                        <td>
                            <?php echo $v['create_time'];?>
                        </td>
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