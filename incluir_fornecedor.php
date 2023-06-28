<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	$novo_cliente_nome = isset($_POST['novo_cliente_nome'])?$_POST['novo_cliente_nome']:false;
	$novo_cliente_cpf = isset($_POST['novo_cliente_cpf'])?$_POST['novo_cliente_cpf']:false;
	$novo_cliente_telefone = isset($_POST['novo_cliente_telefone'])?$_POST['novo_cliente_telefone']:false;
	$novo_cliente_rua = isset($_POST['novo_cliente_rua'])?$_POST['novo_cliente_rua']:false;
	$novo_cliente_numero_casa = isset($_POST['novo_cliente_numero_casa'])?$_POST['novo_cliente_numero_casa']:false;
	$novo_cliente_bairro = isset($_POST['novo_cliente_bairro'])?$_POST['novo_cliente_bairro']:false;
	$novo_cliente_cliente = isset($_POST['novo_cliente_cliente'])?$_POST['novo_cliente_cliente']:false;
	$novo_cliente_uf = isset($_POST['novo_cliente_uf'])?$_POST['novo_cliente_uf']:false;
	$novo_cliente_ceep = isset($_POST['novo_cliente_ceep'])?$_POST['novo_cliente_ceep']:false;
	
	
	$sql_inserir_cliente = "INSERT INTO clientes (nome_cliente,cpf,contato_telefone,rua,numero,bairro,cidade,uf,ceep) VALUES ('$novo_cliente_nome','$novo_cliente_cpf','$novo_cliente_telefone','$novo_cliente_rua','$novo_cliente_numero_casa','$novo_cliente_bairro','$novo_cliente_cliente','$novo_cliente_uf','$novo_cliente_ceep')";

	$resultado_id = mysqli_query($con,$sql_inserir_cliente);
	if($resultado_id){
		echo $novo_cliente_nome.' foi cadastrado com sucesso';

	}else{
		echo 'Falha em cadastrar '.$novo_cliente_nome;
	}


?>
