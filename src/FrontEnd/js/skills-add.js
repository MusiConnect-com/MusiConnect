
//Abrir adicionar habilidade
const openAdd = document.getElementById("i-open-skill-add");
const closeAdd = document.getElementById("close-add-skills");
const skillAdd = document.getElementById("skills-add");
const skillAddHeader = document.querySelector(".skills-add-header h3");
const overlay4 = document.getElementById("overlay4");

function openSkillAdd(){
    if (!skillAdd.classList.contains("open-add-skills")){
        skillAdd.style.display = "flex";
        setTimeout(() => {
            skillAdd.classList.add("open-add-skills");
        }, 10);
        overlay4.style.display = "block";
    }
}

function closeSkillAdd(){
    if(skillAdd.classList.contains("open-add-skills")){
        skillAdd.classList.remove("open-add-skills");
        overlay4.style.display = "none";
        skillAdd.style.display = "none";
        resetSkillAdd();
    }
}

openAdd.onclick = openSkillAdd;
closeAdd.onclick = closeSkillAdd;

const btnAdd = document.getElementById("btn-skills-add");
const skillInput = document.getElementById("skill-input");
const labelInput = document.getElementById("label-skill-input");

function validateSkills(){
    if (skillInput.value == ""){
        labelInput.style.color = "#e63636";
        skillInput.style.border = "1px solid #e63636"
        return false;
    }
    else {
        labelInput.style.color = "#333333";
        skillInput.style.border = "1px solid #00000040"
        return true;
    }
    
}
function resetSkillAdd(){
    skillInput.value = "";
    labelInput.style.color = "#333333";
    skillInput.style.border = "1px solid #00000040";
    skillAddHeader.innerText = "Adicionar Habilidade";
    resetDropdown();

}

//dropdown nível
const levelDropdownBtn = document.getElementById("level-dropdown-btn");
const dropdownList = document.getElementById("level-dropdown-list");
const dropdownItem = document.querySelectorAll(".level-dropdown-list li");
const selectedLevel = document.getElementById("selected-level");

function openDropdown() {
    if (!dropdownList.classList.contains("open-dropdown")){
        dropdownList.style.display = "flex";
        setTimeout(() => {
            levelDropdownBtn.classList.add("open-dropdown");
            dropdownList.classList.add("open-dropdown");
        }, 10);
    }
}

function closeDropdown(){
    if (dropdownList.classList.contains("open-dropdown")){
        levelDropdownBtn.classList.remove("open-dropdown");
        dropdownList.classList.remove("open-dropdown");
        setTimeout(() => {
            dropdownList.style.display = "none";
        }, 300);
    }
}

function resetDropdown(){
    closeDropdown();
    selectedLevel.innerText = dropdownItem[0].innerText;
    dropdownItem.forEach(item =>{
        item.classList.remove("active");
    })
    dropdownItem[0].classList.add("active");

}

levelDropdownBtn.onclick = function(){
    if(dropdownList.classList.contains("open-dropdown")){
        closeDropdown();
    }
    else {
        openDropdown();
    }
};

dropdownItem.forEach(item => {
    item.addEventListener("click", function(){
        selectedLevel.innerText = item.innerText;
        closeDropdown();
        dropdownItem.forEach(item =>{
            item.classList.remove("active");
        })
        item.classList.add("active");
    })
})

//Adicionar nova habilidade
const newSkill = document.getElementById("new-skill-item");
const h4Skill = document.getElementById("h4-new-skill");
const spanSkill = document.getElementById("span-new-skill");

function addNewSkill(){
    if (validateSkills()){
        newSkill.style.display = "flex"
        h4Skill.innerText = skillInput.value;
        spanSkill.innerText = selectedLevel.innerText;
        closeSkillAdd();
    }
}

//editar habilidade
const skillItem = document.querySelectorAll(".skill-item");
const iconEdit = document.querySelectorAll(".skill-item .bi-pen");
const h4SkillItem = document.querySelectorAll(".skill-item h4");
const spanSkillItem = document.querySelectorAll(".skill-item span");
let index = 0;

iconEdit.forEach((icon, i)=> {
    icon.addEventListener("click", function(){
        const newSkillAddHeader = "Editar Habilidade";

        skillInput.value = h4SkillItem[i].innerText;
        selectedLevel.innerText = spanSkillItem[i].innerText;

        dropdownItem.forEach(item =>{
            item.classList.remove("active");
            if (item.innerText == selectedLevel.innerText){
                item.classList.add("active");
            }
        });

        skillAddHeader.innerText = newSkillAddHeader;
        index = i;
        openSkillAdd();
    });
});

//botão adicionar
btnAdd.addEventListener("click", function(){
    if(skillAddHeader.innerText == "Editar Habilidade"){
        let i = index;

        if(validateSkills()){
            h4SkillItem[i].innerText = skillInput.value;
            spanSkillItem[i].innerText = selectedLevel.innerText;
            closeSkillAdd();
        }
    }
    else {
        addNewSkill();
    }
    
});