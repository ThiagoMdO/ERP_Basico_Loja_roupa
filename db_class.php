<?php 

	class db{
		//host
		private $host = 'localhost';
		
		//usuario	
		private $user = 'root';

		//senha
		private $password = '';

		//banco de dados
		private $database = 'empresa_virtual';

		public function conecta_mysql(){
			//conexão
			$con = mysqli_connect($this->host,$this->user,$this->password,$this->database);

			//configuração de charset para utf8
			mysqli_set_charset($con,'utf8');

			//verificação de erro de comunicação do BD
			if(mysqli_connect_errno()){
				echo 'Erro ao tentar se conectar com o Bando de Dados mySQL';
				return false;
			}
			return $con;
		}
	}

?>