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
	
	<script type="text/javascript">
		$(document).ready(function(){
			//Atualizar container caixa
			$.ajax({
				url: 'get_dados_caixa.php',

			}).done(function(data){
				$('#menu_principal').html(data);
			});


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
			

			//Atualizar container contas
			$.ajax({
				url: 'get_dados_contas.php',

			}).done(function(data){
				$('#contas_despesas_investimentos').html(data);
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
		</div><!-- Fim row 1 -->
		
		<div class="row row-down">

			<div class="col-md-4" id="menu_principal"></div>

			<div class="col-md-4" id="contas_despesas_investimentos">
				
			</div>

			<div class="col-md-4">
				<div class="container nav_select d-block">
					<div class="row row-header">
						<h2>CONTROLES</h2>
						<hr>
					</div>
					<div class="row">
						<div class="col-md-12 d-block">
							<div class="row row-space-controle">
								<a href="produto_cadastrar.php" class="plus">Gerenciar Cadastro Produtos</a>
							</div>
							<div class="row row-space-controle">
								<a href="clientes.php" class="plus">Gerenciar Clientes</a>
							</div>
							<div class="row row-space-controle">
								<a href="produto_estoque.php" class="plus">Gerenciar Estoque</a>
							</div>
							<div class="row row-space-controle">
								<a href="historico.php" class="plus">Gerenciar Históricos</a>
							</div>
							<div class="row row-space-controle">
								<a href="fornecedores.php" class="plus">Gerenciar Fornecedores</a>
							</div>
							<div class="row row-space-controle">
								<a href="vender.php" class="plus">Gerenciar Vendas</a>
							</div>
							
						</div>
					</div>
				</div><!-- fim container Controles -->
			</div>
		</div>
		<div id="sair">
			<button class=" btn btn-outline-danger"><a href="sair.php">SAIR</a></button>
		</div>
		<div class="modal fade" id="meuModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalLabel">Editar Manualmente dados</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
		     </div>
		<div class="modal-body">
			<form id="form_incluir_atualiza_saldo">
			    <div>Novo Saldo em dinheiro</div>
			    <p style="color:green;">R$ <span id="saldo_dinheiro"></span></p>
			    <div class="input-group mb-3">
					<button class="btn btn-outline-secondary" type="button" id="atualiza_saldo_dinheiro">Mudar</button>
					<input id="input_inclui_atualiza_saldo_dinheiro" name="novo_saldo_dinheiro" type="number" class="form-control" placeholder="Valor para mudar saldo em mãos" >
				</div>

				<div>Novo Saldo em Banco</div>
			    <p style="color:blue;">R$ <span id="saldo_banco"></span></p>
			    <div class="input-group mb-3">
					<button class="btn btn-outline-secondary" type="button" id="atualiza_saldo_banco">Mudar</button>
					<input id="input_inclui_atualiza_saldo_banco" name="novo_saldo_banco"  type="number" class="form-control" placeholder="Valor para mudar saldo banco" >
				</div>
			        
		        <div>Novo Saldo a Receber</div>
			    <p style="color:brown;">R$ <span id="saldo_receber"></span></p>
			    <div class="input-group mb-3">

					<button class="btn btn-outline-secondary" type="button" id="atualiza_saldo_receber">Mudar</button>
					<input id="input_inclui_atualiza_saldo_receber" name="novo_saldo_receber" type="number" class="form-control" placeholder="Valor para mudar saldo a receber" >

				</div>
			</form>
	    </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<!-- Modal Exibir itens -->

	<div class="modal fade" id="modal_transferir" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalLabel">Editar Manualmente dados</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
		     </div>
		<div class="modal-body">
			<form id="form_transferir_atualiza_saldo">
				<div class="col-12">
					<div class="6">
						<div class="input-group mb-3">

							<input id="input_transfere_atualiza_saldo_receber" name="transferir_novo_saldo" type="number" class="form-control" placeholder="Valor para transferir" >

						</div>
						Transferir de:
						<select name="transferir_de" class="form-select">
							<option value="de_dinheiro">Conta Dinheiro</option>
							<option value="de_banco">Conta Banco</option>
							<option value="de_receber">Conta Receber</option>
						</select>
						
					</div>
					<div class="6">
						Para:
						<select name="transferir_para" class="form-select">
							<option value="para_dinheiro">Conta Dinheiro</option>
							<option value="para_banco">Conta Banco</option>
							<option value="para_receber">Conta Receber</option>
						</select>
					</div>
				</div>
				<br>
				<div class="col-12">
					<button class="btn btn-large btn-outline-primary" type="button" id="transferir">Trocar saldo</button>				
				</div>
			    
			</form>
			<br>
			<div class="col-12" id="resumo_transferencia"></div>
			
	    </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
					
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>