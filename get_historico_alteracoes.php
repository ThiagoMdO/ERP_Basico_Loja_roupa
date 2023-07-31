<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();

	$registros_por_pagina =isset($_POST['registros_por_pagina_alteracoes'])?$_POST['registros_por_pagina_alteracoes']:5;
	$offset =isset($_POST['offset_alteracoes'])?$_POST['offset_alteracoes']:0;


	$nome_produto = isset($_POST['nome_produto_alteracao'])?$_POST['nome_produto_alteracao']:'';
	$select_cadastro = isset($_POST['historico_cadastro_select'])?$_POST['historico_cadastro_select']:'';
	$historico_cadastro_select_tipo = isset($_POST['historico_cadastro_select_tipo'])?$_POST['historico_cadastro_select_tipo']:'';


	
	$select_cadastro_consultar = $select_cadastro;
	switch($select_cadastro_consultar){
		case 'produtos':
			$select_cadastro_consultar = 'id_produto';
		break;
		case 'clientes':
			$select_cadastro_consultar = 'id_cliente';
		break;
		case 'fornecedores':
			$select_cadastro_consultar = 'id_fornecedor';
		break;

	}
	$alternador_pesquisa = '';
	if(is_numeric($nome_produto)){
		$alternador_pesquisa = $select_cadastro_consultar;
	}else if(is_string($nome_produto)){
		$alternador_pesquisa = 'nome_alteracao';
	}
	/* -----------------  Consultar ------------------- */
	// consultar registro
	$sql_historico_qtd = "SELECT COUNT(*) AS total_registros
		FROM (
		    SELECT id_alteracao
			    FROM historico_alteracoes
			    WHERE $alternador_pesquisa LIKE '%$nome_produto%' AND tipo_operacao LIKE '%$historico_cadastro_select_tipo%' AND $select_cadastro_consultar > 0
		) AS subconsulta";
	
	$quantidade_historico;
	$resultado_id_historico_qtd = mysqli_query($con,$sql_historico_qtd);
	if($resultado_id_historico_qtd){
		while($linha = mysqli_fetch_array($resultado_id_historico_qtd)){
			$quantidade_historico = $linha['total_registros'];
		}
	}


	//SQL da pesquisa de cadastro, irá alternar entre consultas de produtos, clientes e fornecedores
	$sql_historico_alteracao = '';
		//verificar o tipo da consulta com base no que foi selecionado
	
	
	if($select_cadastro_consultar){
		
			//Faz a seleção do tipo de alteração, todos, cadastro, edição ou excluidos
			$sql_historico_alteracao = "
			SELECT *, DATE_FORMAT(data_alteracao, '%d %b %Y %T') as data_alteracao 
			FROM historico_alteracoes
		    WHERE $alternador_pesquisa LIKE '%$nome_produto%' AND tipo_operacao LIKE '%$historico_cadastro_select_tipo%' AND $select_cadastro_consultar > 0
		    ORDER BY data_alteracao DESC
		    LIMIT $registros_por_pagina
		    OFFSET $offset";

			$resultado_id = mysqli_query($con,$sql_historico_alteracao);
			$offset++;
			$i = 0;

			$total_paginas = ceil($quantidade_historico / $registros_por_pagina);
						//1/5
			$pagina_atual = ceil($offset / $registros_por_pagina); //localiza a página atual
			for($i = 1; $i <= $total_paginas; $i++) {
		        //$classe_botao = $pagina_atual == $i ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
		        $classe_botao = $pagina_atual == $i ? 'btn_selecionar_pagina' : 'btn_sem_selecionar_pagina';
		        echo '<button class="btn '.$classe_botao.' paginar_alteracoes" data-pagina_clicada="'.$i.'">'.$i.'</button>';
		     };
		     echo '<div class="row relacao_cadastro info_dados">
	            		<div class="col-2">Nome</div>
	            		<div class="col-1">Operacao</div>
						<div class="col-7">Descrição</div>
	            		<div class="col-2">Alterado em</div>
        			</div>';
			while($linha = mysqli_fetch_array($resultado_id)){
				$i++;
				echo '	<hr>
						<form id="form_historico_alteracoes'.$i.'">
							<div class="d-none">
								<input name="id_produto" value="'.$linha['id_produto'].'"/>
								<input name="id_alteracao" value="'.$linha['id_alteracao'].'"/>
							</div>
						</form>
						<div class="row item_exibir linha_pesquisa d-flex align-items-center justify-content-center">
							<div class="col-md-2">
								<p>'.$linha["$select_cadastro_consultar"].'-'.$linha["nome_alteracao"].'</p>
							</div>
							<div class="col-md-1">
								<p>'.$linha['tipo_operacao'].'</p>
							</div>
							<div class="col-md-7">
								<p>'.$linha['descricao'].'</p>
							</div>
							<div class="col-md-2">
								<p>'.$linha["data_alteracao"].'</p>
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
									<button type="button" class="btn_excluir_sim" onclick="excluir_historico_alteracoes('.$i.')">Sim</button>
								</div>
							</div>
							  
						</div>
					</div>
					</div>
					';
			}
			for($i = 1; $i <= $total_paginas; $i++) {
		        //$classe_botao = $pagina_atual == $i ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
		        $classe_botao = $pagina_atual == $i ? 'btn_selecionar_pagina' : 'btn_sem_selecionar_pagina';
		        echo '<button class="btn '.$classe_botao.' paginar_alteracoes" data-pagina_clicada="'.$i.'">'.$i.'</button>';
		     };
		
	}
		


?>
