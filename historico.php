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
			atualizarQtd();
			$('.pesquisa').keyup(function(){
				atualizarQtd();
				return false; //para não ativar a trigger de submit do formulário
			});
			$('#nome_cliente').keyup(function(){
				$('#nome_fornecedor').val(false);
			});
			$('#nome_fornecedor').keyup(function(){
				$('#nome_cliente').val(false);
			})

			$('#btn_pesquisar').click(function(){
				atualizarQtd();
				return false; //para não ativar a trigger de submit do formulário
			});

			$('#registros_por_pagina').change(function(){
				atualizarQtd();
				return false; //para não ativar a trigger de submit do formulário
			});


			//botoes de historicos
			var historico_vendas_cliente = $('#nome_cliente');
			var historico_compras_fornecedores = $('#nome_fornecedor');

			var btn_historico_vendas = $('#btn_historico_vendas');
			var btn_historico_compras = $('#btn_historico_compras');

			var relacionado = $('#relacionado');


			$('#btn_historico_vendas').click(function(){
				btn_historico_vendas.addClass('active');
				btn_historico_compras.removeClass('active');

				relacionado.html('Cliente');

				historico_compras_fornecedores.val(false);
				historico_vendas_cliente.val(' ');
				historico_compras_fornecedores.addClass('d-none');
				historico_vendas_cliente.removeClass('d-none');

				atualizarQtd();
			});

			$('#btn_historico_compras').click(function(){
				btn_historico_compras.addClass('active');
				btn_historico_vendas.removeClass('active');

				relacionado.html('Fornecedor');

				historico_vendas_cliente.val(false);
				historico_compras_fornecedores.val(' ');
				historico_vendas_cliente.addClass('d-none');
				historico_compras_fornecedores.removeClass('d-none');
				atualizarQtd();

			});

			function atualizarQtd(){
				$.ajax({
					url: 'get_historico.php',
					method: 'post',
					data: $('.form_procurar_historico').serialize(),					
				}).done(function(data){
					$('#div_resultado_paginacao_historico').html(data);
					//ação que será tomada após clicar no link de paginação
                    $('.paginar').click(function(){

                        var pagina_clicada = $(this).data('pagina_clicada');
                        pagina_clicada = pagina_clicada - 1; //necessário para ajustar o parâmetro offset = 0
                       
                        //recupera os parametros de paginacao do formulario
                        var registros_por_pagina = $('#registros_por_pagina').val(); // = 5
                        var pagina_atual = $('#pagina_atual').val(); // 

                        var offset_atualizado = pagina_clicada * registros_por_pagina;
                        //aplica o valor atualizado do offset ao campo do form
                        $('#offset').val(offset_atualizado);

                        //refaz a pesquisa (chamada recursiva do método)
                        $('#btn_pesquisar').click();
                    });

				});
			}
			function atualizarPesquisa(){
				$.ajax({
					url:'get_historico.php',
					success: function(data){
						$('#div_resultado_paginacao_historico').html(data);
					}
				})
			}

			

		});
		
			function excluir_historico(get_id) {
			$.ajax({
				url: 'excluir_historico.php',
				method: 'post',
				data: $('#form_historico_'+get_id).serialize(),
				success: function(data){
					alert(data);
				}

				})
			}

		
	
		
		
		


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
							<a href="fornecedores.php" class="btn btn-large btn-outline-success">
								<p>Fornecedores</p>
							</a>
						</div>
						<div class="col-12 menu_lateral">
							<a href="historico.php" class="btn btn-large btn-outline-success active">
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
	           	<div class="row">
	           		

					<div class="col-md-4">
						<button id="btn_historico_vendas" class="btn btn-large btn-outline-primary active">Histórico de Vendas</button>
						<button id="btn_historico_compras" class="btn btn-large btn-outline-primary">Histórico de Compras</button>					
					</div>
					<div class="col-md-4">
						<button id="" class="btn btn-large btn-outline-primary">Histórico de Despesas</button>					
						<button class="btn btn-large btn-outline-primary">Histórico de Investimentos</button>					
					</div>
					<div class="col-md-4">
						<button class="btn btn-large btn-outline-primary">Histórico de Edição</button>					
						<button class="btn btn-large btn-outline-primary">Histórico de Cadastros</button>					
					</div>
	           	</div>
	           	<br>
				<div class="row">
					<div class="col-md-12">	
						<form class="input-group form_procurar_historico">					
		                    <div class="form-group d-none">
		                        <input type="text" class="form-control" name="offset" id="offset" value="0"/>
							</div>
							<div class="col-4">
		                    	<input type="text" id="nome_cliente" class="form-control pesquisa" placeholder="Procurar Cliente" maxlength="140" name="nome_cliente">
		                    	<input type="text" id="nome_fornecedor" class="form-control pesquisa d-none" placeholder="Procurar Fornecedor" maxlength="140" name="nome_fornecedor">
								
							</div>
							<div class="col-4">
		                    	<input type="text" id="nome_produto" class="form-control pesquisa" placeholder="Procurar Produto" maxlength="140" name="nome_produto">								
							</div>
				           	<div id="paginacao" class="form-group col-3">
			                    <select class="form-select" id="registros_por_pagina" name="registros_por_pagina">
			                    	<option value="5">5</option>
			                    	<option value="10">10</option>
			                    	<option value="20">20</option>
			                    	<option value="40">40</option>
			                    	<option value="80">80</option>
			                    </select>
			                </div>
			                    <button type="button" class="btn btn-primary" id="btn_pesquisar">Filtro</button>
		            	</form>
				</div>
				<br>
	            <div class="row">
				<br>
	                <div class="col-md-12">
	                    <div>
	                    	<div class="row">
								<div id="relacionado" class="col-2">Cliente</div>
								<div class="col-8">Descrição venda</div>
								<div class="col-2">Data</div>
							</div>
	                    </div>
	                    <div id="div_resultado_paginacao_historico">
	                    </div>
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