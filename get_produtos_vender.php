<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	
	$nomeProduto = isset($_POST['nomeProduto'])?$_POST['nomeProduto']:'';
	$nome_cliente = isset($_POST['nome_cliente'])?$_POST['nome_cliente']:'';
	$id_cliente = '';


	//SQL para pegar valores da pesquisa, teste com nome
	$sql_resultado_pesquisa = "SELECT * FROM produto_estoque WHERE nome_produto like'%$nomeProduto%' ORDER BY nome_produto";

	$resultado_pesquisa_id = mysqli_query($con,$sql_resultado_pesquisa);

	//SQL pegar informações de clientes
	$sql_pesquisa_clientes = "SELECT id_cliente, nome_cliente FROM clientes  WHERE nome_cliente like '%$nome_cliente%' ORDER BY nome_cliente";

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
						<input type="text" name="id_produto" value="'.$linha['id_produto'].'">
						<input type="text" name="preco_forncedor" value="'.$linha['preco_produto_fornecedor'].'">
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
								<input type="text" name="preco_produto_fornecedor" class="form-control"style="text-align: center;" readonly value=R$'.$linha["preco_produto_fornecedor"].'>
								<input type="text" name="preco_produto_cliente" class="form-control"style="text-align: center;" readonly value=R$'.$linha["preco_produto_cliente"].'>
							</div>
						</div>
						<div class="col-md-2 produto">
							<div>
								<input type="text" name="quantidade" class="form-control"style="text-align: center;" readonly value='.$linha['quantidade'].'>
							</div>
						</div>
					</div>
					<div class="col-12">
						<button type="button" class="btn btn-dark btn_devolver" data-bs-toggle="modal" data-bs-target="#modalDevolver_'.$i.'">Devolução</button>
						<button type="button" class="btn btn-outline-success btn_vender" data-bs-toggle="modal" data-bs-target="#modalVender_'.$i.'">Vender</button>
						<button type="button" class="btn btn-warning btn_adicionar_carrinho" >+ Carrinho Vender</button>
						
					</div>
					<!-- fim Exibir estoque tela -->
					<hr/>


					<!-- Modal Vender Item -->
					<!-- Modal Exibir itens -->
					<div class="modal fade" id="modalVender_'.$i.'" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="false">
						<div class="modal-dialog">
						    <div class="modal-content">
						    	<div class="modal-header">
							        <h5 class="modal-title" id="modalLabel">Vender Produto</h5>
							        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
						     	</div>
								<div class="modal-body">
								<form">
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

												<span style="color:blue">Quantidade Disponivel:<span>
											</div>
											<div class="col-8">
												<input id="exibir_qtd_produto_'.$i.'" type="text" name="quantidade" class="form-control" style="text-align: center;" readonly value='.$linha['quantidade'].'>
											</div>
										</div>
									</div>
								'.'</div>
								<!-- fim Modal Exibir itens -->	
								<hr>
								<form>
								    <div>Vender Produto</div>
								    <br/>
								    <div class="row">
										<div class="col-6">
											<span>Cliente<span>
										</div>
										<div class="col-6">
											<select name="cliente_vender" class="form-select">
												';
													
													$resultado_pesquisa_id_cliente = mysqli_query($con, $sql_pesquisa_clientes);

													if($resultado_pesquisa_id_cliente){
														while($nome = mysqli_fetch_array($resultado_pesquisa_id_cliente, MYSQLI_ASSOC)){
															echo '<option value="'.$nome["nome_cliente"].'">'.$nome["nome_cliente"].'</option>';
														}
													}
			echo '
											</select>
											<div class="">'.$nome["id_cliente"].'</div>
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
											<select name="forma_pagamento_vender" class="form-select">
												<option value="dinheiro">Dinheiro</option>
												<option value="debito">Débito</option>
												<option value="credito">Crédito</option>
											</select>
											<select id="parcelas_'.$i.'" name="forma_pagamento_parcelado_vender" class="form-select">
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
											<input id="desconto_'.$i.'" name="desconto_vender" placeholder="R$" type="number" class="form-control" value="0"/>
											<input id="taxa_'.$i.'" name="taxa_vender" type="number" class="form-control" value="1"/>
										</div>
									</div>

									<br>
								    <div class="row">
										<div class="col-6">
											<span>Quantidade para vender<span>
										</div>
										<div class="col-6">
											<input type="number" id="produto_quantidade_'.$i.'" name="quantidade_vender" class="form-control" style="text-align: center;" value=1>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-3">
											<span>Sub Total<span>
										</div>
										<div class="col-9">
											<input type="text" id="subtotal_'.$i.'" readonly name="subtotal_vender" class="form-control" style="text-align: center;">
										</div>
									</div>
									<br>
									<hr>
									<div class="row">
										<div class="col-4">
											<button type="button" class="btn btn-outline-success" onclick="venderProduto('.$i.')">Vender</button>
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
							</form>
					    </div>
						      
					    </div>
					  </div>
					</div>
				</form>
					';
			$i++;
			}
	
	}else if(!$resultado_pesquisa_id){
		//testar para sem resultados
			echo '<div class="row d-block d-flex align-items-center justify-content-center">';
				echo '<div class="col-3">Sem resultados</div>';
			echo"</div>";
		}
		


?>