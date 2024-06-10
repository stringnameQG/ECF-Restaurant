window.addEventListener("load", (event) => {
const body = document.querySelector("body");
const nav = document.querySelector("nav");
const cross = '.cross-div';

let active = false;
let rotation = 45;

$(cross).click(function() {
    $(cross).animate(
        { deg: rotation },
        {
            duration: 400,
            step: function(now) {
                $(this).css({ transform: 'rotate(' + now + 'deg)' });
            }
        }
    );
    
    rotation += 45;
    if(active){
        Style("none", 0, 'auto');
        active = false;
    } else {
        Style("flex", 1, 'hidden');
        active = true;
    }

    function Style(nav_diplay, nav_opacity, body_overflow){
        nav.style.display = nav_diplay;
        nav.style.opacity = nav_opacity;
        body.style.overflow = body_overflow;
    }
});
});