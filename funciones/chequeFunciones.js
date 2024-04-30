

//Funcion para validar si el cheque existe o no en tiempo real con AJAX
function verificarCheque(numCheque) {
    console.log(numCheque);
    
    //Se realiza la validacion solo si el numero de cheque ingresado es de longitud de 3
    if (numCheque.length < 3) {
        return; // No se realiza la verificación
    }
    //Validar con AJAX la existencia del cheque
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.includes("no")) {
                document.getElementById("fecha").disabled = false;
                document.getElementById("proveedores").disabled = false;
                document.getElementById("montoPagar").disabled = false;
                document.getElementById("descripcion").disabled = false;
                document.getElementById("objeto").disabled = false;
                document.getElementById("grabarCheque").disabled = false;
                document.getElementById("mensajeCheque").innerText = "No existe";
                
            } else {
                document.getElementById("fecha").disabled = true;
                document.getElementById("proveedores").disabled = true;
                document.getElementById("montoPagar").disabled = true;
                document.getElementById("descripcion").disabled = true;
                document.getElementById("objeto").disabled = true;
                document.getElementById("grabarCheque").disabled = true;

                document.getElementById("mensajeCheque").innerText = "¡Este cheque ya existe!";
            }
        }
    };
    xhttp.open("POST", "../consultas/chequeConsultas.php", true);    //Archivo de consultas de cheque
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("numCheque=" + numCheque);
}

// Función para restablecer los campos del formulario
function resetearCampos() {
    document.getElementById("chequeForm").reset();
    document.getElementById("mensajeCheque").innerText = "";
    document.getElementById("fecha").disabled = false; 
    document.getElementById("proveedores").disabled = false;
    document.getElementById("montoPagar").disabled = false;
    document.getElementById("descripcion").disabled = false;
    document.getElementById("objeto").disabled = false;
    document.getElementById("grabarCheque").disabled = false;
}


//Funcion para pasar el monto a montoObjeto
function pasarMonto (){
    var montoPagar = document.getElementById("montoPagar");
    var montoObjeto = document.getElementById("montoObjeto");

    montoPagar.addEventListener("input",function(){
        montoObjeto.value = montoPagar.value;
    });

}