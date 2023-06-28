<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();

	$atualizar_saldo_dinheiro = isset($_POST['novo_saldo_dinheiro'])?$_POST['novo_saldo_dinheiro']:false;
	$atualizar_saldo_banco = isset($_POST['novo_saldo_banco'])?$_POST['novo_saldo_banco']:false;
	$atualizar_saldo_receber = isset($_POST['novo_saldo_receber'])?$_POST['novo_saldo_receber']:false;



	//SQL para pegar informações de caixa da empresa
	$sql_inserir_saldo_dinheiro = "UPDATE empresa SET saldo_dinheiro = $atualizar_saldo_dinheiro WHERE id_empresa = 1";
	$sql_inserir_saldo_banco = "UPDATE empresa SET saldo_banco = $atualizar_saldo_banco WHERE id_empresa = 1";
	$sql_inserir_saldo_receber = "UPDATE empresa SET saldo_receber = $atualizar_saldo_receber WHERE id_empresa = 1";

	
	if($atualizar_saldo_dinheiro){
		$resultado_id = mysqli_query($con,$sql_inserir_saldo_dinheiro);
		echo $atualizar_saldo_dinheiro;
	}

	if($atualizar_saldo_banco){
		$resultado_id = mysqli_query($con,$sql_inserir_saldo_banco);
		echo $atualizar_saldo_banco;
	}
	if($atualizar_saldo_receber){
		$resultado_id = mysqli_query($con,$sql_inserir_saldo_receber);
		echo $atualizar_saldo_receber;
	}

	
	
	


?>
