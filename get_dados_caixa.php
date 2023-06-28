<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	//SQL para pegar informações de caixa da empresa
	$sql_dados_caixa = "SELECT * FROM empresa WHERE dono_empresa = 1";

	$resultado_id = mysqli_query($con,$sql_dados_caixa);

	if($resultado_id){
		$saldo_dinheiro;
		$saldo_banco;
		$saldo_receber;
		while($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			$saldo_dinheiro = $linha['saldo_dinheiro'];
			$saldo_banco = $linha['saldo_banco'];
			$saldo_receber = $linha['saldo_receber'];
			$total_soma = $saldo_dinheiro+$saldo_banco+$saldo_receber;
			echo '
				<div class="container nav_select d-block">
					<div class="row row-header">
						<h2>CAIXA</h2>
						<hr>
					</div>
					<div class="row d-block">
						<div class="col-12 row-space-controle">
							<li>Saldo em dinheiro</li>
							<p style="color:green;">R$ '.$linha['saldo_dinheiro'].'</p>
						</div>
						<div class="col-12 row-space-controle">
							<li>Saldo em Banco</li>
							<p style="color:blue;">R$ '.$linha['saldo_banco'].'</p>
						</div>
						<div class="col-12 row-space-controle">
							<li>Saldo a receber</li>
							<p style="color:brown;">R$ '.$linha['saldo_receber'].'</p>
						</div>
						<div class="col-12 row-space-controle">
							<li>Bruto:</li>
							<p style="color:orange;">R$ '.$total_soma.'</p>
						</div>
						<div class="col-12 row-space-controle">
							<button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modal_transferir">Transferir</button>
						</div>
						<div class="col-12 row-space-controle">
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#meuModal">Editar manualmente</button>
						</div>
					</div>
				</div><!-- fim container Caixa -->'
				;

			
		}

	}


?>
