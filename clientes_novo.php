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

			$('#menu_caixa').click(function(){
				window.location.href = "home.php";
			});
			$('#menu_contas').click(function(){
				window.location.href = "contas_despesas_investimentos.php";				
			});
			$('#menu_cadastrar').click(function(){
				window.location.href = "produto_cadastrar.php";
			});
			$('#menu_estoque').click(function(){
				window.location.href = "produto_estoque.php";
			});
			$('#menu_vender').click(function(){
				window.location.href = "vender.php";
			});
			$('#menu_clientes').click(function(){
				window.location.href = "clientes.php";
			});
			$('#menu_fornecedores').click(function(){
				window.location.href = "fornecedores.php";
			});
			$('#menu_historico').click(function(){
				window.location.href = "historico.php";
			});
			$('#menu_controles').click(function(){
				window.location.href = "controles.php";
			});
			$('#menu_controles_produtos').click(function(){
				window.location.href = "controles_produtos.php";
			});
			


			//btns_navegar_paginas_controles

			
			$('#btn_pg_produtos').click(function(){
				window.location.href = "controles_produtos.php";
			});
			$('#btn_pg_cadastrar_produto').click(function(){
				window.location.href = "produto_cadastrar.php";
			});
			$('#btn_pg_estoque_loja').click(function(){
				window.location.href = "produto_estoque.php";
			});
			$('#btn_pg_vender_estoque').click(function(){
				window.location.href = "vender.php";
			});

			
			$('.btn_pg_pessoal').click(function(){
				window.location.href = "controles_pessoal.php";
			});
			$('.btn_pg_clientes').click(function(){
				window.location.href = "clientes.php";
			});
			$('.btn_pg_fornecedores').click(function(){
				window.location.href = "fornecedores.php";
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
	<?php
		include_once 'menu_principal.php';
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="configuracoes col-md-3">
				<div class="top_configuracoes">
					<span id="navbar_config">
						<img src="img/navbar_icon.png" width="40px">
					</span>
					<span class="titulo_configuracoes">Configurações</span>
				</div>			

				<div id="menu_caixa" class="row seletores_menu" style="text-align:right;">
					<div class="col-3">
						<span >
							<img src="img/caixa.png" width="30px">
						</span>
					</div>
					<div class="col-9" style="text-align:left;">					
						<span class="seletores_configuracoes ">Caixa</span>
					</div>
				</div>

				<div id="menu_contas" class="row seletores_menu" style="text-align:right;">
					<div class="col-3">
						<span >
							<img src="img/contas_pagar.png" width="30px">
						</span>
					</div>
					<div class="col-9" style="text-align:left;">					
						<span class="seletores_configuracoes">Contas A pagar</span>
					</div>
				</div>

				<div id="menu_controles" class="row seletores_menu menu_ativo" style="text-align:right;">
					<div class="col-3">
						<span >
							<img src="img/controles.png" width="30px">
						</span>
					</div>
					<div class="col-9" style="text-align:left;">					
						<span class="seletores_configuracoes">Controles</span>
					</div>
				</div>

				<div id="menu_controles_produtos" class="row seletores_menu" style="text-align:right;">
					<div class="col-4">
						<span >
							<img src="img/produtos.png" width="30px">
						</span>
					</div>
					<div class="col-8" style="text-align:left;">					
						<span class="seletores_configuracoes">Produtos</span>
					</div>
				</div>

				<div id="menu_cadastrar" class="row seletores_menu" style="text-align:right;">
					<div class="col-5">
						<span >
							<img src="img/cadastro_produto.png" width="30px">
						</span>
					</div>
					<div class="col-7" style="text-align:left;">					
						<span class="seletores_configuracoes">Cadastrar</span>
					</div>
				</div>

				<div id="menu_estoque" class="row seletores_menu" style="text-align:right;">
					<div class="col-5">
						<span >
							<img src="img/estoque_produto.png" width="30px">
						</span>
					</div>
					<div class="col-7" style="text-align:left;">					
						<span class="seletores_configuracoes">Estoque</span>
					</div>
				</div>

				<div id="menu_vender" class="row seletores_menu" style="text-align:right;">
					<div class="col-5">
						<span >
							<img src="img/vender_produto.png" width="30px">
						</span>
					</div>
					<div class="col-7" style="text-align:left;">					
						<span class="seletores_configuracoes">Vender</span>
					</div>
				</div>

				<!-- Fim produtos -->

				<div class="row seletores_menu menu_ativo btn_pg_pessoal" style="text-align:right;">
					<div class="col-4">
						<span >
							<img src="img/pessoal.png" width="30px">
						</span>
					</div>
					<div class="col-8" style="text-align:left;">					
						<span class="seletores_configuracoes">Pessoal</span>
					</div>
				</div>

				<div id="menu_clientes" class="row seletores_menu menu_ativo" style="text-align:right;">
					<div class="col-5">
						<span >
							<img src="img/clientes.png" width="30px">
						</span>
					</div>
					<div class="col-7" style="text-align:left;">					
						<span class="seletores_configuracoes">Clientes +</span>
					</div>
				</div>

				<div id="menu_fornecedores" class="row seletores_menu" style="text-align:right;">
					<div class="col-5">
						<span >
							<img src="img/fornecedores.png" width="30px">
						</span>
					</div>
					<div class="col-7" style="text-align:left;">					
						<span class="seletores_configuracoes">Fornecedores</span>
					</div>
				</div>

				<!-- Fim Pessoal -->

				<div id="menu_historico" class="row seletores_menu" style="text-align:right;">
					<div class="col-3">
						<span >
							<img src="img/historico.png" width="30px">
						</span>
					</div>
					<div class="col-9" style="text-align:left;">					
						<span class="seletores_configuracoes">Historico</span>
					</div>
				</div>
			</div>
			
			<div class="col-md-8 tela_informacoes">
				<div class="row">
					<div class="top_header_informacoes">
						<h4>Cadastrar Cliente</h4>
					</div>
					
					<form id="cadastrar_cliente" class="col-md-7">
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
							<input id="novo_cliente_uf" name="novo_cliente_uf" type="text" class="form-control" placeholder="UF cliente, Ex: BA">
						</div>
						<div class="input-group mb-3">						
							<input id="novo_cliente_ceep" name="novo_cliente_ceep" type="text" class="form-control" placeholder="CEEP cliente">
						</div>
						<button class="btn btn-outline-primary" type="button" id="btn_cadastrar_cliente" >Cadastrar</button>
						<a href="clientes.php"><button class="btn btn-outline-secondary" type="button">Voltar</button></a>
	           		</form>

		            <div class="col-md-5 d-flex align-items-center">
		            	<img src="img/icone.png" width="100%" style="border-radius: 4px;">
		            </div>
				</div>
			</div>
		</div>
	</div>
		
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>