// Select profile details element
let profile = document.querySelector('.header .flex .profile-detail');

// Select search form element
let searchForm = document.querySelector('.header .flex .search-form');

// Select navbar element
let navbar = document.querySelector('.navbar');

document.querySelector('#user-btn').onclick = () => {
    console.log("User button clicked");
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
    navbar.classList.remove('active');
}

document.querySelector('#search-btn').onclick = () => {
    console.log("Search button clicked");
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
    navbar.classList.remove('active');
}

document.querySelector('#menu-btn').onclick = () => {
    console.log("Menu button clicked");
    navbar.classList.toggle('active');
    profile.classList.remove('active');
    searchForm.classList.remove('active');
}

/*---Home slider---*/
const imgBox = document.querySelector('.slider-container');
const slides = document.getElementsByClassName('slideBox');
var i = 0;

function nextSlide(){
    slides[i].classList.remove('active');
    i = (i + 1)% slides.length;
    slides[i].classList.add('active');
}

function prevSlide(){
    slides[i].classList.remove('active');
    i = (i - 1 + slides.length)% slides.length;
    slides[i].classList.add('active');
}
/*---Testimonial slider---*/
const btn = document.getElementsByClassName('btn1');
const slide = document.getElementById('slide');

btn[0].onclick = function () {
    slide.style.transform = 'translateX(0px)';
    for (var i = 0; i < btn.length; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
}
btn[1].onclick = function () {
    slide.style.transform = 'translateX(-800px)';
    for (var i = 0; i < btn.length; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
}
btn[2].onclick = function () {
    slide.style.transform = 'translateX(-1600px)';
    for (var i = 0; i < btn.length; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
}
btn[3].onclick = function () {
    slide.style.transform = 'translateX(-2400px)';
    for (var i = 0; i < btn.length; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
}
