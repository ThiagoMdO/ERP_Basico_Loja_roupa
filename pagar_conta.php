<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();



	$id_conta = isset($_POST['id_conta'])?$_POST['id_conta']:false;
	$valor_conta = isset($_POST['valor_conta'])?$_POST['valor_conta']:false;
	$forma_pagamento_conta = isset($_POST['forma_pagamento_conta'])?$_POST['forma_pagamento_conta']:false;
	$data_hoje = isset($_POST['data_hoje'])?$_POST['data_hoje']:false;

	$sql_consulta_saldo;
	$sql_pagar_conta;

	//sql (provisória) que vai bloquear a operação caso a pagina não foi recarregada e o usuário clicar no botão de pagar novamente
	$sql_culta_existe_conta = "SELECT pago_conta FROM contas WHERE pago_conta = 'NAO' AND id_conta = $id_conta";
	$resultado_existe = mysqli_query($con, $sql_culta_existe_conta);
	if($resultado_existe){
		$testar_existe =  mysqli_fetch_array($resultado_existe);
		if($testar_existe){
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


		/* -- Mudar status da conta -- && -- Registar data do pagamento da conta -- */

		$sql_pagar_conta_Sim = "UPDATE contas SET pago_conta = 'SIM', data_pagamento = '$data_hoje' WHERE id_conta = $id_conta";
		$pagar_conta = mysqli_query($con,$sql_pagar_conta_Sim);

			
		}else{
			echo 'Item já pago, por favor reinicie a página';
			return false;

		}
	}else{
		echo 'Falha na cunsulta com o bando de dados';
	}

	

?>