
//validações do formulário
const form = document.getElementById("form");
const campos = document.querySelectorAll(".required");
const spans = document.querySelectorAll(".span-required");
const spanCorrect = document.querySelectorAll(".span-correct");
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


form.addEventListener("submit", (event) =>{
    event.preventDefault();
    if(isFormValid()) {
        if (campos[0].value != "musico@gmail.com" && campos[0].value != "contratante@gmail.com"){
            setEmailError(0);
            clearField(0);
            clearField(1);
        }
        else if (loginMusico()){
            window.location.href = "/html/home-musico.html";
        } 
        else if (loginContratante()){
            window.location.href = "/html/home-contratante.html";
        }
    }
})

function isFormValid(){
    return (emailValidate() && passwordValidate());
}


function setError(index){
    campos[index].style.border = "1px solid #e63636";
    spans[index].style.display = "block";
}

function removeError(index){
    campos[index].style.border = "";
    spans[index].style.display = "none";
}

function setEmailError(index){
    spanCorrect[index].style.display = "block";
}

function removeEmailError(index){
    spanCorrect[index].style.display = "none";
}

function setPassError(index){
    spanCorrect[index].style.display = "block";
}

function removePassError(index){
    spanCorrect[index].style.display = "none";
}

function clearField(index){
    campos[index].value = "";
}

function loginMusico(){

    if (campos[0].value == "musico@gmail.com"){
        if (campos[1].value == "musico123"){
            removeEmailError(0);
            removePassError(1);
            return true;
        }
        else {
            setPassError(1);
            clearField(1);
            return false;
        }
    }
    return false;   
}

function loginContratante(){

    if (campos[0].value == "contratante@gmail.com"){
        if (campos[1].value == "contratante123"){
            removeEmailError(0);
            removePassError(1);
            return true;
        }
        else {
            setPassError(1);
            clearField(1);
            return false;
        }
    }
    return false;  
}



function emailValidate(){
    if(!emailRegex.test(campos[0].value)){
        setError(0);
        removeEmailError(0);
        return false;
    }
    else{
        removeError(0);
        return true;
    }
}

function passwordValidate(){
    if(campos[1].value.length < 8){
        setError(1)
        removePassError(1);
        return false
    }
    else{
        removeError(1)
        return true
    }
}