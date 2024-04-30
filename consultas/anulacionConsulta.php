<?php
// Incluir archivo de conexión y consultas
include "../conexion/conciliacion.php";

// Variables para almacenar datos del cheque
$numero_cheque="";
$fechaCheque = "";
$proveedorNombre = "";
$monto="";
$descripcion="";
$fechaAnulado = "";
$detalleAnulado= "";
$disabledAnular="";
$fila="";
// Procesar formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscar"])) {


    $numero_cheque = $_POST["numero_cheque"];

    // Obtener fecha del cheque
    $queryFecha = "SELECT fecha FROM cheques WHERE numero_cheque = '$numero_cheque'";
    $resultFecha = mysqli_query($conect, $queryFecha);

    //Obtener el nombre del proveedor 
    $queryProveedor = "SELECT nombre FROM proveedores WHERE codigo = (SELECT beneficiario FROM cheques WHERE numero_cheque = '$numero_cheque')";
    $resultProveedor = mysqli_query($conect, $queryProveedor);

    //Obtener el monto
    $queryMonto = "SELECT monto FROM cheques WHERE cheques.numero_cheque = '$numero_cheque'";
    $resultMonto = mysqli_query($conect, $queryMonto);

    //Obtener descricpion
    $queryDescripcion =" SELECT descripcion FROM cheques WHERE cheques.numero_cheque= '$numero_cheque'"; 
    $resultDescripcion = mysqli_query($conect,$queryDescripcion);

    //RESULTADOS DE CONSULTAS
    if (!$resultFecha || !$resultProveedor || !$resultMonto || !$resultDescripcion) {
        die('Error al ejecutar la consulta: ' .mysqli_error($conect));
    }

    //Verificar si se obtuvo el dato de fecha
    if (mysqli_num_rows($resultFecha) > 0) {
        $row = mysqli_fetch_assoc($resultFecha);
        $fechaCheque = $row['fecha'];
    } else {
        $fechaCheque = "";
    }

    //Verificar si se obtuvo el dato del nombre del proveedor 
    if(mysqli_num_rows($resultProveedor) > 0){
        $row = mysqli_fetch_assoc($resultProveedor);
        $proveedorNombre = $row ['nombre'];
    }else{
        $proveedorNombre="No hay proveedor";
    }

     //Verificar si se obtuvo el dato de monto
    if(mysqli_num_rows($resultMonto) > 0){
        $row = mysqli_fetch_assoc($resultMonto);
        $monto = $row['monto'];
    }else{
        $monto ="";
    }

    //Verificar si se obtuvo el dato de descripcion
    if(mysqli_num_rows($resultProveedor) > 0){
        $row = mysqli_fetch_assoc($resultDescripcion);
        $descripcion= $row['descripcion'];

    }else {
        $descripcion="No hay descripcion";
    }

    // Consulta para buscar el cheque
    $sql = "SELECT * FROM cheques WHERE numero_cheque = '$numero_cheque'";
    $resultado = $conect->query($sql);

    

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        
    if ($fila["fecha_circulacion"] == "0000-00-00") {
            echo '<script>alert("El cheque está anulado.")</script>';
            $fechaCheque="";
            $proveedorNombre= "";
            $monto ="";
            $descripcion = "";

            // Traer la fecha de anulación y el detalle de anulación si el cheque está anulado
            $fechaAnulado = $fila["fecha_anulado"];
            $detalleAnulado = $fila["detalle_anulado"];

           // Deshabilitar el botón de anular si el cheque ya está anulado
            $disabledAnular = 'disabled';

        } elseif ($fila["fecha_circulacion"] !== NULL) {
            echo '<script>alert("Ya esta fuera de circulacion")</script>';
            $disabledAnular = 'disabled';
        }
    } else {
        echo '<script>alert("El cheque no existe")</script>';
            $fechaCheque="";
            $proveedorNombre= "";
            $monto ="";
            $descripcion = "";

            $disabledAnular = 'disabled';

    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["anular"])) {
    // Obtener los datos del formulario
    $numero_cheque = $_POST["numero_cheque"];
    $fechaAnulado = $_POST["fechaAnulado"];
    $detalleAnulado = $_POST["detalleAnulado"];

    // Consulta para anular el cheque
    $sqlAnularCheque = "UPDATE cheques 
                        SET fecha_anulado = '$fechaAnulado', detalle_anulado = '$detalleAnulado' 
                        WHERE numero_cheque = '$numero_cheque'";
if ($conect->query($sqlAnularCheque) === TRUE) {
        echo '<script>alert("El cheque ha sido anulado correctamente.")</script>';
        
        $numero_cheque = "";
        $fechaAnulado = "";
        $detalleAnulado = "";

    } else {
        echo "Error al anular el cheque: " . $conect->error;
    }

}
$conect->close(); // Cierra la conexión correctamente
?>