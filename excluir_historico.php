<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_nota_compras = isset($_POST['id_nota_compras'])?$_POST['id_nota_compras']:false;

	//sql deleta cliente
	$sql_deletar_historico = "DELETE FROM notas_compras WHERE id_nota_compras = '$id_nota_compras'";
	$resultado_id = mysqli_query($con,$sql_deletar_historico);
	if($resultado_id){
		echo 'Nota número '.$id_nota_compras.' foi deletado do banco de dados, atualize a página';
	}else{
		echo 'Falha ao tentar excluir cliente';
	}


?>