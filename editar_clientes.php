<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_cliente = isset($_POST['id_cliente'])?$_POST['id_cliente']:false;	
	$editar_nome_cliente = isset($_POST['editar_nome_cliente'])?$_POST['editar_nome_cliente']:false;
	$editar_cpf_cliente = isset($_POST['editar_cpf_cliente'])?$_POST['editar_cpf_cliente']:false;
	$editar_telefone_cliente = isset($_POST['editar_telefone_cliente'])?$_POST['editar_telefone_cliente']:false;
	$editar_rua_cliente = isset($_POST['editar_rua_cliente'])?$_POST['editar_rua_cliente']:false;
	$editar_numero_casa_cliente = isset($_POST['editar_numero_casa_cliente'])?$_POST['editar_numero_casa_cliente']:false;
	$editar_bairro_cliente = isset($_POST['editar_bairro_cliente'])?$_POST['editar_bairro_cliente']:false;
	$editar_cidade_cliente = isset($_POST['editar_cidade_cliente'])?$_POST['editar_cidade_cliente']:false;
	$editar_uf_cliente = isset($_POST['editar_uf_cliente'])?$_POST['editar_uf_cliente']:false;
	$editar_ceep_cliente = isset($_POST['editar_ceep_cliente'])?$_POST['editar_ceep_cliente']:false;

	
	$sql_alterar_cliente_nome = '';
	$sql_alterar_cliente_cpf = '';
	$sql_alterar_cliente_telefone = '';
	$sql_alterar_cliente_rua = '';
	$sql_alterar_cliente_numero_casa = '';
	$sql_alterar_cliente_bairro = '';
	$sql_alterar_cliente_cidade = '';
	$sql_alterar_cliente_uf = '';
	$sql_alterar_cliente_ceep = '';


	//query para comparar o que foi editado
	$sql_comparar_edicao = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
	$resultado_id_sql_edicao = mysqli_query($con, $sql_comparar_edicao);


	//Regatar dados antigos
	$nome_cliente_antigo = '';
	$cpf_cliente_antigo = '';
	$telefone_cliente_antigo = '';
	$rua_cliente_antigo = '';
	$numero_cliente_antigo = '';
	$bairro_cliente_antigo = '';
	$cidade_cliente_antigo = '';
	$uf_cliente_antigo = '';
	$ceep_cliente_antigo = '';

	if($resultado_id_sql_edicao){
		while($linha = mysqli_fetch_array($resultado_id_sql_edicao)){
			$nome_cliente_antigo = $linha['nome_cliente'];
			$cpf_cliente_antigo = $linha['cpf'];
			$telefone_cliente_antigo = $linha['contato_telefone'];
			$rua_cliente_antigo = $linha['rua'];
			$numero_cliente_antigo = $linha['numero'];
			$bairro_cliente_antigo = $linha['bairro'];
			$cidade_cliente_antigo = $linha['cidade'];
			$uf_cliente_antigo = $linha['uf'];
			$ceep_cliente_antigo = $linha['ceep'];
		}
	}

	$valor_operacao_novo = '';


	$alteracao = 'Alterações:<br/>';

	if($editar_nome_cliente){
		//sqls verificar se tem nome, cpf ou telefone igual
		//nome
		$sql_verifica_nome_existe = "SELECT nome_cliente FROM clientes WHERE nome_cliente = '$editar_nome_cliente'";
		$resultado_nome_existe = mysqli_query($con, $sql_verifica_nome_existe);

		if($resultado_nome_existe){
			$nome_existe = false;
			while($linha = mysqli_fetch_array($resultado_nome_existe, MYSQLI_ASSOC)){
				$nome_existe = ['nome_cliente'];
			}
			if($nome_existe){
				echo 'Nome já em uso';
				return false;
			}else{
				echo 'Nome atualizado';
			}
		}
		$sql_alterar_cliente_nome = "UPDATE clientes SET nome_cliente =  '$editar_nome_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_nome = mysqli_query($con,$sql_alterar_cliente_nome);

		$alteracao = $alteracao.'<p>Nome Cliente de <u>"'.$nome_cliente_antigo.'"</u> para <u>"'.$editar_nome_cliente.'"</u><p/>';


	}

	if($editar_cpf_cliente){
		//sqls verificar se tem nome, cpf ou telefone igual
		//cpf
		$sql_verifica_cpf_existe = "SELECT cpf FROM clientes WHERE cpf = '$editar_cpf_cliente'";
		$resultado_cpf_existe = mysqli_query($con, $sql_verifica_cpf_existe);
		if($resultado_cpf_existe){
			$cpf_existe = false;
			while($linha = mysqli_fetch_array($resultado_cpf_existe, MYSQLI_ASSOC)){
				$cpf_existe = ['cpf'];
			}
			if($cpf_existe){
				echo ' - Número de CPF já em uso';
				return false;
			}else{
				echo ' - Número CPF atualizado';
			}
		}
		$sql_alterar_cliente_cpf = "UPDATE clientes SET cpf =  '$editar_cpf_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_cpf = mysqli_query($con,$sql_alterar_cliente_cpf);
		$valor_operacao_novo = $editar_cpf_cliente;
		$alteracao = $alteracao.'<p>CPF Cliente de <u>"'.$cpf_cliente_antigo.'"</u> para <u>"'.$editar_cpf_cliente.'"</u><p/>';

	}

	if($editar_telefone_cliente){
		//sqls verificar se tem nome, cpf ou telefone igual
		//telefone
		$sql_verifica_telefone_existe = "SELECT contato_telefone FROM clientes WHERE contato_telefone = '$editar_telefone_cliente'";
		$resultado_telefone_existe = mysqli_query($con, $sql_verifica_telefone_existe);
		if($resultado_telefone_existe){
			$telefone_existe = false;
			while($linha = mysqli_fetch_array($resultado_telefone_existe, MYSQLI_ASSOC)){
				$telefone_existe = ['contato_telefone'];
			}
			if($telefone_existe ){
				echo ' - Número de Telefone já em uso';
				return false;
			}else{
				echo ' - Número de Telefone Atualizado';
			}
		}
		$sql_alterar_cliente_telefone = "UPDATE clientes SET contato_telefone =  '$editar_telefone_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_telefone = mysqli_query($con,$sql_alterar_cliente_telefone);
		$alteracao = $alteracao.'<p>Telefone Cliente de <u>"'.$telefone_cliente_antigo.'"</u> para <u>"'.$editar_telefone_cliente.'"</u><p/>';
	}

	if($editar_rua_cliente){
		$sql_alterar_cliente_rua = "UPDATE clientes SET rua =  '$editar_rua_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_rua = mysqli_query($con,$sql_alterar_cliente_rua);
		$alteracao = $alteracao.'<p>Rua Cliente de <u>"'.$rua_cliente_antigo.'"</u> para <u>"'.$editar_rua_cliente.'"</u><p/>';
	}

	if($editar_numero_casa_cliente){
		$sql_alterar_cliente_numero_casa = "UPDATE clientes SET numero =  '$editar_numero_casa_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_numero_casa = mysqli_query($con,$sql_alterar_cliente_numero_casa);
		$alteracao = $alteracao.'<p>Número casa Cliente de <u>"'.$numero_cliente_antigo.'"</u> para <u>"'.$editar_numero_casa_cliente.'"</u><p/>';
	}

	if($editar_bairro_cliente){
		$sql_alterar_cliente_bairro = "UPDATE clientes SET bairro =  '$editar_bairro_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_bairro = mysqli_query($con,$sql_alterar_cliente_bairro);
		$alteracao = $alteracao.'<p>Bairro Cliente de <u>"'.$bairro_cliente_antigo.'"</u> para <u>"'.$editar_bairro_cliente.'"</u><p/>';
	}

	if($editar_cidade_cliente){
		$sql_alterar_cliente_cidade = "UPDATE clientes SET cidade =  '$editar_cidade_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_cidade = mysqli_query($con,$sql_alterar_cliente_cidade);
		$alteracao = $alteracao.'<p>Cidade Cliente de <u>"'.$cidade_cliente_antigo.'"</u> para <u>"'.$editar_cidade_cliente.'"</u><p/>';
	}

	if($editar_uf_cliente){
		$sql_alterar_cliente_uf = "UPDATE clientes SET uf =  '$editar_uf_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_uf = mysqli_query($con,$sql_alterar_cliente_uf);
		$alteracao = $alteracao.'<p>Estado(UF) Cliente de <u>"'.$uf_cliente_antigo.'"</u> para <u>"'.$editar_uf_cliente.'"</u><p/>';
	}

	if($editar_ceep_cliente){
		$sql_alterar_cliente_ceep = "UPDATE clientes SET ceep =  '$editar_ceep_cliente' WHERE id_cliente = '$id_cliente'";
		$resultado_id_ceep = mysqli_query($con,$sql_alterar_cliente_ceep);
		$alteracao = $alteracao.'<p>CEEP Cliente de <u>"'.$ceep_cliente_antigo.'"</u> para <u>"'.$editar_ceep_cliente.'"</u><p/>';
	}
	if($editar_nome_cliente || $editar_cpf_cliente || $editar_telefone_cliente || $editar_rua_cliente || $editar_numero_casa_cliente || $editar_bairro_cliente || $editar_cidade_cliente || $editar_uf_cliente || $editar_ceep_cliente){

		$sql_pesquisar_cliente_ja_editado = "SELECT * 
												FROM clientes 
												WHERE id_cliente = $id_cliente";
			$nome_cliente_alteracao_edicao = '';

			$resultado_id_edicao = mysqli_query($con,$sql_pesquisar_cliente_ja_editado);

			if($resultado_id_edicao){
				while($linha = mysqli_fetch_array($resultado_id_edicao)){
					$nome_cliente_alteracao_edicao = $linha['nome_cliente'];
				}
			}
			$sql_incluir_cliente_historico = "INSERT INTO historico_alteracoes 
			(id_cliente,nome_alteracao,descricao,tipo_operacao) 
			VALUES 
			($id_cliente,'$nome_cliente_alteracao_edicao','$alteracao','Edicao')";
			$acrescentar_historico = mysqli_query($con, $sql_incluir_cliente_historico);
	}else{
		echo 'Preencha ao menos um campo';
	}


?>