// var elem = document.querySelector('#category-wrap');
// if(elem){
//     var msnry = new Masonry(elem, {
//         itemSelector: '.category',
//         column: 200
//     });
// }
// $('#category-wrap').masonry(
//     itemSelector: '.category',
//     column: 200
// );
jQuery(function ($) {
    $('#category-wrap').masonry({
            itemSelector: '.category',
            column: 200
    });
// $('#category-wrap').imagesLoaded().progress( function() {
//     $('#category-wrap').masonry('layout');
// });
});