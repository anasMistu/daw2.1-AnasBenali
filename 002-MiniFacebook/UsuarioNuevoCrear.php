<?php
require_once "_varios.php";

if(isset($_POST["Crear"])){

    if(empty($_POST["identificador"])|| empty($_POST["contrasenna"]) || empty($_POST["nombre"]) || empty($_POST["apellidos"])){
        $_SESSION["txt"]="¡Asegurate de rellenar todos los campos!";
        redireccionar("UsuarioNuevoFormulario.php");
    }else{
        $identificador=(string)$_POST["identificador"];
        $contrasenna=(string)$_POST["contrasenna"];
        $nombre=(string)$_POST["nombre"];
        $apellidos=(string)$_POST["apellidos"];
        $foto= $_FILES["ftoDePerfil"]["name"];
        $ruta= $_FILES["ftoDePerfil"]["tmp_name"];
        crearUsuario($identificador,$nombre,$apellidos,$contrasenna,$foto,$ruta);


    }
}


// TODO ¿Excepciones?

