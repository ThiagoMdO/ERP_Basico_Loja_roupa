<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_produto = isset($_POST['id_produto'])?$_POST['id_produto']:false;
	$nomeProduto = isset($_POST['nome_produto'])?$_POST['nome_produto']:false;
	$tamanho = isset($_POST['tamanho'])?$_POST['tamanho']:false;
	$cor = isset($_POST['cor'])?$_POST['cor']:false;
	$cliente_vender = isset($_POST['cliente_vender'])?$_POST['cliente_vender']:false;
	$quantidade_produto_vender = isset($_POST['quantidade_vender'])?$_POST['quantidade_vender']:false;

	$forma_pagamento_vender = isset($_POST['forma_pagamento_vender'])?$_POST['forma_pagamento_vender']:false;
	$preco_produto_fornecedor = isset($_POST['preco_produto_fornecedor'])?$_POST['preco_produto_fornecedor']:false;
	$preco_produto = isset($_POST['preco_produto_cliente'])?$_POST['preco_produto_cliente']:false;
	$parcelas = isset($_POST['forma_pagamento_parcelado_vender'])?$_POST['forma_pagamento_parcelado_vender']:false;
	$desconto_vender = isset($_POST['desconto_vender'])?$_POST['desconto_vender']:false;
	$taxa_vender = isset($_POST['taxa_vender'])?$_POST['taxa_vender']:false;

	$quantidade_estoque_produto = 0;
	$sub_quantidade = 0;
	$subtotal = 0;
	$subtotal_mes = 0;
	$saldo_dinheiro = 0;
	$saldo_banco = 0;
	$saldo_receber = 0;

	$subtotal = $quantidade_produto_vender*$preco_produto;
	$subtotal *= $taxa_vender;
	$subtotal -= $desconto_vender;
	//$subtotal = number_format($subtotal, 2);
	$subtotal_mes = $subtotal/$parcelas;
	//$subtotal_mes = number_format($subtotal_mes, 2);

	$descricao_venda ='Produto: '.$nomeProduto.', TAM: '.$tamanho.', COR: '.$cor.', $Fornecedor: '.$preco_produto_fornecedor.', $Cliente: '.$preco_produto.', QTD: '.$quantidade_produto_vender.'<br> Método: '.$forma_pagamento_vender.', Parcelado em: '.$parcelas.', Desconto: '.$desconto_vender.' e Taxa: '.$taxa_vender.'<br> Total: R$'.$subtotal;

	

		/* -- Atualizar Estoque -- */
	//Usar outra técnica posteriormente para tratar as SQLs mais segurança nas consultas dos produtos, sql provisória:
	$sql_consultar_estoque_produto = "SELECT quantidade FROM produto_estoque WHERE id_produto = $id_produto";
	$resultado_id = mysqli_query($con, $sql_consultar_estoque_produto);
	if($resultado_id){
		while($linha = mysqli_fetch_array($resultado_id)){
			$quantidade_estoque_produto = $linha['quantidade'];
		}
	}

	if($quantidade_estoque_produto>=$quantidade_produto_vender){
		$sub_quantidade = $quantidade_estoque_produto - $quantidade_produto_vender;
	}else{
		echo 'Valor invalido';
		return false;
	}

	//SQL para atualizar o estoque
	$sql_alterar_quantidade_produto = "UPDATE produto_estoque SET quantidade = $sub_quantidade WHERE id_produto = '$id_produto'";
	$resultado_id_atualiza_quantidade = mysqli_query($con, $sql_alterar_quantidade_produto);
	if($resultado_id_atualiza_quantidade){
		echo $nomeProduto.' vendido com sucesso para '. $cliente_vender;
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
			$saldo_receber = $linha['saldo_receber'];
		}
	}
	$novo_saldo_dinheiro = $saldo_dinheiro+$subtotal;
	$novo_saldo_banco = $saldo_banco+$subtotal;
	$novo_saldo_receber = $saldo_receber+$subtotal;

	switch($forma_pagamento_vender){
		case 'dinheiro':
			$sql_atualiza_saldos = "UPDATE empresa set saldo_dinheiro = $novo_saldo_dinheiro WHERE dono_empresa = 1";
		break;
		case 'debito':
			$sql_atualiza_saldos = "UPDATE empresa set saldo_banco = $novo_saldo_banco WHERE dono_empresa = 1";
		break;
		case 'credito':
			$sql_atualiza_saldos = "UPDATE empresa set saldo_receber = $novo_saldo_receber WHERE dono_empresa = 1";
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




		/* -- Atualizar historico -- */

	$sql_consulta_id_cliente = "SELECT id_cliente FROM clientes WHERE nome_cliente = '$cliente_vender'";
	$resultado_id_cliente = mysqli_query($con, $sql_consulta_id_cliente);
	$id_cliente = '';
	if($resultado_id_cliente){
		while($linha = mysqli_fetch_array($resultado_id_cliente)){
			$id_cliente = $linha['id_cliente'];
		}
	}

	//sql_inclui_notas_vender
	$sql_nota_venda = "INSERT INTO notas_compras (id_cliente,id_produto,descricao_venda,metodo_pagamento,parcelas,desconto,taxa)VALUES('$id_cliente','$id_produto','$descricao_venda','$forma_pagamento_vender','$parcelas','$desconto_vender','$taxa_vender')";

	$resultado_id_venda = mysqli_query($con, $sql_nota_venda);


?>