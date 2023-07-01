<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_produto = isset($_POST['id_produto'])?$_POST['id_produto']:false;
	$nomeProduto = isset($_POST['nome_produto'])?$_POST['nome_produto']:false;
	$comprar_fornecedor = isset($_POST['comprar_fornecedor'])?$_POST['comprar_fornecedor']:false;
	$tamanho = isset($_POST['tamanho'])?$_POST['tamanho']:false;
	$cor = isset($_POST['cor'])?$_POST['cor']:false;
	$quantidade_Comprar = isset($_POST['quantidade_Comprar'])?$_POST['quantidade_Comprar']:false;


	$forma_pagamento_comprar = isset($_POST['forma_pagamento_comprar'])?$_POST['forma_pagamento_comprar']:false;
	$preco_produto_fornecedor = isset($_POST['preco_produto_fornecedor'])?$_POST['preco_produto_fornecedor']:false;
	$preco_produto_cliente = isset($_POST['preco_produto_cliente'])?$_POST['preco_produto_cliente']:false;
	$parcelas = isset($_POST['forma_pagamento_parcelado_comprar'])?$_POST['forma_pagamento_parcelado_comprar']:false;
	$desconto_comprar = isset($_POST['desconto_comprar'])?$_POST['desconto_comprar']:false;
	$taxa_comprar = isset($_POST['taxa_comprar'])?$_POST['taxa_comprar']:false;

	$quantidade_estoque_produto = 0;
	$sub_quantidade = 0;
	$subtotal = 0;
	$subtotal_mes = 0;
	$saldo_dinheiro = 0;
	$saldo_banco = 0;
	$saldo_receber = 0;

	$subtotal = $quantidade_Comprar*$preco_produto_fornecedor;
	$subtotal *= $taxa_comprar;
	$subtotal -= $desconto_comprar;
	//$subtotal = number_format($subtotal, 2);
	$subtotal_mes = $subtotal/$parcelas;
	//$subtotal_mes = number_format($subtotal_mes, 2);

	$descricao_venda ='Produto: '.$nomeProduto.', TAM: '.$tamanho.', COR: '.$cor.', $Fornecedor: '.$preco_produto_fornecedor.', QTD: '.$quantidade_Comprar.'<br> Método: '.$forma_pagamento_comprar.', Parcelo em: '.$parcelas.', Desconto: '.$desconto_comprar.' e Taxa: '.$taxa_comprar.'<br> R$'.$subtotal_mes.'x'.$parcelas.' mês(meses)<br> Total: R$'.$subtotal;


		/* -- Atualizar Estoque -- */
	//Usar outra técnica posteriormente para tratar as SQLs mais segurança nas consultas dos produtos, sql provisória:
	$sql_consultar_estoque_produto = "SELECT quantidade FROM produto_estoque WHERE id_produto = $id_produto";
	$resultado_id = mysqli_query($con, $sql_consultar_estoque_produto);
	if($resultado_id){
		while($linha = mysqli_fetch_array($resultado_id)){
			$quantidade_estoque_produto = $linha['quantidade'];
		}
	}

	
	if($quantidade_Comprar>0){
		$sub_quantidade = $quantidade_estoque_produto + $quantidade_Comprar;
	}else{
		echo 'Valor invalido';
		return false;
	}

	//SQL para atualizar o estoque
	$sql_alterar_quantidade_produto = "UPDATE produto_estoque SET quantidade = $sub_quantidade WHERE id_produto = '$id_produto'";
	$resultado_id_atualiza_quantidade = mysqli_query($con, $sql_alterar_quantidade_produto);
	if($resultado_id_atualiza_quantidade){
		echo $nomeProduto.' comprado com sucesso de '.$comprar_fornecedor;
	}




		/* -- Atualizar Saldo -- */
	$sql_atualiza_saldos = "";
	
	//Usar outra técnica posteriormente para tratar as SQLs mais segurança nas consultas dos produtos, sql provisória:
	$sql_consultar_saldo = "SELECT * FROM empresa WHERE dono_empresa = 1";
	$resultado_id_saldo = mysqli_query($con, $sql_consultar_saldo);
	if($resultado_id_saldo){
		while($linha = mysqli_fetch_array($resultado_id_saldo)){
			$saldo_dinheiro = $linha['saldo_dinheiro'];
			$saldo_banco = $linha['saldo_banco'];
		}
	}

	$novo_saldo_dinheiro = $saldo_dinheiro-$subtotal;
	$novo_saldo_banco = $saldo_banco-$subtotal;

	switch($forma_pagamento_comprar){
		case 'dinheiro':
			$sql_atualiza_saldos = "UPDATE empresa set saldo_dinheiro = $novo_saldo_dinheiro WHERE dono_empresa = 1";
		break;
		case 'debito':
			$sql_atualiza_saldos = "UPDATE empresa set saldo_banco = $novo_saldo_banco WHERE dono_empresa = 1";
		break;
		
		default:
			echo 'Erro em selecionar forma de pagamento';
	}	

	$resposta_id_saldo = mysqli_query($con, $sql_atualiza_saldos);
	if($resposta_id_saldo){
		echo 'Saldo atualizado';
	}else{
		echo 'Erro ao atualizar saldo';
	}



die();
		/* -- Atualizar historico -- */

	$sql_consulta_id_fornecedor = "SELECT id_fornecedor FROM fornecedores WHERE nome_fornecedor = '$comprar_fornecedor'";
	$resultado_id_fornecedor = mysqli_query($con, $sql_consulta_id_fornecedor);
	$id_fornecedor = '';
	if($resultado_id_fornecedor){
		while($linha = mysqli_fetch_array($resultado_id_fornecedor)){
			$id_fornecedor = $linha['id_fornecedor'];
		}
	}

	//sql_inclui_notas_vender
	$sql_nota_venda = "INSERT INTO notas_compras (id_fornecedor,id_produto,descricao_venda,metodo_pagamento,parcelas,desconto,taxa)VALUES('$id_fornecedor','$id_produto','$descricao_venda','$forma_pagamento_comprar','$parcelas','$desconto_comprar','$taxa_comprar')";

	$resultado_id_venda = mysqli_query($con, $sql_nota_venda);


?>