<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_produto = isset($_POST['id_produto'])?$_POST['id_produto']:false;
	$nomeProduto_Editado = isset($_POST['editar_nome_produto'])?$_POST['editar_nome_produto']:false;
	$tamanho_produto_Editado = isset($_POST['editar_tamanho_produto'])?$_POST['editar_tamanho_produto']:false;
	$cor_produto_Editado = isset($_POST['editar_cor_produto'])?$_POST['editar_cor_produto']:'';
	$valor_produto_Editado = isset($_POST['editar_preco_produto'])?$_POST['editar_preco_produto']:false;
	$quantidade_produto_Editado = isset($_POST['editar_quantidade_produto'])?$_POST['editar_quantidade_produto']:false;
	

	//query de deletar produto definitivo
	//$sql_deletar_produto = "DELETE FROM produto_estoque WHERE nome_produto = '$nomeProduto' && tamanho = '$tamanho_produto' && cor = '$cor_produto'";

	//query para diminuir estoque
	$sql_alterar_produto = true;

	//criar sql select para comparar qual dado está faltando e fazer alteração individual
	//se a query for verdadeira vai excutar a query correta
	//$sql_consulta_quantidade = "SELECT * FROM produto_estoque WHERE nome_produto = '$nomeProduto' && tamanho = '$tamanho_produto' && cor = '$cor_produto'";

	//echo $quantidade_produto;
	

	$sql_alterar_produto = '';
	switch(true){
		case $nomeProduto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET nome_produto =  '$nomeProduto_Editado' WHERE id_produto = '$id_produto'";
			echo $nomeProduto_Editado;
			break;
		case $tamanho_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET tamanho = '$tamanho_produto_Editado' WHERE id_produto = '$id_produto'";
			echo $tamanho_produto_Editado;
			break;
		case $cor_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET cor = '$cor_produto_Editado' WHERE id_produto = '$id_produto'";
			echo $cor_produto_Editado;
			break;
		case $valor_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET preco_produto_cliente = '$valor_produto_Editado' WHERE id_produto = '$id_produto'";
			echo $valor_produto_Editado;
			break;
		case $quantidade_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET quantidade = '$quantidade_produto_Editado' WHERE id_produto = '$id_produto'";
			echo $quantidade_produto_Editado;
	}

	
	//SQL para pegar valores da pesquisa, teste com nome
	$resultado_id = mysqli_query($con,$sql_alterar_produto);



	if(!$resultado_id){
		//testar para sem resultados
			echo '<div class="row d-block d-flex align-items-center justify-content-center">';
				echo '<div class="col-3">Falha em executar alteração</div>';
			echo"</div>";
		}
		


?>