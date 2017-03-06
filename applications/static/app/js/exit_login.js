function exit(){
	my_dialog.dialog1('提示', '确认退出登录？', function(){
		window.location.href=baseUrl+"/User/logout";
	})
}