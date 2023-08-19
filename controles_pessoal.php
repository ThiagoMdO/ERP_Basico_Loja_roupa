<?php 
	session_start();
	if(!isset($_SESSION['nome'])){
		header('Location: index.php?');
	}

	



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

	<!-- Fonts externa -- Google -->
	<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">

	
	<script type="text/javascript">
		$(document).ready(function(){

			//Atualizar container caixa
			function atualizar_caixa(){
				$.ajax({
					url: 'get_dados_caixa.php',

				}).done(function(data){
					$('#menu_principal').html(data);
				});				
			}

			//Atualizar container contas
			function atualizar_contas(){
				$.ajax({
					url: 'get_dados_contas.php',

				}).done(function(data){
					$('#contas_despesas_investimentos').html(data);
				});
				
			}
			atualizar_caixa();
			atualizar_contas();

			
			//Editar saldos_dinheiro
			$('#atualiza_saldo_dinheiro').click(function(){
				$.ajax({
					url: 'incluir_atualiza_saldos.php',
					method: 'post',
					data: $('#form_incluir_atualiza_saldo').serialize(),
					success: function(data){
						$('#input_inclui_atualiza_saldo_dinheiro').val('');

					}
				}).done(function(data){
					$('#saldo_dinheiro').html(data);
				});
			});

			//Editar saldos_banco
			$('#atualiza_saldo_banco').click(function(){
				$.ajax({
					url: 'incluir_atualiza_saldos.php',
					method: 'post',
					data: $('#form_incluir_atualiza_saldo').serialize(),
					success: function(data){
						$('#input_inclui_atualiza_saldo_banco').val('');
					}
				}).done(function(data){
					$('#saldo_banco').html(data);
				});
			});

			//Editar saldos_receber
			$('#atualiza_saldo_receber').click(function(){
				$.ajax({
					url: 'incluir_atualiza_saldos.php',
					method: 'post',
					data: $('#form_incluir_atualiza_saldo').serialize(),
					success: function(data){
						$('#input_inclui_atualiza_saldo_receber').val('');
					}
				}).done(function(data){
					$('#saldo_receber').html(data);
				});
			});

			//Transferir saldos
			$('#transferir').click(function(){
				$.ajax({
					url:'transferir_atualiza_saldos.php',
					method: 'post',
					data: $('#form_transferir_atualiza_saldo').serialize(),
					success: function(){
						$('#input_transfere_atualiza_saldo_receber').val('');
					}

				}).done(function(data){
					$('#resumo_transferencia').html(data)
				});
			})
			
			

			
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
			$('#btn_pg_cadastrar_produto').click(function(){
				window.location.href = "produto_cadastrar.php";
			});
			$('#btn_pg_estoque_loja').click(function(){
				window.location.href = "produto_estoque.php";
			});
			$('#btn_pg_vender_estoque').click(function(){
				window.location.href = "vender.php";
			});


			$('#btn_pg_clientes').click(function(){
				window.location.href = "clientes.php";
			});
			$('#btn_pg_fornecedores').click(function(){
				window.location.href = "fornecedores.php";
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

				<div class="row seletores_menu menu_ativo" style="text-align:right;">
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
				<div class="caixa">
					<div id="tela_informacoes" class="container">
						<div class="top_header_informacoes">
							<h4>Controles - Pessoal</h4>
						</div>
						<div class="dados_saldos d-flex justify-content-between">
							<div class="d-block">
								<div id="btn_pg_clientes" class="opcao_controle ">							
									<img src="img/clientes.png">
								</div>
								<div>
									<h3>Clientes</h3>
								</div>
							</div>
							<div class="d-block">
								<div id="btn_pg_fornecedores" class="opcao_controle ">							
									<img src="img/fornecedores.png">
								</div>
								<div>
									<h3>Fornecedores</h3>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
					
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>