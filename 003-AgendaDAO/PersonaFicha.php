<?php

require_once "_com/Varios.php";
require_once "_com/dao.php";

$id = (int)$_REQUEST["id"];
$datos= DAO::personaFicha($id);

?>




<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($datos[0] == true) { ?>
    <h1>Nueva ficha de persona</h1>
<?php } else { ?>
    <h1>Ficha de persona</h1>
<?php } ?>

<form method='post' action='PersonaGuardar.php'>

    <input type='hidden' name='id' value='<?= $id ?>' />

    <label for='nombre'>Nombre</label>
    <input type='text' name='nombre' value='<?=$datos[1]?>' />
    <br/>

    <label for='apellidos'> Apellidos</label>
    <input type='text' name='apellidos' value='<?=$datos[2]?>' />
    <br/>

    <label for='telefono'> Teléfono</label>
    <input type='text' name='telefono' value='<?=$datos[3]?>' />
    <br/>

    <label for='categoriaId'>Categoría</label>
    <select name='categoriaId'>
        <?php
        foreach ($datos[6] as $categoria) {
            $categoriaId = $categoria->getId();
            $categoriaNombre = $categoria->getNombre();
            if($categoriaId == $datos[4]) $seleccion = "selected='true'";
            else $seleccion = "";
            echo "<option value='$categoriaId' $seleccion>$categoriaNombre</option>";
        }
        ?>
    </select>
    <br/>

    <label for='estrella'>Estrellado</label>
    <input type='checkbox' name='estrella' <?= $datos[5] ? "checked" : "" ?> />
    <br/>

    <br/>

    <?php if ($datos[0]) { ?>
        <input type='submit' name='crear' value='Crear persona' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<?php if (!$datos[0]) { ?>
    <br />
    <a href='PersonaEliminar.php?id=<?=$id ?>'>Eliminar persona</a>
<?php } ?>

<br />
<br />

<a href='PersonaListado.php'>Volver al listado de personas.</a>

</body>

</html>