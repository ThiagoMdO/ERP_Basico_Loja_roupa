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
				<div class="caixa">
					<div id="tela_informacoes" class="container">
						<div class="top_header_informacoes">
							<h4>Informações de Caixa</h4>
						</div>
						<div class="dados_saldos d-flex justify-content-between">
							<div class="d-block">
								<div class="dados_nome_saldo dinheiro alinhar_meio">Dinheiro</div>
								<div class="dados_valor_saldo dinheiro alinhar_meio"><span>R$'.$linha['saldo_dinheiro'].'</span></div>
							</div>

							<div class="d-block">
								<div class="dados_nome_saldo banco alinhar_meio">Banco</div>
								<div class="dados_valor_saldo banco alinhar_meio"><span>R$'.$linha['saldo_banco'].'</span></div>
							</div>

							<div class="d-block">
								<div class="dados_nome_saldo a_receber alinhar_meio">A Receber</div>
								<div class="dados_valor_saldo a_receber alinhar_meio"><span>R$'.$linha['saldo_receber'].'</span></div>
							</div>

							<div class="d-block">
								<div class="dados_nome_saldo bruto alinhar_meio">Bruto</div>
								<div class="dados_valor_saldo bruto alinhar_meio"><span>R$'.$total_soma.'</span></div>
							</div>
						</div>

						<div class="row editar_saldos alinhar_meio">
							<div class"col-12>
								<h5>Editar Dados de Saldos</h5>
							</div>
							<div class="col-12 d-flex">
								<button type="button" class="btn btn_caixa btn_trocar_saldo" data-bs-toggle="modal" data-bs-target="#modal_transferir">Trocar Saldos</button>
							</div>
							<div class="col-12 d-flex">
								<button type="button" class="btn btn_caixa btn_editar_saldo" data-bs-toggle="modal" data-bs-target="#meuModal">Editar manualmente</button>
							</div>
						</div>
					</div>
				</div>';
		}

	}


?>
