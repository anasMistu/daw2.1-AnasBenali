<?php
require_once "_varios.php";

$pdo = obtenerPdoConexionBD();
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
            WHERE p.estrella=1
            ORDER BY p.nombre";

$select = $pdo->prepare($sql);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rs = $select->fetchAll();
///PENDIENTE BUTTON LISTADO DE ESTRELLAS SOLO
if(isset($_REQUEST[""]));

?>

<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

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
                $estrellitaInput=" ";
            }else{
                $estrellitaInput="*";
            }
            ?>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$estrellitaInput ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_nombre"] ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_apellidos"] ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["c_id"]?>"> <?=$fila["c_nombre"] ?> </a></td>
            <td><a href="persona-eliminar.php?id=<?=$fila["p_id"]?>"> (X)                   </a></td>

        </tr>
    <?php } ?>




</table>

<br />

<a href="persona-ficha.php?id=-1">Crear entrada</a>

<br />
<br />

<a href="persona-listado.php">Ver todos</a>
<br />
<br />

</body>

</html>