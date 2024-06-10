window.addEventListener("load", (event) => {
    let imgInput = document.getElementById('picture_dishes_pictures');
    let previewImage = document.getElementById('image');
   
    imgInput.onchange = function(){
        DeletHoldPicture();
        if (file = imgInput.files[0]) { 
            let newImage = new Image(); 
            newImage.src = URL.createObjectURL(file); 
            newImage.onload = function () { 
                let width = newImage.width; 
                let height = newImage.height; 
                PicturePortraitDimVerify(width, height, newImage);
            }; 
        } else { 
            previewImage.src = ''; 
            alert('No image selected.'); 
        }   
    };

    function PicturePortraitDimVerify(width, height, newImage){
        const coefWidthHeight = 0.5;
        const maxWidth = 1000;
        const maxHeight = maxWidth * coefWidthHeight;

        if (width > height  && (width > maxWidth)) {
            PreviewPicture(maxWidth, maxHeight, newImage);
        } else if (width < height) {
            PictureError("Image non au format portrait");
        } else if (width < maxWidth) {
            PictureError("Image pas asser large");
        } else {
            PictureError("Image incorrect");
        }
    }

    function DeletHoldPicture() {
        try {
            const Image = document.querySelector("#canvas");
            Image.remove();
        } catch {}
    }

    function PreviewPicture(width, height, newImage) {
        let canvas = document.createElement('canvas');
        canvas.id = "canvas";
        canvas.width = width;
        canvas.height = height;
        let ctx = canvas.getContext("2d");
        ctx.drawImage(newImage, 0, 0, width, height);
        const FORMULAIRE = document.querySelector("main");
        FORMULAIRE.appendChild(canvas);
    }
    
    function PictureError(errorText){
        const FORMULAIRE = document.querySelector("main");
        let p = document.createElement('p');
        p.id = "canvas";
        p.innerText = errorText;
        FORMULAIRE.appendChild(p);
    }
})