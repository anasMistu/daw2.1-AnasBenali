<?php
    $operaciones=array("sum","res","mul","div");
    $signos=array("+","-","*","/");
    $limite=count($operaciones);
if (isset($_REQUEST["operacion"])){
    $operacin= $_REQUEST["signo"];
    $operando1= (int)$_REQUEST["operando1"];
    $operando2= (int)$_REQUEST["operando2"];

}else{
    $operacin="";
    $operando1=0;
    $operando2=0;
    $result=0;
}
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<form action='' method='get'>
    <input type="number" name="operando1" value="">
    <select name="signo">
        <option value="-1">Operacion</option>
        <?php
        for($i=0;$i<$limite;$i++){?>
            <option value="<?=$signos[$i];?>"><?=$operaciones[$i];?></option>
            <?php
        }
        ?>
    </select>

    <input type="number" name="operando2" value="">
    <input type='submit' name='operacion' value="Calcular"/>
</form>

</select>
<?php
switch ($operacin) {
    case "-1":
        echo "No se ha elegido ninguna operacion";
        break;
    case "+":
        $result=$operando1+$operando2;
        echo "<h1>El resultado de $operando1 suma $operando2 es igual a $result</h1>";
        break;
    case "-":
        $result=$operando1-$operando2;
        echo "<h1>El resultado de $operando1 resta $operando2 es igual a $result</h1>";
        break;
    case "*":
        $result=$operando1*$operando2;
        echo "<h1>El resultado de $operando1 multiplicado por $operando2 es igual a $result</h1>";
        break;
    case "/":
        if($operando2==0){
            echo "<h1>No se puede dividir por cero</h1>";
            break;
        }
        $result=$operando1/$operando2;
        echo "<h1>El resultado de $operando1 dividido $operando2 es igual a $result</h1>";
        break;
}
?>

</body>
