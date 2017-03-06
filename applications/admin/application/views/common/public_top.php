<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" > 
        <!-- 启用360浏览器的极速模式 -->
    <meta name="renderer" content="webkit">

    <title>PHP学院 - 后台主页</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="<?php echo css_js_url('bootstrap.min.css', 'admin');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $domain['static']['url'].'/admin/font-awesome/css/font-awesome.css';?>" type="text/css" rel="stylesheet"/>

    <!-- Morris -->
    <link href="<?php echo $domain['static']['url'].'/admin/css/plugins/morris/morris-0.4.3.min.css';?>" type="text/css" rel="stylesheet"/>
    <!-- Gritter -->
    <link href="<?php echo $domain['static']['url'].'/admin/js/plugins/gritter/jquery.gritter.css';?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo css_js_url('animate.css', 'admin');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo css_js_url('style.css', 'admin');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $domain['static']['url'];?>/admin/wangeditor/css/wangEditor.min.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo css_js_url('ui-dialog.css', 'admin');?>" type="text/css" rel="stylesheet"/>


</head>
    <script type="text/javascript">
	    	var baseUrl = "<?php echo $domain['admin']['url'];?>";
	        var staticUrl = "<?php echo $domain['static']['url']?>";
	        var uploadUrl = "<?php echo $domain['upload']['url']?>";
	    </script>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php $this->load->view('common/lefts');?>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php $this->load->view('common/tops');?>