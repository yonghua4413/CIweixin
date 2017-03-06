(function ($) {
	/*倒计时*/
    $.fn.CountDown = function (t,e,n) {
		function r() {
            return e -= 1,
            0 >= e ? (clearInterval(window.counter), void(n && n())) : void t.text(e)
        }
        e = e || 30,
        t.text(e),
        clearInterval(window.counter),
        window.counter = setInterval(r, 1e3)
	},
	$.fn.ShowCancel = function (t,n) {
		$("#d_wall").show();
	    $("#d_wrap").show();
	    $("#d_wall").css("background-color","#000").css("display","block");
		$("#d_dialog_footer").show();
		$("#d_wrap").addClass("dialogalert").removeClass("dialogloading");
		$("#dialog-icons").addClass("icon-alert").removeClass("icon-loading");
		$("#dialog-icons").css("width","61px").css("height","61px").css("background-size","61px 61px");
	    $("#dialog-p1").html(t);
		$("#dialog-p1").css("color","#666666").css("font-size","18px").css("font-weight","700");
	    $("#dialog-p2").html(n);
		$("#dialog-p2").css("color","#666666").css("font-size","14px");
	    var l= ($(window).width()-280 ) / 2;
	    var h= ($(window).height()-$("#d_wrap").height()-20 ) / 2;
	    $("#d_wrap").css("left",l+"px");
	    $("#d_wrap").css("top",h+"px");
	},
	$.fn.ShowTel = function (t,n) {
		$("#d_wall").show();
	    $("#d_wrap").show();
	    $("#d_wall").css("background-color","#000").css("display","block");
		$("#d_dialog_footer").show();
		$("#d_wrap").addClass("dialogalert").removeClass("dialogloading");
		$("#dialog-icons").addClass("icon-alert").removeClass("icon-loading");
		$("#dialog-icons").css("width","61px").css("height","61px").css("background-size","61px 61px");
	    $("#dialog-p1").html(t);
		$("#dialog-p1").css("color","#666666").css("font-size","18px").css("font-weight","700");
	    $("#dialog-p2").html(n);
		$("#dialog-p2").css("color","#666666").css("font-size","14px");
	    var l= ($(window).width()-280 ) / 2;
	    var h= ($(window).height()-$("#d_wrap").height()-20 ) / 2;
	    $("#d_wrap").css("left",l+"px");
	    $("#d_wrap").css("top",h+"px");
		$("#btn_close").html("取消").removeClass("btn-orange").addClass("btn-gray").show().css("width","40%");
		$("#btn_confirm").html("确定").show();
		$("#btn_confirm").attr("href","tel:"+tel);
	},
	$.fn.ShowError = function (t,n) {
		$("#d_wall").show();
	    $("#d_wrap").show();
	    $("#d_wall").css("background-color","#000").css("display","block");
		$("#d_dialog_footer").show();
		$("#d_wrap").addClass("dialogalert").removeClass("dialogloading");
		$("#dialog-icons").addClass("icon-alert").removeClass("icon-loading");
		$("#dialog-icons").css("width","61px").css("height","61px").css("background-size","61px 61px");
	    $("#dialog-p1").html(t);
		$("#dialog-p1").css("color","#666666").css("font-size","18px").css("font-weight","700");
	    $("#dialog-p2").html(n);
		$("#dialog-p2").css("color","#666666").css("font-size","14px");
	    var l= ($(window).width()-280 ) / 2;
	    var h= ($(window).height()-$("#d_wrap").height()-20 ) / 2;
	    $("#d_wrap").css("left",l+"px");
	    $("#d_wrap").css("top",h+"px");
		$("#btn_close").html("我知道了").removeClass("btn-gray").addClass("btn-orange").show().css("width","100%");
		$("#btn_confirm").hide();
		$("#btn_close").click(function(e){
			 $("#d_wall").hide();
			 $("#d_wrap").hide();						 
		});
	},
	$.fn.ShowLoading = function (t) {
		$("#d_wall").show();
	    $("#d_wrap").show();
	    $("#d_wall").css("background-color","#ffffff");
		$("#d_dialog_footer").hide();
		$("#d_wrap").addClass("dialogloading").removeClass("dialogalert");
		$("#dialog-icons").removeClass("icon-alert").addClass("icon-loading");
		$("#dialog-icons").css("width","30px").css("height","30px").css("background-size","30px 30px");
	    var l= ($(window).width()-$("#d_wrap").width() ) / 2;
	    var h= ($(window).height()-$("#d_wrap").height()-20 ) / 2;
	    $("#d_wrap").css("left",l+"px");
	    $("#d_wrap").css("top",h+"px");
	    $("#dialog-p1").html(t).show();
		$("#dialog-p1").css("color","#fff").css("font-size","13px");
	},
	$.fn.Hide= function(){
		$("#d_wall").hide();
		$("#d_wrap").hide();		
	}
})(Zepto);


var wall='<div id="d_wall" class="dialog-wall"  style="opacity: 0.5; width: 100%; height: 100%; display: none; "></div>';
var tips='<div class="slide-tips-cont open"><div class="slide-tips"></div></div>';
var dia='<div id="d_wrap" class="dialog-wrap" >';
dia+='  <div style="padding: 0px 16px;">';
dia+='    <p class="dialog_icon" style="margin:20px 0px 12px 0">';
dia+='      <span class="dialog-icon icon-alert" id="dialog-icons" style="display: inline-block; width:61px;height:61px; background-size:61px 61px;">';
dia+='      </span>';
dia+='    </p>';
dia+='    <p class="dialog-p" id="dialog-p1" style="color:#666666;font-size:1.1em;">';
dia+='    </p>';
dia+='    <p class="dialog-p"  id="dialog-p2" style="color:#666666;font-size:0.9em;">';
dia+='    </p>';
dia+='    <div id="d_dialog_footer" class="dialog-footer">';
dia+='      <a class="btn-gray" id="btn_close" style="width: 40%;font-size:16px;" >';
dia+='        返回';
dia+='      </a>';
dia+='      <a class="btn-orange" id="btn_confirm" style="width: 40%;margin-left:15px;font-size:16px;" >';
dia+='        确认送达';
dia+='      </a>';
dia+='    </div>';
dia+='  </div>';
dia+='</div>';
 

var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/; 
$(document).ready(function(){ 
	$("body").append(dia);
	$("body").append(wall);
	
	$("#list .mod-list-item").click(function(){
		$("#list .mod-list-item").find(".vico").removeClass("green");			 
		$(this).find(".vico").addClass("green");
		$(".btn_area #tousubtn").addClass("active");	
	});
	$("#canceltousubtn").click(function(){
		$(".driverdetails").show();	
		$(".tousudetails").hide();									
	});
	$(".btn_area #tousubtn").click(function(){
		var obj=$(this);
		if( obj.attr("class").indexOf("active")!=-1)
		{
			$("body").ShowLoading("提交中，请稍候");	
			var t=$.trim($(".green").attr("rel"))
			var x=$.trim($("#reasontext").val())
			var m=$.trim($("#tel").val());
			if(m!="" && (!myreg.test(m)))
			{
				$("body").ShowError("您的手机号格式不正确哦");	
			}
			else if(t=="")
			{
				$("body").ShowError("请选择您要投诉的类型");	
			}
			else
			{
				$.ajax({
					type: "post",
					dataType: "json",
					data: {"o":obj.data("orderid"),"m":m,"t":t,"x":x},
					url: "/tool/tousu/?version="+new Date(),
					cache:false,
					success: function(d){
						clickflag=true;
						if (d.state == "success") {
							$(".driverdetails").hide();	
							$(".tousudetails").hide();	
							$('#reason_ok').show();
							$("body").Hide();
							$("body").CountDown($("#timer"), 2,
								function() {
									$(".driverdetails").show();	
									$(".tousudetails").hide();	
									$('#reason_ok').hide();
							});
						}
						else
						{ 
							$("body").ShowError(d.msg);
						}
				}})	
			}
		}
	});
	$("#guoqitousu").click(function(){
		$("body").ShowError("很遗憾，订单已超过投诉期","下次请尽早反馈，感谢您的支持~");
		return false;						
	});
	$("#tousu").click(function(){
		$(".driverdetails").hide();	
		$(".tousudetails").show();	
	});
	$(".driverInfo .active").click(function(){
		$("body").ShowTel("不能拔打乘客电话了","订单已结束多时，如需联系乘客，可联系客服帮忙~");
		return false;
	});
	$("#btn_close").click(function(e){
		 $("#d_wall").hide();
		 $("#d_wrap").hide();						 
	});
	/*$(".btn-driver").click(function(){
		$("body").ShowCancel("确定把乘客送到目的地了吗？送到了才能点击哦。","");
		return false;
	});*/
	$("#driver-submit-link").click(function(){
		var o=$(this);
		if($(".on-light").length>3)
		{
			$(".comment-tip").show().html("最多能打三个标签呦，思考一下~");
		}
		else if($(".on-light").length==0)
		{
			$(".comment-tip").show().html("您还没有给他打标签呢~");
		}
		else
		{
			$("body").ShowLoading("处理中，请稍候");
			var tag="";
			$(".on-light").each(function(){
				tag += ","+$(this).attr("vid");					 
			})
			$.ajax({
				type: "post",
				dataType: "json",
				data: {"id":o.data("orderid"),"t":tag},
				url: "/tool/postdrivertag/?version="+new Date(),
				cache:false,
				success: function(d){
					if (d.state == "success") 
					{
						window.location.href=window.location.href;
					}
					else
					{
						$("body").ShowError("很遗憾，评价出错啦",d.msg);
					}
			}})
		}
		return false;
	});
	$(".tagselectlist").click(function(){
		if($(this).hasClass("on-light"))
		{
			$(this).removeClass("on-light");
			$(".comment-tip").hide();
		}
		else
		{
			if($(".on-light").length>=3)
			{
				$(".comment-tip").show().html("最多能打三个标签呦，思考一下~");
			}
			else
			{
				$(this).addClass("on-light");
				$(".comment-tip").hide();
			}
		}
	});
	if( $("#loadingstate").length>0)
	{
		clearInterval(window.timer);//取消
//		window.timer = setInterval("main.loading()", 1e3)
	}
});
var main=
{
	loading:function()
	{
		var o= $("#loadingstate");
		if( o.val()=="1" )
		{
			$.ajax({
				type: "post",
				dataType: "json",
				data: {"id":o.data("orderid"),"d":o.data("driverid"),"s":o.data("webid")},
				url: "/order/getdriverorderstate/?version="+new Date(),
				cache:false,
				success: function(d){
					if (d.state == "success") 
					{
						if(d.orderkill!=o.data("kill") )
					    {
							clearInterval(window.timer);//取消
							$("body").ShowLoading("处理中，请稍候");	
						    window.location.href=d.url;
					    }
					}
			}})
		}
	}
}