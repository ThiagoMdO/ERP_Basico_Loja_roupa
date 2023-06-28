<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();
	

	//SQL que irá fazer a pesquisa dos saldos no banco de dados
	$sql_consultar_saldo = "SELECT * FROM empresa WHERE dono_empresa = 1";

	//SQL que irá transferir o valor
	$sql_transferir_saldo = '';

	$valor_transferir = isset($_POST['transferir_novo_saldo'])?$_POST['transferir_novo_saldo']:false;
	$valor_transferir = floatval($valor_transferir);
	$tipo_saldo_de = isset($_POST['transferir_de'])?$_POST['transferir_de']:false;

	$tipo_saldo_para = isset($_POST['transferir_para'])?$_POST['transferir_para']:false;
	


	$resultado_id = mysqli_query($con, $sql_consultar_saldo);
	$pega_saldo_dinheiro = 0;
	$pega_saldo_banco = 0;
	$pega_saldo_receber = 0;
	if($resultado_id){
		while($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			$pega_saldo_dinheiro = $linha['saldo_dinheiro'];
			$pega_saldo_banco = $linha['saldo_banco'];
			$pega_saldo_receber = $linha['saldo_receber'];
		}
	}


	$tipo_saldo_de_string = '';
	$tipo_saldo_para_string = '';

	$pega_saldo = 0;
	switch($tipo_saldo_de){
		case 'de_dinheiro':
			$tipo_saldo_de_string = 'Saldo dinheiro';
			$pega_saldo_dinheiro -= $valor_transferir;
			$sql_transferir_saldo = "UPDATE empresa SET saldo_dinheiro = $pega_saldo_dinheiro WHERE dono_empresa = 1";
		break;
		case 'de_banco':
			$tipo_saldo_de_string = 'Saldo do banco';
			$pega_saldo_banco -= $valor_transferir;
			$sql_transferir_saldo = "UPDATE empresa SET saldo_banco = $pega_saldo_banco WHERE dono_empresa = 1";
		break;
		case 'de_receber':
			$tipo_saldo_de_string = 'Saldo a receber';
			$pega_saldo_receber -= $valor_transferir;
			$sql_transferir_saldo = "UPDATE empresa SET saldo_receber = $pega_saldo_receber WHERE dono_empresa = 1";
		break;
	}

	//tirar do saldo selecionado usando a mesma variável com set -
	$transferir = mysqli_query($con, $sql_transferir_saldo);
	

	switch($tipo_saldo_para){
		case 'para_dinheiro':
			$tipo_saldo_para_string = 'Saldo dinheiro';
			$pega_saldo_dinheiro += $valor_transferir;
			$sql_transferir_saldo = "UPDATE empresa SET saldo_dinheiro = $pega_saldo_dinheiro WHERE dono_empresa = 1";
		break;
		case 'para_banco':
			$tipo_saldo_para_string = 'Saldo banco';
			$pega_saldo_banco += $valor_transferir;
			$sql_transferir_saldo = "UPDATE empresa SET saldo_banco = $pega_saldo_banco WHERE dono_empresa = 1";
		break;
		case 'para_receber':
			$tipo_saldo_para_string = 'Saldo receber';
			$pega_saldo_receber += $valor_transferir;
			$sql_transferir_saldo = "UPDATE empresa SET saldo_receber = $pega_saldo_receber WHERE dono_empresa = 1";
		break;
	}

	//passar o valor tirado usando a mesma variável com set +
	$transferir = mysqli_query($con, $sql_transferir_saldo);
	
	echo 'Foi transferido R$:'.$valor_transferir.' de '.$tipo_saldo_de_string.' para '.$tipo_saldo_para_string;

	


?>
