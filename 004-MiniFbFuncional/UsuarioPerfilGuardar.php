<?php
require_once "_com/DAO.php";



if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) {
    redireccionar("SesionInicioFormulario.php");
}

$identificador=$_POST["identificador"];
$nombre=$_POST["nombre"];
$apellidos=$_POST["apellidos"];
$id=$_POST["id"];

$usuarioActual=DAO::crearUsuarioDesdeRs(DAO::obtenerUsuarioConIdentificador($_SESSION["identificador"]));
if($identificador==$usuarioActual->getIdentificador()){

    $sql="UPDATE Usuario SET nombre=?, apellidos=? WHERE id=?";
    if(DAO::ejecutarConsultaActualizar($sql,[$nombre,$apellidos,$id])){
        $usuarioNuevo=DAO::crearUsuarioDesdeRs(DAO::obtenerUsuarioConIdentificador($identificador));
        DAO::establecerSesionRam($usuarioNuevo);
        redireccionar("UsuarioPerfilVer.php?identificador=".$identificador);
    }else{
        redireccionar("UsuarioPerfilVer.php?error&identificador=".$identificador);
    }
}else{
    if (DAO::verificarUsuario($identificador)!=1){
        $sql="UPDATE Usuario SET identificador=?, nombre=?, apellidos=? WHERE id=?";
        if(DAO::ejecutarConsultaActualizar($sql,[$identificador,$nombre,$apellidos,$id])){
            $usuarioNuevo=DAO::crearUsuarioDesdeRs(DAO::obtenerUsuarioConIdentificador($identificador));
            DAO::establecerSesionRam($usuarioNuevo);
            redireccionar("UsuarioPerfilVer.php?identificador=".$identificador);
        }else{
            redireccionar("UsuarioPerfilVer.php?error&identificador=".$identificador);
        }
    }else{
        redireccionar("UsuarioPerfilVer.php?errorId&identificador=".$identificador);
    }


}

//print_r(DAO::verificarUsuario($_POST["identificador"]));