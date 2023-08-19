
<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$offset =isset($_POST['offset_pagina'])?$_POST['offset_pagina']:0;
	$limite_exibicao = 2;
	$nomeProduto = isset($_POST['nomeProduto'])?$_POST['nomeProduto']:'';
	$saldo_dinheiro = '';
	$saldo_banco = '';
	

	//SQL para pegar valores da pesquisa, teste com nome
	$sql_resultado_pesquisa = "SELECT * 
								FROM produto_estoque 
								WHERE nome_produto like'%$nomeProduto%' 
								ORDER BY nome_produto
								LIMIT $limite_exibicao
								OFFSET $offset";

	$resultado_pesquisa_id = mysqli_query($con,$sql_resultado_pesquisa);

	//SQL pegar informações de fornecedores
	$sql_pesquisa_fornecedoredores = "SELECT id_fornecedor, nome_fornecedor FROM fornecedores  WHERE 1=1 ORDER BY nome_fornecedor";

	//SQL pegar informações de saldos, usa-la na tela de compra, para impedir que seja alterado quantidade de estoque quando nçao tiver saldo suficiente
	$sql_info_saldo = "SELECT saldo_dinheiro, saldo_banco FROM empresa WHERE id_empresa = 1";
	$resultado_info_saldo = mysqli_query($con, $sql_info_saldo);
	if ($resultado_info_saldo) {
		foreach ($resultado_info_saldo as $linha) {
			$saldo_dinheiro = $linha['saldo_dinheiro'];
			$saldo_banco = $linha['saldo_banco'];
		}
	}


	// consultar registro
	$sql_historico_qtd = "SELECT COUNT(*) AS total_registros
		FROM (
		    SELECT id_produto
			    FROM produto_estoque
			    WHERE nome_produto LIKE '%$nomeProduto%'
		) AS subconsulta";

	$quantidade_historico;
	$resultado_id_historico_qtd = mysqli_query($con,$sql_historico_qtd);
	if($resultado_id_historico_qtd){
		while($linha = mysqli_fetch_array($resultado_id_historico_qtd)){
			$quantidade_historico = $linha['total_registros'];
		}
	}

	$offset++;

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
				<input type="text" name="nomeProduto" value="'.$nomeProduto.'" ">
				<input type="text" name="offset_pagina" value="'.$avancar.'" ">
			</div>
			<div class="row">
				<div class="col-10 d-flex justify-content-end align-items-center">
					Página '.$pagina_atual.' de '.$total_paginas.', total produtos '.$quantidade_historico.'
				</div>
				<div class="col-2 div_btn_pula_pagina">	
					<button class="btn btn_selecionar_pagina '.$esconder_anterior.'" type="button" id="btn_passar_pagina_voltar" onclick="passar_pagina_anterior()"> < </button>
 					<button class="btn btn_selecionar_pagina '.$esconder_posterior.'" type="button" id="btn_passar_pagina_ir" onclick="passar_pagina_posterior()"> > </button>
				</div>
			
			</div>
 		</form>

 		<form id="form_passar_pagina_anterior">
			<div class="d-none">
				<input type="text" name="nomeProduto" value="'.$nomeProduto.'" ">
				<input type="text" name="offset_pagina" value="'.$recuar - 2 .'" ">
			</div>
 		</form>
 		<br/>
 		
 	';
 	echo '
		<div class="row d-none d-sm-flex">
			<div class="col-2 info_produto">Foto</div>
			<div class="col-3 info_produto">Nome</div>
			<div class="col-1 info_produto">TAM</div>
			<div class="col-2 info_produto">COR</div>
			<div class="col-2 info_produto">Preço</div>
			<div class="col-2 info_produto">QTD</div>
		</div>
		<br/>

		';
	if($resultado_pesquisa_id){
		$i = 1;
		
		while($linha = mysqli_fetch_array($resultado_pesquisa_id, MYSQLI_ASSOC)){
			$imagem;
			switch($linha["nome_produto"]){
					case $linha["nome_produto"]:
						//**************************************************************** .PNG
						// **************** Endereço que busca as imagens ****************
						$imagem = '<div class="col-md-2 col-sm-8"><img class="rounded img-fluid" src="img/produtos/'.$linha["nome_produto"].'.png" width="100%" height="100%"/></div>';
					break;
				};
			
			echo '
				<!-- Exibir estoque tela -->
				<form id="form_produto_'.$i.'">

					<div class="d-none">
						<input name="id_produto" value="'.$linha['id_produto'].'">
					</div>
					<div id="item_'.$i.'" class="row d-block d-flex align-items-center justify-content-center">
						'.$imagem.
						"<div class='col-md-3 produto'>
							<div>
								<input type='text' name='nome_produto' class='form-control'style='text-align: center;' readonly value='".$linha['nome_produto']."'>
							</div>".'
						</div>

						<div class="col-md-1 produto">
							<div>
								<input type="text" name="tamanho" class="form-control"style="text-align: center;" readonly value='.$linha["tamanho"].'>
							</div>
						</div>'.
						"<div class='col-md-2 produto'>
							<div>
								<input type='text' name='cor' class='form-control'style='text-align: center;' readonly value='".$linha['cor']."'>
							</div>
						</div>".'
						<div class="col-md-2 produto">
							<div style="margin-top:20px">
								<input title="Preço Fornecedor" type="text" name="preco_produto_fornecedor" class="form-control"style="text-align: center;" readonly value=R$'.$linha["preco_produto_fornecedor"].'>
								<input title="Preço Cliente" type="text" name="preco_produto_cliente" class="form-control"style="text-align: center;" readonly value=R$'.$linha["preco_produto_cliente"].'>
							</div>
						</div>
						<div class="col-md-2 produto">
							<div>
								<input type="text" name="quantidade" class="form-control"style="text-align: center;" readonly value='.$linha['quantidade'].'>
							</div>
						</div>
					</div>
					<div class="col-12 btn_group_estoque">
						<button type="button" class="btn btn_estoque btn_comprar_mais" data-bs-toggle="modal" data-bs-target="#ComprarMais'.$i.'">Comprar mais</button>
						
						<button type="button" class="btn btn_estoque btn_editar" data-bs-toggle="modal" data-bs-target="#meuModal'.$i.'"  id="'.$i.'">Editar</button>
						
						<div class="btn-group">
						  <button type="button" class="btn btn_estoque btn_excluir_produto dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						    Excluir
						  </button>
						  <ul class="dropdown-menu" style="text-align:center">
						    <li><button type="button" class="btn btn-outline-danger btn_excluir_item" onclick="excluir_produto('.$i.')">Sim</button></li>
						  </ul>
						</div>
					</div>


					<!-- fim Exibir estoque tela -->
					<hr/>

					<!-- Modal Exibir itens -->
					<div class="modal fade" id="meuModal'.$i.'" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="false">
						<div class="modal-dialog">
						    <div class="modal-content">
						    	<div class="modal-header">
							        <h5 class="modal-title" id="modalLabel">Alterar estoque individual</h5>
							        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
						     	</div>
								<div class="modal-body">
								<div id="form_alterar_qtd_produtos_'.$i.'">
								'.'
								
									<div class="row d-block d-flex align-items-center justify-content-center" id="item_'.$i.'">'.$imagem
								
								.'	</div>'.
									"
									<div>
										<div class='row'>
											<div class='col-4'>
												<span style='color:blue'>Nome Produto:<span>
											</div>
											<div class='col-8'>
												<input id='exibir_nome_produto_$i' type='text' name='nome_produto' class='form-control'style='text-align: center;' readonly value='".$linha['nome_produto']."'>
											</div>
										</div>
									</div>".'
									<div>
										<div class="row">
											<div class="col-4">
												<span style="color:blue">Tamanho Produto:<span>
											</div>
											<div class="col-8">
												<input id="exibir_tamanho_produto_'.$i.'" type="text" name="tamanho" class="form-control"style="text-align: center;" readonly value='.$linha["tamanho"].'>
											</div>
										</div>
									</div>
								'.
								"
									<div>
										<div class='row'>
											<div class='col-4'>
												<span style='color:blue'>Cor Produto:<span>
											</div>
											<div class='col-8'>
												<input id='exibir_cor_produto_$i' type='text' name='cor' class='form-control'style='text-align: center;' readonly value='".$linha['cor']."'>
											</div>
										</div>

									</div>
								".'
								
									<div>
										<div class="row">

											<div class="col-4">
												<span style="color:blue">Preço Produto:<span>
											</div>
											<div class="col-8">
												<input id="exibir_preco_produto_'.$i.'" type="text" name="preco_produto_cliente" class="form-control"style="text-align: center;" readonly value='.$linha["preco_produto_cliente"].'>
											</div>
										</div>
									</div>
								
								
									<div>
										<div class="row">

											<div class="col-4">

												<span style="color:blue">Quantidade Produto:<span>
											</div>
											<div class="col-8">
												<input id="exibir_qtd_produto_'.$i.'" type="text" name="quantidade" class="form-control"style="text-align: center;" readonly value='.$linha['quantidade'].'>
											</div>
										</div>
									</div>
								'.'</div>
								<!-- fim Modal Exibir itens -->	
								<hr>
								<!-- Modal Editar itens -->
								<div id="alterar_exibir_produto"></div>
							    <div>Campos para alterações</div>
							    <p></p>
							    <div id="form_editar_produto_'.$i.'">
								    <div class="input-group mb-3">
										<button class="btn btn-outline-secondary" type="button" id="btn_editar_'.$i.'" onclick="mudar_atributo_produto('.$i.')">Mudar</button>
										<input id="editar_nome_produto_'.$i.'" name="editar_nome_produto" type="text" class="form-control" placeholder="Nome do produto">

									</div>
									<div class="input-group mb-3">
										<button class="btn btn-outline-secondary" type="button" id="btn_editar_'.$i.'" onclick="mudar_atributo_produto('.$i.')">Mudar</button>
										<input id="editar_tamanho_produto_'.$i.'" name="editar_tamanho_produto" type="text" class="form-control" placeholder="Tamanho do produto">
										
									</div>
									<div class="input-group mb-3">
										<button class="btn btn-outline-secondary" type="button" id="btn_editar_'.$i.'" onclick="mudar_atributo_produto('.$i.')">Mudar</button>
										<input id="editar_cor_produto_'.$i.'" name="editar_cor_produto" type="text" class="form-control" placeholder="Cor do produto">
										
									</div>
									<div class="input-group mb-3">
										<button class="btn btn-outline-secondary" type="button" id="btn_editar_'.$i.'" onclick="mudar_atributo_produto('.$i.')">Mudar</button>
										<input id="editar_preco_produto_'.$i.'" name="editar_preco_produto" type="mumber" class="form-control" placeholder="Preço do produto">
										
									</div>
									<div class="input-group mb-3">
										<button class="btn btn-outline-secondary" type="button" id="btn_editar_'.$i.'" onclick="mudar_atributo_produto('.$i.')">Mudar</button>
										<input id="editar_quantidade_produto_'.$i.'" name="editar_quantidade_produto" type="mumber" class="form-control" placeholder="Quantidade do produto">
										
									</div>
							    </div>
							    <!-- fim Modal Editar itens -->		
							</div>
					    </div
				    </div>
				  </div>
				</div>

					<!-- Modal Exibir itens -->
					<div class="modal fade" id="ComprarMais'.$i.'" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="false">
						<div class="modal-dialog">
						    <div class="modal-content">
						    	<div class="modal-header">
							    	<h5 class="modal-title" id="modalLabel">Comprar Produto</h5>
							    	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
						     	</div>
								<div class="modal-body">
								<div">
									<div class="row d-block d-flex align-items-center justify-content-center" id="item_'.$i.'">
									'.$imagem.'
									</div>'.
									"
									<div>
										<div class='row'>
											<div class='col-4'>
												<span style='color:orange'>Nome Produto:<span>
											</div>
											<div class='col-8'>
												<input id='comprar_exibir_nome_produto_$i' type='text' name='nome_produto' class='form-control'style='text-align: center;' readonly value='".$linha['nome_produto']."'>
											</div>
										</div>
									</div>".'
									<div>
										<div class="row">
											<div class="col-4">
												<span style="color:orange">Tamanho Produto:<span>
											</div>
											<div class="col-8">
												<input id="comprar_exibir_tamanho_produto_'.$i.'" type="text" name="tamanho" class="form-control"style="text-align: center;" readonly value='.$linha["tamanho"].'>
											</div>
										</div>
									</div>
								'.
								"
									<div>
										<div class='row'>
											<div class='col-4'>
												<span style='color:orange'>Cor Produto:<span>
											</div>
											<div class='col-8'>
												<input id='comprar_exibir_cor_produto_$i' type='text' name='cor' class='form-control'style='text-align: center;' readonly value='".$linha['cor']."'>
											</div>
										</div>
									</div>
								".'
								
									<div>
										<div class="row">
											<div class="col-4">
												<span style="color:orange">$ Fornecedor:<span>
											</div>
											<div class="col-8">
												<input title="dsa" id="comprar_preco_produto_'.$i.'" type="text" name="preco_produto_fornecedor" class="form-control"style="text-align: center;" readonly value='.$linha["preco_produto_fornecedor"].'>
											</div>
										</div>
									</div>
								
								
									<div>
										<div class="row">
											<div class="col-4">
												<span style="color:orange">Quantidade em estoque:<span>
											</div>
											<div class="col-8">
												<input id="comprar_qtd_produto_'.$i.'" type="text" name="quantidade" class="form-control"style="text-align: center;" readonly value='.$linha['quantidade'].'>
											</div>
										</div>
									</div>
							'.'</div>
								<!-- fim Modal Exibir itens -->	
								<hr>


								<form>
								    <div>Comprar Produto</div>
								    <br/>
								    <div class="row">
										<div class="col-6">
											<span>Fornecedores<span>
										</div>
										<div class="col-6">
											<select name="comprar_fornecedor" class="form-select">
												';
													
													$resultado_pesquisa_id_fornecedo = mysqli_query($con, $sql_pesquisa_fornecedoredores);

													if($resultado_pesquisa_id_fornecedo){
														while($nome = mysqli_fetch_array($resultado_pesquisa_id_fornecedo, MYSQLI_ASSOC)){
															echo '<option value="'.$nome["nome_fornecedor"].'">'.$nome["nome_fornecedor"].'</option>';
														}
													}
			echo '
											</select>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-6">
											<p>Forma de pagamento<p>
											<p>Parcelas pagamento<p>
											<p>Desconto dinheiro R$<p>
											<p>Taxa<p>
										</div>
										<div class="col-6">
											<select name="forma_pagamento_comprar" class="form-select">
												<option value="dinheiro">Dinheiro</option>
												<option value="debito">Débito</option>
											</select>
											<select id="parcelas_'.$i.'" name="forma_pagamento_parcelado_comprar" class="form-select">
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
											</select>
											<input id="desconto_'.$i.'" name="desconto_comprar" placeholder="R$" type="number" class="form-control" value="0"/>
											<input id="taxa_'.$i.'" name="taxa_comprar" type="number" class="form-control" value="1"/>
										</div>
									</div>

									<br>
								    <div class="row">
										<div class="col-6">
											<span>Quantidade para Comprar<span>
										</div>
										<div class="col-6">
											<input type="number" id="produto_quantidade_'.$i.'" name="quantidade_Comprar" class="form-control" style="text-align: center;" value=1>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-3">
											<span>Sub Total<span>
										</div>
										<div class="col-9">
											<input type="text" id="subtotal_'.$i.'" readonly name="subtotal_Comprar" class="form-control" style="text-align: center;">
										</div>
									</div>
									<br>
									<hr>
									<div class="row">
										<div class="col-4">
											<button type="button" class="btn btn-outline-success" onclick="ComprarProduto('.$i.')">Comprar</button>
										</div>
										<div class="col-4">
											<button type="button" class="btn btn-outline-warning" onclick="visualizarSubTotal('.$i.')">Visualizar Total</button>
										</div>
										<div class="col-4">
											<button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Fechar" >Cancelar</button>
										</div>
									</div>
									<br>
									

								</form>				
							</div>
					    </div>						      
				    </div>
					
					 					      
				    </div>
				  </div>
				</div>

			</form>
					';
			$i++;
			}
	
	}

		


?>