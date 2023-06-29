<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	$novo_fornecedor_nome = isset($_POST['novo_fornecedor_nome'])?$_POST['novo_fornecedor_nome']:false;
	$novo_fornecedor_cpf_cnpj = isset($_POST['novo_fornecedor_cpf_cnpj'])?$_POST['novo_fornecedor_cpf_cnpj']:false;
	$novo_fornecedor_telefone = isset($_POST['novo_fornecedor_telefone'])?$_POST['novo_fornecedor_telefone']:false;
	$novo_fornecedor_rua = isset($_POST['novo_fornecedor_rua'])?$_POST['novo_fornecedor_rua']:false;
	$novo_fornecedor_numero_casa = isset($_POST['novo_fornecedor_numero_casa'])?$_POST['novo_fornecedor_numero_casa']:false;
	$novo_fornecedor_bairro = isset($_POST['novo_fornecedor_bairro'])?$_POST['novo_fornecedor_bairro']:false;
	$novo_fornecedor_cidade = isset($_POST['novo_fornecedor_cidade'])?$_POST['novo_fornecedor_cidade']:false;
	$novo_fornecedor_uf = isset($_POST['novo_fornecedor_uf'])?$_POST['novo_fornecedor_uf']:false;
	$novo_fornecedor_ceep = isset($_POST['novo_fornecedor_ceep'])?$_POST['novo_fornecedor_ceep']:false;
	
	
	$sql_inserir_fornecedor = "INSERT INTO fornecedores (nome_fornecedor,cpf_cnpj,contato_telefone,rua,numero,bairro,cidade,uf,ceep) VALUES ('$novo_fornecedor_nome','$novo_fornecedor_cpf_cnpj','$novo_fornecedor_telefone','$novo_fornecedor_rua','$novo_fornecedor_numero_casa','$novo_fornecedor_bairro','$novo_fornecedor_cidade','$novo_fornecedor_uf','$novo_fornecedor_ceep')";

	$resultado_id = mysqli_query($con,$sql_inserir_fornecedor);
	if($resultado_id){
		echo $novo_fornecedor_nome.' foi cadastrado com sucesso';

	}else{
		echo 'Falha em cadastrar '.$novo_fornecedor_nome;
	}


?>
