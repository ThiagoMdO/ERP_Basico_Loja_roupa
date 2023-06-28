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

			$('#btn_cadastrar_fornecedor').click(function(){
				$.ajax({
					url:'incluir_fornecedor.php',
					method: 'post',
					data: $('#cadastrar_fornecedor').serialize(),
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
							<a href="clientes.php" class="btn btn-large btn-outline-success">
								<p>Clientes</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="produto_estoque.php" class="btn btn-large btn-outline-success">
								<p>Estoque</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="fornecedores.php" class="btn btn-large btn-outline-success active">
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
				<form id="cadastrar_fornecedor" class="col-md-6">
					<div class="input-group mb-3">
						<input id="novo_fornecedor_nome" name="novo_fornecedor_nome" type="text" class="form-control" placeholder="Nome fornecedor">
					</div>
					<div class="input-group mb-3">
						<input id="novo_fornecedor_cpf" name="novo_fornecedor_cpf" type="text" class="form-control" placeholder="CPF fornecedor">
					</div>
					<div class="input-group mb-3">
						<input id="novo_fornecedor_telefone" name="novo_fornecedor_telefone" type="text" class="form-control" placeholder="Número telefone fornecedor">
					</div>
					<div class="input-group mb-3">
						<input id="novo_fornecedor_rua" name="novo_fornecedor_rua" type="text" class="form-control" placeholder="Rua fornecedor">
					</div>
					<div class="input-group mb-3">
						<input id="novo_fornecedor_numero_casa" name="novo_fornecedor_numero_casa" type="text" class="form-control" placeholder="Número casa fornecedor">
					</div>
					<div class="input-group mb-3">
						<input id="novo_fornecedor_bairro" name="novo_fornecedor_bairro" type="text" class="form-control" placeholder="Bairro fornecedor">
					</div>
					<div class="input-group mb-3">
						<input id="novo_fornecedor_cidade" name="novo_fornecedor_cidade" type="text" class="form-control" placeholder="Cidade fornecedor">
					</div>
					<div class="input-group mb-3">
						<input id="novo_fornecedor_uf" name="novo_fornecedor_uf" type="text" class="form-control" placeholder="Estado fornecedor">
					</div>
					<div class="input-group mb-3">						
						<input id="novo_fornecedor_ceep" name="novo_fornecedor_ceep" type="text" class="form-control" placeholder="CEEP fornecedor">
					</div>
					<button class="btn btn-outline-primary" type="button" id="btn_cadastrar_fornecedor" >Cadastrar</button>
					<a href="fornecedores.php"><button class="btn btn-outline-secondary" type="button">Voltar</button></a>
				</div>
            </form>
		</div>

	</div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>