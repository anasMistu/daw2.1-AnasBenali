<?php
$record= array();
$intentosLimite=10;
$min=1;
$max=1000;
if(isset($_POST['numero'])) {

    $number = $_POST['numero'];
    $intentos = $_POST['intentos'] + 1;
} else {
    $number = rand($min,$max);
    $intentos =1;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Adivina el numero secreto</title>
</head>


<body>
<p>El juego genera de manera automateca un número entre <?= $min?> y <?= $max?>.</p>
<p>Prueba tu suerte desafiando el juego.</p>
<p>Recuerda que solo tienes <?=$intentosLimite?> intentos</p>

<?php
        //Si supera el limite de intentos permitidos
    if($intentos>$intentosLimite){
?>
    <h1>Has superado el limite de intentos permitidos</h1>

        <?php
        /* Sistema de Podio pendiene(ERROR El array llega vacio!!!!!)
            $record.sort();
            for ($i=0;$i=2;$i++){
                echo "<p>Top($i+1): $record[i]</br></p>";
            }
        */
        ?>
        <form action="" method="post" name="numeroNuevo">
            <input name="restart" type="submit" value="Nueva Partida" />
            <input name="intentos" type="hidden" value="<?= $intentos ?>" />

        </form>
<?php
    }else{ //Si no supera los intentos
?>
<form action="" method="post" name="adivinaUnNumero">
    <label>Ingresa un número:</label><br/ >
    <input type="text" id="adivinar" name="adivinar"/>
    <input name="numero" type="hidden" value="<?= $number ?>" />
    <input name="intentos" type="hidden" value="<?= $intentos ?>" />
    <input name="submit" type="submit" value="¡Prueba suerte!" />
</form>

<form action="" method="post" name="numeroNuevo">
    <input name="restart" type="submit" value="Nueva Partida" />
    <input name="intentos" type="hidden" value="<?= $intentos ?>" />

</form>

<?php
if($_POST["adivinar"]){

    // Get los datos introducidos
    $adivinar  = $_POST['adivinar'];
    $number  = $_POST['numero'];
    $intentos = $_POST['intentos'];

    if ($adivinar < $number){ //Si se ha introducido numero menor
        echo "</br>Llevas $intentos intentos de $intentosLimite permitodos </br>";
        echo "</br>Has introducido $adivinar </br>";
        echo "Intenta con un número más alto.";
    }elseif($adivinar > $number){ //Si se ha introducido numero mayor
        echo "</br>Llevas $intentos intentos de $intentosLimite permitodos </br>";
        echo "</br>Has introducido $adivinar </br>";
        echo "Intenta con un número más bajo.";
    }elseif($adivinar == $number){ //Si se ha introducido numero igual
       // array_push($record,$intentos); Registrar los intentos
        echo "<p>¡Excelente! Lo adivinaste</p>";
        echo "<p> </br> Has hecho :",$intentos," intentos</p>";
        $puntuacion=round($max/$intentos);
        echo "<p>Tu puntuacion es:  ",$puntuacion, " puntos.</p>";

    }
}
?>
<?php
    }
?>
</body>
</html>