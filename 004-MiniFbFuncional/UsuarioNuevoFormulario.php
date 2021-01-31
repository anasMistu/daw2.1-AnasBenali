<?php
require_once "_com/DAO.php";
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Crear Cuenta nueva</h1>
<?php if(isset($_SESSION["txt"])){?>
    <p><?=$_SESSION["txt"]?></p>
    <?php session_unset();}?>
<?php if(isset($_SESSION["cambiarContraseña"])){?>
    <p><?=$_SESSION["cambiarContraseña"]?></p>
    <?php session_unset();}?>
<div class="formulario">
    <form method="post" action="UsuarioNuevoCrear.php">
        <input type="text" name="nombre" placeholder="Introduce tu nombre" required><br><br>
        <input type="text" name="apellidos" placeholder="Introduce tus apellidos"required><br><br>
        <input type="text" name="identificador" placeholder="Introduce tu identificador" required><br><br>
        <input type="password" name="contrasenna" placeholder="Introduce tu contraseña" required><br><br>
        <input type="submit" name="crear" value="Crear Cuenta">
    </form>
</div>
<a href="SesionInicioFormulario.php">Ya tengo cuenta...</a>
</body>

</html>

