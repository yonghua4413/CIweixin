<?php $this->load->view('common/public_top');?>
            <!-- right main -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper wrapper-content">
                        <div class="middle-box text-center">
                            <h3 class="font-bold"><?php echo $message;?></h3>

                            <div class="error-desc">
                                如果您不做出选择，将在 <b id="spanSeconds"><?php echo $waitSecond;?></b>秒钟后跳转
                                <br/><a href="<?php echo $jumpUrl;?>" class="btn btn-primary m-t">如果您的浏览器没有跳转请点这里</a>
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
        //Mainly scripts
	      seajs.use(['bootstrap', 'metisMenu', 'slimscroll', 'leftMenu'], function() {	
        });

	      <!--
	      var seconds = <?php echo $waitSecond;?>;
	      var defaultUrl = "<?php echo $jumpUrl;?>";


	      onload = function()
	      {
	          if (defaultUrl == 'javascript:history.go(-1)' && window.history.length == 0)
	          {
	              document.getElementById('redirectionMsg').innerHTML = '';
	              return;
	          }

	          window.setInterval(redirection, 1000);
	      }
	      function redirection()
	      {
	          if (seconds <= 0)
	          {
	              window.clearInterval();
	              return;
	          }

	          seconds --;
	          document.getElementById('spanSeconds').innerHTML = seconds;

	          if (seconds == 0)
	          {
	              location.href = defaultUrl;
	          }
	      }
	      //-->
        
    </script>

</body>

</html>