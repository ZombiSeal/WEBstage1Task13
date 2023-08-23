let form = document.getElementById("filter");
let productRows = document.querySelectorAll(".row");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    let formData = new FormData(form);

    fetch("/ajax.php", {
        method: "post",
        body: formData
    }).then(res => {
        return res.json();
    }).then(data => {
        let errors = document.querySelectorAll(".error");
        errors.forEach(err => {
            err.innerHTML = "";
        })

       if(data["emptyErrors"]) alert("Заполните все поля");
       if(data["validErrors"]) {
           data["validErrors"].forEach(el => {
               document.querySelector(  "." + el + "_err").innerHTML = "Введите положительное число";
           })
       }
       if (data["template"]) document.querySelector("tbody").innerHTML = data["template"];
    }).catch((error) => console.log(error));

})