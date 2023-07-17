<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	$novo_fornecedor_nome = isset($_POST['novo_fornecedor_nome'])?$_POST['novo_fornecedor_nome']:false;
	$novo_fornecedor_cpf_cnpj = isset($_POST['novo_fornecedor_cpf_cnpj'])?$_POST['novo_fornecedor_cpf_cnpj']:false;
	$novo_fornecedor_telefone = isset($_POST['novo_fornecedor_telefone'])?$_POST['novo_fornecedor_telefone']:false;
	$novo_fornecedor_rua = isset($_POST['novo_fornecedor_rua'])?$_POST['novo_fornecedor_rua']:false;
	$novo_fornecedor_numero_casa = isset($_POST['novo_fornecedor_numero_casa'])?$_POST['novo_fornecedor_numero_casa']:false;
	$novo_fornecedor_bairro = isset($_POST['novo_fornecedor_bairro'])?$_POST['novo_fornecedor_bairro']:false;
	$novo_fornecedor_cidade = isset($_POST['novo_fornecedor_cidade'])?$_POST['novo_fornecedor_cidade']:false;
	$novo_fornecedor_uf = isset($_POST['novo_fornecedor_uf'])?$_POST['novo_fornecedor_uf']:false;
	$novo_fornecedor_ceep = isset($_POST['novo_fornecedor_ceep'])?$_POST['novo_fornecedor_ceep']:false;
	
	$descricao = 'CPF/CPNJ: '.$novo_fornecedor_cpf_cnpj.', Telefone: '.$novo_fornecedor_telefone.'
					<br> Endereço: '.$novo_fornecedor_rua.', '.$novo_fornecedor_numero_casa.', '.$novo_fornecedor_bairro.', '.$novo_fornecedor_cidade.','.$novo_fornecedor_uf.','.$novo_fornecedor_ceep;

	//Vericar se existe nome no BD
	$sql_pesquisa_nome_existe = "SELECT nome_fornecedor FROM fornecedores  WHERE nome_fornecedor ='$novo_fornecedor_nome'";
	$resultado_id_existe = mysqli_query($con, $sql_pesquisa_nome_existe);

	
	if($resultado_id_existe){
		if(!$novo_fornecedor_nome){
				echo 'Nome não pode ser em branco';
				return false;
			}
		if($linha = mysqli_fetch_array($resultado_id_existe)){
			
			echo 'Nome de Fornecedor já existe';

			}else{
			$sql_inserir_fornecedor = "
				INSERT INTO fornecedores 
				(nome_fornecedor,cpf_cnpj,contato_telefone,rua,numero,bairro,cidade,uf,ceep) 
				VALUES 
				('$novo_fornecedor_nome','$novo_fornecedor_cpf_cnpj','$novo_fornecedor_telefone','$novo_fornecedor_rua','$novo_fornecedor_numero_casa','$novo_fornecedor_bairro','$novo_fornecedor_cidade','$novo_fornecedor_uf','$novo_fornecedor_ceep')";
			$resultado_id = mysqli_query($con,$sql_inserir_fornecedor);
			//pegar id fornecedor novo cadastrado
			$id_fornecedor = 0;
			$sql_get_id_fornecedor = "SELECT id_fornecedor FROM fornecedores WHERE nome_fornecedor = '$novo_fornecedor_nome'";
			$resultado_id_fornecedor = mysqli_query($con, $sql_get_id_fornecedor);
			while($linha = mysqli_fetch_array($resultado_id_fornecedor)){
				$id_fornecedor = $linha['id_fornecedor'];
			}
			//sql incluir fornecedor historico
			$sql_incluir_fornecedor_historico = "
				INSERT INTO historico_alteracoes
				(id_fornecedor, nome_alteracao, descricao, tipo_operacao)
				VALUES
				($id_fornecedor, '$novo_fornecedor_nome','$descricao','Cadastro')";
			$acrescentar_historico = mysqli_query($con, $sql_incluir_fornecedor_historico);
			if($resultado_id){
				echo $novo_fornecedor_nome.' foi cadastrado com sucesso';

			}else{
				echo 'Falha em cadastrar '.$novo_fornecedor_nome;
			}
		}
	}


?>
