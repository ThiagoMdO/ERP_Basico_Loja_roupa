<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();
	$offset =isset($_POST['offset_pagina'])?$_POST['offset_pagina']:0;
	$nome_cliente = isset($_POST['nome_cliente'])?$_POST['nome_cliente']:'';

	$limite_exibicao = 2;
	//SQL para pegar informações de caixa da empresa
	$sql_dados_caixa = "SELECT * FROM clientes 
						WHERE nome_cliente LIKE '%$nome_cliente%'
						ORDER BY nome_cliente
						LIMIT $limite_exibicao
						OFFSET $offset";

	// consultar registro
	$sql_historico_qtd = "SELECT COUNT(*) AS total_registros
		FROM (
		    SELECT id_cliente
			    FROM clientes
			    WHERE nome_cliente LIKE '%$nome_cliente%'
		) AS subconsulta";
	
	$quantidade_historico;
	$resultado_id_historico_qtd = mysqli_query($con,$sql_historico_qtd);
	if($resultado_id_historico_qtd){
		while($linha = mysqli_fetch_array($resultado_id_historico_qtd)){
			$quantidade_historico = $linha['total_registros'];
		}
	}

	$offset++;

	$resultado_id = mysqli_query($con,$sql_dados_caixa);

	$total_paginas = ceil($quantidade_historico / $limite_exibicao);

	$pagina_atual = ceil($offset / $limite_exibicao); //localiza a página atual

	$avancar = $offset + 1;
	$recuar = $offset - 1;
	$esconder_posterior = '';
	$esconder_anterior = '';

	if($pagina_atual >= $total_paginas){
		$esconder_posterior = 'd-none';
	}
	if($recuar < $limite_exibicao){
		$esconder_anterior = 'd-none';
	}

	echo '

		<form id="form_passar_pagina_posterior">
			<div class="d-none">
				<input type="text" name="nome_cliente" value="'.$nome_cliente.'" ">
				<input type="text" name="offset_pagina" value="'.$avancar.'" ">
			</div>
			<div class="row">
				<div class="col-10 d-flex justify-content-end align-items-center">
					Página '.$pagina_atual.' de '.$total_paginas.', total clientes '.$quantidade_historico.'
				</div>
				<div class="col-2 div_btn_pula_pagina">	
					<button class="btn btn_selecionar_pagina '.$esconder_anterior.'" type="button" id="btn_passar_pagina_voltar" onclick="passar_pagina_anterior()"> < </button>
 					<button class="btn btn_selecionar_pagina '.$esconder_posterior.'" type="button" id="btn_passar_pagina_ir" onclick="passar_pagina_posterior()"> > </button>
				</div>
			
			</div>
 		</form>

 		<form id="form_passar_pagina_anterior">
			<div class="d-none">
				<input type="text" name="nome_cliente" value="'.$nome_cliente.'" ">
				<input type="text" name="offset_pagina" value="'.$recuar - 2 .'" ">
			</div>
 		</form>

 		
 	';

	echo '<div class="col-md-12">
	                    <div class="info_dados">
	                    	<div class="row">
								<div class="col-2">Nome</div>
								<div class="col-2">CPF</div>
								<div class="col-2">Telefone</div>
								<div class="col-6">Endereço</div>
							</div>
	                    </div>
	                </div>';
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

				<div id="cliente_'.$i.'" class="row d-flex align-items-center justify-content-center">
					
					<div class="row item_exibir d-flex align-items-center justify-content-center">
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
					</div>
					<div class="col-12">
						<div class="btn-group">

							<div class="btn_editar_pessoa_f">
								<button type="button" class="btn btn_editar_pessoa" data-bs-toggle="modal" data-bs-target="#modal_cliente'.$i.'" id="'.$i.'">Editar</button>
							</div>

							<button class="btn_opcao">
								<img src="img/3_pontos.png">
							</button>


							<div class="btn_excluir">
								<span>Excluir</span>
								<div>
									<button type="button" class="btn_excluir_sim" onclick="excluir_cliente('.$i.')">Sim</button>
								</div>
							</div>
							  
						</div>
					</div>
					
					<div class="col-12">
						
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
