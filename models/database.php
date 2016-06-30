<?php

/**
* Database Class
*/

class Database
{
	public $_pdo;

	function __construct($dbhost, $dbname, $dbuser, $dbpass)
	{
		try
		{
			$this->_pdo = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
			$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) 
		{
			throw new Exception($e->getMessage());
		}
		
	}

	public function get($table, $conditions = "")
	{
		$sql = "SELECT * FROM " . $table;

		if (isset($conditions) && $conditions != null) 
		{
			$sql .= " WHERE " . $conditions;
		}

		$stmt = $this->_pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($table, $data, $token = null)
	{
		$keys = implode(", ", array_keys($data));
		$values = implode(", ", array_map(array($this, "checkType"), array_values($data)));

		if (isset($token) && $token != null) 
		{
			$keys .= ", contact_id";
			$values .= ", (SELECT id FROM contacts WHERE token='" . $token .	 "')";
		}

		$sql = "INSERT INTO " . $table . " ( " . $keys . " ) VALUES ( " . $values . " )";


		$stmt = $this->_pdo->prepare($sql);

		try {
			if ($stmt->execute()) 
			{
				return array("insert_status" => "ok");
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}	
	}

	public function update($table, $id, $data, $token)
	{
		$updates = array();
		foreach ($data as $key => $value) {
			if (!empty($value))
			{
				$updates[] = $key . "=" . $this->checkType($value);
			}
		}

		$sql = "UPDATE " . $table . " SET " . implode(", ", $updates) . " WHERE contact_id=(SELECT id FROM contacts WHERE token='" . $token . "') AND id=" . $id;

		$stmt = $this->_pdo->prepare($sql);

		try {
			if ($stmt->execute()) 
			{
				return array("update_status" => "ok");
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}	
	}

	public function delete($table, $id, $token)
	{
		$sql = "DELETE FROM " . $table . " WHERE id=" . $id . " AND contact_id=(SELECT id FROM contacts WHERE token='" . $token . "')";

		try {
			if ($this->_pdo->exec($sql)) 
			{
				return array("delete_status" => "ok");
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}	
	}

	static function checkType($data) {
		if (!is_numeric($data))
		{
			$data = "'" . $data . "'";
		}

		return $data;
	}
}