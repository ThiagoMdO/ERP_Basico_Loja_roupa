<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_fornecedor = isset($_POST['id_fornecedor'])?$_POST['id_fornecedor']:false;	
	$editar_nome_fornecedor = isset($_POST['editar_nome_fornecedor'])?$_POST['editar_nome_fornecedor']:false;
	$editar_cpf_fornecedor = isset($_POST['editar_cpf_fornecedor'])?$_POST['editar_cpf_fornecedor']:false;
	$editar_telefone_fornecedor = isset($_POST['editar_telefone_fornecedor'])?$_POST['editar_telefone_fornecedor']:false;
	$editar_rua_fornecedor = isset($_POST['editar_rua_fornecedor'])?$_POST['editar_rua_fornecedor']:false;
	$editar_numero_casa_fornecedor = isset($_POST['editar_numero_casa_fornecedor'])?$_POST['editar_numero_casa_fornecedor']:false;
	$editar_bairro_fornecedor = isset($_POST['editar_bairro_fornecedor'])?$_POST['editar_bairro_fornecedor']:false;
	$editar_cidade_fornecedor = isset($_POST['editar_cidade_fornecedor'])?$_POST['editar_cidade_fornecedor']:false;
	$editar_uf_fornecedor = isset($_POST['editar_uf_fornecedor'])?$_POST['editar_uf_fornecedor']:false;
	$editar_ceep_fornecedor = isset($_POST['editar_ceep_fornecedor'])?$_POST['editar_ceep_fornecedor']:false;

	
	$sql_alterar_fornecedor_nome = '';
	$sql_alterar_fornecedor_cpf = '';
	$sql_alterar_fornecedor_telefone = '';
	$sql_alterar_fornecedor_rua = '';
	$sql_alterar_fornecedor_numero_casa = '';
	$sql_alterar_fornecedor_bairro = '';
	$sql_alterar_fornecedor_cidade = '';
	$sql_alterar_fornecedor_uf = '';
	$sql_alterar_fornecedor_ceep = '';

	if($editar_nome_fornecedor){
		$sql_alterar_fornecedor_nome = "UPDATE fornecedores SET nome_fornecedor =  '$editar_nome_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_nome = mysqli_query($con,$sql_alterar_fornecedor_nome);

	}

	if($editar_cpf_fornecedor){
		$sql_alterar_fornecedor_cpf = "UPDATE fornecedores SET cpf_cnpj =  '$editar_cpf_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_cpf = mysqli_query($con,$sql_alterar_fornecedor_cpf);
	}

	if($editar_telefone_fornecedor){
		$sql_alterar_fornecedor_telefone = "UPDATE fornecedores SET contato_telefone =  '$editar_telefone_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_telefone = mysqli_query($con,$sql_alterar_fornecedor_telefone);
			
	}

	if($editar_rua_fornecedor){
		$sql_alterar_fornecedor_rua = "UPDATE fornecedores SET rua =  '$editar_rua_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_rua = mysqli_query($con,$sql_alterar_fornecedor_rua);
			
	}

	if($editar_numero_casa_fornecedor){
		$sql_alterar_fornecedor_numero_casa = "UPDATE fornecedores SET numero =  '$editar_numero_casa_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_numero_casa = mysqli_query($con,$sql_alterar_fornecedor_numero_casa);
			
	}

	if($editar_bairro_fornecedor){
		$sql_alterar_fornecedor_bairro = "UPDATE fornecedores SET bairro =  '$editar_bairro_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_bairro = mysqli_query($con,$sql_alterar_fornecedor_bairro);
			
	}

	if($editar_cidade_fornecedor){
		$sql_alterar_fornecedor_cidade = "UPDATE fornecedores SET cidade =  '$editar_cidade_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_cidade = mysqli_query($con,$sql_alterar_fornecedor_cidade);
			
	}

	if($editar_uf_fornecedor){
		$sql_alterar_fornecedor_uf = "UPDATE fornecedores SET uf =  '$editar_uf_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_uf = mysqli_query($con,$sql_alterar_fornecedor_uf);
			
	}

	if($editar_ceep_fornecedor){
		$sql_alterar_fornecedor_ceep = "UPDATE fornecedores SET ceep =  '$editar_ceep_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_ceep = mysqli_query($con,$sql_alterar_fornecedor_ceep);
			
	}




?>