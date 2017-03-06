var carService = carService || {};
carService.searchbar = function () {
    var _input = $('#search_input');
    var $weuiSearchBar = $('#search_bar');
    $weuiSearchBar.addClass('weui_search_focusing');
   /* $('#search_input').on('focus',function(){
        var $weuiSearchBar = $('#search_bar');
        $weuiSearchBar.addClass('weui_search_focusing');
    }).on('blur',function(){
        var $weuiSearchBar = $('#search_bar');
        $weuiSearchBar.removeClass('weui_search_focusing');
        if($(this).val()){
            $('#search_text').hide();
        }else{
            $('#search_text').show();
        }
    }).on('input',function () {
         var $searchShow = $("#search_show");
        if($(this).val()){
            $searchShow.show();
        }else{
            $searchShow.hide();
        }
    })*/
    $('#search_cancel').on('touchend',function(){
        $("#search_show").hide();
        $('#search_input').val('');
    })
    $('#search_clear').on('touchend',function(){
        $("#search_show").hide();
        $('#search_input').val('');
    })
} 
carService.photo = function () {
    $('.upload-license').on('click',function(){
        var _self = $(this);
        $('#uploadImg').trigger('click');
        carService.showPreview(_self);
    })
}
carService.showPreview = function (_self) {
     $('#uploadImg').on('change',function(e){
        var _img = _self.find('img');
        var source=$(this)[0];
        var file = source.files[0]; 
        lrz(this.files[0],{width: 1200,height:1200,quality:.8}).then(function(rst){
            _img.attr({'src':rst.base64});
        })
        $('#uploadImg').val('');
        _self="";
        e.stopPropagation();
    })
}
