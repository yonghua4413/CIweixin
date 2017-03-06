$(function(){
	$(".submit").click(function(){
		var user_mobile = $("input[name='phone']").val();
		var verify = $("input[name='code']").val();
		var invite_code = $('input[name=invite_code]').val();
		if(user_mobile == ''){
			$("#message").html('手机号不能为空！');
			$('input[name="phone"]').focus();
			return false;
        }
		var isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
		if(!isMobile.test(user_mobile)){
			$("#message").html('手机号不正确！');
			$('input[name="phone"]').focus();
			return false;
		}
		if(verify == ''){
			$("#message").html('手机验证码不能为空！');
			$('input[name="code"]').focus();
			return false;
        }
		else{
			$("#message").html("");
		}
		
	  	$.post(
    			'/user/check_login', 
    			{mobile:user_mobile,verify:verify,invite_code:invite_code}, 
    			function(data){
    				if(data.status == 2){
    					my_dialog.dialog1('提示', data.msg, function(){
    						window.location.href=data.url;
    					});
    				}else if(data.status != 0){
    					$("#message").html(data.msg);
    				}else{
    					window.location.href=data.url;
    				}
    	});
	});
	
    $('#getCode').on('click', function(){
        var btn = $(this);
        var count = 60;
        var mobile_num = $('input[name="phone"]').val();
        var token = $('input[name="token"]').val();
        var is_mobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
        
        if(!is_mobile.test(mobile_num)){
        	$("#message").html("请输入11位有效手机号！");
        	return false;
        }else{
			$("#message").html("");
		}
        btn.text(count+"秒后可重获取");
        var resend = setInterval(function(){
            count--;
            if (count > 0){
                btn.text(count+"秒后可重获取");
                btn.attr('disabled',true).css('cursor','not-allowed');
            }else {
                clearInterval(resend);
                btn.text("获取验证码").removeAttr('disabled').removeAttr('style');
            }
        }, 1000);
        $.post(
        		"/publicservice/mobile_code", 
        		{mobile:mobile_num,token:token},
        		function(data){
        			if(data.status !=0){
        				$("#message").html(data.msg);
        				clearInterval(resend);
                        btn.text("获取验证码").removeAttr('disabled').removeAttr('style');
        			}
        		},
        		'json'
        );
        
    });
    
    //邀请码
    $(".invite-code").click(function(){
    	$("#invite_code_input").toggle();
    })
});