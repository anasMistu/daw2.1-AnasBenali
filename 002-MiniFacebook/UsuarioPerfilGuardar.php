<?php
require_once "_varios.php";
$id="";
$identificador="";
$nombre="";
$apellidos="";
$datos="";
if(isset($_POST["guardar"])){
    if(empty($_POST["id"]) || empty($_POST["identificador"]) || empty($_POST["nombre"]) || empty($_POST["apellidos"])){
        $_SESSION["notif"]="Asegurate de rellenar todos los campos";
        $identificadorEnlace=$_SESSION["identificador"];
        redireccionar("UsuarioPerfilVer.php?identificador=$identificadorEnlace");

    }else{
        $id=$_POST["id"];
        $identificador=$_POST["identificador"];
        $nombre=$_POST["nombre"];
        $apellidos=$_POST["apellidos"];
        $datos=array(["id"=>$id,"identificador"=>$identificador,"nombre"=>$nombre,"apellidos"=>$apellidos]);
        actualizarDatos($datos);
    }
}