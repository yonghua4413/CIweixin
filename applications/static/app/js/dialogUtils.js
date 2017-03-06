/**
 * Created by Baby on 2016/8/6.
 */
define(['indexOrderUtils'], function(indexOrderUtils){
    return {
        _options: {
            
        },
        showToast: function (flag, content, time, contentWidth, marginLeft) {
            /**显示toast提示*/

            //0: 'weui_icon_info', 1: 'weui_icon_success'
            $('#toast .weui_toast .weui_toast_content').text(content);
            flag == 0 ? $('#toast .weui_toast .weui_icon_msg').addClass('weui_icon_info').removeClass('weui_icon_success'):$('#toast .weui_toast .weui_icon_msg').addClass('weui_icon_success').removeClass('weui_icon_info');
            var showTime = indexOrderUtils.isNull(time) ? 1500 : time;
            if(indexOrderUtils.isNull(contentWidth)) {
                $('#toast .weui_toast').css("width", "180px");
            }else {
                $('#toast .weui_toast').css("width", contentWidth);
                $('#toast .weui_toast').css("margin-left", marginLeft);
                $('#toast .weui_toast').css("min-height", "8.5em");
            }
             $('#toast').show();
            setTimeout(function () {
                $('#toast').hide();
            }, showTime);
        },
        showLoadingToast: function(content){
            /**显示加载中toast提示*/
            // if(indexOrderUtils.isNull(content)) {
            //     $('#loadingToast .weui_toast .weui_toast_content').html('数据加载中')
            // }else {
            //     $('#loadingToast .weui_toast .weui_toast_content').html(content)
            // }
             $('#loadingToast').show();
        },
        hideLoadingToast: function(){
            /**隐藏加载中toast提示*/
            $('#loadingToast').hide();
        }
    }
})