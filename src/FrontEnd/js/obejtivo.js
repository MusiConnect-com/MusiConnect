
const selectMusic = document.querySelector(".select-music");
const selectContractor = document.querySelector(".select-contractor");
const span = document.querySelector("span");
const buttonConfirm = document.getElementById("button-confirm");

function setError(){
    selectMusic.style.border = "1px solid #e63636";
    selectContractor.style.border = "1px solid #e63636";
    span.style.display = "block";
};

function removeError(){
    selectMusic.style.border = "";
    selectContractor.style.border = "";
    span.style.display = "none";
};

function validateSelection() {
    const musicOption = document.getElementById('music');
    const contractorOption = document.getElementById('contractor');
    
    if (musicOption.checked || contractorOption.checked) {
        removeError();
        if (musicOption.checked) {
            selectMusic.classList.add("box-checked");
        }else {
            selectMusic.classList.remove("box-checked");
        }

        if (contractorOption.checked) {
            selectContractor.classList.add("box-checked");
        }else {
            selectContractor.classList.remove("box-checked");
        }
        return true;
    } else {
        setError();
        return false;
    }
};

buttonConfirm.addEventListener("click", function(event) {
    event.preventDefault();
    
    if (validateSelection()) {
        const musicOption = document.getElementById('music');
        const contractorOption = document.getElementById('contractor');
        
        if (musicOption.checked) {
            window.location.href = "/html/home-musico.html";
        } else if (contractorOption.checked) {
            window.location.href = "/html/home-contratante.html";
        }
    }
});

const buttonHelp = document.getElementById("button-help");
const modalHelp = document.querySelector(".modal-help");
const overlayModal = document.querySelector(".overlay-modal");
const buttonClose = document.getElementById("button-close");

buttonHelp.onclick = function() {
    modalHelp.style.display = "block"
    overlayModal.style.display = "flex"
}

buttonClose.onclick = function() {
    modalHelp.style.display = "none"
    overlayModal.style.display = "none"
}

const modalCancel = document.querySelector(".modal-cancel");
const buttonCancel = document.getElementById("button-cancel")
const buttonNot = document.getElementById("button-not")
const buttonYes = document.getElementById("button-yes")

buttonCancel.onclick = function() {
    modalCancel.style.display = "Flex"
}

buttonNot.onclick = function() {
    modalCancel.style.display = "none"
}

buttonYes.onclick = function() {
    modalCancel.style.display = "none"
    window.location.href = "/html/cadastro.html";
}

