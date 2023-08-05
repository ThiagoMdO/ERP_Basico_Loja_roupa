<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	//SQL para pegar informações contas despesas
	$sql_dados_conta_despesa = "SELECT * 
								FROM contas 
								WHERE pago_conta = 'NAO' AND natureza_conta = 'Despesa'";

	//SQL para pegar informações contas investimento
	$sql_dados_conta_investimento = "SELECT * FROM contas WHERE pago_conta = 'NAO' AND natureza_conta = 'Investimento'";

	$resultado_id_despesa = mysqli_query($con,$sql_dados_conta_despesa);
	$resultado_id_investimento = mysqli_query($con,$sql_dados_conta_investimento);



	if($resultado_id_despesa){
		$valor_conta_despesas = 0;
		$valor_conta_investimento = 0;
		while($linha = mysqli_fetch_array($resultado_id_despesa, MYSQLI_ASSOC)){
			$valor_conta_despesas += $linha['valor_conta'];
			
		}
		while($linha2 = mysqli_fetch_array($resultado_id_investimento, MYSQLI_ASSOC)){
			$valor_conta_investimento += $linha2['valor_conta'];
			
		}
		$total = $valor_conta_despesas + $valor_conta_investimento;
			echo '
				<div class="contas">
					<div id="tela_informacoes" class="container">
						<div class="top_header_informacoes">
							<h4>Informações de Conta</h4>
						</div>
						<div class="dados_saldos d-flex justify-content-between">
							<div class="d-block">
								<div class="dados_nome_saldo despesa alinhar_meio">Despesas</div>
								<div class="dados_valor_saldo despesa alinhar_meio"><span>R$'.$valor_conta_despesas.'</span></div>
							</div>

							<div class="d-block">
								<div class="dados_nome_saldo investimento alinhar_meio">Investimentos</div>
								<div class="dados_valor_saldo investimento alinhar_meio"><span>R$'.$valor_conta_investimento.'</span></div>
							</div>

							<div class="d-block">
								<div class="dados_nome_saldo total_contas alinhar_meio">Total Contas</div>
								<div class="dados_valor_saldo total_contas alinhar_meio"><span>R$'.$total.'</span></div>
							</div>							
						</div>

						<div class="col-12">
		                	<button type="button" class="btn btn_adicionar_conta" data-bs-toggle="modal" data-bs-target="#modal_nova_conta" id="">Adicionar Nova Conta</button>
		                </div>
					</div>
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
				';
	}

?>
