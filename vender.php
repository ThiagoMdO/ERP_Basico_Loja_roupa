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

			atualizarPesquisa();
			atualizarValorEstoque();
			$('#nomeProduto').keyup(function(){
				$.ajax({
					url: 'get_produtos_vender.php',
					method: 'post',
					data: $('.form_procurar_produtos').serialize(),
					/*success: function(data){
						$('#nomeProduto').val('');
						atualizarPesquisa();
					}*/
				}).done(function(data){
					$('#div_resultado_paginacao').html(data);
				});
			});

			$('.btn_vender').click(function(){
				alert('vendido');
			});
			$('.btn_editar_item').click(function(){
				alert('tem certeza');
			});
			function atualizarPesquisa(){
				$.ajax({
					url:'get_produtos_vender.php',
					success: function(data){
						$('#div_resultado_paginacao').html(data);
					}
				}).done(function(){
					atualizarValorEstoque();
				});
			}

			function atualizarValorEstoque(){
				$.ajax({
					url:'informacoes_estoque.php',
					success: function(data){
						$('#infomacoes_estoque').html(data);
					}
				})
			}
			
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
		

		function venderProduto(id_produto){
			$.ajax({
				url: 'vender_produtos.php',
				method: 'post',
				data: $('#form_produto_'+id_produto).serialize(),
				success: function(data){
					var qtd_disponivel = $('#exibir_qtd_produto_'+id_produto).val();
					var qtd_vender = $('#produto_quantidade_'+id_produto).val();
					var qtd_disponivel = qtd_disponivel * 1;
					var qtd_vender = qtd_vender *1;
					
					if(qtd_vender<=qtd_disponivel){
						var sub = qtd_disponivel - qtd_vender;
						alert(data);
						$('#exibir_qtd_produto_'+id_produto).val(sub);
					}else{
						alert('Quantidade indisponível');
						return false;
					}
				}
			})

			
		}

		function visualizarSubTotal(id_subTotal) {

			$.ajax({
				success: function(){
					var preco_produto = $('#exibir_preco_produto_'+id_subTotal).val();
					var parcelas = $('#parcelas_'+id_subTotal).val();
					var desconto_reais = $('#desconto_'+id_subTotal).val();
					var taxa = $('#taxa_'+id_subTotal).val();
					var qtd_disponivel_1 = $('#exibir_qtd_produto_'+id_subTotal).val();
					var qtd_vender_1 = $('#produto_quantidade_'+id_subTotal).val();
					var subtotal = 0;
					var subtotal_mes = 0;

					subtotal = qtd_vender_1*preco_produto;
					subtotal *= taxa;
					subtotal -= desconto_reais;
					subtotal = subtotal.toFixed(2);
					subtotal_mes = subtotal/parcelas;
					subtotal_mes = subtotal_mes.toFixed(2);
					$('#subtotal_'+id_subTotal).val('R$'+subtotal_mes+' x '+parcelas+' mês(meses) total de: R$'+subtotal);
					
					
					/*
					if(qtd_vender<=qtd_disponivel){
						subtotal = preco_produto*qtd_vender;
						alert(subtotal);
					}else{
						alert('Quantidade indisponível');
					}*/
				}
			});
		}
		function passar_pagina_posterior(){
			$.ajax({
				url:'get_produtos_vender.php',
				method: 'post',
				data:$('#form_passar_pagina_posterior').serialize(),
				
			}).done(function(data){
				$('#div_resultado_paginacao').html(data);
			});
		}

		function passar_pagina_anterior(){
			$.ajax({
				url:'get_produtos_vender.php',
				method: 'post',
				data:$('#form_passar_pagina_anterior').serialize(),
				success: function(){
					
				}
			}).done(function(data){
				$('#div_resultado_paginacao').html(data);
			});
		}

	</script>
	<style type="text/css">

		input{
			width: 100%;
		}
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

				<div id="menu_vender" class="row seletores_menu menu_ativo" style="text-align:right;">
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
				<div class="row" id="infomacoes_estoque"></div>
			</div>
			
			<div class="col-md-8 tela_informacoes tela_produtos">
				<div class="top_header_informacoes">
						<h4>Vender Produtos Loja Roupa</h4>
					</div>
				<div class="row">
					<div class="col-md-3">
						<form class="input-group form_procurar_produtos">
							<div class="barra_pesquisa col-6">
								<span class="lupa_pesquisa">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
									  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
									</svg>
								</span>
		                    	<input type="text" id="nomeProduto" class="barra_pesquisa form-control" placeholder="Pesquisar nome do produto" maxlength="140" name="nomeProduto">
							</div>
							
		                </form>						
					</div>
					
				</div>
	            <div class="row">
	                <div class="col-md-12">
	                    <div id="div_resultado_paginacao"></div>
	                </div>
	            </div>
			</div>
		</div>
	</div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>