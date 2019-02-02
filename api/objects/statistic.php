<?php
/**
 * Created by PhpStorm.
 * User: brorm
 * Date: 28/01/2019
 * Time: 01:51
 */

class Statistic {
// database connection and table name
	private $conn;
	private $table_name = "statistics";

	// object properties
	public $id;
	public $article_id;
	public $article;
	public $user_id;
	public $user;
	public $project_id;
	public $project;
	public $date;

	// constructor with $db as database connection
	public function __construct( $db ) {
		$this->conn = $db;
	}

	// read statistics
	function read() {
		// select all query
		$query = "SELECT a.name as article, a.barcode, u.name as user, p.name as project, s.created
				FROM " . $this->table_name . " s
				INNER JOIN articles a ON a.id = s.fk_article_id
				INNER JOIN users u ON u.id = s.fk_user_id
				INNER JOIN projects p ON p.id = s.fk_project_id";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// search statistics
	function search( $keywords ) {

		// select all query
		$query = "SELECT a.name as article, a.barcode, u.name as user, p.name as project, s.created
				FROM " . $this->table_name . " s
				INNER JOIN articles a ON a.id = s.fk_article_id
				INNER JOIN users u ON u.id = s.fk_user_id
				INNER JOIN projects p ON p.id = s.fk_project_id
				WHERE a.name LIKE ? OR a.barcode LIKE ? OR u.name LIKE ? OR p.name LIKE ?
				ORDER BY s.created DESC";

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


}