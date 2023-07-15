<?php 
	session_start();
	if(!isset($_SESSION['nome'])){
		header('Location: index.php?');
	}
	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Empresa Virtual</title>

	<!-- Bootstrap V 5.3 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	
	<!-- Bootstrap V 5.3 CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

	<!-- jquery V 3.7 -->
	<script type="text/javascript" src="jqueryV3.7.js"></script>

	<!-- jquery V 3.7 CDN -->
	<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

	<!-- CSS externo -->
	<link rel="stylesheet" type="text/css" href="estilos/estilo.css">

	<script type="text/javascript">
		$(document).ready(function(){

			$('#btn_cadastrar_cliente').click(function(){
				$.ajax({
					url:'incluir_cliente.php',
					method: 'post',
					data: $('#cadastrar_cliente').serialize(),
					success: function(data){
						alert(data);
					}
				});
			});



		});
	</script>
	<style type="text/css">

		input{
			width: 100%;
		}
*{
	text-decoration: none;
	list-style: none;
}	</style>
</head>

<body id="main_home">
	<div class="container-fluid conteudo_home">
		<div class="row row-up d-flex justify-content-center align-items-center">
			<?php
				include_once 'menu_principal.php';
			?>
		</div><!-- Fim row 1 -->
		<div class="row row-down">
			<div class="col-md-3 border_custom">
				<div class="container border_custom">
					<div class="row">
						<div class="col-12 menu_lateral">
							<a href="produto_cadastrar.php" class="btn btn-large btn-outline-success">
								<p>Cadastrar</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="clientes.php" class="btn btn-large btn-outline-success active">
								<p>Clientes</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="produto_estoque.php" class="btn btn-large btn-outline-success">
								<p>Estoque</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="fornecedores.php" class="btn btn-large btn-outline-success">
								<p>Fornecedores</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="historico.php" class="btn btn-large btn-outline-success">
								<p>Histórico</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="vender.php" class="btn btn-large btn-outline-success">
								<p>Vender</p>
							</a>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-md-9 border_custom">
				<br>
				<form id="cadastrar_cliente" class="col-md-6">
					<div class="input-group mb-3">
						<input id="novo_cliente_nome" name="novo_cliente_nome" type="text" class="form-control" placeholder="Nome cliente">
					</div>
					<div class="input-group mb-3">
						<input id="novo_cliente_cpf" name="novo_cliente_cpf" type="text" class="form-control" placeholder="CPF cliente">
					</div>
					<div class="input-group mb-3">
						<input id="novo_cliente_telefone" name="novo_cliente_telefone" type="text" class="form-control" placeholder="Número telefone cliente">
					</div>
					<div class="input-group mb-3">
						<input id="novo_cliente_rua" name="novo_cliente_rua" type="text" class="form-control" placeholder="Rua cliente">
					</div>
					<div class="input-group mb-3">
						<input id="novo_cliente_numero_casa" name="novo_cliente_numero_casa" type="text" class="form-control" placeholder="Número casa cliente">
					</div>
					<div class="input-group mb-3">
						<input id="novo_cliente_bairro" name="novo_cliente_bairro" type="text" class="form-control" placeholder="Bairro cliente">
					</div>
					<div class="input-group mb-3">
						<input id="novo_cliente_cidade" name="novo_cliente_cidade" type="text" class="form-control" placeholder="Cidade cliente">
					</div>
					<div class="input-group mb-3">
						<input id="novo_cliente_uf" name="novo_cliente_uf" type="text" class="form-control" placeholder="Estado cliente">
					</div>
					<div class="input-group mb-3">						
						<input id="novo_cliente_ceep" name="novo_cliente_ceep" type="text" class="form-control" placeholder="CEEP cliente">
					</div>
					<button class="btn btn-outline-primary" type="button" id="btn_cadastrar_cliente" >Cadastrar</button>
					<a href="clientes.php"><button class="btn btn-outline-secondary" type="button">Voltar</button></a>
				</div>
            </form>
		</div>

	</div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>