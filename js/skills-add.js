const openAdd = document.getElementById("i-open-skill-add");
const closeAdd = document.getElementById("close-add-skills");
const skillAdd = document.getElementById("skills-add");
const overlay4 = document.getElementById("overlay4");

function openSkillAdd(){
    if (!skillAdd.classList.contains("open-add-skills")){
        resetSkillAdd()
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
    }
    else {
        labelInput.style.color = "#333333";
        skillInput.style.border = "1px solid #00000040"
    }
    
}
function resetSkillAdd(){
    skillInput.value = "";
    labelInput.style.color = "#333333";
    skillInput.style.border = "1px solid #00000040"

}

//Adicionar nova habilidade
btnAdd.addEventListener("click", validateSkills)

//dropdown nível
const levelDropdownBtn = document.getElementById("level-dropdown-btn");
const dropdownList = document.getElementById("level-dropdown-list");
const dropdownItem = document.getElementById("level-dropdown-list li");

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

levelDropdownBtn.onclick = openDropdown;
skillAdd.onclick = 