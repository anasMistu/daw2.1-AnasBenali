<?php
require_once "_com/DAO.php";


if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) {
    redireccionar("SesionInicioFormulario.php");
}

if(isset($_REQUEST["idPublicacion"])){
    $identificadoDestino=$_REQUEST["identificadorDestino"];
    $idPublicacion=$_REQUEST["idPublicacion"];
    $sql = "DELETE FROM Publicacion WHERE id=?";
    DAO::ejecutarConsultaActualizar($sql,[$idPublicacion]);
    redireccionar("MuroVerDe.php?identificador=".$identificadoDestino);
}else{
    $idPublicacion=$_REQUEST["idPublicacionGlbal"];
    $sql = "DELETE FROM Publicacion WHERE id=?";
    DAO::ejecutarConsultaActualizar($sql,[$idPublicacion]);
    print_r($idPublicacion);
   redireccionar("MuroVerGlobal.php");
}
