/**
 * 后台订单管理js
 * @author chaokai@gz-zc.cn
 */
define(function(require, exports, module){
  require('dialog');
  
  module.exports = {
      del:function(){
        $('.del').click(function(){
          var url = $(this).data('url');
          var d = dialog({
            title:'提示',
            content:'确认删除？',
            okValue:'确认',
            cancelValue:'取消',
            cancel:function(){},
            ok:function(){
              var obj = this;
              $.get(url, function(data){
                if(data.status == 0){
                  window.location.reload();
                }else{
                  this.content(data.msg);
                }
              })
            }
          })
          
          d.width(320)
          d.showModal()
        })
      }
  }
})
