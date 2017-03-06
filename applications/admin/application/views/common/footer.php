<!-- 弹出层 -->
<div id="back_bg"></div>
<!-- 弹出框 -->
    <script src="<?php echo css_js_url('sea.js','common');?>"></script>
    <script type="text/javascript">
        seajs.config({
            base: "<?php echo $domain['static']['url'];?>",
            alias: {
              "jquery": "<?php echo css_js_url('jquery.min.js', 'common');?>",
              "base": "<?php echo css_js_url('base.js','admin');?>",
              "form": "<?php echo css_js_url('jquery.form.js','admin');?>",
              "datepicker": "<?php echo css_js_url('datepicker/WdatePicker.js', 'common');?>",
              "dialog": "<?php echo css_js_url('dialog.js','common');?>",
              'jqueryswf':"<?php echo css_js_url('jquery.swfupload.js', 'common');?>",
              "swfupload" : "<?php echo css_js_url('swfupload.js', 'admin')?>",
              "admin_uploader": "<?php echo css_js_url('admin_uploader.js', 'admin');?>",
              "admin_upload_shuiyin": "<?php echo css_js_url('admin_upload_shuiyin.js', 'admin');?>",
              "bootstrap" : "<?php echo css_js_url('bootstrap.min.js', 'admin')?>",
              "jqvalidate" :"<?php echo css_js_url('jq.validate.js', 'admin')?>",
              "wdate":"<?php echo $domain['static']['url'];?>/common/js/datepicker/WdatePicker.js",
              'metisMenu' : "<?php echo css_js_url('plugins/metisMenu/jquery.metisMenu.js', 'admin')?>",
              'slimscroll' : "<?php echo css_js_url('plugins/slimscroll/jquery.slimscroll.min.js', 'admin')?>",
              'leftMenu': "<?php echo css_js_url('hplus.js', 'admin');?>",
              'wangeditor' : "<?php echo $domain['static']['url'];?>/admin/wangeditor/js/wangEditor.min.js"
            },
            preload: ["jquery"]
        });
    </script>
