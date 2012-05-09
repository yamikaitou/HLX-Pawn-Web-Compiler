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
		
		
		$str = rtrim($str, ", ");
		
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
		
		
		$fields = rtrim($fields, ", ");
		$values = rtrim($values, ", ");
		
		return $this->exec("INSERT INTO $table ($fields) VALUES ($values);");
	}
	
	function fetchall($table)
	{
		$result = $this->query("SELECT * FROM $table;");
		
		$row = array();
		$i = 0;
		
		while ($res = $result->fetchArray(SQLITE3_ASSOC))
		{
			if (!isset($res['ID'])) continue;
			
			foreach ($res as $key => $value)
			{
				$row[$i][$key] = $value;
			}
			
			$i++;
		}
		
		return $row;
	}
}

?>