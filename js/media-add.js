
const mediaAdd = document.getElementById("media-add");
const btnOpenMediaAdd = document.getElementById("add-media");
const btnCloseMediaAdd = document.getElementById("close-add-media");

function openMediaAdd(){
    if(!mediaAdd.classList.contains("open-media-add")){
        mediaAdd.style.display = "flex"
        setTimeout(() => {
            mediaAdd.classList.add("open-media-add");
        }, 10);
        overlay4.style.display = "block";
    }
}

function closeMediaAdd(){
    if(mediaAdd.classList.contains("open-media-add")){
        mediaAdd.classList.remove("open-media-add");
        setTimeout(() => {
            mediaAdd.style.display = "none"
        }, 10);
        overlay4.style.display = "none";
    }
}

btnOpenMediaAdd.onclick = openMediaAdd;
btnCloseMediaAdd.onclick = closeMediaAdd;

const labelTitle = docInput.getElementsById("label-media-title");
const titleInput = document.getElementById("input-media-title");
const labelDoc = docInput.getElementById("label-media-doc");
const docInput = document.getElementById("input-media-doc");
const btnMediaAdd = document.getElementById("btn-media-add");

function validateMedia(){
    if (titleInput.value == ""){
        labelTitle.style.color = "#e63636";
        titleInput.style.border = "1px solid #e63636"
        return false;
    }
    else {
        labelTitle.style.color = "#333333";
        titleInput.style.border = "1px solid #00000040"
        return true;
    }
}