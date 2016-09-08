// $('.nav-wrapper ul li').click(function() {
//     $(this).addClass('active');
//     $(this).parent().children('li').not(this).removeClass('active');
// });
// $('.side-nav ul li').click(function() {
//     $(this).addClass('active');
//     $(this).parent().children('li').not(this).removeClass('active');
// });
$(document).ready(function() {
    $('.scroll').click(function(event) {
        event.preventDefault();

        var full_url = this.href;

        var parts = full_url.split('#');
        var trgt = parts[1];

        var target_offset = $('#' + trgt).offset();
        var target_top = target_offset.top;

        $('html, body').animate({
            scrollTop: target_top
        }, 500);
    });

    $('nav a').click(function() {
      $('nav a').removeClass('active');
      $(this).addClass('active');
    });

});
