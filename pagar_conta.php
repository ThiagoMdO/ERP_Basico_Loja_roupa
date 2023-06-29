<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();



	$id_conta = isset($_POST['id_conta'])?$_POST['id_conta']:false;
	$valor_conta = isset($_POST['valor_conta'])?$_POST['valor_conta']:false;
	$forma_pagamento_conta = isset($_POST['forma_pagamento_conta'])?$_POST['forma_pagamento_conta']:false;


	$sql_consulta_saldo;
	$sql_pagar_conta;
	switch($forma_pagamento_conta){
		case 'Dinheiro':
			$sql_consulta_saldo = "SELECT saldo_dinheiro FROM empresa WHERE id_empresa = 1";
			$resultado_id = mysqli_query($con, $sql_consulta_saldo);
			$saldo_dinheiro = 0;
			if($resultado_id){
				while ($linha = mysqli_fetch_array($resultado_id)) {
					$saldo_dinheiro = $linha['saldo_dinheiro'];
				}
				$saldo_dinheiro -= $valor_conta;
				if($saldo_dinheiro<0){
					echo 'Saldo em dinheiro insuficiente';
					return false;
				}else{
					$sql_pagar_conta = "UPDATE empresa SET saldo_dinheiro = $saldo_dinheiro WHERE id_empresa = 1";
					$alterar_saldo = mysqli_query($con, $sql_pagar_conta);
					echo 'Conta paga com sucesso, com Saldo Dinheiro, reinicie a página';
				}
			}
		break;
		case 'Debito':
			$sql_consulta_saldo = "SELECT saldo_banco FROM empresa WHERE id_empresa = 1";
			$resultado_id = mysqli_query($con, $sql_consulta_saldo);
			$saldo_banco = 0;
			if($resultado_id){
				while ($linha = mysqli_fetch_array($resultado_id)) {
					$saldo_banco = $linha['saldo_banco'];
				}
				$saldo_banco -= $valor_conta;
				if($saldo_banco<0){
					echo 'Saldo no banco insuficiente';
					return false;
				}else{
					$sql_pagar_conta = "UPDATE empresa SET saldo_banco = $saldo_banco WHERE id_empresa = 1";
					$alterar_saldo = mysqli_query($con, $sql_pagar_conta);
					echo 'Conta paga com sucesso, com Saldo Banco, reinicie a página';
				}
			}
		break;

		case 'Credito':
			echo 'Pagamento no cartão de credito';

	}


	/* -- Apagar conta -- */

	$sql_apagar_conta = "DELETE FROM contas WHERE id_conta = $id_conta";
	$apagar_conta = mysqli_query($con,$sql_apagar_conta);

	ECHO $sql_apagar_conta;
	die();

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

	$descricao_venda ='Produto: '.$nomeProduto.', TAM: '.$tamanho.', COR: '.$cor.', $Fornecedor: '.$preco_produto_fornecedor.', $Cliente: '.$preco_produto.', QTD: '.$quantidade_produto_vender.'<br> Método: '.$forma_pagamento_vender.', Parcelo em: '.$parcelas.', Desconto: '.$desconto_vender.' e Taxa: '.$taxa_vender.'<br> Total: R$'.$subtotal;

	

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