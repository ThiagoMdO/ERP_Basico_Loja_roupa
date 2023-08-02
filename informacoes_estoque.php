<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	//sql valor estoque
	$sql_valor_estoque = "SELECT * FROM produto_estoque";

	$resultado_id = mysqli_query($con,$sql_valor_estoque);
	
	//sql consultar total de itens sem estoque
	$sql_sem_estoque = "SELECT COUNT(*) AS quantidadeR
			FROM (
				SELECT quantidade
				FROM produto_estoque
				WHERE quantidade = 0) AS subconsulta";
	$resultado_id_sem_estoque = mysqli_query($con,$sql_sem_estoque);
	$total_sem_estoque = 0;
	while($linha = mysqli_fetch_array($resultado_id_sem_estoque)){		
		$total_sem_estoque += $linha['quantidadeR'];
	}

	//sql consultar total de itens estoque baixo <=5
	$sql_baixo_estoque = "SELECT COUNT(*) AS quantidadeR
			FROM (
				SELECT quantidade
				FROM produto_estoque
				WHERE quantidade <= 5 AND quantidade > 0) AS subconsulta";
	$resultado_id_baixo_estoque = mysqli_query($con,$sql_baixo_estoque);
	$total_baixo_estoque = 0;
	while($linha = mysqli_fetch_array($resultado_id_baixo_estoque)){		
		$total_baixo_estoque += $linha['quantidadeR'];
	}

	$total = 0;
	$qtd_estoque_geral = 0;
	$preco_total_fornecedor = 0;
	while($linha = mysqli_fetch_array($resultado_id)){
		$total += $linha['preco_produto_cliente']*$linha['quantidade'];
		$qtd_estoque_geral += $linha['quantidade'];
		$preco_total_fornecedor+=$linha['preco_produto_fornecedor']*$linha['quantidade'];
	}
	$lucro = $total - $preco_total_fornecedor;
	echo 
			'<div style="color:white" class="container-fluid border_custom d-block bg-dark">
				<div class="row"><h3>VALOR EM ESTOQUE</h3></div>
				<div class="row"><h2>R$ <span id="valor_estoque">'.$total.'</span></h2></div>
				<div class="row">
					<div class="col-7">
						<p>Custo do estoque: R$'.$preco_total_fornecedor.'</p>
						<p>Lucro previsto: R$'.$lucro.'</p>
					</div>
					<div class="col-5">
						<p><span id="qtd_estoque_geral">'.$qtd_estoque_geral.'</span> Itens em estoque</p>
						<p style="color:#FFD700">Estoque baixo '.$total_baixo_estoque.'</p>
						<p style="color:#FF6347">Sem estoque '.$total_sem_estoque.'</p>
					</div>
				</div>
			</div>
			'


?>