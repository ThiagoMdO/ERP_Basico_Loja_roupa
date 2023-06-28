<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	
	$nomeProduto = isset($_POST['nomeProduto'])?$_POST['nomeProduto']:'';

	//SQL para pegar valores da pesquisa, teste com nome
	$sql_resultado_pesquisa = "SELECT * FROM produto_estoque WHERE nome_produto like'%$nomeProduto%' ORDER BY nome_produto";

	$resultado_pesquisa_id = mysqli_query($con,$sql_resultado_pesquisa);

	//SQL pegar informações de clientes



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
						<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#meuModal'.$i.'" onclick="teste('.$i.')" id="'.$i.'">Editar</button>
						
						<div class="btn-group">
						  <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						    Excluir
						  </button>
						  <ul class="dropdown-menu" style="text-align:center">
						    <li><button type="button" class="btn btn-outline-danger btn_excluir_item" onclick="excluir_produto('.$i.')">Sim</button></li>
						    <hr>
						    <li><button type="button" class="btn btn-outline-primary">Não</button></li>
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
												<input id="exibir_preco_produto_'.$i.'" type="text" name="preco_produto_cliente" class="form-control"style="text-align: center;" readonly value=R$'.$linha["preco_produto_cliente"].'>
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
							</form>
					    </div>
						      
					    </div>
					  </div>
					</div>

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
												<input id="exibir_preco_produto_'.$i.'" type="text" name="preco_produto_cliente" class="form-control"style="text-align: center;" readonly value=R$'.$linha["preco_produto_cliente"].'>
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