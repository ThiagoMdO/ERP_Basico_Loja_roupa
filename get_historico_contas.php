<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();

	$registros_por_pagina =isset($_POST['registros_por_pagina_contas'])?$_POST['registros_por_pagina_contas']:5;
	$offset =isset($_POST['offset_contas'])?$_POST['offset_contas']:0;


	$nome_conta = isset($_POST['historico_contas_despesas_investimentos'])?$_POST['historico_contas_despesas_investimentos']:'';
	$natureza_conta = isset($_POST['historico_contas_select'])?$_POST['historico_contas_select']:'';


	//SQL para pegar informações de ccontas sda empresa
	$sql_dados_atividades = "SELECT DATE_FORMAT(vencimento, '%d %b %Y') AS data_inclusao, DATE_FORMAT(data_registro, '%d %b %Y') AS data_registro, nome_conta, natureza_conta, valor_conta, forma_pagamento_conta, parcelas, vencimento, id_conta 
							FROM contas 
							WHERE pago_conta = 'SIM' AND nome_conta LIKE '%$nome_conta%' AND natureza_conta LIKE '%$natureza_conta%'
							ORDER BY vencimento";


	$resultado_id = mysqli_query($con,$sql_dados_atividades);

	/* -----------------  Consultar CONTAS PAGAS ------------------- */
	// consultar registro de CONTAS PAGAS
	$sql_historico_qtd = "SELECT COUNT(*) AS total_registros
		FROM (
		    SELECT id_conta
		    FROM contas
		    WHERE pago_conta = 'SIM' AND nome_conta LIKE '%$nome_conta%' AND natureza_conta LIKE '%$natureza_conta%'
		) AS subconsulta";

	$quantidade_historico;
	$resultado_id_historico_qtd = mysqli_query($con,$sql_historico_qtd);
	if($resultado_id_historico_qtd){
		while($linha = mysqli_fetch_array($resultado_id_historico_qtd)){
			$quantidade_historico = $linha['total_registros'];
		}
	}

	//SQL historico e paginação Vendas 
	$sql_historico = "SELECT 
	DATE_FORMAT(data_registro, '%d %b %Y') AS data_registro, 
	DATE_FORMAT(vencimento, '%d %b %Y') AS data_vencimento,
	DATE_FORMAT(data_pagamento, '%d %b %Y') AS data_pagamento,
	id_conta,
	nome_conta,
	natureza_conta,
	valor_conta,
	parcelas
	FROM contas 
	WHERE pago_conta = 'SIM' AND nome_conta LIKE '%$nome_conta%' AND natureza_conta LIKE '%$natureza_conta%'
	ORDER BY data_registro DESC
	LIMIT $registros_por_pagina
	OFFSET $offset ";
	
	$resultado_id_historico = mysqli_query($con,$sql_historico);

	if($resultado_id_historico){
		$offset++;
		$i = 0;

		$total_paginas = ceil($quantidade_historico / $registros_por_pagina);
					//1/5
		$pagina_atual = ceil($offset / $registros_por_pagina); //localiza a página atual
		for($i = 1; $i <= $total_paginas; $i++) {
	        //$classe_botao = $pagina_atual == $i ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
	        $classe_botao = $pagina_atual == $i ? 'btn_selecionar_pagina' : 'btn_sem_selecionar_pagina';
	        echo '<button class="btn '.$classe_botao.' paginar_contas" data-pagina_clicada="'.$i.'">'.$i.'</button>';
	     }
	     echo '<div class="row relacao_contas info_dados">
		            		<div class="col-2">Nome</div>
							<div class="col-1">Valor</div>
							<div class="col-2">Método</div>
							<div class="col-1">Parcelas</div>
							<div class="col-2">Vencimento</div>
							<div class="col-2">Registrado</div>
							<div class="col-2">Pago em</div>	
            			</div>';
		while($linha = mysqli_fetch_array($resultado_id_historico, MYSQLI_ASSOC)){
			$i++;
			echo '	<hr>
					<form id="form_historico_contas'.$i.'">
						<div class="d-none"><input name="id_conta" value="'.$linha["id_conta"].'"/></div>
						<div class="d-none"><input name="nome_conta" value="'.$linha["nome_conta"].'"/></div>
					</form>
					<div class="row item_exibir d-flex align-items-center justify-content-center">
						<div class="col-md-2">
							<p>'.$linha["nome_conta"].'</p>
						</div>
						<div class="col-md-1">
							<p>'.$linha["valor_conta"].'</p>
						</div>
						<div class="col-md-2">
							<p>'.$linha["natureza_conta"].'</p>
						</div>
						<div class="col-md-1">
							<p>'.$linha["parcelas"].'</p>
						</div>
						<div class="col-md-2">
							<p>'.$linha["data_vencimento"].'</p>
						</div>
						<div class="col-md-2">
							<p>'.$linha["data_registro"].'</p>
						</div>
						<div class="col-md-2">
							<p>'.$linha["data_pagamento"].'</p>
						</div>						
						
					</div>
					<div class="col-12">
						<div class="btn-group">

							
							<button class="btn_opcao">
								<img src="img/3_pontos.png">
							</button>


							<div class="btn_excluir">
								<span>Excluir</span>
								<div>
									<button type="button" class="btn_excluir_sim" onclick="excluir_historico_conta('.$i.')">Sim</button>
								</div>
							</div>
							  
						</div>
					</div>
				';
				

			
		}
		for($i = 1; $i <= $total_paginas; $i++) {
	        //$classe_botao = $pagina_atual == $i ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
	        $classe_botao = $pagina_atual == $i ? 'btn_selecionar_pagina' : 'btn_sem_selecionar_pagina';
	        echo '<button class="btn '.$classe_botao.' paginar_contas" data-pagina_clicada="'.$i.'">'.$i.'</button>';
	     }

	}



	


?>
