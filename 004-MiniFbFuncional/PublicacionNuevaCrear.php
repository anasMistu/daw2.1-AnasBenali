<?php
require_once "_com/DAO.php";

if(!DAO::haySesionRamIniciada()){
    redireccionar("SesionInicioFormulario");
}

$asunto=$_POST["asunto"];
$contenido=$_POST["contenido"];
$emisorId=$_SESSION["id"];
$fecha=date("Y/m/d H:i:s");
if(isset($_POST["destacar"])){
    $destacadHasta=date("Y/m/d H:i:s",strtotime($fecha."+ 1 days"));
}else{
    $destacadHasta=NULL;
}

if(!isset($_POST["destinatarioId"])){
    $destinatarioId=NULL;
    DAO::publicacionCrear([$fecha,$destinatarioId,$emisorId,$destacadHasta,$asunto,$contenido]);
    redireccionar("MuroVerGlobal.php");
}else{
    $identificadoDestino=$_POST["identificadorDestino"];
    $destinatarioId=$_POST["destinatarioId"];
    DAO::publicacionCrear([$fecha,$destinatarioId,$emisorId,$destacadHasta,$asunto,$contenido]);
    redireccionar("MuroVerDe.php?identificador=".$identificadoDestino);
}
print_r(56,$_SESSION["id"]);
