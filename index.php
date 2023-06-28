<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Empresa Virtual</title>

	<!-- Bootstrap V 5.3 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	
	<!-- Bootstrap V 5.3 CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

	<!-- jquery V 3.7 -->
	<script type="text/javascript" src="jqueryV3.7.js"></script>

	<!-- jquery V 3.7 CDN -->
	<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

	<!-- CSS externo -->
	<link rel="stylesheet" type="text/css" href="estilos/estilo.css">

	<script type="text/javascript">
		$(document).ready(function(){

			//quando for criar o usuario bloquear ter apenas um digito de usuario ou senha, e não permitir nome ser numero 0;

			$('#btn_login').click(function(){
				//colocar animação de tremer barra quando usuario sem preencher

				let campo_vazio = false;
				let usuario = $('#id_campo_usuario').val();				
				let senha = $('#id_campo_senha').val();

				if(usuario == '' || usuario == false){

					$('#id_campo_usuario').css({'border-color':'#a94442','box-shadow':'2px 1px red'});
					campo_vazio = true;
				}else{
					$('#id_campo_usuario').css({'border-color':'#ccc','box-shadow':'none'});
				}

				if(senha == ''){
					$('#id_campo_senha').css({'border-color':'#a94442','box-shadow':'2px 1px red'});
					campo_vazio = true;
				}else{
					$('#id_campo_senha').css({'border-color':'#ccc','box-shadow':'none'});
				}
				if(campo_vazio){
					return false;
				}
			});

			$('.input_acao_btn').keypress(function(){
				let verifica_campo_senha = $('#id_campo_senha').val();
				let verifica_campo_login = $('#id_campo_usuario').val();

				if(verifica_campo_senha && verifica_campo_login){
					$('#btn_login').removeClass('d-none');
					$('#btn_login').addClass('d-block');
				}else{
					$('#btn_login').removeClass('d-block');
					$('#btn_login').addClass('d-none');
				}
			});
		});
	</script>
</head>

<body id="main">
	<div class="container">
		<div class="row d-flex justify-content-center align-items-center">
			<div class="col red">
				<div id="login" class="d-flex align-items-center justify-content-center">
					<form method="post" action="validar_acesso.php">
						
						<input id="id_campo_usuario" class="form-control input_acao_btn" type="text" name="usuario" placeholder="Nome de usuário">
						
						<input id="id_campo_senha" class="form-control input_acao_btn" type="password" name="password" placeholder="Digite a senha">
						<?php $erroGet = isset($_GET['erro'])?$_GET['erro']:false;
							switch($erroGet){
								case 1:
									echo '<p style="color:red">Usuario ou senha incorretos</p>';
									break;
							}
						 ?>
						 <!-- Estilizar botão de pressionar -->
						<button id="btn_login" type="buttom" class="btn btn-primary d-none">Entrar</button>
					</form>
				</div>
			</div>
		</div>
	</div>	
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>