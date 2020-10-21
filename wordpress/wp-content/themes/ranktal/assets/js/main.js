//  Tools features section

// override click event for Carousel controls
var $tabs = $('#featuresTabs>li>a');
$('[data-slide="next"]').on('click', function () {
    if ($tabs.filter('.active').parent().next('li').length) {
        $tabs.filter('.active').parent().next('li').find('a[data-toggle="tab"]').tab('show');
    } else {
        $tabs.eq(0).parent().find('a[data-toggle="tab"]').tab('show');
    }
});
$('[data-slide="prev"]').on('click', function () {
    if ($tabs.filter('.active').parent().prev('li').length) {
        $tabs.filter('.active').parent().prev('li').find('a[data-toggle="tab"]').tab('show');
    } else {
        $tabs.eq($tabs.length - 1).parent().find('a[data-toggle="tab"]').tab('show');
    }
});

// override Carousel with keyboard controls and to excute click event
$(document).bind('keyup', function (e) {
    if (e.which == 37) {
        $('.carousel-control-next').trigger('click');
    }
    else if (e.which == 39) {
        $('.carousel-control-prev').trigger('click');
    }
});

//!!! Tools features section

// FAQ section
$('.collapse').on('shown.bs.collapse', function(e) {
    var $card = $(this).closest('.card');
    $('html, body').animate({
      scrollTop: $card.offset().top
    }, 500);
  });
  
//!!! FAQ section