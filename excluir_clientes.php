<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_cliente = isset($_POST['id_cliente'])?$_POST['id_cliente']:false;
	$nome_cliente = isset($_POST['nome_cliente'])?$_POST['nome_cliente']:false;

	//sql deleta cliente
	$sql_deletar_cliente = "DELETE FROM clientes WHERE id_cliente = '$id_cliente'";
	 $resultado_id = mysqli_query($con,$sql_deletar_cliente);
	 if($resultado_id){
	 	//sql registrar exclusao cliente
		$sql_registro_exclusao = "INSERT INTO historico_alteracoes 
							(id_cliente, nome_alteracao, descricao, tipo_operacao)
							VALUES
							($id_cliente,'$nome_cliente','Excluido do Banco de Dados','Excluidos')";
		$executar_registro_exclusao = mysqli_query($con, $sql_registro_exclusao);

	 	echo $nome_cliente.' foi deletado do banco de dados, atualize a página';
	 }else{
	 	echo 'Falha ao tentar excluir cliente';
	 }


?>