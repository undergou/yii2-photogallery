$(document).ready(function(){
    if($('.category').length<6){
        $('.link-show-more').hide();
    }
    // $('.wrap-for-link').on('click', '.link-history', function(e){
    //     console.log('Clicked!');
    // });

$('.wrap-for-link').on('click', '.link-show-more', function(e){

    var userStatus = $('#user-status').html();

            var offset = $('.category').length;
            // if(offset%6 == 0){
            //     var page = Math.round(offset/6+1);
            //     history.pushState(null, '', page);
            // }
                $.ajax({
                    url: 'js/formdata.php',
                    type: 'POST',
                    data: {offset:offset,
                            userStatus: userStatus},
                    success: function(response){
                        var resp = JSON.parse(response);
                        var respLength = resp.length;
                        if(!resp[respLength-1].end){
                                  var elems=$();
                                //   var vineta="";

                                  for (var i = 0; i < respLength; i++) {
                                    var vineta = $('<div class="category">'+resp[i].link+resp[i].img+resp[i].title+'</a></div>');
                                    // vineta += ;
                                    // vineta += ;
                                    // vineta += ;
                                    // vineta += ;
                                    var elem = $(vineta);
                                    elems = elems ? elems.add( elem ) : elem;
                                    vineta="";
                                }
                                    $('<a>', { href: '#', class: 'link-show-more', text: 'Show more...'}).appendTo('.wrap-for-link');
                                    $('#category-wrap').append(elems);
                                    // if(respLength==6){
                                    //     $('#category-wrap').append('<div class="wrap-for-link-history"><a href="#" class="link-back">Back</a></div>');
                                    // }
                                    // else {
                                    //     $('<button>', { class: 'link-history', text: 'Back'}).appendTo('.wrap-for-link');
                                    //
                                    // }
                                    $('#category-wrap').masonry('appended', elems);
                                    // $('#category-wrap').masonry();
                                    //   $('#category-wrap').masonry('appended',elems);
                                        $('#category-wrap').masonry('reloadItems');
                                       $('#category-wrap').masonry();
                                    //   $('#category-wrap').masonry('reloadItems');
                                    //   $('#category-wrap').masonry( 'addItems', elems );
                                    $('#category-wrap').imagesLoaded().progress( function() {
                                        $('#category-wrap').masonry('layout');
                                    });
                                    // $('#category-wrap').masonry('reloadItems');
                                    // }, 1000);

                        }


                    }
                });
	});
// $(window).scroll(function(){
//     var current = $(this).scrollTop() + $(window).height();
//     console.log(current);
//     var arrayCoor = [];
//     var g = document.querySelectorAll('.g');
//     for (var k = 0; k < g.length; k++) {
//         if(g[k]){
//             var coor = g[k].getBoundingClientRect();
//             arrayCoor.push(coor.top + pageYOffset);
//         }
//     }
//     console.log(arrayCoor);
//     if(arrayCoor){
//         if(current<arrayCoor[0]){
//             history.pushState(null, '', 1);
//             console.log(1);
//         }
//         for (var l = 0; l < arrayCoor.length-1; l++) {
//             // if(current<arrayCoor[0]){
//             //     history.pushState(null, '', 1);
//             //     console.log(1);
//             // } else
//             if (current < arrayCoor[l+1] && current > arrayCoor[l]){
//                 history.pushState(null, '', l+2);
//                 console.log(l+2);
//             }
//             else if(current>arrayCoor[arrayCoor.length-1]){
//                 history.pushState(null, '', arrayCoor.length+1);
//                 console.log('last: '+(arrayCoor.length+1));
//             }
//         }
//     }
//
// });

        $(window).scroll(function(){
            if($('.link-show-more').length){
                var link = $('.link-show-more').offset().top;
            if(link && $(this).scrollTop() + $(window).height() > link){
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
