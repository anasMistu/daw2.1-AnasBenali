<?php

    require_once "_com/DAO.php";


    if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }
    /*SI no ha venido la variable*/
    if(!isset($_REQUEST["identificador"])){
        redireccionar("MuroVerGlobal.php");
    }

    $identificador=$_REQUEST["identificador"];
    $usuarioDestino=DAO::crearUsuarioDesdeRs(DAO::obtenerUsuarioConIdentificador($identificador));
    $publicaciones=DAO::publicacionObtenerTodo();

    /*Solo permitir borrar publicacion si es mi muro*/
    if($identificador==$_SESSION["identificador"]){
        $permitirBorrar=true;
    }else{
        $permitirBorrar=false;
    }
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

<?php DAO::pintarInfoSesion(); ?><a href='Index.php' style="margin-left: 15px; margin-right: 15px">Ir al Contenido Público 1</a><a href='MuroVerGlobal.php' style="margin-left: 15px">Volver al muro global</a>




<h1>Muro de <?=$usuarioDestino->getIdentificador()?></h1>
<div style="border: black 2px solid; ">
    <form action="PublicacionNuevaCrear.php" method="post" style="margin: 10px;">
        <input type="hidden" name="identificadorDestino" value="<?=$usuarioDestino->getIdentificador()?>">
        <input type="hidden" name="destinatarioId" value="<?=$usuarioDestino->getId()?>">
        Asunto:    <input type="text" name="asunto" required style="height: 20px; width:250px; margin-right: 12px; ""><br><br>
        Contenido: <input type="text" name="contenido" required style="height: 40px; width:900px; ""><br><br>
        Destacar publicacion durante 1 dia? <input type="checkbox" name="destacar"><br><br>
        <input type="submit" name="publicar" value="publicar">
    </form>
</div>

<h1>Los mensajes que ha publicado la gente:</h1>
<?php
foreach ($publicaciones as $publicacion){
    $publicacionObject=DAO::crearPublicacionDesdeRs($publicacion);
    //print_r($publicacion);
   $usuarioEmisor=DAO::ejecutarConsultaObtener("SELECT * FROM Usuario WHERE id=?",[$publicacion["emisorId"]]);
    $negrita="";
    $fechaActual=strtotime(date("Y/m/d H:i:s"));// cobertir fecha actuala sec
    $destacadaHasta= strtotime($publicacionObject->getDestacadaHasta());// convertir fehca destacadaHasta ea sec
    if($destacadaHasta!=NULL && $fechaActual<=$destacadaHasta){
            $negrita="negrita";
    }
    if($publicacionObject->getDistinatorioId()==$usuarioDestino->getId()){?>

        <a href="MuroVerDe.php?identificador=<?=$usuarioEmisor[0]["identificador"]?>"><?=$usuarioEmisor[0]["identificador"]?></a>
        <?php
        if(!$permitirBorrar){
             if ($publicacionObject->getEmisorId()==$_SESSION["id"]){
                ?>
            <a href='PublicacionELiminar.php?idPublicacion=<?=$publicacionObject->getId()?>&identificadorDestino=<?=$usuarioDestino->getIdentificador()?>' style="margin-left:250px"> Eliminar publicacion(X)</a>
            <?php
            }
        }else{ ?>
            <a href='PublicacionELiminar.php?idPublicacion=<?=$publicacionObject->getId()?>&identificadorDestino=<?=$usuarioDestino->getIdentificador()?>' style="margin-left:250px"> Eliminar publicacion(X)</a>
            <?php
        }
            ?>
            <p class="<?=$negrita?>">Asunto: <?=$publicacionObject->getAsunto()?> <br> Contenido: <?=$publicacionObject->getContenido()?></p>
        <p>---------------------------------------------------------------------------------------------</p>
    <?php }
}
?>

</body>

</html>