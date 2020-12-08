<?php
require_once "_varios.php";

if(isset($_REQUEST["identificador"])){
    $identificador=$_REQUEST["identificador"];
    $resultados=obtenerUsuario($identificador);


}else{
    $resultados="";
    redireccionar("SessionInicioFormulario.php");
}

?>
<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Perfil de <?=$resultados[0]["identificador"]?></h1>
<?php if(isset($_SESSION["msg"])){?>
    <p><?=$_SESSION["msg"]?></p>
<?php }?>
<?php if(isset($_SESSION["notif"])){?>
    <p><?=$_SESSION["notif"]?></p>
<?php }?>

<div class="formulario">
    <form method="post" action="UsuarioPerfilGuardar.php">
        <input type="hidden" name="id" value="<?=$resultados[0]["id"]?>"><br><br>
        <?php if($resultados[0]["fotoDePerfil"]==NULL){?>
        <img src="FotosDePerfil/Unknown-person.gif" width="280" height="280";><br><br>
        <? }else{?>
        <img src="FotosDePerfil/<?=$resultados[0]["fotoDePerfil"]?>" width="280" height="280";><br><br>
        <?};?>
        <label>Identificador: </label><input type="text" name="identificador" value="<?=$resultados[0]["identificador"]?>"><br><br>
        <label>Nombre: </label><input type="text" name="nombre" value="<?=$resultados[0]["nombre"]?>"><br><br>
        <label>Apellidos: </label><input type="text" name="apellidos" value="<?=$resultados[0]["apellidos"]?>"><br><br>
        <input type="submit" name="guardar" value="Guardar Cambios">
    </form>
</div>

</body>

</html>


