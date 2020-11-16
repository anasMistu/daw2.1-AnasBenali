<?php
require_once "_varios.php";
$pdo = obtenerPdoConexionBD();

$idPersona=(int)$_REQUEST["id"];

$sql = "UPDATE persona SET estrella = (NOT (SELECT estrella FROM persona WHERE id=?)) WHERE id=?";
$update= $pdo->prepare($sql);
$update->execute([$idPersona,$idPersona]);


redireccionar("persona-listado.php");

