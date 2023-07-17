<?php

	session_start();

	include_once 'db_class.php';

	
	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();


	$id_fornecedor = isset($_POST['id_fornecedor'])?$_POST['id_fornecedor']:false;	
	$editar_nome_fornecedor = isset($_POST['editar_nome_fornecedor'])?$_POST['editar_nome_fornecedor']:false;
	$editar_cpf_cnpj_fornecedor = isset($_POST['editar_cpf_fornecedor'])?$_POST['editar_cpf_fornecedor']:false;
	$editar_telefone_fornecedor = isset($_POST['editar_telefone_fornecedor'])?$_POST['editar_telefone_fornecedor']:false;
	$editar_rua_fornecedor = isset($_POST['editar_rua_fornecedor'])?$_POST['editar_rua_fornecedor']:false;
	$editar_numero_casa_fornecedor = isset($_POST['editar_numero_casa_fornecedor'])?$_POST['editar_numero_casa_fornecedor']:false;
	$editar_bairro_fornecedor = isset($_POST['editar_bairro_fornecedor'])?$_POST['editar_bairro_fornecedor']:false;
	$editar_cidade_fornecedor = isset($_POST['editar_cidade_fornecedor'])?$_POST['editar_cidade_fornecedor']:false;
	$editar_uf_fornecedor = isset($_POST['editar_uf_fornecedor'])?$_POST['editar_uf_fornecedor']:false;
	$editar_ceep_fornecedor = isset($_POST['editar_ceep_fornecedor'])?$_POST['editar_ceep_fornecedor']:false;

	
	$sql_alterar_fornecedor_nome = '';
	$sql_alterar_fornecedor_cpf = '';
	$sql_alterar_fornecedor_telefone = '';
	$sql_alterar_fornecedor_rua = '';
	$sql_alterar_fornecedor_numero_casa = '';
	$sql_alterar_fornecedor_bairro = '';
	$sql_alterar_fornecedor_cidade = '';
	$sql_alterar_fornecedor_uf = '';
	$sql_alterar_fornecedor_ceep = '';

	//query para comparar o que foi editado
	$sql_comparar_edicao = "SELECT * FROM fornecedores WHERE id_fornecedor = '$id_fornecedor'";
	$resultado_id_sql_edicao = mysqli_query($con, $sql_comparar_edicao);


	//Regatar dados antigos
	$nome_fornecedor_antigo = '';
	$cpf_cnpj_fornecedor_antigo = '';
	$telefone_fornecedor_antigo = '';
	$rua_fornecedor_antigo = '';
	$numero_fornecedor_antigo = '';
	$bairro_fornecedor_antigo = '';
	$cidade_fornecedor_antigo = '';
	$uf_fornecedor_antigo = '';
	$ceep_fornecedor_antigo = '';

	if($resultado_id_sql_edicao){
		while($linha = mysqli_fetch_array($resultado_id_sql_edicao)){
			$nome_fornecedor_antigo = $linha['nome_fornecedor'];
			$cpf_cnpj_fornecedor_antigo = $linha['cpf_cnpj'];
			$telefone_fornecedor_antigo = $linha['contato_telefone'];
			$rua_fornecedor_antigo = $linha['rua'];
			$numero_fornecedor_antigo = $linha['numero'];
			$bairro_fornecedor_antigo = $linha['bairro'];
			$cidade_fornecedor_antigo = $linha['cidade'];
			$uf_fornecedor_antigo = $linha['uf'];
			$ceep_fornecedor_antigo = $linha['ceep'];
		}
	}

	$sql_alterar_fornecedor = '';
	$valor_operacao_novo = '';


	$alteracao = 'Alterações:<br/>';

	if($editar_nome_fornecedor){
		$sql_alterar_fornecedor_nome = "UPDATE fornecedores SET nome_fornecedor =  '$editar_nome_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_nome = mysqli_query($con,$sql_alterar_fornecedor_nome);
		$alteracao = $alteracao.'<p>Nome Fornecedor de <u>"'.$nome_fornecedor_antigo.'"</u> para <u>"'.$editar_nome_fornecedor.'"</u><p/>';
	}

	if($editar_cpf_cnpj_fornecedor){
		$sql_alterar_fornecedor_cpf = "UPDATE fornecedores SET cpf_cnpj =  '$editar_cpf_cnpj_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_cpf = mysqli_query($con,$sql_alterar_fornecedor_cpf);
		$alteracao = $alteracao.'<p>CPF Fornecedor de <u>"'.$cpf_cnpj_fornecedor_antigo.'"</u> para <u>"'.$editar_cpf_cnpj_fornecedor.'"</u><p/>';

	}

	if($editar_telefone_fornecedor){
		$sql_alterar_fornecedor_telefone = "UPDATE fornecedores SET contato_telefone =  '$editar_telefone_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_telefone = mysqli_query($con,$sql_alterar_fornecedor_telefone);
		$alteracao = $alteracao.'<p>Telefone Fornecedor de <u>"'.$telefone_fornecedor_antigo.'"</u> para <u>"'.$editar_telefone_fornecedor.'"</u><p/>';
	}

	if($editar_rua_fornecedor){
		$sql_alterar_fornecedor_rua = "UPDATE fornecedores SET rua =  '$editar_rua_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_rua = mysqli_query($con,$sql_alterar_fornecedor_rua);
		$alteracao = $alteracao.'<p>Rua Fornecedor de <u>"'.$rua_fornecedor_antigo.'"</u> para <u>"'.$editar_rua_fornecedor.'"</u><p/>';
	}

	if($editar_numero_casa_fornecedor){
		$sql_alterar_fornecedor_numero_casa = "UPDATE fornecedores SET numero =  '$editar_numero_casa_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_numero_casa = mysqli_query($con,$sql_alterar_fornecedor_numero_casa);
		$alteracao = $alteracao.'<p>Número casa Fornecedor de <u>"'.$numero_fornecedor_antigo.'"</u> para <u>"'.$editar_numero_casa_fornecedor.'"</u><p/>';
	}

	if($editar_bairro_fornecedor){
		$sql_alterar_fornecedor_bairro = "UPDATE fornecedores SET bairro =  '$editar_bairro_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_bairro = mysqli_query($con,$sql_alterar_fornecedor_bairro);
		$alteracao = $alteracao.'<p>Bairro Fornecedor de <u>"'.$bairro_fornecedor_antigo.'"</u> para <u>"'.$editar_bairro_fornecedor.'"</u><p/>';
	}

	if($editar_cidade_fornecedor){
		$sql_alterar_fornecedor_cidade = "UPDATE fornecedores SET cidade =  '$editar_cidade_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_cidade = mysqli_query($con,$sql_alterar_fornecedor_cidade);
		$alteracao = $alteracao.'<p>Cidade Fornecedor de <u>"'.$cidade_fornecedor_antigo.'"</u> para <u>"'.$editar_cidade_fornecedor.'"</u><p/>';
	}

	if($editar_uf_fornecedor){
		$sql_alterar_fornecedor_uf = "UPDATE fornecedores SET uf =  '$editar_uf_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_uf = mysqli_query($con,$sql_alterar_fornecedor_uf);
		$alteracao = $alteracao.'<p>Estado(UF) Fornecedor de <u>"'.$uf_fornecedor_antigo.'"</u> para <u>"'.$editar_uf_fornecedor.'"</u><p/>';
	}

	if($editar_ceep_fornecedor){
		$sql_alterar_fornecedor_ceep = "UPDATE fornecedores SET ceep =  '$editar_ceep_fornecedor' WHERE id_fornecedor = '$id_fornecedor'";
		$resultado_id_ceep = mysqli_query($con,$sql_alterar_fornecedor_ceep);
		$alteracao = $alteracao.'<p>CEEP Fornecedor de <u>"'.$ceep_fornecedor_antigo.'"</u> para <u>"'.$editar_ceep_fornecedor.'"</u><p/>';
	}

	if($editar_nome_fornecedor || $editar_cpf_cnpj_fornecedor || $editar_telefone_fornecedor || $editar_rua_fornecedor || $editar_numero_casa_fornecedor || $editar_bairro_fornecedor || $editar_cidade_fornecedor || $editar_uf_fornecedor || $editar_ceep_fornecedor){

		$sql_pesquisar_fornecedor_ja_editado = "SELECT * 
												FROM fornecedores 
												WHERE id_fornecedor = $id_fornecedor";
			$nome_fornecedor_alteracao_edicao = '';

			$resultado_id_edicao = mysqli_query($con,$sql_pesquisar_fornecedor_ja_editado);

			if($resultado_id_edicao){
				while($linha = mysqli_fetch_array($resultado_id_edicao)){
					$nome_fornecedor_alteracao_edicao = $linha['nome_fornecedor'];
				}
			}
			$sql_incluir_fornecedor_historico = "INSERT INTO historico_alteracoes 
			(id_fornecedor,nome_alteracao,descricao,tipo_operacao) 
			VALUES 
			($id_fornecedor,'$nome_fornecedor_alteracao_edicao','$alteracao','Edicao')";
			$acrescentar_historico = mysqli_query($con, $sql_incluir_fornecedor_historico);
	}


?>