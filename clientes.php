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
			$('#nomeCliente').keyup(function(){
				$.ajax({
					url: 'get_clientes.php',
					method: 'post',
					data: $('.form_procurar_clientes').serialize(),
					/*success: function(data){
						$('#nomeProduto').val('');
						atualizarPesquisa();
					}*/
				}).done(function(data){
					$('#div_resultado_paginacao_clientes').html(data);
				});


			});

			
			function atualizarPesquisa(){
				$.ajax({
					url:'get_clientes.php',
					success: function(data){
						$('#div_resultado_paginacao_clientes').html(data);
					}
				}).done(function(){
					atualizarValorEstoque();
				});
			}

			function atualizarValorEstoque(){
				$.ajax({
					url:'informacoes_estoque.php',
					success: function(data){
						$('#infomacoes_clientes').html(data);
					}
				})
			}
			

		});
		

		function excluir_cliente(get_id) {
			$.ajax({
				url: 'excluir_clientes.php',
				method: 'post',
				data: $('#form_passar_dados'+get_id).serialize(),
				success: function(data){
					alert(data);
				}

			})
		}

		function atualizar_cliente(id_cliente){
			$.ajax({
				url: 'editar_clientes.php',
				method: 'post',
				data:$('#form_alterar_dados_clientes_'+id_cliente).serialize(),
				success: function(data){
					alert(data);
					$('#editar_nome_cliente'+id_cliente).val('');
					$('#editar_cpf_cliente'+id_cliente).val('');
					$('#editar_telefone_cliente'+id_cliente).val('');
					$('#editar_rua_cliente'+id_cliente).val('');
					$('#editar_numero_casa_cliente'+id_cliente).val('');
					$('#editar_bairro_cliente'+id_cliente).val('');
					$('#editar_cidade_cliente'+id_cliente).val('');
					$('#editar_uf_cliente'+id_cliente).val('');
					$('#editar_ceep_cliente'+id_cliente).val('');
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
							<a href="clientes.php" class="btn btn-large btn-outline-success active">
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
							<a href="vender.php" class="btn btn-large btn-outline-success">
								<p>Vender</p>
							</a>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-md-9 border_custom">
				
				<br>
                <div class="col-12">
                	<a href="clientes_novo.php"><button class="btn btn-large btn-primary">+ NOVO CLIENTE</button></a>
                </div>
	           	<br>
				<div class="row">
					<div class="col-md-6">						
						<form class="input-group form_procurar_clientes">
		                    <input type="text" id="nomeCliente" class="form-control" placeholder="pesquisar nome" maxlength="140" name="nome_cliente">
		                </form>
					</div>

				</div>
				<br>
	            <div class="row">
				<br>
	                <div class="col-md-12">
	                    <div>
	                    	<div class="row">
								<div class="col-2">Nome</div>
								<div class="col-2">CPF</div>
								<div class="col-2">Telefone</div>
								<div class="col-6">Endereço</div>
							</div>
	                    </div>
	                    <div id="div_resultado_paginacao_clientes">
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