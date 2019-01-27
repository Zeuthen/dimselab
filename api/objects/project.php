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
	public $user;

	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
}