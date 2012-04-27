<?php

class DB_MySQL extends mysqli
{
	private $prefix;
	
	function __construct($host, $user, $pass, $db, $prefix)
	{
		parent::__construct($host, $user, $pass, $db);
		
		if ($this->connect_error)
			die("Connection Error: ".$this->connect_error);
		
		$this->prefix = $prefix;
	}
	
	function create($table, $args)
	{
		$str = "";
		
		foreach ($args as $f => $v)
			$str .= "$f $v, ";
		
		rtrim($str, ", ");
		
		return $this->exec("CREATE TABLE $prefix$table (ID INTEGER PRIMARY KEY, $str);");
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
		
		rtrim($fields, ", ");
		rtrim($values, ", ");
		
		return $this->exec("INSERT INTO $prefix$table ($fields) VALUES ($values);");
	}
	
}

?>