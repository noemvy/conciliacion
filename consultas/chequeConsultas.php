<?php
// Conexión a la base de datos
include('../conexion/conciliacion.php');

$tablaProveedores = mysqli_query($conect,"SELECT*FROM proveedores");
$objetoGasto = mysqli_query($conect, "SELECT*FROM objeto_gasto");

$numCheque = "";
$fecha = "";
$proveedores ="";
$montoPagar="";
$descripcion= "";
$objeto = "";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numCheque"], $_POST["fecha"], $_POST["proveedores"] ,$_POST["montoPagar"],$_POST["descripcion"],$_POST["objeto"])) {
    $numCheque = $_POST['numCheque'];
    $fecha = $_POST['fecha'];
    $proveedores = $_POST['proveedores'];
    $montoPagar = $_POST['montoPagar'];
    $descripcion = $_POST['descripcion'];
    $objeto = $_POST['objeto'];

    // Preparar la consulta SQL para verificar si el cheque ya existe
    $chequeVerificar = "SELECT * FROM cheques WHERE numero_cheque = ?";
    $stmt = $conect->prepare($chequeVerificar);
    if ($stmt) {
        $stmt->bind_param("s", $numCheque);
        $stmt->execute();
        $resultadoCheque = $stmt->get_result();

        // Verificar si el cheque ya existe
        if ($resultadoCheque->num_rows > 0) {
            echo '<script>alert("Este cheque ya existe, ingrese uno válido")</script>'; // Envía "existe" como respuesta si el cheque ya existe // Salir del script PHP después de enviar la respuesta
        } else {
            // Preparar la consulta SQL con consultas preparadas
            $sql = "INSERT INTO cheques (numero_cheque, fecha, beneficiario, monto, descripcion, codigo_objeto1,monto_objeto1) VALUES (?, ?, ?,?,?,?,?)";
            $stmt = $conect->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssssss", $numCheque, $fecha, $proveedores,$montoPagar,$descripcion,$objeto,$montoPagar);
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    echo '<script>alert("Cheque guardado existosamente")</script>';
                    $numCheque="";
                    $fecha="";
                    $proveedores="";
                    $montoPagar="";
                    $descripcion="";
                    $objeto="";
                    $montoPagar="";
                } else {
                    echo '<script>alert("Error al guardar el cheque")</script>';
                }
            } else {
                echo '<script>alert("Error al preparar la consulta SQL.")</script>';
            }
        }
    } else {
        echo '<script>alert("Error al preparar la consulta SQL para verificar el cheque.")</script>';
    }
} else {
    echo '<script>alert("Por favor, complete todos los campos del formulario.")</script>';
}

// Cerrar la conexión
$conect->close();
?>
