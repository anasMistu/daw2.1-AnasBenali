<?php
	require_once "_com/DAO.php";
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);
	//$conexionBD = obtenerPdoConexionBD();

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];

	echo(DAO::categoriaActualizar($id,$nombre));


