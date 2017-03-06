//weui提示框
var my_dialog = {
	dialog1:function(title, content, callback){
		var html = '<div class="weui_dialog_confirm" style="width:100%;height:100%" id="dialog1" style="display: none;">';
		html = '<div class="weui_mask weui_mask_visible"></div>';
		html += '<div class="weui_dialog">';
		html += '<div class="weui_dialog_hd"><strong class="weui_dialog_title" style="line-height:1.6;text-align:center;">'+title+'</strong></div>';
		html += '<div class="weui_dialog_bd" style="line-height:1.6;text-align:center;">'+content+'</div>';
		html += '<div class="weui_dialog_ft">';
		html += '<a href="javascript:;" class="weui_btn_dialog default" act="cancle" style="line-height:2;text-align:center;">取消</a>';
		html += '<a href="javascript:;" class="weui_btn_dialog primary" act="sure" style="line-height:2;text-align:center;">确定</a>';
		html += '</div>';
		html += '</div>';
		html += '</div>';
		var dialog = $(html).appendTo(document.body);
		dialog.show();
		dialog.removeAttr('style');
		dialog.find('a[act=cancle]').one('click', function(){
			dialog.hide().remove();
			return false;
		})
		dialog.find('a[act=sure]').one('click', function(){
			dialog.hide().remove();
			callback.apply(this);
		})
	},
	dialog2:function(title, content, callback){
		var html = '<div class="weui_dialog_alert" id="dialog2" style="display: none;">';
		html += '<div class="weui_mask"></div>';
		html += '<div class="weui_dialog">';
		html += '<div class="weui_dialog_hd" style="text-align:center;"><strong class="weui_dialog_title" style="line-height:1.6;">'+title+'</strong></div>';
		html += '<div class="weui_dialog_bd" style="line-height:1.6;text-align:center;">'+content+'</div>';
		html += '<div class="weui_dialog_ft">';
		html += '<a href="javascript:;" class="weui_btn_dialog primary" style="line-height:2;text-align:center;">确定</a>';
		html += '</div>';
		html += '</div>';
		html += '</div>';
		var dialog = $(html).appendTo(document.body);
		dialog.show();
		dialog.removeAttr('style');
		dialog.find('.weui_btn_dialog').one('click',function(){
			dialog.hide().remove();
			if(callback != ''){
				callback.apply(this);
			}
		})
	},
	toast:function(info){
		var html = '<div id="toast" style="display: none;">';
		html += '<div class="weui_mask_transparent"></div>';
		html += '<div class="weui_toast">';
		html += '<i class="weui_icon_toast"></i>';
		html += '<p class="weui_toast_content">'+info+'</p>';
		html += '</div>';
		html += '</div>';
		var toast = $(html).appendTo(document.body);
		toast.show();
		toast.removeAttr('style');
		setTimeout(function(){
			toast.hide().remove();
		}, 1000);
	},
	load_toast:function(content){
		var html = '<div id="loadingToast" class="weui_loading_toast" style="display:none;">';
		html += '<div class="weui_mask_transparent"></div>';
		html += '<div class="weui_toast">';
		html += '<div class="weui_loading">';
		html += '<div class="weui_loading_leaf weui_loading_leaf_0"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_1"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_2"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_3"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_4"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_5"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_6"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_7"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_8"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_9"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_10"></div>';
		html += '<div class="weui_loading_leaf weui_loading_leaf_11"></div>';
		html += '</div>';
		html += '<p class="weui_toast_content">'+content+'</p>';
		html += '</div>';
		html += '</div>';
		var load_toast = $(html).appendTo(document.body);
		return load_toast;
	}
};