<?php

class Project {
	// database connection and table name
	private $conn;
	private $table_name = "projects";

	// object properties
	public $id;
	public $name;
	public $description;
	public $created;
	public $user_id;
	public $user_name;
	public $user;

	public $search;

	// constructor with $db as database connection
	public function __construct( $db ) {
		$this->conn = $db;
	}

	// create article
	function create() {
		// query to insert record
		$query = "INSERT INTO " . $this->table_name . " (name, description, fk_user_id) 
					VALUES (:name, :description, :user_id)";

		// prepare query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->name        = htmlspecialchars( strip_tags( $this->name ) );
		$this->description = htmlspecialchars( strip_tags( $this->description ) );
		$this->user_id     = htmlspecialchars( strip_tags( $this->user_id ) );

		// bind values
		$stmt->bindParam( ":name", $this->name, PDO::PARAM_STR );
		$stmt->bindParam( ":description", $this->description, PDO::PARAM_STR );
		$stmt->bindParam( ":user_id", $this->user_id, PDO::PARAM_INT );

		// execute query
		if ( $stmt->execute() ) {
			return true;
		}

		return false;

	}

	// read articles
	function read() {
		// select all query
		$query = "SELECT p.id as project_id, p.name as project, p.description, u.username as username, u.name as user_name, p.fk_user_id as user_id
				FROM " . $this->table_name . " p
				INNER JOIN users u ON u.id = p.fk_user_id";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// search articles
	function search( $keywords ) {

		// select all query
		$query = "SELECT p.id as project_id, p.name as project, p.description, u.username as username, u.name as user_name, p.fk_user_id as user_id
				FROM " . $this->table_name . " p
				INNER JOIN users u ON u.id = p.fk_user_id
				WHERE p.name LIKE ? OR p.description LIKE ? OR u.username LIKE ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$keywords = htmlspecialchars( strip_tags( $keywords ) );
		$keywords = "%{$keywords}%";

		// bind
		$stmt->bindParam( 1, $keywords );
		$stmt->bindParam( 2, $keywords );
		$stmt->bindParam( 3, $keywords );

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// read one article
	function readOne() {
		// update query
		$query = "SELECT p.id as project_id, p.name as project, p.description, u.username as username, u.name as user_name, p.fk_user_id as user_id
				FROM " . $this->table_name . " p
				INNER JOIN users u ON u.id = p.fk_user_id
				WHERE p.id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		$this->id = htmlspecialchars( strip_tags( $this->id ) );

		// bind values
		$stmt->bindParam( 1, $this->id );

		// execute query
		$stmt->execute();

		// get retrieved row
		$row = $stmt->fetch( PDO::FETCH_ASSOC );

		// set values to object properties
		$this->id          = $row['article_id'];
		$this->name        = $row['article'];
		$this->description = $row['description'];
		$this->username    = $row['username'];
		$this->user_name   = $row['user_name'];
		$this->user_id     = $row['user_id'];

		return $stmt;
	}

	// search articles
	function readPaging( $from_record_num, $records_per_page ) {

		// select all query
		$query = "SELECT p.id as project_id, p.name as project, p.description, u.username as username, u.name as user_name, projects.fk_user_id as user_id
				FROM " . $this->table_name . " p
				INNER JOIN users u ON u.id = p.fk_user_id
				LIMIT ?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind
		$stmt->bindParam( 1, $from_record_num );
		$stmt->bindParam( 2, $records_per_page );

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// update articles
	function update() {
		// select all query
		$query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE ID = :id";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id          = htmlspecialchars( strip_tags( $this->id ) );
		$this->name        = htmlspecialchars( strip_tags( $this->name ) );
		$this->description = htmlspecialchars( strip_tags( $this->description ) );

		// bind values
		$stmt->bindParam( ":id", $this->id, PDO::PARAM_INT );
		$stmt->bindParam( ":name", $this->name, PDO::PARAM_STR );
		$stmt->bindParam( ":description", $this->description, PDO::PARAM_STR );

		// execute the query
		if ( $stmt->execute() ) {
			return true;
		}

		return false;
	}

	// delete article
	function delete() {
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

		// prepare query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id = htmlspecialchars( strip_tags( $this->id ) );

		// bind id of record to delete
		$stmt->bindParam( ":id", $this->id, PDO::PARAM_INT );

		// execute query
		if ( $stmt->execute() ) {
			return true;
		}

		return false;
	}

	// delete article
	function count() {
		// delete query
		$query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;

		// prepare query
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		$row = $stmt->fetch( PDO::FETCH_ASSOC );

		return $row["total_rows"];
	}
}