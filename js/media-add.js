// Abrir adicionar mídia
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
        resetMediaAdd();
    }
}

btnOpenMediaAdd.onclick = openMediaAdd;
btnCloseMediaAdd.onclick = closeMediaAdd;

const labelTitle = document.getElementById("label-media-title");
const titleInput = document.getElementById("input-media-title");
const labelDoc = document.getElementById("label-media-doc");
const docInput = document.getElementById("input-media-doc");
const btnMediaAdd = document.getElementById("btn-media-add");

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
        fileType = [".jpg", ".jpeg", ".png"];
        message.textContent = selectedType.innerText;
    }else if(selectedType.innerText === "Vídeos"){
        fileType = [".mp4", ".webm"];
        message.textContent = selectedType.innerText;
    }else if(selectedType.innerText === "Documentos"){
        fileType = ["application/pdf", "text/plain", "application/zip"];
        message.textContent = selectedType.innerText;
    }

    const file = docInput.files[0];

    if (!file){
        message.classList.remove("open-error");
        labelDoc.style.color = "#e63636";
        docInput.classList.add("fake-input");
        return false;
    }
    
    if(!fileType.includes(file.type)){
        message.classList.add("open-error");
        labelDoc.style.color = "#e63636";
        docInput.classList.add("fake-input");
        return false;
    }else {
        message.classList.remove("open-error");
        labelDoc.style.color = "#333333";
        docInput.classList.remove("fake-input");
        return true;
    }
}

function resetMediaAdd(){
    labelTitle.style.color = "#333333";
    titleInput.value = "";
    titleInput.style.border = "1px solid #00000040"
    labelDoc.style.color = "#333333";
    docInput.value = "";
    docInput.classList.remove("fake-input");
    resetDropdownType();
    setAcceptImages();
}

//accepts
function setAcceptImages(){
    docInput.setAttribute("accept", ".jpg, .jpeg, .png");
}

function setAcceptVideos(){
    docInput.setAttribute("accept", ".mp4, .webm");
}

function setAcceptDoc(){
    docInput.setAttribute("accept", ".pdf, .txt, .zip");
}

//dropdown tipo de arquivo
const TypeDropdownBtn = document.getElementById("type-dropdown-btn");
const dropdownListType = document.getElementById("type-dropdown-list");
const dropdownItemType = document.querySelectorAll(".type-dropdown-list li");
const selectedType = document.getElementById("selected-type");

function openDropdownType(){
    if(!dropdownListType.classList.contains("open-dropdown")){
        dropdownListType.style.display = "flex";
        setTimeout(() => {
            TypeDropdownBtn.classList.add("open-dropdown");
            dropdownListType.classList.add("open-dropdown");
        }, 10);
    }
}

function closeDropdownType(){
    if(dropdownListType.classList.contains("open-dropdown")){
        dropdownListType.classList.remove("open-dropdown");
        TypeDropdownBtn.classList.remove("open-dropdown");
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

TypeDropdownBtn.addEventListener("click", function(){
    if(dropdownListType.classList.contains("open-dropdown")){
        closeDropdownType();
    }else {
        openDropdownType();
    }
});

dropdownItemType.forEach(item =>{
    item.addEventListener("click", function(){
        selectedType.innerText = item.innerText;
        closeDropdownType();
        dropdownItemType.forEach(item => {
            item.classList.remove("active");
        })
        item.classList.add("active");
    });
});


btnMediaAdd.addEventListener("click", function(){
    validateMediaFile();
    validateMediaTitle();
});