<?php
require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

// Se recogen los datos del formulario de la request.
$idPersona = (int)$_REQUEST["id"];
$nombre_persona = $_REQUEST["nombre"];
$persona_tele=$_REQUEST["telefono"];
$persona_apellido= $_REQUEST["apellido"];
$estrella=(int)$_REQUEST["estrella"];
$idCategoria=$_REQUEST["rsCategoria"];
/* Para guardarlo en la base de datos Si viene 1 (chekbox chekeado) le doy valor 1 si no esta chekeado le doy valor 0*/

if($estrella==1){
    $estrella=1;
}else{
    $estrella=0;
}

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
$nueva_entrada = ($idPersona == -1);

if ($nueva_entrada) {
    // Quieren CREAR una nueva entrada, así que es un INSERT.
    $sql = "INSERT INTO persona (nombre,apellidos,telefono,estrella,categoriaId) VALUES (?,?,?,?,?)";
    $parametros = [$nombre_persona,$persona_apellido,$persona_tele,$estrella,$idCategoria];
} else {
    // Quieren MODIFICAR una categoría existente y es un UPDATE.
    $sql = "UPDATE persona SET nombre=?,apellidos=?,telefono=?, estrella=?,categoriaId=? WHERE id=?";
    $parametros = [$nombre_persona,$persona_apellido,$persona_tele,$estrella,$idCategoria,$idPersona];
}

$sentencia = $pdo->prepare($sql);
//Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
$sql_con_exito = $sentencia->execute($parametros); // Se añaden los parámetros a la consulta preparada.

//Se consulta la cantidad de filas afectadas por la ultima sentencia sql.
$una_fila_afectada = ($sentencia->rowCount() == 1);
$ninguna_fila_afectada = ($sentencia->rowCount() == 0);

// Está todo correcto de forma normal si NO ha habido errores y se ha visto afectada UNA fila.
$correcto = ($sql_con_exito && $una_fila_afectada);

// Si los datos no se habían modificado, también está correcto.
$datos_no_modificados = ($sql_con_exito && $ninguna_fila_afectada);
?>



<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<?php
// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
if ($correcto || $datos_no_modificados) { ?>

    <?php if ($idPersona == -1) { ?>
        <h1>Inserción completada</h1>
        <p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre_persona; ?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?php echo $nombre_persona; ?>.</p>

        <?php if ($datos_no_modificados) { ?>
            <p>En realidad, no había modificado nada, pero no está de más que se haya
                asegurado pulsando el botón de guardar :)</p>
        <?php } ?>
    <?php }
    ?>

    <?php
} else {
    ?>

    <h1>Error en la modificación.</h1>
    <p>No se han podido guardar los datos de la persona.</p>

    <?php
}
?>

<a href="persona-listado.php">Volver al listado de persona .</a>

</body>

</html>