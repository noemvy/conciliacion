
<?php
include("../conexion/conciliacion.php");

$tablaProveedores = mysqli_query($conect, "SELECT * FROM proveedores");
$objetoGasto = mysqli_query($conect, "SELECT*FROM objeto_gasto");

$numCheque = "";
$fecha = "";
$proveedores = "";
$montoPagar = "";
$descripcion= "";
$objeto = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numCheque"])) {
    // Obtener el número de cheque enviado por AJAX
    $numCheque = $_POST['numCheque'];

    // Verificar si el número de cheque ya existe en la base de datos
    $sql_check = "SELECT * FROM cheques WHERE numero_cheque = ?";
    $stmt = $conect->prepare($sql_check);
    $stmt->bind_param("s", $numCheque);
    $stmt->execute();
    $result_check = $stmt->get_result();

    if ($result_check && $result_check->num_rows > 0) {
        echo "Si";
        exit;
    } else {
        echo "Este numero de cheque no puede ser ingresado nuevamente";

        // El número de cheque no existe, puedes realizar la inserción de datos aquí
        $fecha = $_POST['fecha'];
        $proveedores = $_POST['proveedores']; // Corregido
        $montoPagar = $_POST['montoPagar'];
        $descripcion = $_POST['descripcion']; 
        $objeto = $_POST['objeto'];
        // Corregido

        $sql_insert = "INSERT INTO cheques (numero_cheque, fecha, beneficiario, monto, descripcion, codigo_objeto1,monto_objeto1) VALUES (?, ?, ?, ?, ?,?,?)";
        $stmt_insert = $conect->prepare($sql_insert);
        if ($stmt_insert) {
            $stmt_insert->bind_param("sssssss", $numCheque, $fecha, $proveedores, $montoPagar,$descripcion,$objeto,$montoPagar); // Corregido
            $stmt_insert->execute();

            if ($stmt_insert->affected_rows > 0) {
                echo '<script>alert("Cheque guardado existosamente")</script>';
            } else {
                echo '<script>alert("Error al guardar el cheque")</script>';
            }
        } else {
            echo '<script>alert("Error al preparar la consulta SQL para verificar el cheque.")</script>';
        }
    }
}
?>
