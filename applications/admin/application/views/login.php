<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" > 
    <title>欢迎登录后台管理系统--PHP学院</title>
    <link href="<?php echo css_js_url('style.css', 'admin');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo css_js_url('admin.css', 'admin');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo css_js_url('ui-dialog.css', 'common');?>" type="text/css" rel="stylesheet"/>
</head>
<body class="login-body">
<div id="mainBody">
    <div id="cloud1" class="cloud"></div>
    <div id="cloud2" class="cloud"></div>
</div>
<div class="loginbody">
    <span class="systemlogo"></span>
    <div class="loginbox">
        <ul>
            <li id="J_loginuser"><input name="name" type="text" class="loginuser"   placeholder="请输入用户名"/></li>
            <li id="J_loginpwd"><input name="password" type="password" class="loginpwd"   placeholder="请输入密码"/></li>
            <?php if($verify['val'] == 1){?>
            <li id="J_yzm" class="yzm">
                <span><input name="verify" type="text" placeholder="验证码" required class="verify" /></span>
                <cite> <img src="/login/code" id="verify_img" /></cite>
            </li>
            <?php } ?>
            <input type="hidden" name="verify_type" class="verify_type" value="<?php echo $verify['val'];?>" />
           <li><input  type="button" class="loginbtn" value="登录"  />
        </ul>
    </div>
</div>
<div class="loginbm">版权所有  2016-2020</div>
<script src="<?php echo css_js_url('sea.js','common');?>"></script>
<script type="text/javascript">
    seajs.config({
        base: "<?php echo $domain['static']['url'];?>",
        alias: {
            "jquery": "<?php echo css_js_url('jquery.min.js', 'common');?>",
            "dialog": "<?php echo css_js_url('dialog.js','common');?>",
            "jqueryplaceholder": "<?php echo css_js_url('jquery.placeholder.js','common');?>",
            "public": "<?php echo css_js_url('public.cmd.js','admin');?>",
            "login": "<?php echo css_js_url('login.js', 'admin');?>",
        },
        preload: ["jquery"]
    });

    seajs.use(["login", 'public'], function(a,p) {
        p.setPlaceholder();
        a.reflashCode();
        a.doLogin();
    });
</script>
</body>
</html>
