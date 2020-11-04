<?php
$colores = array("Verde", "Amarillo", "Rojo", "Azul");
$codigos= array("green","yellow","red","blue");
$limite= count($colores);

    $colorEligido="";
    if(isset($_REQUEST["seleccionado"])){
        $colorEligido= $_REQUEST["colores"];
    }else{
        $colorEligido="no se ha seleccionado";
    }
?>
<!DOCTYPE html>
<html>
<style>
    p{
        color: <?=$colorEligido?>;
    }
</style>
<body>
<label for="Colores">Elige un color:</label>
<form method="get">
<select name="colores">
    <option value='-1'>Colores</option>;
    <?php
    for($i=0;$i<$limite;$i++){?>
        <option value="<?=$codigos[$i];?>"><?=$colores[$i];?></option>
        <?php
    }
    ?>
</select>
    <input type="submit" name="seleccionado" value="Enviar" >
</form>
    <h1>color es <?=  $colorEligido?></h1>
    <p>Fragmento de un escrito con unidad temática, que queda diferenciado del resto de fragmentos por un punto y aparte y generalmente también por llevar letra mayúscula inicial y un espacio en blanco en el margen izquierdo de alineación del texto principal de la primera línea.
        Fragmento de un escrito con unidad temática, que queda diferenciado del resto de fragmentos por un punto y aparte y generalmente también por llevar letra mayúscula inicial y un espacio en blanco en el margen izquierdo de alineación del texto principal de la primera línea.Fragmento de un escrito con unidad temática, que queda diferenciado del resto de fragmentos por un punto y aparte y generalmente también por llevar letra mayúscula inicial y un espacio en blanco en el margen izquierdo de alineación del texto principal de la primera línea.
        Fragmento de un escrito con unidad temática, que queda diferenciado del resto de fragmentos por un punto y aparte y generalmente también por llevar letra mayúscula inicial y un espacio en blanco en el margen izquierdo de alineación del texto principal de la primera línea.
    </p>
</body>
</html>