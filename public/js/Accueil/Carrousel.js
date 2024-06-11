window.addEventListener("load", (event) => {
    
let slideIndex = 0;
showSlides();

function showSlides() {
    const slides = document.getElementsByClassName("dishes");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
    }

    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}   
    slides[slideIndex-1].style.display = "flex";  
    setTimeout(showSlides, 4000);
}

});

