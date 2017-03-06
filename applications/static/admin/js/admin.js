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
      add: function() {
          // validate signup form on keyup and submit
          $("#signupForm").validate({
              rules: {
                  fullname: "required",
                  name: {
                      required: true,
                      minlength: 3
                  },
                  password: {
                      required: true,
                      minlength: 5
                  },
                  confirm_password: {
                      required: true,
                      minlength: 5,
                      equalTo: "#password"
                  },
                  email: {
                      email: true
                  },
              },
              messages: {
                  fullname: "请输入您的名字",
                  name: {
                      required: "请输入您的用户名",
                      minlength: "用户名必须两个字符以上"
                  },
                  password: {
                      required: "请输入您的密码",
                      minlength: "密码必须5个字符以上~"
                  },
                  confirm_password: {
                      required: "请再次输入密码",
                      minlength: "密码必须5个字符以上~",
                      equalTo: "两次输入的密码不一致"
                  },
                  email: "请输入您的E-mail"
              },
              submitHandler: function() {
                var param = $("#signupForm").serialize();  
                $(":submit").addClass("disabled");
                $.ajax({  
                   url : "/admin/add",  
                   type : "post",  
                   dataType : "json",  
                   data: param,  
                   success : function(res) {
                     if(res.status == 0) {  
                       module.exports.dialogAlert(res.msg, '/admin');
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
      
      edit: function() {
        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                fullname: "required",
                name: {
                    required: true,
                    minlength: 3
                },
                password: {
                    
                    minlength: 5
                },
                confirm_password: {
                   
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    email: true
                },
            },
            messages: {
                fullname: "请输入您的名字",
                name: {
                    required: "请输入您的用户名",
                    minlength: "用户名必须两个字符以上"
                },
                password: {
                    required: "请输入您的密码",
                    minlength: "密码必须5个字符以上~"
                },
                confirm_password: {
                    required: "请再次输入密码",
                    minlength: "密码必须5个字符以上~",
                    equalTo: "两次输入的密码不一致"
                },
                email: "请输入您的E-mail"
            },
            submitHandler: function() {
              var param = $("#signupForm").serialize();  
              $.ajax({  
                 url : "/admin/edit",  
                 type : "post",  
                 dataType : "json",  
                 data: param,  
                 success : function(res) {
                   if(res.status == 0) {
                     module.exports.dialogAlert(res.msg, '/admin');
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
      
      del: function() {
        $('.admin_del').on('click', function() {
          var id = $(this).data('id');
            module.exports.dialogAlert('确定删除？', '',function(){
                $.ajax({
                  url : "/admin/del",  
                  type : "post",  
                  dataType : "json",  
                  data: {id: id},  
                  success : function(res) {
                    if(res.status == 0) {  
                      module.exports.dialogAlert(res.msg, '/admin');
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
             url : "/admin/purview",  
             type : "post",  
             dataType : "json",  
             data: param,  
             success : function(res) {
               if(res.status == 0) {  
                 module.exports.dialogAlert(res.msg, '/admin');
               } else {
                 module.exports.dialogAlert(res.msg);
               }  
             },
             error: function() {
               module.exports.dialogAlert('网络异常！');
             }
          });
        });
      },
      enable_disable: function() {
        $(".enable_disabled").on('click', function() {
          var id = $(this).data('id');
          var disabled = $(this).data('disabled');
          $.ajax({
             url : "/admin/enable_disable",  
             type : "post",  
             dataType : "json",  
             data: {id, disabled},  
             success : function(res) {
               if(res.status == 0) {  
                 module.exports.dialogAlert(res.msg, '/admin');
               } else {
                 module.exports.dialogAlert(res.msg);
               }  
             },
             error: function() {
               module.exports.dialogAlert('网络异常！');
             }
          });
        });
      },
      
    
    }
});