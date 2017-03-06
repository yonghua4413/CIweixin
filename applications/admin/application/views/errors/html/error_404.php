<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

.gray-bg {
	background-color: #f3f3f4;
	height: 100%;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}
.middle-box {
    max-width: 400px;
    z-index: 100;
    margin: 0 auto;
    padding-top: 40px;
}

.fadeInDown {
    -webkit-animation-name: fadeInDown;
    animation-name: fadeInDown;
}
.animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    z-index: 100;
}
.text-center {
    text-align: center;
}

.middle-box h1 {
    font-size: 170px;
    color: #1ab394;
}

.font-bold {
    font-weight: 600;
}

</style>
</head>
<body class="gray-bg">

    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">页面未找到！</h3>

        <div class="error-desc">
            抱歉，页面好像去火星了~

        </div>
    </div>



</body>
</html>