<?php
session_start();
require_once "_varios.php";
$parrafo="";
$tema="blanco";
if(!isset($_SESSION["tema"]) && !isset($_REQUEST["tema"]) ){
    $_SESSION["tema"]=$tema;
}else{
    $_SESSION["tema"]=$_REQUEST["tema"];
    $tema=$_REQUEST["tema"];
    $_SESSION["enlace"]="n";

}
redireccionar("persona-listado.php");
