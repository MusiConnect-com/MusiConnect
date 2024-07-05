const searchIcon = document.getElementById("search-icon");
const iconClose = document.getElementById("icon-close");
const searchHeader = document.querySelector(".search-header");
const searchInput = document.querySelector(".search-header input");
const adsSearch = document.getElementById("ads-search");

function saveQuery() {
    const query = searchInput.value;
    localStorage.setItem("searchQuery", query);
}

adsSearch.addEventListener("click", function(){
    localStorage.removeItem('searchQuery');
});

searchIcon.addEventListener("click", function(){
    if (!searchHeader.classList.contains("open-search")){
        searchIcon.classList.add("open-search");
        searchHeader.style.display = "flex";
        setTimeout(() => {
            searchHeader.classList.add("open-search");
            overlay.style.display = "block";
            searchInput.focus();
        }, 300);
    }
    else {
        searchHeader.classList.remove("open-search");
        overlay.style.display = "none";
        searchInput.value = "";
        searchInput.blur();
        setTimeout(() => {
            searchHeader.style.display = "none";
            searchIcon.classList.remove("open-search");
        }, 300);
    }
});

iconClose.addEventListener("click", function(){
    if(searchHeader.classList.contains("open-search")){
        searchHeader.classList.remove("open-search");
        overlay.style.display = "none";
        searchInput.value = "";
        searchInput.blur();
        setTimeout(() => {
            searchHeader.style.display = "none";
            searchIcon.classList.remove("open-search");
        }, 300);
    }
})

overlay.addEventListener("click", function(){
    if(searchHeader.classList.contains("open-search")){
        searchHeader.classList.remove("open-search");
        overlay.style.display = "none";
        searchInput.value = "";
        setTimeout(() => {
            searchHeader.style.display = "none";
            searchIcon.classList.remove("open-search");
        }, 300);
    }
});

searchInput.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        searchHeader.style.display = "none";
        searchIcon.classList.remove("open-search");
        searchHeader.classList.remove("open-search");
        overlay.style.display = "none";
        event.preventDefault();
        performSearch();
    }
});

function performSearch() {
    saveQuery()
    window.location.href = "/Anúncios/Code/Anuncios.html"
}