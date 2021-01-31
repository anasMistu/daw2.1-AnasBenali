<?php

    require_once "_com/DAO.php";

    if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }
    $arrayPublicaciones=DAO::publicacionObtenerTodo();
    //print_r($arrayPublicaciones);

?>



<html>

<head>
    <meta charset='UTF-8'>
    <style>
        .negrita{
            font-weight: bold;
        }
    </style>
</head>



<body>

<?php DAO::pintarInfoSesion(); ?> <a href='MuroVerDe.php?identificador=<?=$_SESSION["identificador"]?>' style="margin-left: 15px;">Ir a mi muro</a>
<a href='UsuarioPerfilVer.php?identificador=<?=$_SESSION["identificador"]?>' style="margin-left: 15px;">Ver Perfil</a>



<h1>Muro global</h1>
<div style="border: black 2px solid; ">
    <form action="PublicacionNuevaCrear.php" method="post" style="margin: 10px;">
        Asunto:    <input type="text" name="asunto" required style="height: 20px; width:250px; margin-right: 12px; ""><br><br>
        Contenido: <input type="text" name="contenido" required style="height: 40px; width:900px; ""><br><br>
        Destacar publicacion durante 1 dia? <input type="checkbox" name="destacar"><br><br>
        <input type="submit" name="publicar" value="publicar">
    </form>
</div>


<h1>Publicaciones</h1>

<?php
foreach ($arrayPublicaciones as $publicacion){
    $publicacionObject=DAO::crearPublicacionDesdeRs($publicacion);
    //print_r($publicacion);
    $usuario=DAO::ejecutarConsultaObtener("SELECT * FROM Usuario WHERE id=?",[$publicacion["emisorId"]]);
    $negrita="";
    $fechaActual=strtotime(date("Y/m/d H:i:s"));// cobertir fecha actuala sec
    $destacadaHasta= strtotime($publicacionObject->getDestacadaHasta());// convertir fehca destacadaHasta ea sec
    if($destacadaHasta!=NULL && $fechaActual<=$destacadaHasta){
        $negrita="negrita";
    }
    if($publicacionObject->getDistinatorioId()==NULL){?>
        <a href="MuroVerDe.php?identificador=<?=$usuario[0]["identificador"]?>"><?=$usuario[0]["identificador"]?></a>
        <?php
        if ($publicacionObject->getEmisorId()==$_SESSION["id"]){
        ?>
            <a href='PublicacionELiminar.php?idPublicacionGlbal=<?=$publicacionObject->getId()?>' style="color: red;margin-left:250px"> Eliminar publicacion(X)</a>
            <?php
        } ?>
        <p class="<?=$negrita?>">Asunto: <?=$publicacionObject->getAsunto()?> <br> Contenido: <?=$publicacionObject->getContenido()?></p>
        <p>---------------------------------------------------------------------------------------------</p>

    <?php }
}
?>

</body>

</html>