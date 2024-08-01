// Responder avaliação
const btnAnswer = document.querySelectorAll(".btn-answer");
const btnSubmit = document.querySelectorAll(".btn-submit-answer");
const submitAnswer = document.querySelectorAll(".submit-answer");
const textAnswer = document.querySelectorAll(".submit-answer textarea");
const answered = document.querySelectorAll(".answered");
const response = document.querySelectorAll(".answered p");
let indexReview = 0;

function answerReview(){
    let i = indexReview;

    if (textAnswer[i].value != ""){
        submitAnswer[i].style.display = "none";
        response[i].innerText = textAnswer[i].value;
        answered[i].style.display = "inline-block"
    }
}

function closeBtnAnswer(){
    submitAnswer.forEach(submit =>{
        if (submit.style.display == "flex"){
            submit.style.display = "none";
            btnAnswer.forEach(btn =>{
                if (btn.classList.contains("answered")){
                    btn.classList.remove("answered");
                }
            });
        }
    });
}

btnAnswer.forEach((btn, i) =>{
    btn.addEventListener("click", function(){
        closeBtnAnswer();
        textAnswer.forEach(text => {
            text.value = "";
        });
        submitAnswer[i].style.display = "flex";
        btn.classList.add("answered");
        indexReview = i;
    });
});


