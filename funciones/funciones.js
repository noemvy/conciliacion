function limpiar() {
    document.getElementById("numCheque").value = "";
    document.getElementById("fecha").value = "";
}


function pasarMonto (){
    var montoPagar = document.getElementById("montoPagar");
    var montoObjeto = document.getElementById("montoObjeto");

    montoPagar.addEventListener("input",function(){
        montoObjeto.value = montoPagar.value;
    });

}
