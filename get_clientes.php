<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	$nome_cliente = isset($_POST['nome_cliente'])?$_POST['nome_cliente']:'';
	//SQL para pegar informações de caixa da empresa
	$sql_dados_caixa = "SELECT * FROM clientes WHERE nome_cliente LIKE '%$nome_cliente%' ORDER BY nome_cliente";

	$resultado_id = mysqli_query($con,$sql_dados_caixa);

	if($resultado_id){
		$i = 0;
		while($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			$i++;
			echo '

				<div class="d-none">
					<form id="form_passar_dados'.$i.'">
						<input type="text" name="id_cliente" value="'.$linha['id_cliente'].'">
						<input type="text" name="nome_cliente" value="'.$linha['nome_cliente'].'">
					</form>
				</div>	

				<br/>
				<div id="cliente_'.$i.'" class="row linha_pesquisa d-flex align-items-center justify-content-center">
					<hr>
				<br/>
					<div class="col-md-2">
							<p>'.$linha["nome_cliente"].'</p>
					</div>
					<div class="col-md-2">
							<p>'.$linha["cpf"].'</p>
					</div>
					<div class="col-md-2">
							<p>'.$linha["contato_telefone"].'</p>
					</div>
					<div class="col-md-6">
							<p>'.$linha["rua"].', '.$linha["numero"].', '.$linha["bairro"].', '.$linha["cidade"].', '.$linha["uf"].', '.$linha["ceep"].'</p>
					</div>
					<div class="col-12">
						<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal_cliente'.$i.'" id="'.$i.'">Editar</button>
						
						<div class="btn-group">
						  <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						    Excluir
						  </button>
						  <ul class="dropdown-menu" style="text-align:center">
						    <li><button type="button" class="btn btn-outline-danger btn_excluir_item" onclick="excluir_cliente('.$i.')">Sim</button></li>
						    <hr>
						    <li><button type="button" class="btn btn-outline-primary">Não</button></li>
						  </ul>
						</div>

						  <!-- Modal Exibir itens -->
						<div class="modal fade" id="modal_cliente'.$i.'" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="false">
							<div class="modal-dialog">
							    <div class="modal-content">
							    	<div class="modal-header">
								        <h5 class="modal-title" id="modalLabel">Editar Cliente</h5>
							        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
						     	</div>
								<div class="modal-body">
									<form id="form_alterar_dados_clientes_'.$i.'">
										<div id="form_editar_clientes_'.$i.'">
											<div class="d-none">
												<input type="text" name="id_cliente" value="'.$linha['id_cliente'].'">
											</div>
										    <div class="col-12">Atualizar dados cliente: '.$linha["nome_cliente"].'</div>
										    <div class="input-group mb-3">
												<input id="editar_nome_cliente'.$i.'" name="editar_nome_cliente" type="text" class="form-control" placeholder="Novo nome cliente">
											</div>
											<div class="input-group mb-3">
												<input id="editar_cpf_cliente'.$i.'" name="editar_cpf_cliente" type="text" class="form-control" placeholder="Novo CPF cliente">
											</div>
											<div class="input-group mb-3">
												<input id="editar_telefone_cliente'.$i.'" name="editar_telefone_cliente" type="text" class="form-control" placeholder="Novo número telefone cliente">
											</div>
											<div class="input-group mb-3">
												<input id="editar_rua_cliente'.$i.'" name="editar_rua_cliente" type="text" class="form-control" placeholder="Nova rua cliente">
											</div>
											<div class="input-group mb-3">
												<input id="editar_numero_casa_cliente'.$i.'" name="editar_numero_casa_cliente" type="text" class="form-control" placeholder="Novo número casa cliente">
											</div>
											<div class="input-group mb-3">
												<input id="editar_bairro_cliente'.$i.'" name="editar_bairro_cliente" type="text" class="form-control" placeholder="Novo bairro cliente">
											</div>
											<div class="input-group mb-3">
												<input id="editar_cidade_cliente'.$i.'" name="editar_cidade_cliente" type="text" class="form-control" placeholder="Nova cidade cliente">
											</div>
											<div class="input-group mb-3">
												<input id="editar_uf_cliente'.$i.'" name="editar_uf_cliente" type="text" class="form-control" placeholder="Novo estado cliente">
											</div>
											<div class="input-group mb-3">
												
												<input id="editar_ceep_cliente'.$i.'" name="editar_ceep_cliente" type="text" class="form-control" placeholder="Novo ceep cliente">
											</div>
											<button class="btn btn-outline-secondary" type="button" id="btn_editar_'.$i.'" onclick="atualizar_cliente('.$i.')">Mudar</button>

											
								   		</div>
									</form>								
								</div>
							</div>
						</div>
					<br/>
					<br/>
					<hr>
					
				</div>
				';
				
					
		}
		

		$resultado_id_pesquisa = mysqli_fetch_array($resultado_id);
			if($resultado_id_pesquisa != null){
				echo '
					<div id="fornecedor_'.$i.'" class="row linha_pesquisa d-flex align-items-center justify-content-center">
						<div class="col-md-2">
							<p>Não econtrado</p>
						</div>
						<div class="col-md-2">
							<p>Não econtrado</p>
						</div>
						<div class="col-md-2">
							<p>Não econtrado</p>
						</div>
						<div class="col-md-6">
							<p>Não econtrado</p>
						</div>
					</div>';
				}
	}
	


?>
