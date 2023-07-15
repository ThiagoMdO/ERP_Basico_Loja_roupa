<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_produto = isset($_POST['id_produto'])?$_POST['id_produto']:false;
	$nomeProduto_Editado = isset($_POST['editar_nome_produto'])?$_POST['editar_nome_produto']:false;
	$tamanho_produto_Editado = isset($_POST['editar_tamanho_produto'])?$_POST['editar_tamanho_produto']:false;
	$cor_produto_Editado = isset($_POST['editar_cor_produto'])?$_POST['editar_cor_produto']:false;
	$valor_produto_Editado = isset($_POST['editar_preco_produto'])?$_POST['editar_preco_produto']:false;
	$quantidade_produto_Editado = isset($_POST['editar_quantidade_produto'])?$_POST['editar_quantidade_produto']:false;
	
	//alternar o que será editado, um item por vez
	$campo_editado = '';
	$valor_campo = '';

	//query de deletar produto definitivo
	//$sql_deletar_produto = "DELETE FROM produto_estoque WHERE nome_produto = '$nomeProduto' && tamanho = '$tamanho_produto' && cor = '$cor_produto'";

	//query para diminuir estoque

	//criar sql select para comparar qual dado está faltando e fazer alteração individual
	//se a query for verdadeira vai excutar a query correta
	//$sql_consulta_quantidade = "SELECT * FROM produto_estoque WHERE nome_produto = '$nomeProduto' && tamanho = '$tamanho_produto' && cor = '$cor_produto'";

	//echo $quantidade_produto;
	
	//query para comparar o que foi editado
	$sql_comparar_edicao = "SELECT * FROM produto_estoque WHERE id_produto ='$id_produto'";
	$resultado_id_sql_edicao = mysqli_query($con, $sql_comparar_edicao);

	//Regatar dados antigos
	$nome_produto_antigo = '';
	$tamanho_produto_antigo = '';
	$cor_produto_antigo = '';
	$valor_produto_antigo = '';
	$quantidade_produto_antigo = '';

	if($resultado_id_sql_edicao){
		while($linha = mysqli_fetch_array($resultado_id_sql_edicao)){
			$nome_produto_antigo = $linha['nome_produto'];
			$tamanho_produto_antigo = $linha['tamanho'];
			$cor_produto_antigo = $linha['cor'];
			$valor_produto_antigo = $linha['preco_produto_cliente'];
			$quantidade_produto_antigo = $linha['quantidade'];
		}
	}

	$sql_alterar_produto = '';
	$tipo_operacao = '';
	$valor_operacao_antigo = '';
	$valor_operacao_novo = '';
	switch(true){
		case $nomeProduto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET nome_produto =  '$nomeProduto_Editado' WHERE id_produto = '$id_produto'";
			$tipo_operacao = 'Nome do produto';
			$valor_operacao_antigo = $nome_produto_antigo;
			$valor_operacao_novo = $nomeProduto_Editado;
			echo $nomeProduto_Editado;
			break;
		case $tamanho_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET tamanho = '$tamanho_produto_Editado' WHERE id_produto = '$id_produto'";
			$tipo_operacao = 'Tamanho do produto';
			$valor_operacao_antigo = $tamanho_produto_antigo;
			$valor_operacao_novo = $tamanho_produto_Editado;
			echo $tamanho_produto_Editado;
			break;
		case $cor_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET cor = '$cor_produto_Editado' WHERE id_produto = '$id_produto'";
			$tipo_operacao = 'Cor do produto';
			$valor_operacao_antigo = $cor_produto_antigo;
			$valor_operacao_novo = $cor_produto_Editado;
			echo $cor_produto_Editado;
			break;
		case $valor_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET preco_produto_cliente = '$valor_produto_Editado' WHERE id_produto = '$id_produto'";
			$tipo_operacao = 'Valor do produto';
			$valor_operacao_antigo = $valor_produto_antigo;
			$valor_operacao_novo = $valor_produto_Editado;
			echo $valor_produto_Editado;
			break;
		case $quantidade_produto_Editado == true:
			$sql_alterar_produto = "UPDATE produto_estoque SET quantidade = '$quantidade_produto_Editado' WHERE id_produto = '$id_produto'";
			$tipo_operacao = 'Quantidade do produto';
			$valor_operacao_antigo = $quantidade_produto_antigo;
			$valor_operacao_novo = $quantidade_produto_Editado;
			echo $quantidade_produto_Editado;
	}

	
	//SQL para pegar executar a alteração
	$resultado_id = mysqli_query($con,$sql_alterar_produto);



	if($resultado_id == null){
		//testar para sem resultados
			echo '<div class="row d-block d-flex align-items-center justify-content-center">';
				echo '<div class="col-3">Falha em executar alteração</div>';
			echo"</div>";
		}else{
			$sql_pesquisar_produto_ja_editado = "SELECT * 
												FROM produto_estoque 
												WHERE id_produto = $id_produto";
			$nome_produto_alteracao_edicao = '';
			$descricao_edicao = '';

			$resultado_id_edicao = mysqli_query($con,$sql_pesquisar_produto_ja_editado);
			if($resultado_id_edicao){
				while($linha = mysqli_fetch_array($resultado_id_edicao)){
					$nome_produto_alteracao_edicao = $linha['nome_produto'];
					$descricao_edicao = 'TAM: '.$linha['tamanho'].', Cor: '.$linha['cor'].', $Fornecedor: '.$linha['preco_produto_fornecedor'].', $Cliente: '.$linha['preco_produto_cliente'].', QTD: '.$linha['quantidade'].'<br>
					Alteração: '.$tipo_operacao.' de '.$valor_operacao_antigo.' para '.$valor_operacao_novo;

				}
			}


			$sql_incluir_produto_historico = "INSERT INTO historico_alteracoes 
			(id_produto,nome_alteracao,descricao,tipo_operacao) 
			VALUES 
			($id_produto,'$nome_produto_alteracao_edicao','$descricao_edicao','Edicao')";
				$acrescentar_historico = mysqli_query($con, $sql_incluir_produto_historico);
		}
		

	

?>