<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();

	$nome_conta = isset($_POST['nome_conta'])?$_POST['nome_conta']:false;
	$natureza_conta = isset($_POST['natureza_conta'])?$_POST['natureza_conta']:false;
	$valor_conta = isset($_POST['valor_conta'])?$_POST['valor_conta']:false;
	$pago_conta = isset($_POST['pago_conta'])?$_POST['pago_conta']:false;
	$forma_pagamento_conta = isset($_POST['forma_pagamento_conta'])?$_POST['forma_pagamento_conta']:false;
	$parcelas = isset($_POST['parcelas'])?$_POST['parcelas']:false;
	$vencimento = isset($_POST['vencimento'])?$_POST['vencimento']:false;

	
	if($nome_conta && $natureza_conta && $valor_conta && $pago_conta && $forma_pagamento_conta && $parcelas && $vencimento){
		$sql_inserir_conta = "INSERT INTO contas (nome_conta, natureza_conta, valor_conta, pago_conta, forma_pagamento_conta, parcelas, vencimento) VALUES ('$nome_conta', '$natureza_conta', '$valor_conta', '$pago_conta', '$forma_pagamento_conta', '$parcelas', '$vencimento')";
		$resultado_id = mysqli_query($con, $sql_inserir_conta);
		echo 'Conta '.$nome_conta.' cadastrada com sucesso, atualize a página';
	}else{
		echo 'Preencha todos campos obrigatórios';
	}

?>
