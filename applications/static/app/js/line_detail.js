
$(document).on('click', '#numMinus', function() {
        var _num = $('#numInput').val();
        if(_num==0) return;
        _num--;
        $('#numInput').val(_num);
    });
    $(document).on('click', '#numAdd', function() {
        var _num = $('#numInput').val();
        _num++;
        $('#numInput').val(_num);
    });
    // 乘车信息
    $('#infoNum').on('click',function () {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        weuiActionsheet.addClass('weui_actionsheet_toggle');
        mask.show().addClass('weui_fade_toggle').one('click', function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        $('#actionsheet_cancel').one('click', function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        $('#actionsheet_confirm').one('click', function () {
            //点击确定
            $("#infoNum").val($("#numInput").val()+"人");
            var html = "";
            var money = $(".rating_money").val();
            if( money != ""){
                html += "行程额外感谢"+money+" ";
            }
            if($("#checkbox1_input").val() == "1"){
                html += $(".checkbox1_info").html();
            }
            if($("#checkbox2_input").val() == "1"){
                html +=" "+$(".checkbox2_info").html();
            }
            html +=" "+$("#info").val();
            $("#ride_info").html(html);
            hideActionSheet(weuiActionsheet, mask);
        });
        weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');

        function hideActionSheet(weuiActionsheet, mask) {
            weuiActionsheet.removeClass('weui_actionsheet_toggle');
            mask.removeClass('weui_fade_toggle');
            weuiActionsheet.on('transitionend', function () {
                mask.hide();
            }).on('webkitTransitionEnd', function () {
                mask.hide();
            })
        }
    })
    // 时间选择器
    $('#endTime').date({theme:"datetime"});

    
    $(document).on('click', '.lm-nav>li', function() {
        var self = $(this);
        self.addClass('on').siblings('li').removeClass('on');
        if(self.index() == 1){
            $(".sort_list_first").hide();
            $(".sort_list_second").show();
        }else{
            $(".sort_list_second").hide();
            $(".sort_list_first").show();
        }
    });
    $(document).on('click', '#landmarkList li', function(event) {
        event.preventDefault();
        /* Act on the event */
        var self = $(this);
        self.addClass('on').siblings('li').removeClass('on');
    });

    // 点击感谢费按钮
    $('.driver-rating a').on('click', function() {
        var self = $(this);
        $(".rating_money").val(self.html());
        self.addClass('weui_btn_primary')
            .removeClass('weui_btn_default')
            .siblings('a').removeClass('weui_btn_primary')
            .addClass('weui_btn_default')
    });
    $('#s11').on('click', function() {
        if ($("input[name='checkbox1']").is(':checked')) {
            $("#checkbox1_input").val(1);
        }
        else{
            $("#checkbox1_input").val(0);
        }
    });
    $('#s12').on('click', function() {
        if ($("input[name='checkbox2']").is(':checked')) {
            $("#checkbox2_input").val(1);
        }
        else{
            $("#checkbox2_input").val(0);
        }
    });
//地图
    

//自动定位
var point = '';
var map = '';
var geolocation = new BMap.Geolocation();
geolocation.getCurrentPosition(function(r){
	if(this.getStatus() == BMAP_STATUS_SUCCESS){
		getList(r.point);
		point = r.point;
		
	} else {
		console.log('failed:'+this.getStatus());
	}
},{enableHighAccuracy: true});
// 地标选择
$('#infoPlace').on('click',function() {
    $('#landmark,#landmarkShaow').removeClass('hide');
    show_map(point);
})
//加载等待
var wait = {a:'',b:function(){var a='';this.a=setInterval(function(){$('#infoPlace').attr('placeholder','正在获取当前位置'+a);if(a == '...'){a = '';}a+='.';},500);},c:function(){clearInterval(this.a)},lng:'',lat:''}
wait.b();
//地图显示

//根据坐标获取地点
function getList(point){
	$.ajax({
	    type:'POST',
	    url:baseUrl+'/Publicservice/getmaplist',
	    data:{lat:point.lat+','+point.lng},
	    dataType:'json',
	    timeout:3000,
	    cache:false,
	    async:true,
	    beforeSend:function(){
	    },
	    success:function(data){	
			wait.c();
			$("#infoPlace").val(data.addrone.name);
			$("#infoLocation").val(data.addrone.location);
			var content = '';
			$.each(data.results,function(k,v){
				content += '<li onclick="sure_place(this)">';
				content += '<div class="maplist-text">';
				content += '<p class="detail_name">'+v.name+'</p>';
				content += '<p class="name"><span>'+v.address+'</p>';
				content += '<input type="hidden" value="'+v.location+'" class="location">';
				content += '</div>';
				if(k == 0){
					content += '<i class="weui_icon_success_no_circle list-icon"></i>';
				}
				content += '</li>';
			})
			$('#place_list').html(content);
	    },
	    error:function(){
			wait.c();
			$("#infoPlace").attr("placeholder","获取位置失败");
	    },    
	}); 
}

//确定选择地点
function sure_place(obj){
    var place = $(obj).children('div').children('p[class=detail_name]').text();
    var location = $(obj).children('div').children('input[class=location]').val();
    close_maplist();
    $("#infoLocation").val(location);
    $('#infoPlace').val(place);
}
//关闭地图选址
function close_maplist(){
	$('#landmark,#landmarkShaow').addClass('hide');
	$('#result-cont').hide();
}

//地点搜索
function search_text(){
	var text = $('#search_text').val();
	if($.trim(text) == ''){
		$("#result-cont").show();
		return false;
	}
	$.ajax({
	    type:'POST',
	    url:baseUrl+'/Publicservice/getmaplist',
	    data:{query:text},
	    dataType:'json',
	    timeout:3000,
	    cache:false,
	    async:true,
	    beforeSend:function(){
	    },
	    success:function(data){	
			var content = '';
			$.each(data,function(k,v){
				content += '<li onclick="select_place(this,'+v.point.lng+', '+v.point.lat+')">';
				content += '<div class="maplist-text">';
				content += '<p class="detail_name">'+v.name+'</p>';
				content += '<p class="name"><span>'+v.address+'</p>';
				content += '<input type="hidden" value="'+v.location+'" class="location">';
				content += '</div>';
				content += '</li>';
			})
			$("#result-cont").show();
			$("#result-cont ul").html(content);
	    },
	    error:function(){
	    },    
	}); 
}
//搜索选择
function select_place(obj, lng, lat){
	var point = new BMap.Point(lng, lat);
	var location = $(obj).find('input').val();
	getList(point);
	//默认定位
	map.setCenter(point);
	show_icon(map, point);
	$("#result-cont").hide();
}
//显示地图
function show_map(point){
	// 百度地图API功能
	map = new BMap.Map("search_map");
	//默认定位
	var point = new BMap.Point(point.lng, point.lat);
	map.centerAndZoom(point, 15);
	
	show_icon(map, point);
	//拖拽地图
	map.addEventListener("dragend", function(){
		var center = map.getCenter();
		//删除标注
		map.clearOverlays();
		show_icon(map, center);
		//获取百度地址列表
		getList(center);
	});		
}
//添加地图标注
function show_icon(map, pt){
	//自定义图标
	var icon = new BMap.Icon(staticUrl+"/app/images/adres.png", new BMap.Size(32,43));
	//添加标注
	var marker = new BMap.Marker(pt, {icon:icon});  // 创建标注
	map.addOverlay(marker);               // 将标注添加到地图中
	marker.setAnimation(BMAP_ANIMATION_DROP); //跳动的动画
}
