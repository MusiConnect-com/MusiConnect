
//validações do formulário
// Adiciona a lógica de redirecionamento após o envio do formulário
const form = document.getElementById("form");
const campos = document.querySelectorAll(".required");
const spans = document.querySelectorAll(".span-required");
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

form.addEventListener("submit", (event) =>{
    event.preventDefault();
    nameValidate();
    emailValidate();
    passwordValidate();
    comparePassword();

    if (isFormValid()) {
        window.location.href = "../objetivo.html";
    }
});

function isFormValid() {
    return (
        nameValidate() &&
        emailValidate() &&
        passwordValidate() &&
        comparePassword()
    );
}

function setError(index){
    campos[index].style.border = "1px solid #e63636";
    spans[index].style.display = "block";
}

function removeError(index){
    campos[index].style.border = "";
    spans[index].style.display = "none";
}

function nameValidate(){
    if(campos[0].value.length < 3){
        setError(0);
        return false;
    }
    else{
        removeError(0);
        return true;
    }
}

function emailValidate(){
    if(!emailRegex.test(campos[1].value)){
        setError(1);
        return false;
    }
    else{
        removeError(1);
        return true;
    }
}

function passwordValidate(){
    if(campos[2].value.length < 8){
        setError(2);
        return false;
    }
    else{
        removeError(2);
        return true;
    }
}

function comparePassword(){
    if(campos[3].value !== campos[2].value || campos[3].value.length < 8){
        setError(3);
        return false;
    }
    else{
        removeError(3);
        return true;
    }
}
