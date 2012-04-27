<?php

class DB_SQLite extends SQLite3
{
	function __construct($database)
	{
		$this->open($database, SQLITE3_OPEN_READWRITE|SQLITE3_OPEN_CREATE);
	}
	
	function create($table, $args)
	{
		$str = "";
		
		foreach ($args as $f => $v)
			$str .= "$f $v, ";
		
		rtrim($str, ",");
		
		return $this->exec("CREATE TABLE $table (ID INTEGER PRIMARY KEY, $str);");
	}
	
	function insert($table, $args)
	{
		$fields = "";
		$values = "";
		
		foreach ($args as $f => $v)
		{
			$fields .= "$f, ";
			$values .= "'$v', ";
		}
		
		rtrim($fields, ",");
		rtrim($values, ",");
		
		return $this->exec("INSERT INTO $table ($fields) VALUES ($values);");
	}
}

?>