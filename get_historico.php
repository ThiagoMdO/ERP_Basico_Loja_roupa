<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();

	$registros_por_pagina =isset($_POST['registros_por_pagina'])?$_POST['registros_por_pagina']:5;
	$offset =isset($_POST['offset'])?$_POST['offset']:0;


	$nome_cliente = isset($_POST['nome_cliente'])?$_POST['nome_cliente']:'';
	
	$nome_produto = isset($_POST['nome_produto'])?$_POST['nome_produto']:'';


	/* -----------------  Consultar Vendas - CLIENTES ------------------- */
	if($nome_cliente != 'false'){
		// consultar registro de Vendas
		$sql_historico_qtd_vendas = "SELECT COUNT(*) AS total_registros
			FROM (
				SELECT id_nota_compras
				FROM notas_compras
				WHERE nome_cliente LIKE '%$nome_cliente%' AND nome_produto LIKE '%$nome_produto%'
			) AS subconsulta";

		/*
		// consultar registro de Vendas
		$sql_historico_qtd = "SELECT COUNT(*) AS total_registros
			FROM (
			    SELECT nc.id_nota_compras
			    FROM notas_compras AS nc
			    JOIN clientes AS c ON nc.id_cliente = c.id_cliente
			    JOIN produto_estoque AS pe ON nc.id_produto = pe.id_produto
			    WHERE c.nome_cliente LIKE '%$nome_cliente%' AND pe.nome_produto LIKE '%$nome_produto%'
			) AS subconsulta";
		*/

		$quantidade_historico;
		$resultado_id_historico_qtd = mysqli_query($con,$sql_historico_qtd_vendas);
		if($resultado_id_historico_qtd){
			while($linha = mysqli_fetch_array($resultado_id_historico_qtd)){
				$quantidade_historico = $linha['total_registros'];
			}
		}

		//SQL historico e paginação Vendas
		$sql_historico_vendas = "SELECT DATE_FORMAT(data_inclusao, '%d %b %Y %T') AS data_inclusao, id_nota_compras, id_cliente, nome_cliente, contato_telefone_cliente, id_produto, nome_produto, descricao_venda
			FROM notas_compras 
			WHERE nome_cliente LIKE '%$nome_cliente%' AND nome_produto LIKE '%$nome_produto%'
			ORDER BY data_inclusao DESC
			LIMIT $registros_por_pagina
			OFFSET $offset";
				
		/*//SQL historico e paginação Vendas 
		$sql_historico = "SELECT DATE_FORMAT(nc.data_inclusao, '%d %b %Y %T') AS data_inclusao, nc.id_nota_compras, nc.descricao_venda, nc.metodo_pagamento, nc.parcelas, nc.desconto, nc.taxa, c.nome_cliente, c.contato_telefone, pe.nome_produto
			FROM notas_compras as nc 
			JOIN clientes as c on(nc.id_cliente = c.id_cliente)
			JOIN produto_estoque as pe on(nc.id_produto = pe.id_produto) 
			WHERE c.nome_cliente LIKE '%$nome_cliente%' AND pe.nome_produto LIKE '%$nome_produto%'
			ORDER BY data_inclusao DESC
			LIMIT $registros_por_pagina
			OFFSET $offset ";
		*/
		
		$resultado_id_historico = mysqli_query($con,$sql_historico_vendas);
		if($resultado_id_historico){
			$offset++;
			$i = 0;

			$total_paginas = ceil($quantidade_historico / $registros_por_pagina);
						//1/5
			$pagina_atual = ceil($offset / $registros_por_pagina); //localiza a página atual
			for($e = 1; $e <= $total_paginas; $e++) {
		        $classe_botao = $pagina_atual == $e ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
		        echo '<button class="btn '.$classe_botao.' paginar" data-pagina_clicada="'.$e.'">'.$e.'</button>';
		     }

		     echo '<div id="vendas_e_compras_clientes">
	                    <div class="row">
							<div class="col-2">Clientes</div>
							<div class="col-8">Descrição venda</div>
							<div class="col-2">Data</div>
						</div>
	                </div>';
			while($linha = mysqli_fetch_array($resultado_id_historico, MYSQLI_ASSOC)){
				$i++;

				echo '
							
		                <hr>
						<form id="form_historico_'.$i.'">
							<div class="d-none"><input name="id_nota_compras" value="'.$linha["id_nota_compras"].'"/></div>
						</form>
						<div class="row linha_pesquisa">
							<div class="col-md-2">
									<p>'.$linha["nome_cliente"].'</p>
									<p>Fone: '.$linha["contato_telefone_cliente"].'</p>
							</div>
							<div class="col-md-8">
									<p> Nota número: '.$linha["id_nota_compras"].'</p>
									<p>'.$linha["descricao_venda"].'</p>
							</div>
							<div class="col-md-2">
									<p>'.$linha["data_inclusao"].'</p>
							</div>
							<div class="col-md-12">
								<div class="btn-group">
								  <button type="button" class="btn btn-small btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								    Excluir
								  </button>
								  <ul class="dropdown-menu" style="text-align:center">
								    <li><button type="button" class="btn btn-outline-danger btn_excluir_item" onclick="excluir_historico('.$i.')">Sim</button></li>
								    <hr>
								    <li><button type="button" class="btn btn-outline-primary">Não</button></li>
								  </ul>
								</div>
							</div>
						</div>
					';
					

				
			}
			for($e = 1; $e <= $total_paginas; $e++) {
		        $classe_botao = $pagina_atual == $e ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
		        echo '<button class="btn '.$classe_botao.' paginar" data-pagina_clicada="'.$e.'">'.$e.'</button>';
		     }

		}
	}
	
	//zerarvariaveis para nova consulta
	$nome_fornecedor = isset($_POST['nome_fornecedor'])?$_POST['nome_fornecedor']:null;
	$nome_produto = isset($_POST['nome_produto'])?$_POST['nome_produto']:'';
	$offset =isset($_POST['offset'])?$_POST['offset']:0;
	$registros_por_pagina =isset($_POST['registros_por_pagina'])?$_POST['registros_por_pagina']:5;

	/* -----------------  Consultar Compras - FORNECEDORES ------------------- */
	if($nome_fornecedor != 'false'){
		
		// consultar registro de Compras
		$sql_historico_qtd_compras = "SELECT COUNT(*) AS total_registros
			FROM (
				SELECT id_nota_compras
				FROM notas_compras
				WHERE nome_fornecedor LIKE '%$nome_fornecedor%' AND nome_produto LIKE '%$nome_produto%'
			) AS subconsulta";

		/*
		$sql_historico_qtd_compras = "SELECT COUNT(*) AS total_registros
			FROM (
			    SELECT nc.id_nota_compras
			    FROM notas_compras AS nc
			    JOIN fornecedores AS f ON nc.id_fornecedor = f.id_fornecedor
			    JOIN produto_estoque AS pe ON nc.id_produto = pe.id_produto
			    WHERE f.nome_fornecedor LIKE '%$nome_fornecedor%' AND pe.nome_produto LIKE '%$nome_produto%'
			) AS subconsulta";
		*/
		$quantidade_historico_compras;
		$resultado_id_historico_qtd_compras = mysqli_query($con,$sql_historico_qtd_compras);
		if($resultado_id_historico_qtd_compras){
			while($linha = mysqli_fetch_array($resultado_id_historico_qtd_compras)){
				$quantidade_historico_compras = $linha['total_registros'];
			}
		}

		//SQL historico e paginação Compras
		$sql_historico_compras = "SELECT DATE_FORMAT(data_inclusao, '%d %b %Y %T') AS data_inclusao, id_nota_compras, id_fornecedor, nome_fornecedor, contato_telefone_fornecedor, id_produto, nome_produto, descricao_venda
			FROM notas_compras 
			WHERE nome_fornecedor LIKE '%$nome_fornecedor%' AND nome_produto LIKE '%$nome_produto%'
			ORDER BY data_inclusao DESC
			LIMIT $registros_por_pagina
			OFFSET $offset";

		
		/*
		//SQL historico e paginação Compras
		
		$sql_historico_compras = "SELECT DATE_FORMAT(nc.data_inclusao, '%d %b %Y %T') AS data_inclusao, nc.id_nota_compras, nc.descricao_venda, nc.metodo_pagamento, nc.parcelas, nc.desconto, nc.taxa, f.nome_fornecedor, f.contato_telefone, pe.nome_produto
			FROM notas_compras as nc 
			JOIN fornecedores as f on(nc.id_fornecedor = f.id_fornecedor)
			JOIN produto_estoque as pe on(nc.id_produto = pe.id_produto) 
			WHERE f.nome_fornecedor LIKE '%$nome_fornecedor%' AND pe.nome_produto LIKE '%$nome_produto%'
			ORDER BY data_inclusao DESC
			LIMIT $registros_por_pagina
			OFFSET $offset ";
		*/
		
		$resultado_id_historico_compras = mysqli_query($con,$sql_historico_compras);
		
		if($resultado_id_historico_compras){
			$offset++;
			$i = 0;

			$total_paginas = ceil($quantidade_historico_compras / $registros_por_pagina);
						//1/5
			$pagina_atual = ceil($offset / $registros_por_pagina); //localiza a página atual
			for($i = 1; $i <= $total_paginas; $i++) {
		        $classe_botao = $pagina_atual == $i ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
		        echo '<button class="btn '.$classe_botao.' paginar" data-pagina_clicada="'.$i.'">'.$i.'</button>';
		     };
		     echo '<div id="vendas_e_compras_fornecedores">
	                    <div class="row">
							<div class="col-2">Fornecedores</div>
							<div class="col-8">Descrição venda</div>
							<div class="col-2">Data</div>
						</div>
	                </div>';
			while($linha = mysqli_fetch_array($resultado_id_historico_compras, MYSQLI_ASSOC)){
				$i++;
				echo '
						<hr>
						<form id="form_historico_'.$i.'">
							<div class="d-none"><input name="id_nota_compras" value="'.$linha["id_nota_compras"].'"/></div>
						</form>
						<div class="row linha_pesquisa">
							<div class="col-md-2">
									<p>'.$linha["nome_fornecedor"].'</p>
									<p>Fone: '.$linha["contato_telefone_fornecedor"].'</p>
							</div>
							<div class="col-md-8">
									<p> Nota número: '.$linha["id_nota_compras"].'</p>
									<p>'.$linha["descricao_venda"].'</p>
							</div>
							<div class="col-md-2">
									<p>'.$linha["data_inclusao"].'</p>
							</div>
							<div class="col-md-12">
								<div class="btn-group">
								  <button type="button" class="btn btn-small btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								    Excluir
								  </button>
								  <ul class="dropdown-menu" style="text-align:center">
								    <li><button type="button" class="btn btn-outline-danger btn_excluir_item" onclick="excluir_historico('.$i.')">Sim</button></li>
								    <hr>
								    <li><button type="button" class="btn btn-outline-primary">Não</button></li>
								  </ul>
								</div>
							</div>
						</div>
					';
					

				
			}
			for($i = 1; $i <= $total_paginas; $i++) {
		        $classe_botao = $pagina_atual == $i ? 'btn-primary' : 'btn-outline-primary'; //aplica a classe para o botão da página atual
		        echo '<button class="btn '.$classe_botao.' paginar" data-pagina_clicada="'.$i.'">'.$i.'</button>';
		    }
		}
	}


?>
