// Abrir adicionar mídia
const mediaAdd = document.getElementById("media-add");
const mediaAddHeader = document.querySelector(".media-add-header h3");
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
        resetMediaAdd();
    }
}

btnOpenMediaAdd.onclick = openMediaAdd;
btnCloseMediaAdd.onclick = closeMediaAdd;

const labelTitle = document.getElementById("label-media-title");
const titleInput = document.getElementById("input-media-title");
const labelFile = document.getElementById("label-media-file");
const fileInput = document.getElementById("input-media-file");
const btnMediaAdd = document.getElementById("btn-media-add");
const btnMediaDelete = document.getElementById("btn-media-delete");

function validateMediaTitle(){
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

function validateMediaFile(){
    const message = document.getElementById("message");
    let fileType = [];

    if (selectedType.innerText === "Foto"){
        fileType = ["image/jpg", "image/jpeg", "image/png"];
        message.innerText = "Formato aceito para fotos : jpg , jpeg e png";
    }else if(selectedType.innerText === "Vídeo"){
        fileType = ["video/mp4", "video/webm"];
        message.innerText = "Formato aceito para vídeos : mp4 e webm";
    }else if(selectedType.innerText === "Documento"){
        fileType = ["application/pdf", "text/plain", "application/zip"];
        message.innerText = "Formato aceito para documentos : pdf , txt e zip";
    }

    const file = fileInput.files[0];

    if (!file){
        message.classList.remove("open-error");
        labelFile.style.color = "#e63636";
        fileInput.classList.add("fake-input");
        return false;
    }
    
    if(!fileType.includes(file.type)){
        message.classList.add("open-error");
        labelFile.style.color = "#e63636";
        fileInput.classList.add("fake-input");
        return false;
    }else {
        message.classList.remove("open-error");
        labelFile.style.color = "#333333";
        fileInput.classList.remove("fake-input");
        return true;
    }
}

function validateMediaAdd(){
    if (validateMediaTitle() && validateMediaFile()){
        return true;
    }else {
        return false;
    }
}

function resetMediaAdd(){
    labelTitle.style.color = "#333333";
    titleInput.value = "";
    titleInput.style.border = "1px solid #00000040"
    labelFile.style.color = "#333333";
    fileInput.value = "";
    fileInput.classList.remove("fake-input");
    resetDropdownType();
    setAcceptImages();
    mediaAddHeader.innerText = "Adicionar Mídia";
    btnMediaAdd.innerText = "Adicionar";
    btnMediaDelete.style.display = "none";
    typeDropdown.style.display = "inline";
}

//accepts
function setAcceptImages(){
    fileInput.setAttribute("accept", ".jpg, .jpeg, .png");
}

function setAcceptVideos(){
    fileInput.setAttribute("accept", ".mp4, .webm");
}

function setAcceptDoc(){
    fileInput.setAttribute("accept", ".pdf, .txt, .zip");
}

//dropdown tipo de arquivo
const typeDropdown = document.getElementById("type-dropdown");
const typeDropdownBtn = document.getElementById("type-dropdown-btn");
const dropdownListType = document.getElementById("type-dropdown-list");
const dropdownItemType = document.querySelectorAll(".type-dropdown-list li");
const selectedType = document.getElementById("selected-type");

function openDropdownType(){
    if(!dropdownListType.classList.contains("open-dropdown")){
        dropdownListType.style.display = "flex";
        setTimeout(() => {
            typeDropdownBtn.classList.add("open-dropdown");
            dropdownListType.classList.add("open-dropdown");
        }, 10);
    }
}

function closeDropdownType(){
    if(dropdownListType.classList.contains("open-dropdown")){
        dropdownListType.classList.remove("open-dropdown");
        typeDropdownBtn.classList.remove("open-dropdown");
        setTimeout(() => {
            dropdownListType.style.display = "none";
        }, 10);
    }
}

function resetDropdownType(){
    closeDropdownType();
    selectedType.innerText = dropdownItemType[0].innerText;
    dropdownItemType.forEach(item =>{
        item.classList.remove("active");
    });
    dropdownItemType[0].classList.add("active");
}

typeDropdownBtn.addEventListener("click", function(){
    if(dropdownListType.classList.contains("open-dropdown")){
        closeDropdownType();
    }else {
        openDropdownType();
    }
});

dropdownItemType.forEach(item =>{
    item.addEventListener("click", function(){
        fileInput.value = "";
        validateMediaFile();
        selectedType.innerText = item.innerText;
        closeDropdownType();
        dropdownItemType.forEach(item => {
            item.classList.remove("active");
        })
        item.classList.add("active");
    });
});


//Adicionar nova foto
const newPhoto = document.getElementById("new-photo");
const newPhotoTitle = document.getElementById("new-photo-title");
const newPhotoImg = document.getElementById("new-photo-img");

function addNewPhoto(){

    const file = fileInput.files[0];

    if (file){
        newPhotoTitle.innerText = titleInput.value;
        newPhotoImg.src = URL.createObjectURL(file);
        newPhoto.classList.add("add-new-photo");
        closeMediaAdd();
    }
}

//Editar nova foto
const photos = document.querySelectorAll(".section-media-photo");
const editPhotos = document.querySelectorAll(".photo-header .bi-pen");
const photoTitle = document.querySelectorAll(".photo-header h1");
const photoImg = document.querySelectorAll(".section-media-photo li img");
let indexPhoto = 0;

editPhotos.forEach((photo, i) =>{
    photo.addEventListener("click", function(){
        mediaAddHeader.innerText = "Editar Mídia";
        titleInput.value = photoTitle[i].innerText;

        typeDropdown.style.display = "none";

        btnMediaDelete.style.display = "inline";
        btnMediaAdd.innerText = "Editar";
        openMediaAdd();
        indexPhoto = i;
    });
});


btnMediaAdd.addEventListener("click", function(){
    if (mediaAddHeader.innerText == "Editar Mídia"){
        let i = indexPhoto;

        if (validateMediaTitle()){
            photoTitle[i].innerText = titleInput.value;
        }

        if (validateMediaFile()){
            const file = fileInput.files[0];

            if (file){
                photoImg[i].src = URL.createObjectURL(file);
            }
        }
        closeMediaAdd();
    }else {
        if (validateMediaAdd()){
            addNewPhoto();
        }
    }
});