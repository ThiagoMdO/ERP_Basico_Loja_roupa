<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_conta = isset($_POST['id_conta'])?$_POST['id_conta']:false;
	$nome_conta = isset($_POST['nome_conta'])?$_POST['nome_conta']:false;

	//sql deleta cliente
	$sql_deletar_historico_conta = "DELETE FROM contas WHERE id_conta = '$id_conta'";
	$resultado_id = mysqli_query($con,$sql_deletar_historico_conta);
	if($resultado_id){
		echo 'Nota número: '.$id_conta.', Nome: '.$nome_conta.' foi deletado do banco de dados, atualize a página';
	}else{
		echo 'Falha ao tentar excluir cliente';
	}


?>