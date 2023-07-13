<?php 
	session_start();

	$getNome = isset($_SESSION['nome'])?$_SESSION['nome']:false;
	if(!$getNome){
		header('Location: index.php');
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
			var divPai = $('#cadastar_produto_todos');
			var btnCriar = $('#novo_campo_cadastro');
			var btnExcluir = $('.btn_excluir');
			var btn_cadastrar_todos = $('#btn_cadastar_produto_todos');

			var formCadastrar = $('#formCadastrar');
	 		var i = 1;
			btnCriar.click(function(){
			    divPai.append(`
			    	<div class="row" id="row_incluir_campo_`+i+`">
							<div class='col-2 produto'><div><input type="text" name="nomeProduto_cadastrar"
							maxlength="20"></div></div>
							<div class='col-1 produto'><div><input type="text" name="tamanho_cadastrar" maxlength="2"></div></div>
							<div class='col-2 produto'><div><input type="text" name="cor_cadastrar" maxlength="20"></div></div>
							<div class='col-2 produto'><div><input type="text" name="preco_cadastrar_fornecedor" maxlength="4"></div></div>
							<div class='col-2 produto'><div><input type="text" name="preco_cadastrar_cliente" maxlength="4"></div></div>
							<!-- <div class='col-2 produto'><div><input type="text" name="qtd_cadastrar" maxlength="3"></div></div> -->
							<div class='col-1 produto'><div><input  type="date" name="data_cadastrar" maxlength="3"></div></div>
							<div class="col-12">
								<hr>
							</div>
		    			<div class="col-12">
		    				<button type="button" class="btn btn-outline-danger btn_excluir" id="btn_excluir_'+i+'">Excluir</button>
		    				<hr>
		    			</div>
			    	</div>`);
			    i++
			});


			btnExcluir.click(function(){
				var id_btn_excluir = this.id;
				alert(id_btn_excluir);
			})


			btn_cadastrar_todos.click(function(){
				$.ajax({
					url: 'incluir_cadastrar_produto.php',
					method: 'post',
					data: formCadastrar.serialize(),
				}).done(function(data){

					alert(data);
				});
			});


			
		});

	</script>
	<style type="text/css">
		
	</style>
</head>

<body id="main_home">
	<div class="container-fluid conteudo_home">
		<div class="row row-up d-flex justify-content-center align-items-center">
			<?php
				include_once 'menu_principal.php';
			?>
			<div class="container border_custom">
					
					
		</div><!-- Fim row 1 -->
		<div class="row row-down">
			<div class="col-md-3 border_custom">
				<div class="container border_custom">
					<div class="row">
						<div class="col-12 menu_lateral">
							<a href="produto_cadastrar.php" class="btn btn-large btn-outline-success active">
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
				<div class="row d-flex align-items-center justify-content-center">
					<div class="col-2">Nome</div>
					<div class="col-1">TAM</div>
					<div class="col-2">COR</div>
					<div class="col-2">$ fornecedor</div>
					<div class="col-2">$ cliente</div>
					<!-- <div class="col-2">QTD</div> -->
					<!-- <div class="col-1">Data</div> -->
				</div>
				<br />


				<div class="row d-flex align-items-center justify-content-center">
					<form id="formCadastrar">
						<div class="container-fluid" id="cadastar_produto_todos">
							<div class="row  d-flex align-items-center justify-content-center">
								<div class='col-2 produto'>
									<div>
										<input type="text" name="nomeProduto_cadastrar" maxlength="20">
									</div>
								</div>
								<div class='col-1 produto'>
									<div>
										<input type="text" name="tamanho_cadastrar" maxlength="2">
									</div>
								</div>
								<div class='col-2 produto'>
									<div>
										<input type="text" name="cor_cadastrar" maxlength="20">
									</div>
								</div>
								<div class='col-2 produto'>
									<div>
										<input type="text" name="preco_cadastrar_fornecedor" maxlength="4">
									</div>
								</div>
								<div class='col-2 produto'>
									<div>
										<input type="text" name="preco_cadastrar_cliente" maxlength="4">
									</div>
								</div>
								<!-- <div class='col-2 produto'>
									<div>
										<input type="text" name="qtd_cadastrar" maxlength="3">
									</div>
								</div> -->
								<!-- <div class='col-1 produto'>
									<div>
										<input  type="date" name="data_cadastrar" maxlength="3">
									</div>
								</div> -->
							</div>
						</div>
						<br>
						<button type="reset" class="btn btn-small btn-warning">Resetar tudo</button>					
						<hr>
						<br>
						<div class="row">
							<!-- <div class="col-3">
								<button type="button" id="novo_campo_cadastro" class="btn btn-lg btn-primary">+</button>
								<p>Novo campo registro</p>
							</div> -->
							<div class="col-12">
								<button type="button" class="btn btn-primary" id="btn_cadastar_produto_todos">+</button>
								<p>Cadastrar Todos</p>
							</div>
						</div>
					</form>
				</div>
            </div>
				<div id="sair">
					<button class="btn btn-outline-danger"><a href="sair.php">SAIR</a></button>
				</div>
		</div>

	</div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>