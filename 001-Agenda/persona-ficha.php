<?php
session_start();

require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

// Se recoge el parámetro "id" de la request.
$idPersona = (int)$_REQUEST["id"];
$estrella = (int)$_REQUEST["estrella"];

//$persona_nombre=$_REQUEST["nombre"];
//$persona_tele=$_REQUEST["telefono"];
//$idCategoriaSelected=$_REQUEST["categoria_id"];
// Si id es -1 quieren CREAR una nueva categoria (nueva categoria toamara valor true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (nueva categoria tomara el valor de FALSE ).
$nueva_persona = ($idPersona == -1);

if ($nueva_persona) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $estrella="";
    $persona_nombre = "<introduzca nombre>";// Crear una nueva PERSONA
    $persona_apellidos= "<Introduzca apellidos>";
    $persona_tele = "<intrduzca telefon>";// Telefono de la persona
    $idCategoriaSelected = "<id de categoria>";// Categoria a la que pertence

} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
    $sql = " SELECT * FROM persona WHERE id=? ";/* Consultar los datos de una categoria */

    $select = $pdo->prepare($sql);/*Preparar la consulta con el string SQL anterior*/
    $select->execute([$idPersona]); // Se añade el parámetro recogido de la REQUEST a la consulta preparada.
    $rs_persona = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $estrella= $rs_persona[0]["estrella"];
    $persona_apellidos= $rs_persona[0]["apellidos"];
    $persona_nombre = $rs_persona[0]["nombre"];
    $persona_tele = $rs_persona[0]["telefono"];
    $idCategoriaSelected = $rs_persona[0]["categoria_id"];

}
$sqlCategoria= "SELECT id,nombre FROM categoria";
$selectCategoria = $pdo->prepare($sqlCategoria);/*Preparar la consulta con el string SQL anterior*/
$selectCategoria->execute([]); // Se añade el parámetro recogido de la REQUEST a la consulta preparada.
$rsCategoria = $selectCategoria->fetchAll();

?>



<html>

<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
=======
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">

>>>>>>> main
</head>



<body class="<?=$_SESSION['tema']?>">

<?php if ($nueva_persona) { ?>
    <h1>Nueva ficha de personas</h1>
<?php } else { ?>
    <h1>Ficha de personas</h1>
<?php } ?>

<form method="post" action="persona-guardar.php">

    <input type="hidden" name="id" value="<?=$idPersona?>" />
    <ul>
        <li>
            <strong>Estrella: </strong>
            <?php if($estrella==1){
                $chekreado="checked";
            }else{
                $chekreado="";
            }
            ?>
            Marca si tiene estrella    <input type="checkbox" name="estrella" value="1" <?=$chekreado?>>

        </li>
    </ul>
    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type="text" name="nombre" value="<?=$persona_nombre?>" />
        </li>
    </ul>
    <ul>
        <li>
            <strong>Apellidos: </strong>
            <input type="text" name="apellido" value="<?=$persona_apellidos?>" />
        </li>
    </ul>
    <ul>
        <li>
            <strong>Telefono: </strong>
            <input type="text" name="telefono" value="<?=$persona_tele?>" />
        </li>
    </ul>
    <ul>
        <li>
            <strong>Categoria: </strong>
            <select name="rsCategoria">
                <?php
                foreach ($rsCategoria as $filaCategoria){
                    $idCategoria= $filaCategoria["id"];
                    $nombreCategoria= $filaCategoria["nombre"];
                        if($idCategoria == $idCategoriaSelected){
                            $seleccoinado="selected='true'";
                        }else{
                            $seleccoinado="";
                        }
                        echo "<option value='$idCategoria' $seleccoinado>$nombreCategoria</option>";

                }
                ?>
            </select>
        </li>
    </ul>

    <?php if ($nueva_persona) { ?>
        <input type="submit" name="crear" value="Añadir persona" />
    <?php } else { ?>
        <input type="submit" name="guardar" value="Guardar cambios" />
    <?php } ?>

</form>

<br />

<a href="persona-eliminar.php?id=<?=$idPersona ?>">Eliminar persona</a>

<br />
<br />

<a href="persona-listado.php" >Volver al listado de personas.</a>

</body>

</html>