<?php 
	session_start();

	if(!isset($_SESSION['nome'])){
		header('Location: index.php');
	}

	include_once 'db_class.php';

	$objDb = new db();
	$con = $objDb->conecta_mysql();


	$novo_cliente_nome = isset($_POST['novo_cliente_nome'])?$_POST['novo_cliente_nome']:false;
	$novo_cliente_cpf = isset($_POST['novo_cliente_cpf'])?$_POST['novo_cliente_cpf']:false;
	$novo_cliente_telefone = isset($_POST['novo_cliente_telefone'])?$_POST['novo_cliente_telefone']:false;
	$novo_cliente_rua = isset($_POST['novo_cliente_rua'])?$_POST['novo_cliente_rua']:false;
	$novo_cliente_numero_casa = isset($_POST['novo_cliente_numero_casa'])?$_POST['novo_cliente_numero_casa']:false;
	$novo_cliente_bairro = isset($_POST['novo_cliente_bairro'])?$_POST['novo_cliente_bairro']:false;
	$novo_cliente_cidade = isset($_POST['novo_cliente_cidade'])?$_POST['novo_cliente_cidade']:false;
	$novo_cliente_uf = isset($_POST['novo_cliente_uf'])?$_POST['novo_cliente_uf']:false;
	$novo_cliente_ceep = isset($_POST['novo_cliente_ceep'])?$_POST['novo_cliente_ceep']:false;
	
	$descricao = 'CPF: '.$novo_cliente_cpf.', Telefone: '.$novo_cliente_telefone.'
					<br> Endereço: '.$novo_cliente_rua.', '.$novo_cliente_numero_casa.', '.$novo_cliente_bairro.', '.$novo_cliente_cidade.','.$novo_cliente_uf.','.$novo_cliente_ceep;
	//Vericar se existe nome no BD
	$sql_pesquisa_nome_existe = "SELECT nome_cliente FROM clientes  WHERE nome_cliente ='$novo_cliente_nome'";
	$resultado_id_existe = mysqli_query($con, $sql_pesquisa_nome_existe);
	if($resultado_id_existe){
		if(!$novo_cliente_nome){
				echo 'Nome não pode ser em branco';
				return false;
			}
		if($linha = mysqli_fetch_array($resultado_id_existe)){
			
			echo 'Nome de Cliente já existe';

			}else{
			$sql_inserir_cliente = "
				INSERT INTO clientes 
				(nome_cliente,cpf,contato_telefone,rua,numero,bairro,cidade,uf,ceep) 
				VALUES
				('$novo_cliente_nome','$novo_cliente_cpf','$novo_cliente_telefone','$novo_cliente_rua','$novo_cliente_numero_casa','$novo_cliente_bairro','$novo_cliente_cidade','$novo_cliente_uf','$novo_cliente_ceep')";
			$resultado_id = mysqli_query($con,$sql_inserir_cliente);
			//pegar id cliente novo cadastrado
			$id_cliente = 0;
			$sql_get_id_cliente = "SELECT id_cliente FROM clientes WHERE nome_cliente = '$novo_cliente_nome'";
			$resultado_id_cliente = mysqli_query($con, $sql_get_id_cliente);
			while($linha = mysqli_fetch_array($resultado_id_cliente)){
				$id_cliente = $linha['id_cliente'];
			}
			//sql incluir cliente historico
			$sql_incluir_cliente_historico = "
				INSERT INTO historico_alteracoes
				(id_cliente, nome_alteracao, descricao, tipo_operacao)
				VALUES
				($id_cliente, '$novo_cliente_nome','$descricao','Cadastro')";
			$acrescentar_historico = mysqli_query($con, $sql_incluir_cliente_historico);
			if($resultado_id){
				echo $novo_cliente_nome.' foi cadastrado com sucesso';

			}else{
				echo 'Falha em cadastrar '.$novo_cliente_nome;
			}
		}
	}


?>
