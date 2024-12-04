// Limitar caracteres na descrição e no complemento
const comp = document.getElementById("complemento");
const desc = document.getElementById("description");
const countComp = document.getElementById("char-count-comp");
const countDesc = document.getElementById("char-count-desc");

// Função para limitar os caracteres e atualizar o contador
comp.addEventListener("input", function() {
  let maxLength = 50;
  let length = comp.value.length;
  let remaining = maxLength - length;

  // Impede o texto de ultrapassar o limite
  remaining >= 0 ? countComp.textContent = `Restam ${remaining}` : comp.value = comp.value.substring(0, maxLength);
});

desc.addEventListener("input", function() {
  let maxLength = 200;
  let length = desc.value.length;
  let remaining = maxLength - length;

  remaining >= 0 ? countDesc.textContent = `Restam ${remaining}` : desc.value = desc.value.substring(0, maxLength);
});


// Função para atualizar a barra de progresso
let indexStep = 0;
const form = document.getElementById('form-signup');
const progressBar = document.getElementById('progress-bar');
const btnNext = document.getElementById('botao-avancar');
const btnBack = document.getElementById('botao-voltar');
const formSteps = document.querySelectorAll('.form-step');
const steps = document.querySelectorAll('.step');
const stepsDefault = document.querySelectorAll('.step.default');
const stepsHidden = document.querySelectorAll('.step.hidden-step');
const totalSteps = steps.length;
const totalDefault = stepsDefault.length;
let totalHidden = stepsHidden.length;

function updateTotalHidden() {
  return document.querySelectorAll('.step.hidden-step').length;
}

// Exemplo de como avançar as etapas
function nextStep() {
  let nextIndexStep = indexStep + 1;
  let totalHidden = updateTotalHidden();

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

  if (totalHidden === 0) {
    if (nextIndexStep < totalSteps) {
      let width = (nextIndexStep / totalSteps) * 100;
      next(width);
    }
  } else if (totalHidden !== 0) {
    if (nextIndexStep < totalDefault) {
      let width = (nextIndexStep / totalDefault) * 100;
      next(width);
    }
  }

  return nextIndexStep;
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

const selectMusic = document.querySelector(".select-music");
const selectContractor = document.querySelector(".select-contractor");
const span = document.querySelector(".form-step-goal-top span");
const musicOption = document.getElementById('music');
const contractorOption = document.getElementById('contractor');
const errorProfileSpan = document.getElementById("error-profile");
const errorAddressSpan = document.getElementById("error-address");
const inputFile = document.getElementById('foto');
const preview = document.getElementById('image-preview');
const botaoFoto = document.getElementById('botao-foto');

function setError() {
  selectMusic.style.border = "1px solid #e63636";
  selectContractor.style.border = "1px solid #e63636";
  span.style.display = "block";
}

function removeError() {
  selectMusic.style.border = "";
  selectContractor.style.border = "";
  span.style.display = "none";
}

function validateSelection() {
  if (musicOption.checked || contractorOption.checked) {
    removeError();
    selectMusic.classList.toggle("box-checked", musicOption.checked);
    selectContractor.classList.toggle("box-checked", contractorOption.checked);
    return true;
  } else {
    setError();
    return false;
  }
}

function validateMusicOption() {
  if (musicOption.checked) {
    const stepsHidden = document.querySelectorAll('.step.hidden-step');
    stepsHidden.forEach(stepHidden => {
      stepHidden.classList.remove("hidden-step");
    });

    return true;
  } else if (!musicOption.checked && contractorOption.checked) {
    return false;
  }
}

function validateFile(file, erro) {
  const fileTypes = ["image/jpeg", "image/png", "image/jpg"];

  if (!file) {
    erro.innerHTML = "Imagem é obrigatória";
    return false;
  } else if (!fileTypes.includes(file.type)) {
    erro.innerHTML = "Esse arquivo não é uma imagem.";
    return false;
  }
  
  erro.innerHTML = "";
  return true;
}

function validatePersonalData() {
  // Limpe mensagens de erro anteriores
  errorProfileSpan.innerHTML = "";
  errorAddressSpan.innerHTML = "";

  // Validação de dados pessoais
  const dateBirth = document.getElementById("date-birth").value;
  const sex = document.getElementById("sex").value;
  const phone = document.getElementById("phone").value;
  const logradouro = document.getElementById("logradouro").value;
  const numero = document.getElementById("numero").value;
  const bairro = document.getElementById("bairro").value;
  const cep = document.getElementById("cep").value;
  const cidade = document.getElementById("cidade").value;

  // Inicializa a variável isValid como true
  if (!validateFile(inputFile.files[0], errorProfileSpan)) {
    inputFile.value = ""; 
    preview.src = ""; 
    return false; 
  } else if (!dateBirth) {
    errorProfileSpan.innerHTML = "Data de Nascimento é obrigatória.";
    return false;
  } else if (!sex) {
    errorProfileSpan.innerHTML = "Sexo é obrigatório.";
    return false;
  } else if (!phone) {
    errorProfileSpan.innerHTML = "Telefone é obrigatório.";
  } else if (!logradouro) {
    errorAddressSpan.innerHTML = "Logradouro é obrigatório.";
    return false;
  } else if (!numero) {
    errorAddressSpan.innerHTML = "Número é obrigatório.";
    return false;
  } else if (!bairro) {
    errorAddressSpan.innerHTML = "Bairro é obrigatório.";
    return false;
  } else if (!cep) {
    errorAddressSpan.innerHTML = "CEP é obrigatório.";
    return false;
  } else if (!cidade) {
    errorAddressSpan.innerHTML = "Cidade é obrigatória.";
    return false;
  } else if (dateBirth && sex && logradouro && numero && bairro && cep && cidade) {
    return true; // Se todas as validações passarem, retorna true
  }
}

function validateSkillsAndGenres() {
  const errorAboutMusicSpan = document.getElementById('error-about-music');

  // Limpe a mensagem de erro anterior
  errorAboutMusicSpan.innerHTML = "";

  // Validação de habilidade e gênero musical
  const skill = document.getElementById("skill").value;
  const genreMusic = document.getElementById("genre-music").value;

  if (!skill) {
    errorAboutMusicSpan.innerHTML = "Habilidade é obrigatória.";
    return false;
  } else if (!genreMusic) {
    errorAboutMusicSpan.innerHTML = "Gênero Musical é obrigatório.";
    return false; 
  } else if (skill && genreMusic) {
    return true;
  }
}

const validacoesDeEtapas = [
  { validacao1: validateSelection, validacao2: validateMusicOption },
  { validacao1: validatePersonalData },
  { validacao1: null },
  { validacao1: validateSkillsAndGenres }
];

function validarAvancoDeEtapa(index){
  let indexValidacao = validacoesDeEtapas[index];

  let validacao = indexValidacao.validacao1 ? indexValidacao.validacao1() : true;
  if (validacao) {
    if (indexValidacao.validacao2) {indexValidacao.validacao2()}
    return true;
  } else {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    return false;
  }
  
}

btnNext.addEventListener('click', function (event) {
  event.preventDefault();

  if (validarAvancoDeEtapa(indexStep)) {
    let indexAtual = nextStep();
    console.log(`${indexAtual} de ${totalSteps}`)
    if (indexAtual >= totalSteps) {
      removerFotoVazia();
      form.submit();
    }
  }
});

btnBack.addEventListener('click', function(event){
  event.preventDefault();
  backStep();
});


// Mostrando imagem selecionada
inputFile.addEventListener('change', function(event) {
  const file = event.target.files[0];

  preview.src = ""; 

  if (file) {
      if (!validateFile(file, errorProfileSpan)) {
          inputFile.value = ""; 
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

function mostrarFotoInserida(fotos, preview) {
  const erroFotos = document.getElementById('error-gallery-photos');

  const foto = fotos[0]; 

  if (!foto || !validateFile(foto, erroFotos)) {
    return; 
  }

  const previewDiv = document.createElement('div');
  previewDiv.classList.add('layout-preview-gallery');
  const btnClose = adicionarBotaoClose();
  const img = document.createElement('img');
  img.src = URL.createObjectURL(foto); 
  previewDiv.appendChild(img);
  previewDiv.appendChild(btnClose);
  preview.appendChild(previewDiv);
}

function removerFotoVazia() {
  let inputs = document.querySelectorAll('.fotos');
  let inputsGaleria = document.getElementById('inputs-gallery');

  inputs.forEach(foto => {
    if (foto.value === '') {inputsGaleria.removeChild(foto);}
  });
}

function adicionarInputFoto() {
  const previewGaleria = document.getElementById('preview-gallery');
  const inputsGaleria = document.getElementById('inputs-gallery');

  const input = document.createElement('input');

  input.type = 'file';
  input.name = 'fotos[]';
  input.style.display = 'none';
  input.classList.add('fotos');
  input.accept = 'image/png, image/jpeg, image/jpg';

  inputsGaleria.appendChild(input);

  input.click();

  input.addEventListener('change', function(event) {
    const fotos = event.target.files;
    
    mostrarFotoInserida(fotos, previewGaleria);
  });
}

function adicionarBotaoClose() {
  const btnClose = document.createElement('button');
  btnClose.type = 'button';
  const iconClose = document.createElement('i');
  iconClose.classList.add('bi-x-lg');
  btnClose.appendChild(iconClose);

  return btnClose;
}

function removerFotoInserida(id) {
  let preview = document.querySelectorAll('.layout-preview-gallery');

  if (preview[id]) {preview[id].remove()}
}

function capturarIdBotaoCloseClicado(event) {
  let btnClicado = event.target.closest('button'); // encontra o botão mais próximo
  let btnsClose = document.querySelectorAll('.layout-preview-gallery button');
  return Array.from(btnsClose).indexOf(btnClicado); // retorna o índice do botão clicado
}

const addFoto = document.getElementById('add-foto');
addFoto.addEventListener('click', ()=>{
  removerFotoVazia();
  adicionarInputFoto();
});

const previewGaleria = document.getElementById('preview-gallery');
previewGaleria.addEventListener('click', function(event) {
  if (event.target.closest('button')) {
    let id = capturarIdBotaoCloseClicado(event);
    removerFotoInserida(id);
  }
});