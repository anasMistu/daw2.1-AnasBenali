<?php
$numero = (int) $_REQUEST["numero"];
if (isset($_REQUEST["intento"])){
    $intento = (int) $_REQUEST["intento"];
    $contador = (int) $_REQUEST["contador"] + 1;

} else{
    $intento = null; //Primera vez que se inicia
    $contador = 0;
}

?>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
</head>
<body>
<?php
if($intento == null){
} elseif ($intento > $numero){
    echo"<p>El número que buscas es <b>menor</b> al introducido.</p>";
} elseif ($intento < $numero){
    echo"<p>El número que buscas es <b>mayor</b> al introducido.</p>";
} else{
    ?>
    <h1>¡Acertaste!</h1>
    <p>Número de intentos: <?=$contador?></p>
    <?php
}

?>
<?php
if($intento != $numero){
    ?>
    <p>Llevas <?=$contador?> intentos.</p>
    <form>
        <input type="hidden" name="numero" value="<?=$numero?>" />
        <input type="hidden" name="contador" value="<?=$contador?>" />

        <input type="number" name="intento" />
        <input type="submit" name="intentar" value="Intentar" />
    </form>
    <?php
}
?>

</body>
</html>