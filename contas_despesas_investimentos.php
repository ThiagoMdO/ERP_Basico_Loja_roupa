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
			//Atualizar container contas
			function atualizar_contas(){
				$.ajax({
					url: 'get_dados_contas.php',

				}).done(function(data){
					$('#contas_despesas_investimentos').html(data);
				});
				
			}
			atualizar_contas();
			atualizarPesquisa();
			$('#nome_conta_despesa_investimento').keyup(function(){
				$.ajax({	
					url: 'get_dados_atividades.php',
					method: 'post',
					data: $('.form_procurar_notas').serialize(),
					/*success: function(data){
						$('#nomeProduto').val('');
						atualizarPesquisa();
					}*/
				}).done(function(data){
					$('#div_resultado_paginacao_contas_despesas').html(data);
				});


			});
			$('#natureza_conta').change(function(){
				$.ajax({	
					url: 'get_dados_atividades.php',
					method: 'post',
					data: $('.form_procurar_notas').serialize(),
					/*success: function(data){
						$('#nomeProduto').val('');
						atualizarPesquisa();
					}*/
				}).done(function(data){
					$('#div_resultado_paginacao_contas_despesas').html(data);
				});


			});
			
			function atualizarPesquisa(){
				$.ajax({
					url:'get_dados_atividades.php',
					success: function(data){
						$('#div_resultado_paginacao_contas_despesas').html(data);
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
		
		function pagar_conta(get_id){
			var dataAtual = new Date();

			var dataFormatada = dataAtual.toISOString().split('T')[0];

			document.getElementById('dateInput').value = dataFormatada;

			$.ajax({
				url: 'pagar_conta.php',
				method: 'post',
				data:  $('#conta'+get_id).serialize(),
				success: function(data){
					alert(data);
				}
			})
		}


		function excluir_conta(get_id){
			$.ajax({
				url: 'excluir_conta.php',
				method: 'post',
				data: $('#conta'+get_id).serialize(),
				success: function(data){
					alert(data);
				}

			})
		}


		function incluir_conta(get_id){
			$.ajax({
				url: 'incluir_conta.php',
				method: 'post',
				data:$('#form_cadastrar_conta').serialize(),
				success: function(){
					if($('#nome_conta').val()!='' && $('#natureza_conta').val()!='' && $('#valor_conta').val()!='' && $('#pago_conta').val()!='' && $('#forma_pagamento_conta').val()!='' && $('#parcelas').val()!='' && $('#vencimento').val()!=''){
						$('#nome_conta').val('');
						$('#valor_conta').val('');
						$('#parcelas').val(1);
					}

					
				}
			}).done(function(data){
				alert(data)
			});
		}
		
	</script>
	<style type="text/css"></style>
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
						<span class="seletores_configuracoes">Caixa</span>
					</div>
				</div>

				<div id="menu_contas" class="row seletores_menu menu_ativo" style="text-align:right;">
					<div class="col-3">
						<span >
							<img src="img/contas_pagar.png" width="30px">
						</span>
					</div>
					<div class="col-9" style="text-align:left;">					
						<span class="seletores_configuracoes">Contas A pagar</span>
					</div>
				</div>

				<div id="menu_controles" class="row seletores_menu" style="text-align:right;">
					<div class="col-3">
						<span >
							<img src="img/controles.png" width="30px">
						</span>
					</div>
					<div class="col-9" style="text-align:left;">					
						<span class="seletores_configuracoes">Controles</span>
					</div>
				</div>

				<div  id="menu_controles_produtos" class="row seletores_menu" style="text-align:right;">
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

				<div class="col-md-12" id="contas_despesas_investimentos">

				</div>

				<div class=" col-md-12">
					<div class="row">
						<div class="col-md-12">
							<form class="form_procurar_notas">
								<div class="row filtro">
									<div class="barra_pesquisa col-6">
										<span class="lupa_pesquisa">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
											  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
											</svg>
										</span>
				                    	<input type="text" id="nome_conta_despesa_investimento" class="barra_pesquisa form-control" placeholder="Pesquisar nome da conta" maxlength="140" name="nome_conta_despesa_investimento">
									</div>
									<div class="col-6">
					                    <select  id="natureza_conta" class="col-3 form-select selects" name="natureza_conta">
					                    	<option value="">Todos Tipos</option>
					                    	<option value="Despesa">Despesa</option>
					                    	<option value="Investimento">Investimento</option>
					                    </select>
									</div>
									
								</div>

			                </form>
						</div>						
					</div>
                	<div class="row d-flex align-items-center info_dados">
						<div class="col-2">Nome</div>
						<div class="col-1">Natureza</div>
						<div class="col-2">Valor</div>
						<div class="col-2">Método</div>
						<div class="col-1">Parcelas</div>
						<div class="col-2">Vencimento</div>
						<div class="col-2">Registrado</div>
					</div>
                </div>
                <hr>
                <div id="div_resultado_paginacao_contas_despesas"></div>
			</div>
		</div>
	</div>
	
	
					
	<div class="container-fluid conteudo_home">
		<div class="row row-down">
			<!-- Modal Exibir itens -->
				<div class="modal fade" id="modal_nova_conta" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="false">
					<div class="modal-dialog">
					    <div class="modal-content">
					    	<div class="modal-header">
						        <h5 class="modal-title" id="modalLabel">Cadastrar nova Conta</h5>
					        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				     	</div>

						<div class="modal-body"  style="text-align: center;">
							<form id="form_cadastrar_conta" >
								<div>
									<div class="input-group mb-3">
										<div class="col-6">
											Descrição da conta:
										</div>
										<div class="col-6">

											<input class="form-control" type="text" name="nome_conta" id="nome_conta" placeholder="Nome da conta">
										</div>
									</div>
									<div class="input-group mb-3">
										<div class="col-6">
											Natureza:
										</div>
										<div class="col-6">
											<select name="natureza_conta" id="natureza_conta" class="form-select">
												<option value="Despesa">Despesa</option>
												<option value="Investimento">Investimento</option>
											</select>
										</div>
									</div>
									<div class="input-group mb-3">
										<div class="col-6">
											Valor da conta:
										</div>
										<div class="col-6">
											<input class="form-control" type="number" name="valor_conta" id="valor_conta" placeholder="Valor">
										</div>
									</div>
									<div class="input-group mb-3">
										<div class="col-6">
											Já foi pago?
										</div>
										<div class="col-6">
											<select name="pago_conta" id="pago_conta" class="form-select">
												<option value="NAO">NÃO</option>
												<option value="SIM">SIM</option>
											</select>
										</div>
									</div>
									<div class="input-group mb-3">
										<div class="col-6">
											Forma de Pagamento:
										</div>
										<div class="col-6">
											<select name="forma_pagamento_conta" id="forma_pagamento_conta" class="form-select">
												<option value="Dinheiro">Dinheiro</option>
												<option value="Debito">Débito</option>
												<option value="Credito">Credito</option>
											</select>
										</div>
									</div>
									<div class="input-group mb-3">
										<div class="col-6">
											Quantidade de parcelas:
										</div>
										<div class="col-6">
											<select name="parcelas" id="parcelas" class="form-select">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											</select>
										</div>
									</div>

								    <div class="input-group mb-3">
										<div class="col-6">
											Data vencimento:
										</div>
										<div class="col-6">
											<input class="form-control" type="date" name="vencimento" id="vencimento">
										</div>
									</div>

									<button class="btn btn-outline-secondary" type="button" id="btn_editar" onclick="incluir_conta()">Cadastrar</button>

						   		</div>
							</form>								
						</div><!-- fim Modal body -->
					</div>
				</div><!-- Fim Modal -->
            </div>
		</div>

	</div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>