$(function(){

    $(".city").click(function() {
        keyword = $(this).html();
        search(keyword);
    });
    //线路列表搜索
   $("#search_cancel").click(function(){
      var pagetype = $("#page-type").val();
      var keyword = $.trim($("#keyword").val());
       if(keyword == ""){
            my_dialog.dialog2("提示", "请输入城市！");
           return false;
       }
       if(pagetype == "index"){
           window.location.href="/line/lines_list/1/"+encodeURI(keyword);
       }else{
           search(keyword);
       }

  });
   $("#keyword").focus(function(){
	   $(".places-box").show();
   });


   function search(keyword){
       $.ajax( {
           url:'/line/search_line',
           data: {
               "keyword":keyword
           },
           type:'post',
           dataType:'json',
           beforeSend:function(){
              // $(".weui_search_cancel").html("搜索中...");
            },
           success:function(data) {
               $(".weui_search_cancel").html("搜索");
               var html = "";
               if(data.status == 0){
                   $(".hot_loads").html("");
                   var type = $("#type").val();
                   for(var i=0; i<data.data.length;i++){
                       html += '<li>';
                       html += '<a href="/line/line_detail/1/'+data.data[i]['id']+'">';
                       html += '<p class="place">'+data.data[i]['place1']+'</p>';
                       html += '<p class="place">'+data.data[i]['place2']+'</p>';
                       html += '<p class="place-dpt">';
                       if(data.data[i]['price']){
                    	   html += '&yen;'+data.data[i]['price']+'起,';
                       }else{
                    	   html += '&yen;0起';
                       }
                       if(data.data[i]['trade_all_count']){
                    	   html += '已约'+data.data[i]['trade_all_count']+'次';
                       }else{
                    	   html += '已约0次';
                       }
                       html += "</p>";
                       html += '</a>'
                       html += "</li>";
                   }
                   $(".hot_loads").html(html)
               }
               else{
                   my_dialog.dialog2("提示", "没有搜到路线");
               }
           },
           error : function() {
               my_dialog.dialog2("提示", "网络异常！");
           }
       });
   }

    //加载更多平路信息
    $(".load-more").click(function(){
        //获取最后一个评论信息的时间

        var road_id = $("#road_id").val();
        var last_id = $(".judge-cont-ul").find("li").last().attr("data");
        var startend = $(".start-end").last().html();

        $.ajax( {
            url:'/line/line_judge',
            data: {
                 'road_id':road_id,
                 'id':last_id
            },
            type:'post',
            dataType:'json',
            beforeSend:function(){
                 $(".load-more").html("加载中...");
            },
            success:function(data) {
                var html = "";
                if(data.status == 0){
                    if(data.data.length>0){
                        for(var i=0; i<data.data.length;i++) {
                            html += '<li class="judge-line-id" data="'+data.data[i]['id']+'">';
                            html += '<div class="bag clearfix"><div class="user-tel">';
                            html +=  replace_substr(data.data[i]['customer_tel'],3,10,"*")+ "</div>";
                            html += '<div class="dpt">' + data.data[i]['content'] + '</div>';
                            html += '</div>';
                            html += ' <div class="order-dpt clearfix">';
                            html += '<p>'+startend+'</p>';
                            html += '<p>司机：' + data.data[i]['realname'] + '</p>';
                            html += '<p>约车时间：<label class="judge-time">' + data.data[i]['time'] + '</label></p>';
                            html += '</div></li>';
                        }
                        $(".judge-cont-ul").append(html);
                        $(".load-more").html("加载更多");
                        $("#create_time").val(data.data[data.data.length-1]['create_time']);
                    }
                }
                else{
                    $(".load-more").html(data.msg);
                }


            },
            error : function() {
                my_dialog.dialog2("提示", "网络异常！");
            }
        });
    });


    $(".hot_loads").click(function(e){
       if($(e.target).is(".add-load")){
    	   var load_obj = $(e.target);
        $.post(
               "/line/add_load",
               {
                   road_id:  $(e.target).attr("data")
               },
               function(data){
                  
            	  my_dialog.dialog2("提示", data.msg, function(){
//                   	   window.location.reload();
            		  if(data.status != -3){
            			  load_obj.removeClass('add-load weui_btn_primary').text('已添加').addClass('weui_btn_warn');
            		  }
                  });
               },
               'json'
           );
        };
    });

    function replace_substr(str,begin,end,char){
        if(str){
            var fstStr = str.substring(0,begin);
            var scdStr =str.substring(begin,end);
            var lstStr = str.substring(end,str.length);
            var matchExp = /\d/g;
            return fstStr+scdStr.replace(matchExp,char)+lstStr;
        }
        else{
            return null;
        }

  }


});