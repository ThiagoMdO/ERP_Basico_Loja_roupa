<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_cliente = isset($_POST['id_cliente'])?$_POST['id_cliente']:false;
	$nome_cliente = isset($_POST['nome_cliente'])?$_POST['nome_cliente']:false;

	//sql deleta cliente
	$sql_deletar_produto = "DELETE FROM clientes WHERE id_cliente = '$id_cliente'";
	 $resultado_id = mysqli_query($con,$sql_deletar_produto);
	 if($resultado_id){
	 	echo $nome_cliente.' foi deletado do banco de dados, atualize a página';
	 }else{
	 	echo 'Falha ao tentar excluir cliente';
	 }


?>