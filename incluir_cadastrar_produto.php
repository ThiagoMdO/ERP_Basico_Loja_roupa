<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();

	
	$nome_produto = isset($_POST['nomeProduto_cadastrar'])?$_POST['nomeProduto_cadastrar']:false;
	$data_venda_produto = isset($_POST['data_cadastrar'])?$_POST['data_cadastrar']:false;
	$cor_produto = isset($_POST['cor_cadastrar'])?$_POST['cor_cadastrar']:false;
	$tamanho_produto = isset($_POST['tamanho_cadastrar'])?$_POST['tamanho_cadastrar']:false;
	$preco_produto_fornecedor = isset($_POST['preco_cadastrar_fornecedor'])?$_POST['preco_cadastrar_fornecedor']:false;
	//$quantidade_produto = isset($_POST['qtd_cadastrar'])?$_POST['qtd_cadastrar']:false;
	$preco_produto_cliente = isset($_POST['preco_cadastrar_cliente'])?$_POST['preco_cadastrar_cliente']:false;;


	$sql_incluir_produto = "INSERT INTO produto_estoque (nome_produto, data_venda, cor, tamanho, preco_produto_fornecedor,preco_produto_cliente,quantidade) VALUES ('$nome_produto', '$data_venda_produto', '$cor_produto', '$tamanho_produto', '$preco_produto_fornecedor','$preco_produto_cliente')";

	//sql vai testar se existe registro especificos e não deixar cadastar o mesmo produto
	$slq_testa_produto_existente = "SELECT * FROM produto_estoque WHERE nome_produto = '$nome_produto' && cor = '$cor_produto' && tamanho = '$tamanho_produto'";
	$resultado_id_existe = mysqli_query($con,$slq_testa_produto_existente);
	if($nome_produto && $data_venda_produto && $cor_produto && $tamanho_produto && $preco_produto_fornecedor && $preco_produto_cliente){
		if($resultado_id_existe){
			$resposta_sql = mysqli_fetch_array($resultado_id_existe, MYSQLI_ASSOC);
			if (!$resposta_sql) {

				$resultado_id = mysqli_query($con,$sql_incluir_produto);
				echo 'Produto cadastrado com sucesso';
			}else{
				echo 'Produto já existe, por favor, edite a quantidade que desejar na página estoque';
				return false;			
			}
		}
	}else{
		echo 'Preencha todos os campos do formulário';
	}
	
	die();

	/*if($nome_produto && $data_venda_produto && $cor_produto && $tamanho_produto && $preco_produto_fornecedor){
		if($resultado_id_existe){
			echo 'Produto já cadastrado, volte para a página estoque e edite a quantidade para acrescentar';
			return false;
		}
		//Inserir dados da tabela produtos
		$resultado_id = mysqli_query($con,$sql_incluir_produto);
		if($resultado_id){
			echo 'Produto cadastrado com sucesso!!';
		}else{
			echo 'Erro em cadastrado produto';
		}

	}else{
		echo 'Preeencha todos os campos';	
	}*/
	


/*
		Mais segurança
	//verificar se todos dados foram inseridos
	if($nome_produto &&  $cor_produto && $tamanho_produto){

		//Inserir dados da tabela produtos
		$sql_inserir_dados_produtos = "INSERT INTO produto_estoque (nome_produto, data_venda, cor, tamanho, preco_produto_fornecedor) VALUES (?, ?, ?, ?, ?)";

		//preparar query
		$stmt = mysqli_prepare($con,$sql_inserir_dados_produtos);

		if($stmt){
			mysqli_stmt_bind_param($stmt,"ssssdd",$nome_produto,$data_venda_produto,$cor_produto,$tamanho_produto,$preco_produto_fornecedor);

			//execultar query
			$resultado = mysqli_stmt_execute($stmt);

			//mensagem se foi ou não acrescentado o produto
			if($resultado){
				echo 'Produtos cadastrados com sucesso!!';
			}else{
				echo 'Erro ao cadastrar os produtos';
			}
		}else{
			echo 'Erro na preparação da cunsulta';
		}
			

	}else{
		echo 'Todos campos devem ser preenchidos';
	}*/

	


?>
