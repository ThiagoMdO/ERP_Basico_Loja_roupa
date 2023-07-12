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
			//atualizarPesquisa();
			atualizarQtd();

			/*$('.pesquisa').keyup(function(){
				atualizarQtd();
				return false; //para não ativar a trigger de submit do formulário
			});*/
			/*$('#nome_cliente').keyup(function(){
				$('#nome_fornecedor').val(false);
			});
			$('#nome_fornecedor').keyup(function(){
				$('#nome_cliente').val(false);
			})*/

			$('#btn_pesquisar').click(function(){
				atualizarQtd();
				return false; //para não ativar a trigger de submit do formulário
			});

			$('#registros_por_pagina').change(function(){
				atualizarQtd();
				return false; //para não ativar a trigger de submit do formulário
			});


			//campos inputs historico
			var class_inputs_historico = $('.inputs_historico');
			var class_inputs_historico_contas = $('.inputs_historico_contas');
			var historico_vendas_cliente = $('#nome_cliente');
			var historico_nome_produto = $('#nome_produto');
			var historico_compras_fornecedores = $('#nome_fornecedor');
			var historico_contas_despesas_investimentos = $('#historico_contas_despesas_investimentos');
			var historico_nome_produto_alteracao = $('#nome_produto_alteracao');

			//selects
			var historico_contas_select = $('#historico_contas_select');
			var registros_por_pagina_contas = $('#registros_por_pagina_contas');
			var historico_cadastro_select = $('#historico_cadastro_select');
			var historico_cadastro_select_tipo = $('#historico_cadastro_select_tipo');
			var registros_por_pagina_alteracoes = $('#registros_por_pagina_alteracoes');

			//botoes de historicos
			var class_btn_historico = $('.btn_historico');
			var btn_historico_vendas = $('#btn_historico_vendas');
			var btn_historico_compras = $('#btn_historico_compras');
			//var btn_historico_devolucoes = $('#btn_historico_devolucoes');//posteriormente
			var btn_historico_contas = $('#btn_historico_contas');
			var btn_historico_alteracoes = $('#btn_historico_alteracoes');

			//forms historico
			var form_historico_vendas_compras = $('#form_historico_vendas_compras');
			var paginacao_cadastro = $('#paginacao_cadastro');

			
			var relacao_contas = $('.relacao_contas');
			var relacao_cadastro = $('.relacao_cadastro');

			
			//Comando padrao para todos .btn_historico
			class_btn_historico.click(function(){

				class_btn_historico.removeClass('active');

				class_inputs_historico.addClass('d-none');
				class_inputs_historico.val(false);

				form_historico_vendas_compras.addClass('d-none');
				
				relacao_contas.addClass('d-none');
				relacao_cadastro.addClass('d-none');

			});


			//btn VENDAS - CLIENTES
			btn_historico_vendas.click(function(){

				btn_historico_vendas.addClass('active');

				historico_vendas_cliente.removeClass('d-none');
				historico_nome_produto.removeClass('d-none');
				historico_nome_produto.val('');

				historico_vendas_cliente.val('%%');
				atualizarQtd();
				historico_vendas_cliente.val('');

				form_historico_vendas_compras.removeClass('d-none');				

				
			});
			class_inputs_historico.keyup(function(){
				atualizarQtd();

			});

			
			//btn COMPRAS - FORNECEDORES
			btn_historico_compras.click(function(){

				btn_historico_compras.addClass('active');

				historico_compras_fornecedores.removeClass('d-none');
				historico_nome_produto.removeClass('d-none');
				historico_nome_produto.val('');

				historico_compras_fornecedores.val('%%');
				atualizarQtd();
				historico_compras_fornecedores.val('');

				form_historico_vendas_compras.removeClass('d-none');


			});
			class_inputs_historico_contas.keyup(function(){
				atualizarContas();
			});
			

			//btn CONTAS - DESPESAS E INVESTIMENTOS
			btn_historico_contas.click(function(){
				btn_historico_contas.addClass('active');
				relacao_contas.removeClass('d-none');
				historico_contas_despesas_investimentos.removeClass('d-none');

				historico_contas_despesas_investimentos.val('%%');
				atualizarContas();
				historico_contas_despesas_investimentos.val('');

			});

			historico_contas_select.change(function(){
				atualizarContas();
			})

			registros_por_pagina_contas.change(function(){
				atualizarContas();
			})


			//btn CADASTRO - Produtos, Clientes, Fornecedores 
			btn_historico_alteracoes.click(function(){
				btn_historico_alteracoes.addClass('active');
				relacao_cadastro.removeClass('d-none');
				atualiza_historico_alteracoes();

			});
			historico_nome_produto_alteracao.keyup(function(){
				atualiza_historico_alteracoes();
			});

			historico_cadastro_select.change(function(){
				atualiza_historico_alteracoes();
			});
			historico_cadastro_select_tipo.change(function(){
				atualiza_historico_alteracoes();
			})
			registros_por_pagina_alteracoes.change(function(){
				atualiza_historico_alteracoes();
			})


			
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

                        var offset_atualizado = pagina_clicada * registros_por_pagina;
                        //aplica o valor atualizado do offset ao campo do form
                        $('#offset').val(offset_atualizado);

                        //refaz a pesquisa (chamada recursiva do método)
                        
                        $('#btn_pesquisar').click();
                    });

				});
			}

			function atualizarContas(){
				$.ajax({
					url:'get_historico_contas.php',
					method: 'post',
					data: $('#form_contas').serialize()
				}).done(function(data){
					$('#div_resultado_paginacao_historico').html(data);
					//ação que será tomada após clicar no link de paginação
                    $('.paginar_contas').click(function(){


                        var pagina_clicada = $(this).data('pagina_clicada');
                        pagina_clicada = pagina_clicada - 1; //necessário para ajustar o parâmetro offset = 0
                       
                        //recupera os parametros de paginacao do formulario
                        var registros_por_pagina = $('#registros_por_pagina_contas').val(); // = 5

                        var offset_atualizado = pagina_clicada * registros_por_pagina;
                        //aplica o valor atualizado do offset ao campo do form
                        $('#offset_contas').val(offset_atualizado);

                        //refaz a pesquisa (chamada recursiva do método)
                        
                       	atualizarContas();
                    });

				});;
			}

			function atualiza_historico_alteracoes(){
				$.ajax({
					url: 'get_historico_alteracoes.php',
					method: 'post',
					data: $('#historico_alteracoes').serialize(),
				}).done(function(data){
					$('#div_resultado_paginacao_historico').html(data);
					//ação que será tomada após clicar no link de paginação
                    $('.paginar_alteracoes').click(function(){

                        var pagina_clicada = $(this).data('pagina_clicada');
                        pagina_clicada = pagina_clicada - 1; //necessário para ajustar o parâmetro offset = 0
                       
                        //recupera os parametros de paginacao do formulario
                        var registros_por_pagina = $('#registros_por_pagina_alteracoes').val(); // = 5

                        var offset_atualizado = pagina_clicada * registros_por_pagina;
                        //aplica o valor atualizado do offset ao campo do form
                        $('#offset_alteracoes').val(offset_atualizado);

                        //refaz a pesquisa (chamada recursiva do método)
                        
                        atualiza_historico_alteracoes();
                    });

				});
			}


			btn_historico_vendas.click();


		});
		
			function excluir_historico(get_id) {
				$.ajax({
					url: 'excluir_historico.php',
					method: 'post',
					data: $('#form_historico_'+get_id).serialize(),
					success: function(data){
						alert(data);
					}

				});
			}

			function excluir_historico_conta(get_id) {
				$.ajax({
					url: 'excluir_historico_contas.php',
					method: 'post',
					data: $('#form_historico_contas'+get_id).serialize(),
					success: function(data){
						alert(data);
					}

				});
			}

		
	
		
		
		


	</script>
	<style type="text/css">

		input{
			width: 100%;
		}
		*{
		text-decoration: none;
		list-style: none;
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
						<button id="btn_historico_vendas" class="btn btn-large btn-outline-primary btn_historico active">Histórico de Vendas</button>
						<button id="btn_historico_compras" class="btn btn-large btn-outline-primary btn_historico">Histórico de Compras</button>					
					</div>
					<div class="col-md-4">
						<!-- <button id="" class="btn btn-large btn-outline-primary btn_historico">Histórico de Devoluções</button>	 -->				
						<button id="btn_historico_contas" class="btn btn-large btn-outline-primary btn_historico">Histórico de Contas</button>					
					</div>
					<div class="col-md-4">					
						<button id="btn_historico_alteracoes" class="btn btn-large btn-outline-primary btn_historico">Histórico de Alterações</button>					
					</div>
	           	</div>
	           	<br>
				<div class="row">
					<!-- HISTORICO DE VENDAS E COMPRAS -->
					<div class="col-md-12">	
						<form id="form_historico_vendas_compras" class="input-group form_procurar_historico">					
		                    <div class="form-group d-none">
		                        <input type="text" class="form-control" name="offset" id="offset" value="0"/>
							</div>
							<div class="col-4">
		                    	<input type="text" id="nome_cliente" class="form-control inputs_historico" placeholder="Procurar Cliente" maxlength="140" name="nome_cliente">
		                    	<input type="text" id="nome_fornecedor" class="form-control inputs_historico d-none" placeholder="Procurar Fornecedor" maxlength="140" name="nome_fornecedor">
								
							</div>
							<div class="col-4">
		                    	<input type="text" id="nome_produto" class="form-control inputs_historico" placeholder="Procurar Produto" maxlength="140" name="nome_produto">								
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
			                    <button type="button" class="btn btn-primary d-none" id="btn_pesquisar">Filtro</button>
		            	</form>
		            	<!-- FIM HISTORICO DE VENDAS E COMPRAS -->


		            	<!-- HISTORICO DE CONTAS -->
		            	<div class="relacao_contas" class="col-12 d-flex align-items-center d-none">
		            		<form id="form_contas">
		            			<div class="form-group d-none">
			                        <input type="text" class="form-control" name="offset_contas" id="offset_contas" value="0"/>
								</div>
			            		<div class="col-12">
			            			<div class="row">
			            				<div class="col-4">
					            			<input type="text" id="historico_contas_despesas_investimentos" class="form-control inputs_historico_contas" placeholder="Procurar Conta" maxlength="140" name="historico_contas_despesas_investimentos">
			            				</div>
			            				<div class="col-4">
			            					<select class="form-select" id="historico_contas_select" name="historico_contas_select">
			            						<option value="">Todos</option>
			            						<option value="Despesa">Despesas</option>
			            						<option value="Investimento">Investimentos</option>
			            					</select>
			            					<input type="text" id="historico_contas_investimento" class="form-control inputs_historico_contas d-none" placeholder="Procurar Investimento" maxlength="140" name="historico_contas_investimento">
			            				</div>
		            					<div id="paginacao_contas" class="form-group col-4">
						                    <select class="form-select" id="registros_por_pagina_contas" name="registros_por_pagina_contas">
						                    	<option value="5">5</option>
						                    	<option value="10">10</option>
						                    	<option value="20">20</option>
						                    	<option value="40">40</option>
						                    	<option value="80">80</option>
						                    </select>
						                </div>
			            			</div>
			            			
			            		</div>
		            		</form><!-- Fim form contas -->
						</div><!-- fim relacao contas -->
						
            			<!-- FIM HISTORICO DE CONTAS -->

            			<!-- HISTORICO DE CADASTROS -->
            			<div class="col-12 d-none relacao_cadastro" >
            				<form id="historico_alteracoes">
            					<div class="form-group d-none">
			                        <input type="text" class="form-control" name="offset_alteracoes" id="offset_alteracoes" value="0"/>
								</div>
			            		<div class="col-12">
			            			<div class="row ">
			            				<div class="col-3">
					            			<input type="text" id="nome_produto_alteracao" class="form-control inputs_historico_cadastro" placeholder="Procurar por Nome" maxlength="140" name="nome_produto_alteracao">
			            				</div>
			            				<div class="col-3">
			            					<select class="form-select" id="historico_cadastro_select" name="historico_cadastro_select">
			            						<option value="produtos">Produtos</option>
			            						<option value="clientes">Clientes</option>
			            						<option value="fornecedores">Fornecedores</option>
			            					</select>
			            				</div>
			            				<div class="col-3">
			            					<select class="form-select" id="historico_cadastro_select_tipo" name="historico_cadastro_select_tipo">
			            						<option value="">Todos</option>
			            						<option value="Cadastro">Cadastro</option>
			            						<option value="Edicao">Edição</option>
			            						<option value="Excluidos">Excluidos</option>
			            					</select>
			            				</div>
		            					<div id="paginacao_cadastro" class="form-group col-3">
						                    <select class="form-select" id="registros_por_pagina_alteracoes" name="registros_por_pagina_alteracoes">
						                    	<option value="5">5</option>
						                    	<option value="10">10</option>
						                    	<option value="20">20</option>
						                    	<option value="40">40</option>
						                    	<option value="80">80</option>
						                    </select>
						                </div>
			            			</div>
			            		</div>
            				</form><!-- fim form historico alterações -->
            			</div>
            			
            			<!-- FIM HISTORICO DE CADASTROS -->
					</div>
				</div><!-- Fim barras de pesquisas -->
				<br>
	            <div class="row">
				<br>
	                <div class="col-md-12">
	                    
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