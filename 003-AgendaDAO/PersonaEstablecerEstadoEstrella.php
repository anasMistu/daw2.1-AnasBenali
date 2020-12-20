<?php
require_once "_com/Varios.php";
require_once "_com/dao.php";

$id = (int)$_REQUEST["id"];
DAO::personaEstablecerEstadoEstrella($id);

redireccionar("PersonaListado.php");
?>