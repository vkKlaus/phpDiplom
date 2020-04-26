$(function () {

    var owl = $('.owl-carousel');

    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 40,
        nav: true,
        mouseDrag: true,
        touchDrag: true,
        autoHeight: true,
        startPosition: 1,
        // dotsEach:1,
        autoplay: true,
        autoplayHoverPause: true,
        autoplaySpeed: 2000,
        navSpeed: 2000,
        dotsSpeed: 2000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })


    owl.on('mousewheel', '.owl-stage', function (e) {
        e.preventDefault();
        if (e.deltaY > 0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
    });
})
