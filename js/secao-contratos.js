const orders = document.querySelectorAll(".order");
const overlay3 = document.getElementById("overlay3");

orders.forEach(order =>{
    const select = order.querySelector(".select");
    const orderList = order.querySelector(".order-list");
    const options = order.querySelectorAll(".order-list li");

    select.addEventListener("click", function(){
        if(!orderList.classList.contains("open-order")) {
            select.classList.add("open-order");
            orderList.classList.add("open-order");
            overlay3.style.display = "block"
        } else {
            select.classList.remove("open-order");
            orderList.classList.remove("open-order");
            overlay3.style.display = "none"
        }
        
    });

    options.forEach(option => {
        option.addEventListener("click", function(){
            const selected = option.textContent;

            if(selected == "Todos"){
                orderList.classList.remove("open-order");
                select.classList.remove("open-order");
                select.classList.remove("selected");
                overlay3.style.display = "none"
            }else {
                orderList.classList.remove("open-order");
                select.classList.remove("open-order");
                select.classList.add("selected");
                overlay3.style.display = "none"
            }

            options.forEach(option => {
                option.classList.remove("active");
            });
    
            option.classList.add("active");
        });
    });

    overlay3.addEventListener("click", function(){
        select.classList.remove("open-order");
        orderList.classList.remove("open-order");
        overlay3.style.display = "none"
    });

});