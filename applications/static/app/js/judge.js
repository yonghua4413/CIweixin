$(function(){

    $(".score").click(function(){
        $("#score").val($(this).html());
     });
    $(".tag_type li span ").click(function(){
        var tag_type = $(this).attr("data").toString();
        var tag_content = $(this).html();
        var content = $("#content").val();
        var html = "";
        html = content+" "+tag_type+":"+tag_content;
        $("#content").val(html);
    });
    //提交用户评论信息
    $(".cs-btn a").click(function(){
        var score = $("#score").val();
        var content = $("#content").val();
        if(score == ""){
            my_dialog.dialog2("提示", "你还没有打分呢！");
            return false;
        }
        if(content == ""){
        	my_dialog.dialog2("提示", "你还没有评价呢！");
            return false;
        }
        $.ajax( {
            url:'/line/ajax_add_rate',
            data: {
                "content":content,
                'score':score,
                'road_id':road_id,
                'order_id':order_id,
                'driver_id':driver_id
             },
            type:'post',
            dataType:'json',
            beforeSend:function(){
                $("#submit").html("提交中...");
            },
            success:function(data) {
                $("#submit").html("提交匿名评价");
               if(data.status == 0){
            	   my_dialog.dialog2("提示", data.msg, function(){
            		   window.location.href="/Usercenter/index";
            	   });
               }else{
            	   my_dialog.dialog2('提示', data.msg);
               }
            },
            error : function() {
            	my_dialog.dialog2("提示", "网络异常！");
            }
        });
    });
    //取消约车
    $(".cancel-order").click(function(){
    	my_dialog.dialog1('提示','确认取消订单？',function(){
    		var order_id = $('.cancel-order').attr("data-id");
    		$.ajax( {
    			url:'/usercenter/cancle_order',
    			data: {"order_id":order_id},
    			type:'post',
    			dataType:'json',
    			success:function(data) {
    				if(data.status == 0){
    					window.location.reload(true);
    				}
    			},
    			error : function() {
    				my_dialog.dialog2("提示", "网络异常！");
    			}
    		});
    	});
    });

    //立即预约
    $(".next-order li a").click(function(){
        var road_id = $(this).attr("data");
        var ride_info = $("#ride_info").html();
        var passenger_count = $("#infoNum").val();
        var ride_place = $("#infoPlace").val();
        var ride_cost = $(this).prev(".price").find("p").eq(0).attr("data");
        var endtime = $("#endTime").val();
        var location = $('#infoLocation').val();
        if(ride_place == ""){
        	my_dialog.dialog2("提示", "请选择上车地点！", "");
            return false;
        }
        if(endtime == ""){
        	my_dialog.dialog2("提示", "请选择出发时间！", "");
            return false;
        }
        if(passenger_count == ""){
        	my_dialog.dialog2("提示", "请选择乘车人数！");
            return false;
        }
        $.ajax( {
            url:'/car/operate_order',
            data: {
                "road_id":road_id,
                "ride_info":ride_info,
                "passenger_count":passenger_count,
                "ride_place":ride_place,
                "ride_cost":ride_cost,
                "ride_time":endtime,
                "coordinate":location,
            },
            type:'post',
            dataType:'json',
            success:function(data) {
              if(data.status == 0){
                    window.location.href="/car/yue_car_success";
                }
                else{
                	my_dialog.dialog2("提示", data.msg);
              }
            },
            error : function() {
            	my_dialog.dialog2("提示", "网络异常！");
            }
        });
    });
    // 点击感谢费按钮
    $('.judge-btns-bag a').on('click', function() {
        var self = $(this);
        self.addClass('weui_btn_primary')
            .removeClass('weui_btn_default')
            .siblings('a').removeClass('weui_btn_primary')
            .addClass('weui_btn_default')
    });
    $('.judge-btns-bag span').on('click', function() {
        var self = $(this);
        self.addClass('weui_btn_primary')
            .removeClass('weui_btn_default')
            .siblings('span').removeClass('weui_btn_primary')
            .addClass('weui_btn_default')
    });
});
