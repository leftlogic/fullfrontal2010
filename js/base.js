/* MAP ON HOMEPAGE - makes it the same size as the tweets */
$('body.home #venue div').height( $('body.home ul#tweets').outerHeight() - 60 ); 

/* CH: 60 is the height of the white box, could have figured it out in JS but not likely to change */

// document.documentElement.className = ' js';
$('nav ul a[href$=' +location.pathname + ']').parent().addClass('selected');

$('#schedule li').click(function () {
  $(this).find('div').each(function () {
    var $el = $(this), 
        h = $el.height(),
        hide = [{ height: 0, marginTop: 0 }, 100 ],
        show = [{ height: $.data(this, 'height'), marginTop: $.data(this, 'margin') }, 800, 'easeOutBounce' ];
    $el.animate.apply($el, h > 0 ? hide : show);
  });
}).find('div').each(function () {
  var $el = $(this);
  $.data(this, { height: $el.height(), margin: $el.css('marginTop') });
}).css({ marginTop: 0, height: 0, overflow: 'hidden'});

/mobile/i.test(navigator.userAgent) && setTimeout(function () {
  window.scrollTo(0, 1);
}, 1000);