<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_cliente = isset($_POST['id_cliente'])?$_POST['id_cliente']:false;	
	$editar_nome_cliente = isset($_POST['editar_nome_cliente'])?$_POST['editar_nome_cliente']:false;
	$editar_cpf_cliente = isset($_POST['editar_cpf_cliente'])?$_POST['editar_cpf_cliente']:false;
	$editar_telefone_cliente = isset($_POST['editar_telefone_cliente'])?$_POST['editar_telefone_cliente']:false;
	$editar_rua_cliente = isset($_POST['editar_rua_cliente'])?$_POST['editar_rua_cliente']:false;
	$editar_numero_casa_cliente = isset($_POST['editar_numero_casa_cliente'])?$_POST['editar_numero_casa_cliente']:false;
	$editar_bairro_cliente = isset($_POST['editar_bairro_cliente'])?$_POST['editar_bairro_cliente']:false;
	$editar_cidade_cliente = isset($_POST['editar_cidade_cliente'])?$_POST['editar_cidade_cliente']:false;
	$editar_uf_cliente = isset($_POST['editar_uf_cliente'])?$_POST['editar_uf_cliente']:false;
	$editar_ceep_cliente = isset($_POST['editar_ceep_cliente'])?$_POST['editar_ceep_cliente']:false;

	
	$sql_alterar_cliente_nome = '';
	$sql_alterar_cliente_cpf = '';
	$sql_alterar_cliente_telefone = '';
	$sql_alterar_cliente_rua = '';
	$sql_alterar_cliente_numero_casa = '';
	$sql_alterar_cliente_bairro = '';
	$sql_alterar_cliente_cidade = '';
	$sql_alterar_cliente_uf = '';
	$sql_alterar_cliente_ceep = '';

	if($editar_nome_cliente){
		$sql_alterar_cliente_nome = "UPDATE clientes SET nome_cliente =  '$editar_nome_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_nome = mysqli_query($con,$sql_alterar_cliente_nome);

	}

	if($editar_cpf_cliente){
		$sql_alterar_cliente_cpf = "UPDATE clientes SET cpf =  '$editar_cpf_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_cpf = mysqli_query($con,$sql_alterar_cliente_cpf);
	}

	if($editar_telefone_cliente){
		$sql_alterar_cliente_telefone = "UPDATE clientes SET contato_telefone =  '$editar_telefone_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_telefone = mysqli_query($con,$sql_alterar_cliente_telefone);
			
	}

	if($editar_rua_cliente){
		$sql_alterar_cliente_rua = "UPDATE clientes SET rua =  '$editar_rua_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_rua = mysqli_query($con,$sql_alterar_cliente_rua);
			
	}

	if($editar_numero_casa_cliente){
		$sql_alterar_cliente_numero_casa = "UPDATE clientes SET numero =  '$editar_numero_casa_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_numero_casa = mysqli_query($con,$sql_alterar_cliente_numero_casa);
			
	}

	if($editar_bairro_cliente){
		$sql_alterar_cliente_bairro = "UPDATE clientes SET bairro =  '$editar_bairro_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_bairro = mysqli_query($con,$sql_alterar_cliente_bairro);
			
	}

	if($editar_cidade_cliente){
		$sql_alterar_cliente_cidade = "UPDATE clientes SET cidade =  '$editar_cidade_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_cidade = mysqli_query($con,$sql_alterar_cliente_cidade);
			
	}

	if($editar_uf_cliente){
		$sql_alterar_cliente_uf = "UPDATE clientes SET uf =  '$editar_uf_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_uf = mysqli_query($con,$sql_alterar_cliente_uf);
			
	}

	if($editar_ceep_cliente){
		$sql_alterar_cliente_ceep = "UPDATE clientes SET ceep =  '$editar_ceep_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_ceep = mysqli_query($con,$sql_alterar_cliente_ceep);
			
	}




?>