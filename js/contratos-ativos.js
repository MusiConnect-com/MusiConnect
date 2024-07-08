const contractsAtivos = document.querySelectorAll(".contracts-item");
const alertSpan = document.querySelectorAll(".alert");
const btnConfirm = document.querySelectorAll(".btns .confirm");
const btnConfirmed = document.querySelectorAll(".btns .confirmed");
const modalConfirm = document.querySelector(".modal-confirm");
const modalConfirmed = document.querySelector(".modal-confirmed");
const overlay3 = document.getElementById("overlay3");

const btnNot = document.querySelector(".not-confirm");
const btnYes = document.querySelector(".yes-confirm");
const btnOk = document.querySelector(".btn-ok");

alertSpan[1].style.display = "none"
confirmedOn();

function confirmedOn() {
    alertSpan.forEach((span, i) => {
        let displayStyle = window.getComputedStyle(span).display;
        if (displayStyle === "none") {
            btnConfirm[i].style.display = "none";
            btnConfirmed[i].style.display = "block";
        } else {
            btnConfirm[i].style.display = "block";
            btnConfirmed[i].style.display = "none";
        }
    });
}

// dataset é usado para armazenar o índice atual do contrato.

contractsAtivos.forEach((contracts, i) => {
    btnConfirm[i].addEventListener("click", function () {
        let displayStyle = window.getComputedStyle(alertSpan[i]).display;
        if (displayStyle === "flex") {
            modalConfirm.dataset.currentIndex = i; 
            modalConfirm.style.display = "flex";
            overlay3.style.display = "block";
        }
    });
});

btnNot.addEventListener("click", function () {
    let i = modalConfirm.dataset.currentIndex; 
    let displayStyleAlert = window.getComputedStyle(alertSpan[i]).display;
    let displayStyleModal = window.getComputedStyle(modalConfirm).display;
    if (displayStyleAlert === "flex" && displayStyleModal === "flex") {
        modalConfirm.style.display = "none";
        overlay3.style.display = "none";
    }
});

btnYes.addEventListener("click", function () {
    let i = modalConfirm.dataset.currentIndex; 
    let displayStyleAlert = window.getComputedStyle(alertSpan[i]).display;
    let displayStyleModal = window.getComputedStyle(modalConfirm).display;
    if (displayStyleAlert === "flex" && displayStyleModal === "flex") {
        modalConfirm.style.display = "none";
        modalConfirmed.style.display = "flex";
    }
});

btnOk.addEventListener("click", function () {
    let i = modalConfirm.dataset.currentIndex; 
    let displayStyleAlert = window.getComputedStyle(alertSpan[i]).display;
    let displayStyleModal = window.getComputedStyle(modalConfirmed).display;
    if (displayStyleAlert === "flex" && displayStyleModal === "flex") {
        modalConfirmed.style.display = "none";
        alertSpan[i].style.display = "none";
        overlay3.style.display = "none";
        confirmedOn();
    }
});

overlay3.addEventListener("click", function(){
    let i = modalConfirm.dataset.currentIndex;
    let displayStyleAlert = window.getComputedStyle(alertSpan[i]).display;
    let displayStyleModal = window.getComputedStyle(modalConfirmed).display; 
    if (displayStyleAlert === "flex" && displayStyleModal === "flex"){
        modalConfirmed.style.display = "none";
        alertSpan[i].style.display = "none";
        overlay3.style.display = "none";
        confirmedOn();
    }else {
        modalConfirm.style.display = "none";
        overlay3.style.display = "none";
    }
});
