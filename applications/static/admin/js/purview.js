/** 
 * 登录js文件
 * @author: jianming@gz-zc.cn
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');

    module.exports = {
      dialogAlert: function(msg, url = '', fn ){
          var d = dialog({
            id : 'FADO',
            title: '系统提示',
            content: msg,
            width: 300,
            okValue: '确定',
            cancelValue: '取消',
            ok : function(){
               if( fn ){
                 fn();
               }
               if( url != ''){
                 window.location.href = url;
               }
               return true;
            },
            
         })
         d.showModal();
      },
      del: function() {
          $('.purview_del').on('click', function() {
            var id = $(this).data('id');
            module.exports.dialogAlert('确定删除?', '', function(){
              $.ajax({
                url : "/adminspurview/del",  
                type : "post",  
                dataType : "json",  
                data: {id: id},  
                success : function(res) {
                  if(res.status == 0) {  
                    module.exports.dialogAlert(res.msg, '/adminspurview');
                  } else {
                    module.exports.dialogAlert(res.msg);
                  }  
                },
                error: function() {
                  module.exports.dialogAlert('网络异常！');
                }
             });
              
            });

        });
      },
      //权限添加
      add: function() {
          // validate signup form on keyup and submit
          $("#purviewForm").validate({
              rules: {
                  parent_id: "required",
                  url: "required",
                  name: {
                      required: true,
                  },
                  sort: {
                      required: true,
                      digits:true
                  },
              },
              messages: {
                  parent_id: "请选择上级权限",
                  url: "权限代码不能为空",
                  name: {
                      required: "权限名称不能为空",
                  },
                  sort: {
                      required: "排序不能为空",
                      digits: "请输入排序数字0~10，数值越大，排序越靠前",
                  },

              },
              submitHandler: function() {
                var param = $("#purviewForm").serialize();
                $(":submit").addClass("disabled");
                $.ajax({
                   url : "/adminspurview/add",  
                   type : "post",  
                   dataType : "json",  
                   data: param,  
                   success : function(res) {
                     if(res.status == 0) {  
                       module.exports.dialogAlert(res.msg, '/adminspurview');
                     } else {
                       module.exports.dialogAlert(res.msg);
                     }  
                   },
                   error: function() {
                     module.exports.dialogAlert('网络异常！');
                   }
                });
              }  
        });

      },
      //权限修改
      edit: function() {
        // validate signup form on keyup and submit
        $("#purviewForm").validate({
            rules: {
                parent_id: "required",
                url: "required",
                name: {
                    required: true,
                },
                sort: {
                    required: true,
                    digits:true
                },
            },
            messages: {
                parent_id: "请选择上级权限",
                url: "权限代码不能为空",
                name: {
                    required: "权限名称不能为空",
                },
                sort: {
                    required: "排序不能为空",
                    digits: "请输入排序数字0~10，数值越大，排序越靠前",
                },

            },
            submitHandler: function() {
              var param = $("#purviewForm").serialize();  
              $.ajax({
                 url : "/adminspurview/edit",  
                 type : "post",  
                 dataType : "json",  
                 data: param,  
                 success : function(res) {
                   if(res.status == 0) {  
                     module.exports.dialogAlert(res.msg, '/adminspurview');
                   } else {
                     module.exports.dialogAlert(res.msg);
                   }
                 },
                 error: function() {
                   module.exports.dialogAlert('网络异常！');
                 }
              });
            }  
        });
      },
      role_add: function() {
        // validate signup form on keyup and submit
        $("#purviewForm").validate({
            rules: {
                name: {
                    required: true,
                },
                describe: {
                    required: true,
                },
            },
            messages: {
               
                name: {
                    required: "角色名不能为空",
                },
                describe: {
                    required: "角色描述不能为空",
                },

            },
            submitHandler: function() {
              var param = $("#purviewForm").serialize();
              $(":submit").addClass("disabled");
              $.ajax({  
                 url : "/admingroup/add",  
                 type : "post",  
                 dataType : "json",  
                 data: param,  
                 success : function(res) {
                   if(res.status == 0) {  
                     module.exports.dialogAlert(res.msg, '/admingroup');
                   } else {
                     module.exports.dialogAlert(res.msg);
                   }  
                 },
                 error: function() {
                   module.exports.dialogAlert('网络异常！');
                 }
              });
            }  
        });
      },
      role_edit: function() {
        // validate signup form on keyup and submit
        $("#purviewForm").validate({
            rules: {
                name: {
                    required: true,
                },
                describe: {
                    required: true,
                },
            },
            messages: {
               
                name: {
                    required: "角色名不能为空",
                },
                describe: {
                    required: "角色描述不能为空",
                },

            },
            submitHandler: function() {
              var param = $("#purviewForm").serialize();  
              $.ajax({  
                 url : "/admingroup/edit",  
                 type : "post",  
                 dataType : "json",  
                 data: param,  
                 success : function(res) {
                   if(res.status == 0) {  
                     module.exports.dialogAlert(res.msg, '/admingroup');
                   } else {
                     module.exports.dialogAlert(res.msg);
                   }  
                 },
                 error: function() {
                   module.exports.dialogAlert('网络异常！');
                 }
              });
            }  
        });
      },
      
      role_del: function() {
        $('.role_del').on('click', function() {
          var id = $(this).data('id');

         module.exports.dialogAlert('确定删除？', '', function(){
           $.ajax({
             url : "/admingroup/del",  
             type : "post",  
             dataType : "json",  
             data: {id: id},  
             success : function(res) {
               if(res.status == 0) {  
                 module.exports.dialogAlert(res.msg, '/admingroup');
               } else {
                 module.exports.dialogAlert(res.msg);
               }  
             },
             error: function() {
               module.exports.dialogAlert('网络异常！');
             }
          });
         });

          
        });
      },

      purview_appoint: function() {
        $("#all_check").click(function(){
          sel(this);
        });
        
        $("#submit").on('click', function() {
          var param = $("#purviewForm").serialize();  
          $.ajax({
             url : "/admingroup/purview",  
             type : "post",  
             dataType : "json",  
             data: param,  
             success : function(res) {
               if(res.status == 0) {  
                 module.exports.dialogAlert(res.msg, '/admingroup');
               } else {
                 module.exports.dialogAlert(res.msg);
               }  
             },
             error: function() {
               module.exports.dialogAlert('网络异常！');
             }
          });
        });
        
      }

    }

});