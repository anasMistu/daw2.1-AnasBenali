<?php

    if(isset($_POST["subir"])){
        $foto= $_FILES["ftoDePerfil"]["name"];
        $ruta= $_FILES["ftoDePerfil"]["tmp_name"];
        $destino= "FotosDePerfil/".$foto;
        copy($ruta, $destino);

        $extension=pathinfo($foto,PATHINFO_EXTENSION);
        $usuario="nice";
        $nombreNuevo="$usuario"."."."$extension";
        rename("FotosDePerfil/$foto","FotosDePerfil/"."$nombreNuevo");
    }else{
        print_r(getcwd());
    }

?>

<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="pruebas.php" method="post" enctype="multipart/form-data">
    <input type="file" name="ftoDePerfil" accept="image/x-png,image/gif,image/jpeg" size="1">
    <input type="submit" name="subir" value="subir">
</form>


</body>
</html>
