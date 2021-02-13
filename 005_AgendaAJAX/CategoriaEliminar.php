<?php
	require_once "_com/DAO.php";
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

	$id = (int)$_REQUEST["id"];

	echo(DAO::eliminarCategoriaPorId($id));

?>

