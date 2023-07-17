<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_alteracao = isset($_POST['id_alteracao'])?$_POST['id_alteracao']:false;

	//sql deleta histórico alterações
	$sql_deletar_historico_alteracoes = "DELETE FROM historico_alteracoes WHERE id_alteracao = $id_alteracao";
	$resultado_id = mysqli_query($con,$sql_deletar_historico_alteracoes);
	if($resultado_id){
		echo 'Alteração número: '.$id_alteracao.' foi deletado do banco de dados, atualize a página';
	}else{
		echo 'Falha ao tentar excluir cliente';
	}


?>