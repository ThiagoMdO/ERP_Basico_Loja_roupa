<?php 
	
	session_start();

	include_once 'db_class.php';	


	$usuario = isset($_POST['usuario'])?$_POST['usuario']:0;
	$senha_usuario = isset($_POST['password'])?md5($_POST['password']):0;

	if(!$usuario || !$senha_usuario){
		header('Location:index.php?erro=1');
	}

	//query de comparação
	$sql = "SELECT * FROM usuario WHERE nome = '$usuario' AND senha = '$senha_usuario'";

	//instanciar class do BD
	$objDB = new db();
	$con = $objDB->conecta_mysql();

	$resultado_id = mysqli_query($con,$sql);
	echo '<br/>';
	if($resultado_id){
		$dados_usuario = mysqli_fetch_array($resultado_id,MYSQLI_ASSOC);
		if($dados_usuario){
			$_SESSION['nome'] = $dados_usuario['nome'];
			header('Location: home.php');
		}else{
			header('Location: index.php?erro=1');
		}
	}


	

?>