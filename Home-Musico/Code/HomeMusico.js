const profileButton = document.querySelector(".profile-button");
const profileList = document.querySelector(".profile-list");
const leave = document.getElementById("leave");
const buttonSearch = document.querySelector(".button-search");

buttonSearch.addEventListener("click", function() {
    window.location.href = "/Anúncios/Code/Anuncios.html"
});

leave.addEventListener("click", function() {
    window.location.href = "/Login/Code/Login.html"
});

function openProfileList(){
    if (profileList.classList.contains("open-profile")){
        profileList.style.display = "none";
        profileList.classList.remove("open-profile")
        profileButton.classList.remove("open-profile")
    } else {
        profileList.style.display = "flex"
        profileList.classList.add("open-profile")
        profileButton.classList.add("open-profile")
    }
    
}

profileButton.addEventListener("click", openProfileList);
profileList.addEventListener("click", function() {
    profileList.style.display = "none";
    profileList.classList.remove("open-profile")
    profileButton.classList.remove("open-profile")
})