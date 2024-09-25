
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
const order = document.querySelector(".order");
const select = order.querySelector(".select");
const selected = order.querySelector(".selected");
const orderList = order.querySelector(".order-list");
const options = order.querySelectorAll(".order-list li");
const overlay3 = document.getElementById("overlay3");

select.addEventListener("click", function(){
    if(orderList.classList.contains("open-order")) {
        orderList.style.display = "none";
        overlay3.style.display = "none";
        orderList.classList.remove("open-order");
        select.classList.remove("open-order");
    } else {
        orderList.style.display = "flex";
        overlay3.style.display = "block";
        orderList.classList.add("open-order");
        select.classList.add("open-order");
    }
    
});

options.forEach(option => {
    option.addEventListener("click", function(){
        selected.innerText = option.innerText;
        orderList.style.display = "none";
        overlay3.style.display = "none";
        orderList.classList.remove("open-order");
        select.classList.remove("open-order");

        options.forEach(option => {
            option.classList.remove("active");
        });

        option.classList.add("active");
    });
});

overlay3.addEventListener("click", function(){
    orderList.style.display = "none";
    overlay3.style.display = "none";
    orderList.classList.remove("open-order");
    select.classList.remove("open-order");
});