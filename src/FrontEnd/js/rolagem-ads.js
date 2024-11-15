// rolagem de anúncios

const ad = document.querySelector(".anuncios-recentes");
const leftArrow = document.querySelector(".left-arrow");
const rightArrow = document.querySelector(".right-arrow");

let adAtual = 0;
let adFinal = ad.children.length - 4;

offArrow();

function updateAds(){
    const deslocamento = - (adAtual) * 330;
    ad.style.transform = `translateX(${deslocamento}px)`;
    offArrow();
}

function offArrow(){

    if (ad.children.length <= 3){
        leftArrow.style.display = "none";
        rightArrow.style.display = "none";
    }else {
        if (adAtual === 0){
            leftArrow.style.display = "none";
        } else {
            leftArrow.style.display = "block";
        }

        if (adAtual === adFinal) {
            rightArrow.style.display = "none";
        }else {
            rightArrow.style.display = "block";
        }
    } 
}


leftArrow.addEventListener("click", function(){

    if (adAtual > 0){
        adAtual--;
        updateAds();
    }

})

rightArrow.addEventListener("click", function(){
    adFinal = ad.children.length -4;

    if (adAtual < adFinal){
        adAtual++;
        updateAds();
    }
} )