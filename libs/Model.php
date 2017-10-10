<?php
class Model{
	protected $connect;
	protected $database;
	protected $table;
	protected $resultQuery;
	
	function __construct($params = NULL){
		if($params == NULL){
			$params['server']	= DB_HOST;
			$params['username']	= DB_USER;
			$params['password']	= DB_PASS;
			$params['database']	= DB_NAME;
			$params['table']	= DB_TABLE;
		}
		$link = mysql_connect($params['server'], $params['username'], $params['password']);

		if(!$link){
			die('Fail connect: '.mysql_errno());
		}else{
			$this->connect 	= $link;
			$this->database = $params['database'];
			$this->table 	= $params['table'];
			$this->setDatabase();
			$this->query("SET NAMES 'utf8'");
			$this->query("SET CHARACTER SET 'utf8'");
		}
	}
	
	function setConnect($connect){
		$this->connect = $connect;
	}
	
	function setDatabase($database = NULL){
		if($database != NULL) {
			$this->database = $database;
		}
		mysql_select_db($this->database, $this->connect );
	}
	
	function setTable($table){
		$this->table = $table;
	}
	
	function __destruct(){
		mysql_close($this->connect);
	}
	
	function insert($data, $type = 'single'){
		if($type == 'single'){
			$newQuery 	= $this->createInsertSQL($data);
			$query 		= "INSERT INTO `$this->table`(".$newQuery['cols'].") VALUES (".$newQuery['vals'].")";
			$this->query($query);
		}else{
			foreach($data as $value){
				$newQuery = $this->createInsertSQL($value);
				$query = "INSERT INTO `$this->table`(".$newQuery['cols'].") VALUES (".$newQuery['vals'].")";
				$this->query($query);
			}
		}
		return $this->lastID();
	}
	
	function createInsertSQL($data){
		$newQuery = array();
		if(!empty($data)){
			foreach($data as $key=> $value){
				$cols .= ", `$key`";
				$vals .= ", '$value'";
			}
		}
		$newQuery['cols'] = substr($cols, 2);
		$newQuery['vals'] = substr($vals, 2);
		return $newQuery;
	}
	
	function lastID(){
		return mysql_insert_id($this->connect);
	}
	
	function query($query){
		$this->resultQuery = mysql_query($query, $this->connect);
		return $this->resultQuery;
	}
	
	// UPDATE
	function update($data, $where){
		$newSet 	= $this->createUpdateSQL($data);
		$newWhere 	= $this->createWhereUpdateSQL($where);
		$query = "UPDATE `$this->table` SET ".$newSet." WHERE $newWhere";
		$this->query($query);
		return $this->affectedRows();
	}
	
	// CREATE UPDATE SQL
	function createUpdateSQL($data){
		$newQuery = "";
		if(!empty($data)){
			foreach($data as $key => $value){
				$newQuery .= ", `$key` = '$value'";
			}
		}
		$newQuery = substr($newQuery, 2);
		return $newQuery;
	}
	
	// CREATE WHERE UPDATE SQL
	function createWhereUpdateSQL($data){
		$newWhere = '';
		if(!empty($data)){
			foreach($data as $value){
				$newWhere[] = "`$value[0]` = '$value[1]'";
				$newWhere[] = $value[2];
			}
			$newWhere = implode(" ", $newWhere);
		}
		return $newWhere;
	}
	
	// AFFECTED ROWS
	function affectedRows(){
		return mysql_affected_rows($this->connect);
	}
	
	// DELETE
	function delete($where){
		$newWhere 	= $this->createWhereDeleteSQL($where);
		$query 		= "DELETE FROM `$this->table` WHERE `id` IN ($newWhere)";
		$this->query($query);
		return $this->affectedRows();
	}
	
	function createWhereDeleteSQL($data){
		$newWhere = '';
		if(!empty($data)){
			foreach($data as $id) {
				$newWhere .= "'".$id."', ";
			}
			$newWhere .= "'0'";
		}
		return $newWhere;
	}
	
	// LIST RECORD
	function listRecord($query){
		$result = array();
		if(!empty($query)){
			$resultQuery = $this->query($query);
			if(mysql_num_rows($resultQuery) > 0){
				while($row = mysql_fetch_assoc($resultQuery)){
					$result[] = $row;
				}
				mysql_free_result($resultQuery);
			}
		}
		return $result;
	}
	
	// LIST RECORD
	function createSelectbox($query, $name, $keySelected = NULL, $class = NULL){
		if(empty($query)){ 
			return;
		}

		$resultQuery = $this->query($query);
		if(mysql_num_rows($resultQuery) == 0){
			return;
		}

		$xhtml = '<select class="'.$class.'" name="'.$name.'">';
		$xhtml .= '<option value="0">Select a value</option>';
		while($row = mysql_fetch_assoc($resultQuery)){
			if($keySelected == $row['id'] && $keySelected != NULL){
				$xhtml .= '<option value="'.$row['id'].'" selected="true">'.$row['name'].'</option>';
			}else{
				$xhtml .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
		}
		$xhtml .= '</select>';
		mysql_free_result($resultQuery);
		return $xhtml;
	}
	
	function singleRecord($query){
		if(empty($query)){
			return;
		}

		$resultQuery = $this->query($query);
		$result = array();
		if(mysql_num_rows($resultQuery) > 0){
			$result = mysql_fetch_assoc($resultQuery);
		}
		mysql_free_result($resultQuery);
		return $result;
	}
	
	function isExist($query){
		if($query != NULL) {
			$this->resultQuery = $this->query($query);
		}
		if(mysql_num_rows($this->resultQuery) > 0) return true;
		return false;
	}
}