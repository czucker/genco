(function($){  
    
    $('img[data-transition=true]').one('inview', function(event, isInView, visiblePartX, visiblePartY){
        if(isInView){
            $(this).addClass('inview');
        }
    });
    
})(jQuery);