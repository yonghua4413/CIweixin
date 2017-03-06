//抢单
$("body").on("click", ".take-order", function(){
    $.post("/driver/update_order", {order_id: $(this).attr("data-id"), driver_id: $("input[name='driver_id']").val()}, function(result){
        if (result.status == 0) {
            my_dialog.dialog2("提示", result.data, function(){
                window.location.reload();
                });
        } else {
            my_dialog.dialog2("提示", result.msg);
        }
    });
});

//上拉加载更多
var i = 3;  //每次加载3条内容
var road_id = '';
var loadend = false;//是否加载完成
var dropload = $("#order-list-parent").dropload({
	scrollArea:window,
	loadDownFn: function(dl){
		var params = {page: i};
	    if (road_id !== '') {
	        params.road_id = road_id;
	    }
	    $.post("/driver/take_order", params, function(result){
	        if (result) {
	            $(".order-list").append(result);
	            i = i + 3;
	        } else {
	        	loadend = true;
	        	// 无数据
	        	dl.noData(true);
	        	// 锁定
                dl.lock('down');
	        }
	        dl.resetload();
	    });
	}
})
//加载线路订单
$(".load-road-order").click(function(){
	if(loadend){
		dropload.unlock('down');
		dropload.noData(false);
	}
	i = 3;
    var road = $(this).attr("data-id");
    $.post("/driver/take_order", {road_id: road}, function(result){
        if (result) {
            $(".order-list").html(result);
            //重新初始化全局数据
            road_id = road;
        }else{
        	my_dialog.toast("没有订单！");
        } 
        dropload.resetload();
    });
});