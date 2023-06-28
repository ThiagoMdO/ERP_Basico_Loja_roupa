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

			$.ajax({
				
			});
			
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


	</script>
	<style type="text/css">

		input{
			width: 100%;
		}
	</style>
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
							<a href="vender.php" class="btn btn-large btn-outline-success active">
								<p>Vender</p>
							</a>
						</div>
						
					</div>
				</div>
				<div class="row" id="infomacoes_estoque">

						
					</div>
			</div>
			<div class="col-md-9 border_custom">
				
				<br>
				<div class="row">
					<div class="col-2"></div>
					<div class="col-3">						
						<form class="input-group form_procurar_produtos">
		                    <input type="text" id="nomeProduto" class="form-control" placeholder="Nome Produto" maxlength="140" name="nomeProduto">
		                </form>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-2">foto</div>
					<div class="col-3">Nome</div>
					<div class="col-1">TAM</div>
					<div class="col-2">COR</div>
					<div class="col-2">Preço</div>
					<div class="col-2">QTD</div>
				</div>


		        <br />
	            <div class="row">
	                <div class="col-md-12">
	                    <div id="div_resultado_paginacao"></div>
	                </div>
	            </div>
				</div>
				<div id="sair">
					<button class="btn btn-outline-danger"><a href="sair.php">SAIR</a></button>
				</div>

				

            </div>
		</div>

	</div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>