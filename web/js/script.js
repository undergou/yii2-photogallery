var formToMove = document.getElementById('form-to-move');
var moveImages = document.getElementById('move-images');
if(moveImages) {
    moveImages.addEventListener('click', hideForm);
}


function hideForm() {
    formToMove.style.display = 'inline-block';
}
