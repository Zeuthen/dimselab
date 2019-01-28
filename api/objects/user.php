<?php
/**
 * Created by PhpStorm.
 * User: brorm
 * Date: 28/01/2019
 * Time: 01:51
 */

class User {
// database connection and table name
	private $conn;
	private $table_name = "users";

	// object properties
	public $id;
	public $name;
	public $username;
	public $email;
	public $password;
	public $barcode;

	// constructor with $db as database connection
	public function __construct( $db ) {
		$this->conn = $db;
	}

	// read products
	function login() {
		// select all query
		$query = "SELECT id,name FROM " . $this->table_name . " WHERE email = :email AND password = :password LIMIT 1";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->email    = htmlspecialchars( strip_tags( $this->email ) );
		$this->password = htmlspecialchars( strip_tags( $this->password ) );

		// bind values
		$stmt->bindParam( ":email", $this->email, PDO::PARAM_STR );
		$stmt->bindParam( ":password", $this->password, PDO::PARAM_STR );

		// execute the query
		if ( $stmt->execute() )
		{
			// get retrieved row
			$row = $stmt->fetch( PDO::FETCH_ASSOC );

			// set values to object properties
			$this->id    = $row['id'];
			$this->name    = $row['name'];

			return true;
		}

		return false;
	}

}