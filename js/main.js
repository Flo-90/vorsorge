$(document).ready(function() {

    //Back to Top Function (reveal on Scroll)
    var toTop = $('#back-to-top');

    $(window).scroll(function() {
        var topPosition = $(this).scrollTop();

        if (topPosition > 500) {
            $(toTop).css('display', 'block');
        } else {
            $(toTop).css('display', 'none');
        }

    });
    //Back to Top Function (scroll to Top on click)
    $(toTop).click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });



    //Smooth Scrolling 
    var kontakt = $('#kontakt').position();

    $('#nav-cta').click(function() {
        $('html, body').animate({
            scrollTop: kontakt.top
        }, 800);
        return false;
    });

    


    //Call back Form
    
    //show label for Form Input
    $('.form-input').each(function() {
        $(this).on('focus', function(event) {
            $(event.target).removeAttr('placeholder');
            $(event.target).next().removeClass('hidden-label');
        });
    });




    
});