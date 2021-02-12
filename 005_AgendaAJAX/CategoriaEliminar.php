<?php
	require_once "_com/DAO.php";


	$id = (int)$_REQUEST["id"];

	if(DAO::categoriaEliminar($id)){
		echo(0);
	}else{
		echo(1);
	}
 	// INTERFAZ:
    // $correctoNormal
    // $noExistia

