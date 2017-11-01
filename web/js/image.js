var nav = document.querySelector('nav#w0');
var styleNav = getComputedStyle(nav);
var heightNav = styleNav.height;
var imgTitle = document.querySelector('#fullimage-title');
var fullImg = document.querySelector('#fullImg');

var arrowLeft = document.querySelector('#arrow-left');
var arrowRight = document.querySelector('#arrow-right');

if(arrowLeft && arrowRight){
	arrowLeft.addEventListener('click', showFullImage);
	arrowRight.addEventListener('click', showFullImage);
}



function showFullImage(state, elem) {
	var images = document.querySelectorAll('.small-image');
	var imgArray = [];
	var imgTitlesArray = [];
	for (var i = 0; i < images.length; i++) {
		imgArray.push(images[i].src);
		imgTitlesArray.push(images[i].alt);
	}
	if(elem){
		for (var j = 0; j < imgArray.length; j++) {
			if(imgArray[j] == elem.src){
				fullImg.src = elem.src;
				imgTitle.innerHTML = elem.alt;
				num = j;
			}
		}

		// fullImg.src = elem.firstElementChild.src;

	}

	if(this.id == 'arrow-left'){
			if(num == 0){
			} else {
				num--;
				fullImg.src = imgArray[num];
				imgTitle.innerHTML = imgTitlesArray[num];
			}
		}
		if(this.id == 'arrow-right'){
			if(num == imgArray.length-1){
			}
		else{
			num++;
			fullImg.src = imgArray[num];
			imgTitle.innerHTML = imgTitlesArray[num];
			}
		}
	imgTitle.style.display = state;
	fullImg.style.display = state;
	document.querySelector('.shadow').style.display = state;
	document.querySelector('#fileclose').style.display = state;


	arrowLeft.style.display = state;
	arrowRight.style.display = state;
	var styleArrow = getComputedStyle(arrowLeft);
	arrowLeft.style.top = (parseInt(window.innerHeight)-parseInt(styleArrow.height))/2+'px';
	arrowRight.style.top = (parseInt(window.innerHeight)-parseInt(styleArrow.height))/2+'px';

	setImageSize(elem);
}

function setImageSize(elem) {

	resetValues();

	var style = getComputedStyle(fullImg);
	var proportionImage = parseInt(style.width)/parseInt(style.height);
	var proportionWindow = parseInt(window.innerWidth)/parseInt(window.innerHeight);
	if(proportionWindow >= proportionImage){
		if(fullImg.naturalHeight <= window.innerHeight){
			var imageHeight = fullImg.naturalHeight;
		}  else {
			var imageHeight = window.innerHeight;
		}
		fullImg.setAttribute('height',parseInt(imageHeight));
		fullImg.setAttribute('width','');
	} else if(proportionWindow < proportionImage){
		if(fullImg.naturalWidth <= window.innerWidth){
			var imageWidth = fullImg.naturalWidth;
		}  else {
			var imageWidth = window.innerWidth;
		}
		fullImg.setAttribute('width',parseInt(imageWidth));
		fullImg.setAttribute('height','');
	}
	var positionTop = (parseInt(window.innerHeight)-parseInt(style.height))/2+'px';
	var positionLeft = (parseInt(window.innerWidth)-parseInt(style.width))/2+'px';
	fullImg.style.top = positionTop;
	fullImg.style.left = positionLeft;

	imgTitle.style.width = style.width;
	imgTitle.style.left = positionLeft;
	imgTitle.style.bottom = positionTop;
}

window.addEventListener('resize', changeImageSizes);

function changeImageSizes() {
	// resetValues();
	if(fullImg){
		var style = getComputedStyle(fullImg);

	var proportionImage = parseInt(style.width)/parseInt(style.height);
	var proportionWindow = parseInt(window.innerWidth)/parseInt(window.innerHeight);

	if(proportionWindow >= proportionImage){
		if(fullImg.naturalHeight <= window.innerHeight){
			var imageHeight = fullImg.naturalHeight;
		}  else {
			var imageHeight = window.innerHeight;
		}
		fullImg.setAttribute('height',parseInt(imageHeight));
		fullImg.setAttribute('width','');
	} else if(proportionWindow < proportionImage){
		if(fullImg.naturalWidth <= window.innerWidth){
			var imageWidth = fullImg.naturalWidth;
		}  else {
			var imageWidth = window.innerWidth;
		}
		fullImg.setAttribute('width',parseInt(imageWidth));
		fullImg.setAttribute('height','');
	}
	var positionTop = (parseInt(window.innerHeight)-parseInt(style.height))/2+'px';
	var positionLeft = (parseInt(window.innerWidth)-parseInt(style.width))/2+'px';
	fullImg.style.top = positionTop;
	fullImg.style.left = positionLeft;

	imgTitle.style.width = style.width;
	imgTitle.style.left = positionLeft;
	imgTitle.style.bottom = positionTop;

	var styleArrow = getComputedStyle(arrowLeft);
	arrowLeft.style.top = (parseInt(window.innerHeight)-parseInt(styleArrow.height))/2+'px';
	arrowRight.style.top = (parseInt(window.innerHeight)-parseInt(styleArrow.height))/2+'px';
}
}

function resetValues() {
	fullImg.removeAttribute('height');
	fullImg.removeAttribute('width');
	fullImg.style.top = '0px';
	fullImg.style.left = '0px';
	imgTitle.style.left = '0px';
	imgTitle.style.bottom = '0px';
	var proportionImage = 0;
	var proportionWindow = 0;
	var imageHeight = 0;
	var imageWidth = 0;
}
