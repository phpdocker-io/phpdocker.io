/*=============================================================
 Authour URL: www.designbootstrap.com

 http://www.designbootstrap.com/

 License: MIT

 http://opensource.org/licenses/MIT

 100% Free To use For Personal And Commercial Use.

 IN EXCHANGE JUST TELL PEOPLE ABOUT THIS WEBSITE

 ========================================================  */

$(document).ready(function () {

    /*====================================
     SCROLLING SCRIPTS
     ======================================*/

    $('.scroll-me a').bind('click', function (event) { //just pass scroll-me in design and start scrolling
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1200, 'easeInOutExpo');
        event.preventDefault();
    });


    /*====================================
     SLIDER SCRIPTS
     ======================================*/





    /*====================================
     WRITE YOUR CUSTOM SCRIPTS BELOW
     ======================================*/


});
