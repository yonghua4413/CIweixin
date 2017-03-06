$(function(){
    var swiper = new Swiper('.cs-banner', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay:2000
    });
    $(".invite-code").on('click',function(){
        $('.invite-code-input').toggleClass('hide');
    })
    
    carService.photo();
})