
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
    <form method="post" action="UsuarioNuevoCrear.php">
        <input type="text" name="nombre" placeholder="Introduce tu nombre"><br><br>
        <input type="text" name="apellidos" placeholder="Introduce tus apellidos"><br><br>
        <input type="text" name="identificador" placeholder="Introduce tu usuario"><br><br>
        <input type="password" name="contrasenna" placeholder="Introduce tu contraseña" ><br><br>
        <input type="submit" name="Crear" value="Crear usuario">
    </form>
</div>

</body>

</html>

