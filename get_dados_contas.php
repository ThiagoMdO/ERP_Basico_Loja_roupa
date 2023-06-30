<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	//SQL para pegar informações contas despesas
	$sql_dados_conta_despesa = "SELECT * FROM contas WHERE pago_conta = 'NAO' AND natureza_conta = 'Despesa'";

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
				<div class="container nav_select d-block">
					<div class="row row-header">
						<h2>CONTAS</h2>
						<hr>
					</div>
					<div class="row row-space-controle d-flex justify-content-center align-items-center">						
						<div class="col-md-12">
							<h3>Despesas</h3>
							<p style="color: red">R$'.$valor_conta_despesas.'</p>
						</div>
						<hr>

						<div class="col-md-12">
							<h3>Investimentos</h3>
							<p style="color: blue">R$'.$valor_conta_investimento.'</p>
							
						</div>
						<hr>
						<div class="col-md-12">
							<h4>Total contas</h4>
							<p style="color: orange">R$'.$total.'</p>
							
						</div>
					</div>
					<a href="contas_despesas_investimentos.php" class="plus">+ Adicionar Nova Conta</a>
				</div><!-- fim container Atividades -->
				';
	}
	

?>
