const profileButton = document.querySelector(".profile-button img");
const profileList = document.querySelector(".profile-list");
const profileItems = document.querySelectorAll(".profile-list-items");
const buttonClose = document.getElementById("close-profile-list");
const overlay2 = document.getElementById("overlay2");
const leave = document.getElementById("leave");

leave.addEventListener("click", function() {
    window.location.href = "/html/login.html"
});

function openProfileList(){
    if (profileList.classList.contains("open-profile")){
        profileList.classList.remove("open-profile");
        overlayProfile.style.display = "none";
        setTimeout(() => {
            profileList.style.display = "none";
        }, 300);
    } else {
        profileList.style.display = "flex";
        overlay2.style.display = "block";
        setTimeout(() => {
            profileList.classList.add("open-profile");
        }, 10);
    }
}
profileItems.forEach(items => {
    items.addEventListener("click", function() {
        profileList.classList.remove("open-profile");
        overlay2.style.display = "none";
        setTimeout(() => {
            profileList.style.display = "none";
        }, 300);
    })
})

overlay2.addEventListener("click", function() {
    profileList.classList.remove("open-profile");
    overlay2.style.display = "none";
    setTimeout(() => {
        profileList.style.display = "none";
    }, 300);
})

buttonClose.addEventListener("click", function(){
    profileList.classList.remove("open-profile");
    overlay2.style.display = "none";
    setTimeout(() => {
        profileList.style.display = "none";
    }, 300);
})


profileButton.addEventListener("click", openProfileList);