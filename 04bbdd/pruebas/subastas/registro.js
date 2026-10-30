let boton = document.getElementById("botonSubmit");
let formu = document.getElementById("formu");
let tabla = document.getElementById("tabla");
boton.addEventListener("click", passwordCorrecta);

let tr = document.createElement("tr");
let td = document.createElement("td");
tr.appendChild(td);
td.setAttribute("colspan", "2");

function passwordCorrecta(event) {
    event.preventDefault();
    tabla.appendChild(tr);

    let password1 = document.getElementById("password1").value;
    let password2 = document.getElementById("password2").value;

    if(password1.trim() == "" || password2.trim() == "") {
        td.textContent = "Las contraseñas no pueden estar vacias";
    }
    else if(password1 != password2) {
        td.textContent = "Las contraseñas tienen que coincidir"
    }
    else {
        formu.submit();
    }
}