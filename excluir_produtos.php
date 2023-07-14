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
	$preco_produto_fornecedor = isset($_POST['preco_produto_fornecedor'])?$_POST['preco_produto_fornecedor']:false;
	$preco_produto_cliente = isset($_POST['preco_produto_cliente'])?$_POST['preco_produto_cliente']:false;

	$descricao_produto = 'TAM: '.$tamanho_produto.', Cor: '.$cor_produto.', $Fornecedor: '.$preco_produto_fornecedor.', $Cliente: '.$preco_produto_cliente.'';


	//sql deleta produto
	$sql_deletar_produto = "DELETE FROM produto_estoque WHERE id_produto = '$id_produto'";
	$resultado_id = mysqli_query($con,$sql_deletar_produto);
	if($resultado_id){
	 	//sql registrar exclusao produto
		$sql_registro_exclusao = "INSERT INTO historico_alteracoes 
							(id_produto, nome_alteracao, descricao, tipo_operacao)
							VALUES
							($id_produto,'$nomeProduto','$descricao_produto','Excluidos')";
		$executar_registro_exclusao = mysqli_query($con, $sql_registro_exclusao);

	 	echo $nomeProduto.' '.$tamanho_produto.' '.$cor_produto.' foi deletado do banco de dados, atualize a página';
	 }else{
	 	echo 'Falha ao tentar excluir produto';
	 }


?>