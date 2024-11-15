// Mostrando imagem selecionada
const erroEvento = document.getElementById('erro-evento');
const erroEndereco = document.getElementById('erroEndereco');
const erroVaga = document.getElementById('erroVaga');
const erroContato = document.getElementById('erroContato');
const preview = document.getElementById('image-preview');
const inputFoto = document.getElementById('foto');
const botaoFoto = document.getElementById('botao-foto');


function validateFile(file) {
    const fileTypes = ["image/jpeg", "image/png", "image/jpg"];
  
    if (!file) {
      erroEvento.innerHTML = "Imagem é obrigatória";
      return false;
    } else if (!fileTypes.includes(file.type)) {
        erroEvento.innerHTML = "Esse arquivo não é uma imagem.";
      return false;
    }
    
    erroEvento.innerHTML = "";
    return true;
}

inputFoto.addEventListener('change', function(event) {
    const file = event.target.files[0];

    preview.src = ""; 

    if (file) {
        if (!validateFile(file)) {
            inputFoto.value = ""; 
            preview.src = ""; 
            return; 
        }

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        botaoFoto.textContent = 'Mudar foto';

    } else {
        preview.src = '';
        preview.style.display = 'none';
        botaoFoto.textContent = 'Adicionar Foto'; 
    }
});

// Mudando as etapas
let indexStep = 0;
const form = document.getElementById('form-novo-anuncio');
const progressBar = document.getElementById('progress-bar');
const btnAvancar = document.getElementById('botao-avancar');
const btnVoltar = document.getElementById('botao-voltar');
const formSteps = document.querySelectorAll('.form-step');
const steps = document.querySelectorAll('.step');
const totalSteps = steps.length;

function nextStep() {
    let nextIndexStep = indexStep + 1;
  
    function next(width) {
        formSteps.forEach(formStep => {
            formStep.classList.add("hidden");
        });
      
        formSteps[nextIndexStep].classList.remove("hidden");

        progressBar.style.width = `${width}%`;
    
        steps.forEach((step, index) => {
            step.classList.toggle("active", index < nextIndexStep);
        });
    
        indexStep = nextIndexStep;
    }
  
    if (nextIndexStep < totalSteps) {
        let width = (nextIndexStep / totalSteps) * 100;

        next(width);
    } else if (nextIndexStep >= totalSteps) {
        form.submit();
    }
}

function backStep() {
    let backIndexStep = indexStep - 1;
    console.log("backIndex " + backIndexStep);
  
    function back(width) {
        formSteps.forEach(formStep => {
            formStep.classList.add("hidden");
        });
      
        formSteps[backIndexStep].classList.remove("hidden");
        
        progressBar.style.width = `${width}%`;
    
        steps.forEach((step, index) => {
            step.classList.toggle("active", index < backIndexStep);
        });
    
        indexStep = backIndexStep;
    }
  
    if (backIndexStep >= 0) {
        let width = (backIndexStep / totalSteps) * 100;

        back(width);
    }
}

btnAvancar.addEventListener('click', function(event){
    event.preventDefault();
    console.log("indexAtual " + indexStep);
    nextStep();
});

btnVoltar.addEventListener('click', function(event){
    event.preventDefault();
    console.log("indexAtual " + indexStep);
    backStep();
});
  
