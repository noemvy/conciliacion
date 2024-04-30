<?php include "../consultas/chequeConsultas.php" ?>

<!DOCTYPE html>
<html>
<head>
    <title>PRUEBA CHEQUE</title>
    <script src="../funciones/chequeFunciones.js" ></script>
</head>
<body  onload="pasarMonto()">
    <h1>CHEQUE PRUEBA </h1>
    <form method="post" id="chequeForm">
        <label for="numCheque">Número de Cheque:</label>
        <input type="text" id="numCheque" name="numCheque" required onblur="verificarCheque(this.value)" value="<?php echo $numCheque ?>"> <br>
        
        <!-- Mostrar mensaje de cheque existente o no existente -->
        <span id="mensajeCheque"></span> <br>

        <label for="fechaCheque">Fecha:</label> <br>
        <input type="date" id="fecha" name="fecha" required> <br>

        <label for="proveedores">Paguese a la Orden: </label>
        <select name="proveedores" id="proveedores" >
            <?php 
    while($proveedores = mysqli_fetch_assoc($tablaProveedores)) {
    ?>
            <option value="<?php echo $proveedores['codigo'] ?>"><?php echo $proveedores ['nombre']?></option>
            <?php
    }
    ?>
        </select><br>

        <label for="montoPagar">La suma de:</label><br>
        <input type="text" id="montoPagar" name ="montoPagar">


        <label for="descripcion">Detalle: </label>
        <input type="text" id="descripcion" name ="descripcion"><br>

        <label for="objeto">Objeto: </label>
        <select name="objeto" id="objeto">
            <?php 
    while($objeto = mysqli_fetch_assoc($objetoGasto)) {
    ?>
            <option value="<?php echo $objeto['codigo'] ?>"><?php echo $objeto ['detalle']?></option>
            <?php
    }
    ?>
        </select><br>

        <label for="montoObjeto">Monto Objeto:</label><br>
        <input type="text" id="montoObjeto" name ="montoObjeto" disabled>

        <button type="submit" id="grabarCheque" name="grabarCheque" >Grabar</button>
        <!-- Botón para restablecer los campos -->
        <button type="button" onclick="resetearCampos()">Restablecer</button>
    </form>

    
</body>
</html>