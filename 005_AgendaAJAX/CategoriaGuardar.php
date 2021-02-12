<?php
	require_once "_com/DAO.php";

	$conexionBD = obtenerPdoConexionBD();

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];

	DAO::categoriaActualizar($id,$nombre);

    echo (1);

