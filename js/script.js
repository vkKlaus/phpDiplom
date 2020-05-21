

$(function () {

    var owl = $('.owl-carousel');

    owl.owlCarousel({
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
    })


    $('.count').click(function (e) {
        var id = e.currentTarget.id;

        var count = e.currentTarget.value

        if ((count) <= 0) {
            alert('минимальный заказ 1');
           
            e.currentTarget.value = 1;
          
            return;
        }

        var price = $('#' + id + '_price');
       
        var sum = $('#' + id + '_sum');
      
        sum.html(Number(count) * Number(price.html()));

        getTotal();
    })

    $('.deliv').click(function () {
        getTotal();
    })

    function getTotal(){
        var total = 0;
    
        var products = $('.sum');
    
        for (var key of products) {
            total += Number($('#' + key.id).html());
        }
    
        var deliv=$("input:radio:checked");

        for (var key of deliv){
            total += Number($('#'+key.id).attr('data'));
        }




        $('#total').html(total);
    };
})
