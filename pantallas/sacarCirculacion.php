<?php  include "../consultas/circulacionConsulta.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacar de Circulacion</title>
</head>

<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div id="Anulacion">
            <label>N° de Cheque</label>
            <input type="text" name="numero_cheque" id="numero_cheque"value="<?php  echo $numero_cheque?>">
            <button type="submit" name="buscar">Buscar</button><br>

            
            <label for="fecha">Fecha</label><br>
            <input type="date" id="fechaCheque" name="fechaCheque " disabled value="<?php echo $fechaCheque ?>"><br>
            

            <label for="paguese">Páguese a la orden de:</label>
            <input type="text" id="pagueseALaOrden" name="pagueseALaOrden" disabled
                value="<?php echo $proveedorNombre ?>"><br>

            <label for="monto">Monto</label>
            <input type="text" name="monto" id="monto" disabled value="<?php echo $monto ?>"><br>

            <label for="descripcion">Descripción de Gasto</label><br>
            <textarea name="descripcion" id="descripcion" cols="30" rows="10"
                disabled><?php echo $descripcion ?></textarea> <br>

            <label for="fechaCirculacion">Fecha Circulacion: </label>
            <input type="date" id="circulacion" name="circulacion" disabled >

            <button type="submit" name= "grabar" disabled <?php echo $disabledAnular; ?>>Grabar</button>

        </div>
    </form>
</body>

</html>