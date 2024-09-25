const options = document.querySelectorAll(".nav-perfil ul li span");
const sections = document.querySelectorAll(".info-perfil section");

options.forEach((option, i) => {
    const optionsList = document.querySelectorAll(".nav-perfil ul li");

    option.addEventListener("click", function(){
        optionsList.forEach(optionList => {
            optionList.classList.remove("selected");
        });
        optionsList[i].classList.add("selected");

        sections.forEach(section => {
            section.classList.remove("active");
        });

        const activeSection = sections[i];
        activeSection.style.display = "flex";
        activeSection.offsetHeight;
        activeSection.classList.add("active");
        
        sections.forEach(section => {
            if (!section.classList.contains("active")) {
                section.style.display = "none";
            }
        });
    });
})

//navegar para mídia
function moveMedia(){
    const optionsList = document.querySelectorAll(".nav-perfil ul li");

    optionsList.forEach(optionList => {
        optionList.classList.remove("selected");
    });
    optionsList[3].classList.add("selected");

    sections.forEach(section => {
        section.classList.remove("active");
    });

    const activeSection = sections[3];
    activeSection.style.display = "flex";
    activeSection.offsetHeight;
    activeSection.classList.add("active");

    sections.forEach(section => {
        if (!section.classList.contains("active")) {
            section.style.display = "none";
        }
    });
}