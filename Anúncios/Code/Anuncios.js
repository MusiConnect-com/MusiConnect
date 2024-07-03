
//mask input

$('#minimum-value').mask("#.##0,00", {reverse: true});
$('#maximum-value').mask("#.##0,00", {reverse: true});

//Sair da conta

const leave = document.getElementById("leave")

leave.addEventListener("click", function() {
    window.location.href = "/Login/Code/Login.html"
})

//Menu perfil

const profileButton = document.querySelector(".profile-button");
const profileList = document.querySelector(".profile-list");

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

//Filtros de busca

const buttonFilters = document.querySelector(".button-filters");
const filtersList = document.querySelector(".filters-list");
const buttonFilter = document.querySelector(".button-filter");

function openFiltersList() {
    if (filtersList.classList.contains("open-filters")){
        filtersList.style.display = "none";
        filtersList.classList.remove("open-filters")
        buttonFilters.classList.remove("open-filters")
    } else {
        filtersList.style.display = "flex";
        filtersList.classList.add("open-filters")
        buttonFilters.classList.add("open-filters")
    }
};

buttonFilters.addEventListener("click", openFiltersList)
buttonFilter.addEventListener("click", function() {
    filtersList.style.display = "none";
    filtersList.classList.remove("open-filters")
    buttonFilters.classList.remove("open-filters")
});

//limpar filtros de busca

const filterBox = document.querySelectorAll(".filter-box")
const buttonClean = document.querySelector(".button-clean")


function cleanBox(){
    filterBox.forEach(filterBox => {
        if (filterBox.checked) {
            filterBox.checked = false;
        }
    })
}

function cleanValue(){
    const minValue = document.getElementById("minimum-value")
    const maxValue = document.getElementById("maximum-value")

    if (minValue.value !== "" || maxValue.value !== "") {
        minValue.value = "";
        maxValue.value = "";
    }
}

buttonClean.addEventListener("click", function(){
    cleanBox();
    cleanValue();
});

//Ordem de busca

const order = document.querySelectorAll(".order");

order.forEach(order => {
    const select = order.querySelector(".select");
    const selected = order.querySelector(".selected");
    const orderList = order.querySelector(".order-list");
    const options = order.querySelectorAll(".order-list li");

    select.addEventListener("click", function(){
        if(orderList.classList.contains("open-order")) {
            orderList.style.display = "none"
            orderList.classList.remove("open-order")
            select.classList.remove("open-order")
        } else {
            orderList.style.display = "block"
            orderList.classList.add("open-order")
            select.classList.add("open-order")
        }
        
    });

    options.forEach(option => {
        option.addEventListener("click", function(){
            selected.innerText = option.innerText;
            orderList.style.display = "none"
            orderList.classList.remove("open-order")
            select.classList.remove("open-order")

            options.forEach(option => {
                option.classList.remove("active")
            });

            option.classList.add("active")
        });
    });
});