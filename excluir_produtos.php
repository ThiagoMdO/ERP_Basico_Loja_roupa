<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_produto = isset($_POST['id_produto'])?$_POST['id_produto']:false;
	$nomeProduto = isset($_POST['nome_produto'])?$_POST['nome_produto']:false;
	$tamanho_produto = isset($_POST['tamanho'])?$_POST['tamanho']:false;
	$cor_produto = isset($_POST['cor'])?$_POST['cor']:'';


	//sql deleta produto
	$sql_deletar_produto = "DELETE FROM produto_estoque WHERE id_produto = '$id_produto'";
	 $resultado_id = mysqli_query($con,$sql_deletar_produto);
	 if($resultado_id){
	 	echo $nomeProduto.' '.$tamanho_produto.' '.$cor_produto.' foi deletado do banco de dados, atualize a página';
	 }else{
	 	echo 'Falha ao tentar excluir produto';
	 }


?>