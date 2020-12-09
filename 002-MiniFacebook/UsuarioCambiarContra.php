<?php
require_once "_varios.php";

if(!isset($_REQUEST["idContrasenna"]) && !isset($_POST["Guardar"])){
    redireccionar("SessionInicioFormulario.php");
}else{
    $contrasenna=$_POST["contrasenna"];
    $contrasennaNueva=$_POST["contrasennaNueva"];
    $contrasennaConfrimar=$_POST["contrasennaConfirmar"];
}

?>


<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Modificar contraseña</h1>
<div class="formulario">
    <form method="post" action="UsuarioCambiarContra.php">
        <label>Contraseña actual: </label><input type="text" name="contrasenna"  readonly><br><br>
        <label>Contraseña nueva: </label><input type="text" name="contrasennaNueva" ><br><br>
        <label>Confirmar contraseña: </label><input type="text" name="contrasennaConfirmar" ><br><br>
        <input type="submit" name="Guardar" value="Guardar Cambios">
    </form>


</div>

</body>

</html>