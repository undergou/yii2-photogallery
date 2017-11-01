$(document).ready(function(){
    if($('.image-in-category').length<7){
        $('.link-show-more-images').hide();
    }
$('.wrap-for-link-images').on('click', '.link-show-more-images', function(e){
    var userStatus = $('#user-status').html();
                var offset = $('.image-in-category').length;
                var categoryTitle = $('#category-title').html();
                $.ajax({
                    url: '../../js/formdata-img.php',
                    type: 'POST',
                    data: {offset:offset,
                            userStatus: userStatus,
                            categoryTitle: categoryTitle},
                    success: function(response){
                        var check = response.slice(-1);
                        if(check != 1){
                            $('#waiting-img').show();
                            setTimeout(function(){
                                $('#category-wrap-image').append(response);
                                $('#waiting-img').hide();
                                $('<a>', { href: '#', class: 'link-show-more-images', text: 'Show more...'}).appendTo('.wrap-for-link-images');
                            }, 1000);
                        }

                    }
                });
	});
        $(window).scroll(function(){
            if($('.link-show-more-images').length){
                var link = $('.link-show-more-images').offset().top;
            if(link && $(this).scrollTop() + $(window).height() > link){
                    $('.link-show-more-images').click();
                    $('.link-show-more-images').remove();
            }
            }
        });
});
