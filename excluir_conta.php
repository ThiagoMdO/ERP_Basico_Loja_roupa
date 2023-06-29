<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();

	$id_conta = isset($_POST['id_conta'])?$_POST['id_conta']:false;	

	//sql deleta conta
	$sql_deletar_conta = "DELETE FROM contas WHERE id_conta = '$id_conta'";
	 $resultado_id = mysqli_query($con,$sql_deletar_conta);
	 if($resultado_id){
	 	echo 'Conta foi deletado do banco de dados, atualize a página';
	 }else{
	 	echo 'Falha ao tentar excluir cliente';
	 }


?>