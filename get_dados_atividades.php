<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	//SQL para pegar informações de ccontas sda empresa
	$sql_dados_atividades = "SELECT DATE_FORMAT(vencimento, '%d %b %Y') AS vencimento, nome_conta, natureza_conta, valor_conta, pago_conta, forma_pagamento_conta, parcelas, vencimento 
							FROM contas 
							WHERE 1 = 1
							ORDER BY vencimento";

	$resultado_id = mysqli_query($con,$sql_dados_atividades);

	if($resultado_id){
		$i = 0;
		while($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			$i++;
			echo '<div id="conta_despesa_'.$i.'" class="row linha_pesquisa d-flex align-items-center">
					<hr>
					<br/>
					<div class="col-md-2">
							<p>'.$linha["nome_conta"].'</p>
					</div>
					<div class="col-md-2">
							<p>'.$linha["natureza_conta"].'</p>
					</div>
					<div class="col-md-2">
							<p>'.$linha["valor_conta"].'</p>
					</div>
					<div class="col-md-1">
							<p>'.$linha["pago_conta"].'</p>
					</div>
					<div class="col-md-2">
							<p>'.$linha["forma_pagamento_conta"].'</p>
					</div>
					<div class="col-md-1">
							<p>'.$linha["parcelas"].'</p>
					</div>
					<div class="col-md-2">
							<p>'.$linha["vencimento"].'</p>
					</div>
					<div class="col-12">
						<div class="btn-group">

						<button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						    Pagar
						  </button>
						  <ul class="dropdown-menu" style="text-align:center">
						    <li><button type="button" class="btn btn-outline-success btn_excluir_item" onclick="excluir_fornecedor('.$i.')">Sim</button></li>
						    
						  </ul>

							
						  <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						    Excluir
						  </button>
						  <ul class="dropdown-menu" style="text-align:center">
						    <li><button type="button" class="btn btn-outline-danger btn_excluir_item" onclick="excluir_fornecedor('.$i.')">Sim</button></li>
						    <hr>
						    <li><button type="button" class="btn btn-outline-primary">Não</button></li>
						  </ul>
						</div>
					</div>
					<br/>
					<br/>
					<hr>
					
				</div>';
		}
		


	}


?>
