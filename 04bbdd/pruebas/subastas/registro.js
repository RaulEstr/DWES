let password1 = document.getElementById("password1");
let password2 = document.getElementById("password2");
let botonSubmit = document.getElementById("botonSubmit")

password1.addEventListener("input", comprobarPass);
password2.addEventListener("input", comprobarPass);

function comprobarPass()  {
    if(password1.value == password2.value) {  
        botonSubmit.removeAttribute("disabled", "false");
    }
    else {
        botonSubmit.setAttribute("disabled", "true");
    }
}