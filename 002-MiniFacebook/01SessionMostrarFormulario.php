<?php
session_start();

if(isset($_SESSION["Iniciar Session"]) && isset($_SESSION["identificador"])){
    redireccionar("02Contenido");
}




?>




<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>
<div class="formulario">
    <form method="post" action="01SessionComprobar.php">
        <input type="text" name="identificador" placeholder="Introduce tu usuario"><br><br>
        <input type="password" name="contrasenna" placeholder="Introduce tu contraseña" ><br><br>
        <input type="submit" name="Iniciar Session">
    </form>
</div>

</body>

</html>
