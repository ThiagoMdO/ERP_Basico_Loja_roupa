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
		
	</style>
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

					<div id="menu_controles_produtos" class="row seletores_menu menu_ativo" style="text-align:right;">
						<div class="col-4">
							<span >
								<img src="img/produtos.png" width="30px">
							</span>
						</div>
						<div class="col-8" style="text-align:left;">					
							<span class="seletores_configuracoes">Produtos</span>
						</div>
					</div>

					<div id="menu_cadastrar" class="row seletores_menu menu_ativo" style="text-align:right;">
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

					<div class="row seletores_menu btn_pg_pessoal" style="text-align:right;">
						<div class="col-4">
							<span >
								<img src="img/pessoal.png" width="30px">
							</span>
						</div>
						<div class="col-8" style="text-align:left;">					
							<span class="seletores_configuracoes">Pessoal</span>
						</div>
					</div>

					<div id="menu_clientes" class="row seletores_menu" style="text-align:right;">
						<div class="col-5">
							<span >
								<img src="img/clientes.png" width="30px">
							</span>
						</div>
						<div class="col-7" style="text-align:left;">					
							<span class="seletores_configuracoes">Clientes</span>
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
					<div class="produto_cadastrar">					
					
						<div class="top_header_informacoes">
							<h4>Cadastrar Novo Produto</h4>
						</div>
						<div class="col-md-12 ">				
							<br>
											
							<div class="container">
								<div class="container info_cadastrar d-none d-sm-flex align-items-center justify-content-center">
									
									<div class="col-2 info_produto">Nome</div>
									<div class="col-1 info_produto">TAM</div>
									<div class="col-2 info_produto">COR</div>
									<div class="col-2 info_produto">$ fornecedor</div>
									<div class="col-2 info_produto">$ cliente</div>
									<!-- <div class="col-2">QTD</div> -->
									<!-- <div class="col-1">Data</div> -->
								</div>
							</div>
							<br />


							<div class="container info_cadastrar d-flex align-items-center justify-content-center">

								<form id="formCadastrar">
									<div class="container-fluid" id="cadastar_produto_todos">
										<div class="d-block d-sm-flex align-items-center justify-content-center">	
											<div class='col-sm-12 col-md-2 produto'>
												<div>
													<input type="text" name="nomeProduto_cadastrar" placeholder="Nome" maxlength="20">
												</div>
											</div>
											<div class='col-sm-12 col-md-1 produto'>
												<div>
													<input type="text" name="tamanho_cadastrar" placeholder="Tamanho" maxlength="2">
												</div>
											</div>
											<div class='col-sm-12 col-md-2 produto'>
												<div>
													<input type="text" name="cor_cadastrar" placeholder="Cor" maxlength="20">
												</div>
											</div>
											<div class='col-sm-12 col-md-2 produto'>
												<div>
													<input type="text" name="preco_cadastrar_fornecedor" placeholder="$Fornecedor" maxlength="4">
												</div>
											</div>
											<div class='col-sm-12 col-md-2 produto'>
												<div>
													<input type="text" name="preco_cadastrar_cliente" placeholder="$Cliente" maxlength="4">
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
									<button type="reset" class="btn btn_cadastro btn_resetar_cadastro_produto">Resetar tudo</button>
									
										<!-- <div class="col-3">
											<button type="button" id="novo_campo_cadastro" class="btn btn-lg btn-primary">+</button>
											<p>Novo campo registro</p>
									</div> -->
									<div class="col-12">
										<button type="button" class="btn btn_cadastro btn_adicionar_cadastro_produto" id="btn_cadastar_produto_todos">Cadastrar</button>
									</div>
								</div>
							</form>
						</div>
		            </div>
				</div>
			</div>
		</div>
	<div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>