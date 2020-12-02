<?php
session_start();
require_once "00_varios.php";
/*Si no hay session iniciada redirigimos a la pagina de CONTENIDO PRIADO 1*/
if (haySesionIniciada()) {
    redireccionar("02ContenidoPrivado1.php");
}
?>




<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>
<?php
if(isset($_SESSION["txt"])){
?>
<p><?= $_SESSION["txt"]?></p>
<?php
}
?>
<div class="formulario">
    <form method="post" action="01SesionInicioComprobar.php">
        <input type="text" name="identificador" placeholder="Introduce tu usuario"><br><br>
        <input type="password" name="contrasenna" placeholder="Introduce tu contraseña" ><br><br>
        <input type="submit" name="Iniciar Session" value="Iniciar Session">
    </form>
</div>

</body>

</html>
