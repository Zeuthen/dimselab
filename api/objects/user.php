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

	public $article;
	public $user;
	public $project;

	// constructor with $db as database connection
	public function __construct( $db ) {
		$this->conn = $db;
	}

	// login
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
			$this->id   = $row['id'];
			$this->name = $row['name'];

			return true;
		}

		return false;
	}

	// loan
	function loan() {
		// select all query
		$query = "INSERT INTO statistics (fk_article_id, fk_user_id, fk_project_id)
					VALUES ((SELECT ID FROM articles WHERE barcode = :barcode LIMIT 1), :user, :project)";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->article    = htmlspecialchars( strip_tags( $this->article ) );
		$this->user = htmlspecialchars( strip_tags( $this->user ) );
		$this->project   = htmlspecialchars( strip_tags( $this->project ) );

		// bind values
		$stmt->bindParam( ":barcode", $this->article, PDO::PARAM_INT );
		$stmt->bindParam( ":user", $this->user, PDO::PARAM_INT );
		$stmt->bindParam( ":project", $this->project, PDO::PARAM_INT );

		// execute the query
		if ( $stmt->execute() )
		{
			return true;
		}

		return false;
	}


}