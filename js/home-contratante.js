const profileButton = document.querySelector(".profile-button");
const profileList = document.querySelector(".profile-list");
const profileItems = document.querySelectorAll(".profile-list-items");
const buttonClose = document.getElementById("close-profile-list");
const leave = document.getElementById("leave");
const buttonSearch = document.querySelector(".button-search");
const overlay = document.querySelector(".overlay");

function openProfileList(){
    if (profileList.classList.contains("open-profile")){
        profileList.style.display = "none";
        overlay.style.display = "none";
        setTimeout(() => {
            profileList.classList.remove("open-profile");
        }, 10);
    } else {
        profileList.style.display = "flex";
        overlay.style.display = "block";
        setTimeout(() => {
            profileList.classList.add("open-profile");
        }, 10);
    }
}
profileItems.forEach(items => {
    items.addEventListener("click", function() {
        profileList.style.display = "none";
        overlay.style.display = "none";
        setTimeout(() => {
            profileList.classList.remove("open-profile");
        }, 10);
    })
})

overlay.addEventListener("click", function() {
    profileList.style.display = "none";
    overlay.style.display = "none";
    setTimeout(() => {
        profileList.classList.remove("open-profile");
    }, 10);
})

buttonClose.addEventListener("click", function(){
    profileList.style.display = "none";
    overlay.style.display = "none";
    setTimeout(() => {
        profileList.classList.remove("open-profile");
    }, 10);
})


profileButton.addEventListener("click", openProfileList);