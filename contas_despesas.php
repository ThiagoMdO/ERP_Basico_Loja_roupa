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
			$('#nome_fornecedor').keyup(function(){
				$.ajax({
					url: 'get_dados_atividades.php',
					method: 'post',
					//data: $('.form_procurar_fornecedor').serialize(),
					/*success: function(data){
						$('#nomeProduto').val('');
						atualizarPesquisa();
					}*/
				}).done(function(data){
					$('#div_resultado_paginacao_fornecedores').html(data);
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
			
			


		});
		
		function pagar_conta(get_id){
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
						$('#natureza_conta').val('');
						$('#valor_conta').val('');
						$('#pago_conta').val('');
						$('#forma_pagamento_conta').val('');
						$('#parcelas').val('');
						$('#vencimento').val('');
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
	<div class="container-fluid conteudo_home">

		<div class="row row-up d-flex justify-content-center align-items-center">
			<?php
				include_once 'menu_principal.php';
			?>
		</div><!-- Fim row 1 -->
		<div class="row row-down">
			
			
			
			<div class="col-md-12 border_custom">
				
				<br>
                <div class="col-12">
                	<a href="home.php"><button class="btn btn-large btn-outline-primary">VOLTAR</button></a>
                </div>
                <div class="col-12">
                	<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal_nova_conta" id="">+ Nova Conta</button>
                </div>
	           	<br>
				

				<br>
	            <div class="container-fluid">
				<br>
					<div class="col-md-3">						
						<form class="input-group form_procurar_fornecedor">
		                    <input type="text" id="nome_conta_despesa" class="form-control" placeholder="Nome Conta" maxlength="140" name="nome_conta_despesa">
		                </form>
					</div>

	                    <div class=" col-md-12">
	                    	<div class="row d-flex align-items-center">
								<div class="col-2">Nome</div>
								<div class="col-2">Natureza</div>
								<div class="col-2">Valor</div>
								<div class="col-2">Forma de Pagamento</div>
								<div class="col-1">Parcelas</div>
								<div class="col-2">Vencimento</div>
							</div>
	                    </div>
	                    <div id="div_resultado_paginacao_contas_despesas">
	                    </div>
	               
	            </div>
				</div>
				<div id="sair">
					<button class="btn btn-outline-danger"><a href="sair.php">SAIR</a></button>
				</div>

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
												<option value="SIM">SIM</option>
												<option value="NAO">NÃO</option>
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