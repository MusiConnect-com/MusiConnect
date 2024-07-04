const profileButton = document.querySelector(".profile-button");
const profileList = document.querySelector(".profile-list");
const profileItems = document.querySelectorAll(".profile-list-items");
const buttonClose = document.getElementById("close-profile-list");
const leave = document.getElementById("leave");
const buttonSearch = document.querySelector(".button-search");
const overlay = document.querySelector(".overlay");

buttonSearch.addEventListener("click", function() {
    window.location.href = "/Anúncios/Code/Anuncios.html"
});

leave.addEventListener("click", function() {
    window.location.href = "/Login/Code/Login.html"
});

function openProfileList(){
    if (profileList.classList.contains("open-profile")){
        profileList.style.display = "none";
        overlay.style.display = "none";
        profileList.classList.remove("open-profile")
        profileButton.classList.remove("open-profile")
    } else {
        profileList.style.display = "flex";
        overlay.style.display = "block";
        profileList.classList.add("open-profile")
        profileButton.classList.add("open-profile")
    }
}
profileItems.forEach(items => {
    items.addEventListener("click", function() {
        profileList.style.display = "none";
        overlay.style.display = "none";
        profileList.classList.remove("open-profile")
        profileButton.classList.remove("open-profile")
    })
})

overlay.addEventListener("click", function() {
    profileList.style.display = "none";
    overlay.style.display = "none";
    profileList.classList.remove("open-profile")
    profileButton.classList.remove("open-profile")
})

buttonClose.addEventListener("click", function(){
    profileList.style.display = "none";
    overlay.style.display = "none";
    profileList.classList.remove("open-profile")
    profileButton.classList.remove("open-profile")
})


profileButton.addEventListener("click", openProfileList);