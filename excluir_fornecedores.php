<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_fornecedor = isset($_POST['id_fornecedor'])?$_POST['id_fornecedor']:false;	
	$nome_fornecedor = isset($_POST['nome_fornecedor'])?$_POST['nome_fornecedor']:false;

	//sql deleta fornecedor
	$sql_deletar = "DELETE FROM fornecedores WHERE id_fornecedor = '$id_fornecedor'";
	 $resultado_id = mysqli_query($con,$sql_deletar);
	 if($resultado_id){
	 	echo $nome_fornecedor.' foi deletado do banco de dados, atualize a página';
	 }else{
	 	echo 'Falha ao tentar excluir fornecedor';
	 }


?>