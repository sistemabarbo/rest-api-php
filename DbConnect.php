<?php 
	/**
     * ARQUIVO DE CONEXAO COM O BANCO DE DADOS
	* Database Connection
	*/
	class DbConnect {
		private $server = 'database-1.cnkeccaesr5l.eu-north-1.rds.amazonaws.com';
		private $dbname = 'database';
		private $user = 'admin';
		private $pass = 'rKclhPUCyBAUyX4rvNeJ';

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch (\Exception $e) {
				echo "Database Error: " . $e->getMessage();
			}
		}
	}
 ?>
