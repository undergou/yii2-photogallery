$(document).ready(function () {
    if ($('.category').length < 6) {
        $('.link-show-more').hide();
    }
    // $('.wrap-for-link').on('click', '.link-history', function(e){
    //     console.log('Clicked!');
    // });


    $('.wrap-for-link-back').on('click', '.link-show-more-back', function (e) {
        if($('.link-show-more-back').length){
            $('.link-show-more-back').remove();
        }
        var url = parseInt(document.location.pathname.slice(1));
        console.log(url);
        $('#category-wrap').prepend($('<div class="g category-masonry"><div class="number-page-hidden">'+url+'</div></div>'));
        var userStatus = $('#user-status').html();
        var offsetBack = parseInt($('#offset-back').html());
        console.log(offsetBack);

        if (offsetBack>=0) {
            history.pushState(null, '', url-1);
        }
        var url = parseInt(document.location.pathname.slice(1));
        console.log(url);
        $.ajax({
            url: 'js/formdata.php',
            type: 'POST',
            data: {
                offset: offsetBack,
                userStatus: userStatus
            },
            success: function (response) {
                var resp = JSON.parse(response);
                console.log(resp);
                var respLength = resp.length;
                if(url !=0){
                    if(url !=1) {
                        var elems = $();
                    }
                    for (var i = 0; i < respLength; i++) {
                        var vineta = $('<div class="category category-masonry">' + resp[i].link + resp[i].img + resp[i].title + '</a></div>');
                        var elem = $(vineta);
                        elems = elems ? elems.add(elem) : elem;
                        vineta = "";
                    }
                    // $('#category-wrap').prepend();
                    $('#category-wrap').prepend(elems);
                    if(url !=1) {
                        $('<a>', {
                            class: 'link-show-more-back',
                            text: 'Show previous categories'
                        }).appendTo('.wrap-for-link-back');
                    }

                    // $('#wrap-for-link-back').append()
                    $('#offset-back').html(offsetBack-6);
                    $('#category-wrap').masonry('appended', elems);
                    $('#category-wrap').masonry('reloadItems');
                    $('#category-wrap').masonry();
                    $('#category-wrap').imagesLoaded().progress(function () {
                        $('#category-wrap').masonry('layout');
                    });
                    // $('#category-wrap').prepend('<div class="g category-masonry"></div>');
                }
            }
        });
    });

    $('.wrap-for-link').on('click', '.link-show-more', function (e) {

        var userStatus = $('#user-status').html();
        var pagesNumber = $('#pages-number').html();
        var offset = $('#offset').html();
        var url = parseInt(document.location.pathname.slice(1));
        console.log(url);
        if (offset % 6 == 0) {
            var page = Math.round(offset / 6 + 1);
            history.pushState(null, '', page);
        }
        var url = parseInt(document.location.pathname.slice(1));
        console.log(url);
        $.ajax({
            url: 'js/formdata.php',
            type: 'POST',
            data: {
                offset: offset,
                userStatus: userStatus
            },
            success: function (response) {
                var resp = JSON.parse(response);
                var respLength = resp.length;
                if (!resp[respLength - 1].end) {
                    var elems = $('<div class="g category-masonry"><div class="number-page-hidden">'+url+'</div></div>');
                    //   var vineta="";

                    for (var i = 0; i < respLength; i++) {
                        var vineta = $('<div class="category category-masonry">' + resp[i].link + resp[i].img + resp[i].title + '</a></div>');
                        // vineta += ;
                        // vineta += ;
                        // vineta += ;
                        // vineta += ;
                        var elem = $(vineta);
                        elems = elems ? elems.add(elem) : elem;
                        vineta = "";
                    }
                    $('<a>', {href: '#', class: 'link-show-more', text: 'Show more...'}).appendTo('.wrap-for-link');
                    $('#category-wrap').append(elems);
                    if (pagesNumber != url) {
                        $('#offset').html(url * 6);
                    } else {
                        $('#offset').html((url * 6) - 1);
                    }


                    // if(respLength==6){
                    //     $('#category-wrap').append('<div class="wrap-for-link-history"><a href="#" class="link-back">Back</a></div>');
                    // }
                    // else {
                    //     $('<button>', { class: 'link-history', text: 'Back'}).appendTo('.wrap-for-link');
                    //
                    // }
                    $('#category-wrap').masonry('appended', elems);
                    $('#category-wrap').masonry('reloadItems');
                    $('#category-wrap').masonry();
                    $('#category-wrap').imagesLoaded().progress(function () {
                        $('#category-wrap').masonry('layout');
                    });
                    // $('#category-wrap').masonry();
                    //   $('#category-wrap').masonry('appended',elems);

                    //   $('#category-wrap').masonry('reloadItems');
                    //   $('#category-wrap').masonry( 'addItems', elems );

                    // $('#category-wrap').masonry('reloadItems');
                    // }, 1000);

                }


            }
        });
    });
$(window).scroll(function(){
    var current = $(this).scrollTop() + $(window).height();
    console.log(current);
    var arrayCoor = [];
    var g = document.querySelectorAll('.g');
    var numberPage = document.querySelectorAll('.number-page-hidden');
    // console.log(numberPage);
    for (var k = 0; k < g.length; k++) {
        if(g[k]){
            var object = {};
            object.page = numberPage[k].innerHTML;
            object.coor = g[k].getBoundingClientRect().top + pageYOffset;
            arrayCoor.push(object);
        }
    }
    console.log(arrayCoor);
    if(arrayCoor.length){


        for (var l = 0; l < arrayCoor.length; l++) {
            // if(current<arrayCoor[0]){
            //     history.pushState(null, '', 1);
            //     console.log(1);
            // } else
            if(current<arrayCoor[0].coor){
                history.pushState(null, '', arrayCoor[0].page-1);
                console.log(arrayCoor[0].page);
                console.log(document.location.pathname.slice(1));
            } else if (arrayCoor[l+1] && current > arrayCoor[l].coor && current < arrayCoor[l+1].coor){
                history.pushState(null, '', arrayCoor[l].page);
                console.log(arrayCoor[l].page);
                console.log(document.location.pathname.slice(1));
            }
            else if(current>arrayCoor[arrayCoor.length-1].coor){
                history.pushState(null, '', arrayCoor[arrayCoor.length-1].page);
                console.log('last: '+(arrayCoor[arrayCoor.length-1].page));
                console.log(document.location.pathname.slice(1));
            }
        }
    }

});

    $(window).scroll(function () {
        if ($('.link-show-more').length) {
            var link = $('.link-show-more').offset().top;
            if (link && $(this).scrollTop() + $(window).height() > link) {
                $('.link-show-more').click();
                $('.link-show-more').remove();
            }
        }
        // if($('.link-history').length){
        //     $('.link-history').click();
        //     $('.link-history').remove();
        // }

    });
});
