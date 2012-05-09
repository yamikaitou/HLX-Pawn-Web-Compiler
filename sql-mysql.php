<?php

class DB_MySQL extends mysqli
{
	private $prefix;
	
	function __construct($host, $user, $pass, $db, $tprefix)
	{
		parent::__construct($host, $user, $pass, $db);
		
		if ($this->connect_error)
			die("Connection Error: ".$this->connect_error);
		
		$this->prefix = $tprefix;
	}
	
	function create($table, $args)
	{
		$str = "";
		
		foreach ($args as $f => $v)
			$str .= "`$f` $v NOT NULL, ";
		
		$str = rtrim($str, ", ");
		
		$str = str_replace(array("INTEGER", "TEXT"), array("int(6)", "varchar(20)"), $str);
		
		return $this->query("CREATE TABLE `$prefix$table` (`ID` smallint(2) NOT NULL AUTO_INCREMENT, $str, PRIMARY KEY (`ID`)) AUTO_INCREMENT=1;");
	}
	
	function insert($table, $args)
	{
		$fields = "";
		$values = "";
		
		foreach ($args as $f => $v)
		{
			$fields .= "`$f`, ";
			$values .= "'$v', ";
		}
		
		$fields = rtrim($fields, ", ");
		$values = rtrim($values, ", ");
		
		return $this->query("INSERT INTO `$prefix$table` ($fields) VALUES ($values);");
	}
	
	function fetchall($table)
	{
		$result = $this->query("SELECT * FROM `$prefix$table`;");
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
}

?>