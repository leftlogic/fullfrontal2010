/* MAP ON HOMEPAGE - makes it the same size as the tweets */
$('body.home #venue div').height( $('body.home ul#tweets').outerHeight() - 60 ); 

/* CH: 60 is the height of the white box, could have figured it out in JS but not likely to change */

// document.documentElement.className = ' js';
$('nav ul a[href$=' +location.pathname + ']').parent().addClass('selected');

$('#schedule li').click(function () {
  $(this).find('div').animate({
    height: 'toggle',
    opacity: 'toggle'
  }, 100);
}).find('div').hide();