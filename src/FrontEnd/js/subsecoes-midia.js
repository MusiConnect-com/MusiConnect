const navLinks = document.querySelectorAll(".nav-media li");
const addMedia = document.getElementById("add-media");
const subsections = document.querySelectorAll(".subsection-media");

navLinks.forEach((links, i)=>{
    links.addEventListener("click", function(){
        navLinks.forEach(links =>{
            links.classList.remove("selected");
        });
        links.classList.add("selected");
        
        subsections.forEach(section =>{
            section.removeAttribute("id");
        });

        const activeSubSection = subsections[i];
        activeSubSection.setAttribute("id", "active");

        subsections.forEach(section =>{
            if (section.getAttribute("id") !== "active"){
                section.removeAttribute("id");
            }
        });
    });
});

//reset subseções
function resetSubSections(){
    navLinks.forEach(links =>{
        links.classList.remove("selected");
    });
    navLinks[0].classList.add("selected");
    
    subsections.forEach(section =>{
        section.removeAttribute("id");
    });

    const activeSubSection = subsections[0];
    activeSubSection.setAttribute("id", "active");

    subsections.forEach(section =>{
        if (section.getAttribute("id") !== "active"){
            section.removeAttribute("id");
        }
    });
}

//navegar para vídeos
function moveVideos(){
    navLinks.forEach(links =>{
        links.classList.remove("selected");
    });
    navLinks[1].classList.add("selected");
    
    subsections.forEach(section =>{
        section.removeAttribute("id");
    });

    const activeSubSection = subsections[1];
    activeSubSection.setAttribute("id", "active");

    subsections.forEach(section =>{
        if (section.getAttribute("id") !== "active"){
            section.removeAttribute("id");
        }
    });
}