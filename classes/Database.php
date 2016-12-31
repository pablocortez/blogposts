<?php

class Database {
	private $host		= "localhost";
	private $user		= "root";
	private $password	= "root";
	private $db_name	= "myblog";

	private $dbh;
	private $statement;


	public function __construct() {
		// Set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;

		// Set Options
		$options = array (
			PDO::ATTR_PERSISTENT	=> true,
			PDO::ATTR_ERRMODE 		=> PDO::ERRMODE_EXCEPTION
		);

		// Create new PDO
		try {
			$this->dbh = new PDO($dsn, $this->user, $this->password, $options);
		} catch ( PDOException $e ) {
			echo $e -> getMessage();
		}


	}

	public function query( $query ) {
		$this->statement = $this->dbh->prepare($query);
	}

	public function bind( $param, $value, $type = null ) {
		if ( is_null($type) ) {
			switch(true) {
				case is_int( $value ):
					$type = PDO::PARAM_INT;
					break;
				case is_bool( $value ):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null( $value ):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}

		$this->statement->bindValue( $param, $value, $type);

	}

	public function execute() {
		return $this->statement->execute();
	}

	public function lastInsertId() {
		$this->dbh->lastInsertId();
	}

	public function resultset() {
		$this->execute();
		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}

}

?>
