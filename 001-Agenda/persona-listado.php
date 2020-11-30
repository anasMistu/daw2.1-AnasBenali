<?php
session_start();

    require_once "_varios.php";
    $pdo = obtenerPdoConexionBD();
    $mostrarSoloEstrellas = isset($_REQUEST["soloEstrellas"]);
    $ordenarPor="p.nombre";
    if(isset($_REQUEST["ordenSeleccionado"])){
        $ordenarPor=$_REQUEST["orden"];
    }

    $ordenarDe="ASC";
    if(isset($_REQUEST["masMenoss"])){
        $ordenarDe=$_REQUEST["masMenos"];
    }

    $posibleClausulaWhere = $mostrarSoloEstrellas ? "WHERE p.estrella=1" : "";
    $sql = "SELECT
                p.id     AS p_id,
                p.nombre AS p_nombre,
                p.apellidos AS p_apellidos,
                p.estrella AS p_estrella,
                c.id     AS c_id,
                c.nombre AS c_nombre
            FROM
               persona AS p INNER JOIN categoria AS c
               ON p.categoriaId = c.id
            $posibleClausulaWhere
            ORDER BY $ordenarPor $ordenarDe ";

    $select = $pdo->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();

?>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">

</head>



<body class="<?=$_SESSION['tema']?>">

<h1>Listado de Persona</h1>

<table border="1">

    <tr>
        <th>Estrella</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Categoria</th>
        <th>Eliminar</th>

    </tr>

    <?php
    foreach ($rs as $fila) { ?>
        <tr>
            <?php
            $estrellita=(int)$fila["p_estrella"];
            if($estrellita==0){
                $estrellitaInput='<img src="estrellaVacia.png" alt="Estrella vacia" width="25" height="25">';
            }else{
                $estrellitaInput='<img src="estrella.png" alt="Estrella rellena" width="25" height="25">';
            }
            ?>
            <td><a href="persona-alternarEstrella.php?id=<?=$fila["p_id"]?>"> <?=$estrellitaInput ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_nombre"] ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_apellidos"] ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["c_id"]?>"> <?=$fila["c_nombre"] ?> </a></td>
            <td><a href="persona-eliminar.php?id=<?=$fila["p_id"]?>"> <img src="papelera.png" alt="papelera" width="25" height="25"> </a></td>

        </tr>
    <?php } ?>




</table>

<br />
<form method="get" action="persona-listado.php">
    <label for="orden1">Ordenar Por:</label>
    <select name="orden" >
        <option value="p.apellidos" >Apellidos</option>
        <option value="p.nombre">nombre</option>
        <option value="c.nombre">categoria</option>
    </select>
    <input type="submit" name="ordenSeleccionado" value="Ordenar">
    <select name="masMenos" >
        <option value=" ASC" >Ascendente</option>
        <option value=" DESC" >Descendente</option>
    </select>
    <input type="submit" name="masMenoss" value="Ordenar">
</form>
<?php if (!$mostrarSoloEstrellas) {?>
    <a href='persona-listado.php?soloEstrellas'>Ver favoritos</a>
<?php } else { ?>
    <a href='persona-listado.php'>Mostrar todos los contactos</a>
<?php } ?>
<a href="persona-ficha.php?id=-1">Crear entrada</a>

<br />
<br />


<br />
<br />
<p >Cambiar tema : <a class="n" href='establecerTema.php?tema=negro'>Negro</a><a href='establecerTema.php?tema=rojo'>Rojo</a><a href='establecerTema.php?tema=azul'>Azul</a>

</body>

</html>

