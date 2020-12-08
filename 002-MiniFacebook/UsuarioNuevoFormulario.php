<?php

require_once "_varios.php";

?>
<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Crear Cuenta nueva</h1>
<?php if(isset($_SESSION["txt"])){?>
<p><?=$_SESSION["txt"]?></p>
<?php }?>

<div class="formulario">
    <form method="post" action="UsuarioNuevoCrear.php" enctype="multipart/form-data">
        Nombre: <input type="text" name="nombre" placeholder="Introduce tu nombre" required><br><br>
        Apellidos: <input type="text" name="apellidos" placeholder="Introduce tus apellidos" required><br><br>
        Usuario: <input type="text" name="identificador" placeholder="Introduce tu usuario" required><br><br>
        Contraseña: <input type="password" name="contrasenna" placeholder="Introduce tu contraseña" required><br><br>
        Foto de perfil (Opcional): <input type="file" name="ftoDePerfil"  accept="image/x-png,image/gif,image/jpeg"><br><br>
        <input type="submit" name="Crear" value="Crear usuario">
    </form>
</div>

</body>

</html>

