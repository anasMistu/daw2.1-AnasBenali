<?php

require_once "_com/DAO.php";


if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) {
    redireccionar("SesionInicioFormulario.php");
}


    $usuario=DAO::crearUsuarioDesdeRs(DAO::obtenerUsuarioConIdentificador($_REQUEST["identificador"]));

  $notificacion="";
    if(isset($_REQUEST["error"])){
        $notificacion="Ha ocurrido algun error, Intentalo de nuevo.";
    }
    if(isset($_REQUEST["errorId"])){
        $notificacion="El identificador introducido ya existe.";
    }
    print_r($_SESSION["identificador"]);
?>
<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>
<p style="color: red;"> <?=$notificacion?></p>

<?php DAO::pintarInfoSesion(); ?>


<div class="formulario">
    <form action="UsuarioPerfilGuardar.php" method="post">
        <br><br><br><input type="hidden" name="id" value="<?=$usuario->getId()?>">
        Identificador: <input type="text" name="identificador" value="<?=$usuario->getIdentificador()?>"><br><br>
        Nombre: <input type="text" name="nombre" value="<?=$usuario->getNombre()?>"><br><br>
        Apellidos: <input type="text" name="apellidos" value="<?=$usuario->getApellidos()?>"><br><br>
        <input type="submit" name="Guardar" value="Guardar datos">
    </form>
</div>
<a href='MuroVerGlobal.php' >Volver al muro global</a>

</body>

</html>


