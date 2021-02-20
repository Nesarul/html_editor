
    $('.js-toexpand').click(function(){
        $(this).toggleClass('ico');
        $(this).next('.js-expand_more').slideToggle('slow');
    });
