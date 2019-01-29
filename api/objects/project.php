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
		if ( $stmt->execute() )
		{
			return true;
		}

		return false;

	}

	// read articles
	function read() {
		// select all query
		$query = "SELECT a.id as article_id, a.name as article, a.tray_number, a.barcode, a.on_loan, a.quantity, a.fk_category_id as category_id, c.name as category
				FROM " . $this->table_name . " a
				INNER JOIN categories c ON c.id = a.fk_category_id";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// search articles
	function search( $keywords ) {

		// select all query
		$query = "SELECT a.id as article_id, a.name as article, a.tray_number, a.barcode, a.on_loan, a.quantity, a.fk_category_id as category_id, c.name as category
				FROM " . $this->table_name . " a
				INNER JOIN categories c ON c.id = a.fk_category_id
				WHERE a.name LIKE ? OR a.barcode LIKE ? OR a.tray_number LIKE ? OR c.name LIKE ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$keywords = htmlspecialchars( strip_tags( $keywords ) );
		$keywords = "%{$keywords}%";

		// bind
		$stmt->bindParam( 1, $keywords );
		$stmt->bindParam( 2, $keywords );
		$stmt->bindParam( 3, $keywords );
		$stmt->bindParam( 4, $keywords );

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// read one article
	function readOne() {
		// update query
		$query = "SELECT a.id as article_id, a.name as article, a.tray_number, a.barcode, a.on_loan, a.quantity, a.fk_category_id as category_id, c.name as category
				FROM " . $this->table_name . " a
				INNER JOIN categories c ON c.id = a.fk_category_id
				WHERE barcode = :barcode";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		$this->barcode = htmlspecialchars( strip_tags( $this->barcode ) );

		// bind values
		$stmt->bindParam( ":barcode", $this->barcode, PDO::PARAM_STR );

		// execute query
		$stmt->execute();

		// get retrieved row
		$row = $stmt->fetch( PDO::FETCH_ASSOC );

		// set values to object properties
		$this->id          = $row['article_id'];
		$this->name        = $row['article'];
		$this->tray_number = $row['tray_number'];
		$this->barcode     = $row['barcode'];
		$this->on_loan     = $row['on_loan'];
		$this->quantity    = $row['quantity'];
		$this->category_id = $row['category_id'];
		$this->category    = $row['category'];

		return $stmt;
	}

	// search articles
	function readPaging( $from_record_num, $records_per_page ) {

		// select all query
		$query = "SELECT a.id as article_id, a.name as article, a.tray_number, a.barcode, a.on_loan, a.quantity, a.fk_category_id as category_id, c.name as category
				FROM " . $this->table_name . " a
				INNER JOIN categories c ON c.id = a.fk_category_id
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
		$query = "UPDATE " . $this->table_name .
		         " SET name = :name, tray_number = :tray_number, barcode = :barcode, quantity = :quantity, fk_category_id = :category_id WHERE ID = :id";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id          = htmlspecialchars( strip_tags( $this->id ) );
		$this->name        = htmlspecialchars( strip_tags( $this->name ) );
		$this->tray_number = htmlspecialchars( strip_tags( $this->tray_number ) );
		$this->barcode     = htmlspecialchars( strip_tags( $this->barcode ) );
		$this->on_loan     = htmlspecialchars( strip_tags( $this->on_loan ) );
		$this->quantity    = htmlspecialchars( strip_tags( $this->quantity ) );
		$this->category_id = htmlspecialchars( strip_tags( $this->category_id ) );

		// bind values
		$stmt->bindParam( ":id", $this->id, PDO::PARAM_INT );
		$stmt->bindParam( ":name", $this->name, PDO::PARAM_STR );
		$stmt->bindParam( ":tray_number", $this->tray_number, PDO::PARAM_INT );
		$stmt->bindParam( ":barcode", $this->barcode, PDO::PARAM_STR );
		$stmt->bindParam( ":quantity", $this->quantity, PDO::PARAM_INT );
		$stmt->bindParam( ":category_id", $this->category_id, PDO::PARAM_INT );

		// execute the query
		if ( $stmt->execute() )
		{
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
		if ( $stmt->execute() )
		{
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