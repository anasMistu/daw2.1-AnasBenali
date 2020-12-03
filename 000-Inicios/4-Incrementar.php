<?php
$valor = 0;

if(isset($_POST['incremento'])){
    $valor = $_POST['valor'] + 1;
}

if(isset($_POST['reinicio'])){
    $_POST['valor'] = 0;

}

?>
<html>
<head>
    <title>Ejercicio Incremento</title>
    <meta charset='UTF-8'>
</head>
<body>
<p><?=$valor?></p>
<form method="POST">
    <input type="number" name="valor" value="<?=$valor?>"/>
    <input type="submit" name="incremento" value="Incrementar" />
    <input type="submit" name="reinicio" value="Reiniciar" />
</form>

</body>
</html>