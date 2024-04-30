function verificarCheque(numCheque) {
    console.log(numCheque);
    // Verificar si el número de cheque tiene al menos 3 dígitos
    if (numCheque.length < 3) {
        return; // No se realiza la verificación
    }

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
    xhttp.open("POST", "../conexionPhp/consultaCK.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("numCheque=" + numCheque);
}

// Función para restablecer los campos del formulario
function resetearCampos() {
    document.getElementById("chequeForm").reset();
    document.getElementById("mensajeCheque").innerText = ""; // Restablecer el mensaje de cheque
    document.getElementById("fecha").disabled = false; 
    document.getElementById("grabarCheque").disabled= false;// Habilitar el campo de fecha
}