/*
*/
window.addEventListener("load", (event) => {
    
const body = document.querySelector("body");
const nav = document.querySelector("nav");
const main = document.querySelector("main");
const footer = document.querySelector("footer");
const cross = '.cross-div';

let active = false;
let rotation = 45;

$(cross).click(function() {
    $(cross).animate(
        { deg: rotation },
        {
            duration: 200,
            step: function(now) {
                $(this).css({ transform: 'rotate(' + now + 'deg)' });
            }
        }
    );
    rotation += 45;
    if(active){
        Style("none", 0, 1, 1, 'auto');
        active = false;
    } else {
        Style("flex", 1, 0, 0, 'hidden');
        active = true;
    }

    function Style(nav_diplay, nav_opacity, main_opacity, footer_opacity, body_overflow){
        nav.style.display = nav_diplay;
        nav.style.opacity = nav_opacity;
        main.style.opacity = main_opacity;
        footer.style.opacity = footer_opacity;
        body.style.overflow = body_overflow;
    }
});
});