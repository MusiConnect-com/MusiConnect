const searchIcon = document.getElementById("search-icon");
const iconClose = document.getElementById("icon-close");
const searchHeader = document.querySelector(".search-header");
const searchInput = document.querySelector(".search-header input");
const adsSearch = document.getElementById("ads-search");
const overlay1 = document.getElementById("overlay1");

function saveQuery() {
    const query = searchInput.value;
    localStorage.setItem("searchQuery", query);
}

function closeSearch() {
    if(searchHeader.classList.contains("open-search")){
        searchHeader.classList.remove("open-search");
        overlay1.style.display = "none";
        searchInput.value = "";
        searchInput.blur();
        setTimeout(() => {
            searchHeader.style.display = "none";
            searchIcon.classList.remove("open-search");
        }, 300);
    }
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
            overlay1.style.display = "block";
            document.body.classList.add("no-scroll")
            searchInput.focus();
        }, 10);
    }
    else {
        closeSearch();
    }
});

iconClose.addEventListener("click", closeSearch);
overlay1.addEventListener("click", closeSearch);

searchInput.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        searchHeader.style.display = "none";
        searchIcon.classList.remove("open-search");
        searchHeader.classList.remove("open-search");
        overlay1.style.display = "none";
        event.preventDefault();
        performSearch();
    }
});

function performSearch() {
    saveQuery()
    window.location.href = "/html/anuncios-musico.html"
}