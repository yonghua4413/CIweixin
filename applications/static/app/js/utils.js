/**
    通用工具类
*/
define([],function() {
    return {
         isFn:function(n) {
            return t(n, "Function")
        },
        isObj:function(n) {
                return t(n, "Object")
        },
        isStr:function(n) {
            return t(n, "String")
        },
        isArray:function(n) {
            return t(n, "Array")
        },
        checkPhone:function(n) {
            return /^(11|13|14|15|17|18|19)[0-9]{9}$/.test(n)
        },
        isUndefined:function(n) {
            return t(n, "Undefined")
        },
        isNull:function(n){
            return (typeof(n) == 'undefined' || ''== n || null==n) ? true : false;
        },
        isValidate:function(n){
            return n.length < 1 ? false : true;
        }
    }
})


