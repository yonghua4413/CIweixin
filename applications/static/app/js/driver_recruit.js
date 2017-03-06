$(function(){
    $('.a-car-brand').on('click', function(event) {
        openUl(".div-car-brand");
    });
    
    
    $('.div-car-brand li').on('click',  function(event) {
        selectUl(".a-car-brand",$(this));
    });

    $('.a-car-num').on('click', function(event) {
        openUl(".div-car-num");
    });
    
    
    $('.div-car-num li').on('click',  function(event) {
        selectUl(".a-car-num",$(this));
    });
    
    $('body').on('click',function(event){
        $('.div-car-brand').hide('fast');
        $('.div-car-num').hide('fast');
    });
    

    //获取验证码
    $('.get-code').on('click', function(){
        var btn = $(this);
        var count = 60;
        var mobile_num = $('input[name="tel"]').val();
        var token = $('input[name="token"]').val();
        var is_mobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
        if(!is_mobile.test(mobile_num)){
            show_msg("input[name='tel']","请输入11位有效手机号！");
        	return false;
        }else{
			$(".message").html("");
		}
        $.post(
        		"/publicservice/mobile_code", 
        		{mobile:mobile_num,token:token},
        		function(data){
        			if(data.status !=0){
        				$(".message").html(data.msg);
        			}
        		},
        		'json'
        );
        var resend = setInterval(function(){
            count--;
            if (count > 0){
                btn.text(count+"秒后可重获取");
                $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
            }else {
                clearInterval(resend);
                btn.text("获取验证码").removeAttr('disabled style');
            }
        }, 1000);
        btn.attr('disabled',true).css('cursor','not-allowed');
    });

    //下一步
    $(".next-step").click(function(){
        if ($.trim($("input[name='tel']").val()) == "") {
            show_msg("input[name='tel']","手机号不能为空！");
            return false;
        } 

        if ($.trim($("input[name='code']").val()) == "") {
            show_msg("input[name='code']","验证码不能为空！");
            return false;
        } 

        if ($.trim($(".a-car-brand").attr("data-val")) == "") {
            show_msg("input[name='car_brand']","请选择车辆颜色！");
            return false;
        }

        if ($.trim($("input[name='car_brand']").val()) == "") {
            show_msg("input[name='car_brand']","请输入车辆品牌！");
            return false;
        }

        if ($.trim($(".a-car-num").attr("data-val")) == "") {
            show_msg("input[name='car_brand']","请选择车牌！");
            return false;
        }

        if ($.trim($("input[name='car_num']").val()) == "") {
            show_msg("input[name='car_num']","请输入车牌号！");
            return false;
        }

        $(".message").html("");
        $.post(
                "/DriverRecruit/step1", 
                {
                    token: $.trim($("input[name='token']").val()),
                    tel: $.trim($("input[name='tel']").val()),
                    code: $.trim($("input[name='code']").val()),
                    car_color: $.trim($(".a-car-brand").attr("data-val")),
                    car_brand: $.trim($("input[name='car_brand']").val()),
                    car_num: $.trim($(".a-car-num").attr("data-val")) + $.trim($("input[name='car_num']").val())
                },
                function(data){
                    if(data.status == 0 && data.data) {
                        window.location.href = "/DriverRecruit/step2/"+data.data;
                    } else {
                        $(".message").html(data.msg);
                    }
                },
                'json'
        );

    });

    //上传驾驶证和行驶证
    $(".upload-license").click(function(){
        var _self = $(this);
        $('#uploadImg').trigger('click');
        showPreview(_self);
    });


    //提交审核
    $(".submit-audit").click(function(){
        if ($.trim($("input[name='realname']").val()) == "") {
            show_msg("input[name='realname']","请输入司机姓名");
            return false;
        }

        if ($.trim($("input[name='drive_license_num']").val()) == "") {
            show_msg("input[name='drive_license_num']","请输入驾驶证号");
            return false;
        }

        if($.trim($("input[name=identity_card_front]").val()) == ''){
        	$('message').html('请上传身份证正面照');
        	return false;
        }
        if ($.trim($("input[name='drive_license_front']").val()) == "") {
            $(".message").html("请上传驾驶证正面图");
            return false;
        }

        if ($.trim($("input[name='drive_registration_front']").val()) == "") {
            $(".message").html("请上传行驶证正面图");
            return false;
        }

        $(".message").html("");
        $(this).html("提交中...");
        $.post(
                "/DriverRecruit/step2", 
                {
                    token: $.trim($("input[name='token']").val()),
                    id: $.trim($("input[name='id']").val()),
                    realname: $.trim($("input[name='realname']").val()),
                    drive_license_num: $.trim($("input[name='drive_license_num']").val()),
                    drive_license_front: $.trim($("input[name='drive_license_front']").val()),
                    drive_registration_front: $.trim($("input[name='drive_registration_front']").val()),
                    identity_card_front: $.trim($('input[name=identity_card_front]').val()),
                },
                function(data){
                    if(data.status == 0 && data.data) {
                        window.location.href = "/DriverRecruit/step3";
                    } else {
                        $(".message").html(data.msg);
                        $(this).html('提交审核');
                    }
                },
                'json'
        );

    });


    function showPreview(_self) {
        $('#uploadImg').on('change',function(e){
            var _img = _self.find('img');
            var data = new FormData();
            var load_toast = '';
            $.each($('#uploadImg')[0].files, function(i, file) {
                data.append('Filedata', file);
            });
            data.append('type', 'image');
            $.ajax({
                url:uploadUrl+'/File/upload_php',
                type:'POST',
                data:data,
                cache: false,
                contentType: false,    
                processData: false,
                beforeSend:function(){
                	load_toast = my_dialog.load_toast('上传中');
                	load_toast.show().removeAttr('style');
                },
                success:function(data){
                	load_toast.hide().remove();
                    $("#uploadImg").unbind("change");
                    data = JSON.parse(data);
                    if (data.error == 0) {
                        _img.attr("src",data.full_url);
                        _self.find("input[type='hidden']").val(data.url);
                        $('#uploadImg').val('');
                        _self = "";
                        e.stopPropagation();
                    }else{
                    	my_dialog.dialog2('提示', data.message.replace(/<\/?[^>]*>/, ''));
                    } 
                }
            });
        })
    }


    function show_msg(obj, msg) {
        $(".message").html(msg);
        $(obj).focus();
    }


    function openUl(obj) {
        event.preventDefault();
        event.stopPropagation();
        $(obj).toggle('fast');
    }

    function selectUl(obj,_self) {
        event.preventDefault();
        var val = _self.find('span').html();
        var clr = _self.find('em').css('background-color');
        var value = _self.find('input').val();
        if(!value){
        	value = val;
        }
        $(obj).css({
            background: clr,
            height:26,
            width:77
        });
        $(obj).text(val);
        $(obj).attr("data-val",value);
    }

});