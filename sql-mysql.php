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
	
	function create($table, $args, $auto)
	{
		$str = "";
		
		foreach ($args as $f => $v)
			$str .= "`$f` $v NOT NULL, ";
		
		$str = rtrim($str, ", ");
		
		$str = str_replace(array("INTEGER", "TEXT"), array("int(9)", "varchar(20)"), $str);
		
		if ($auto)
			return $this->query("CREATE TABLE `{$this->prefix}$table` (`ID` smallint(2) NOT NULL AUTO_INCREMENT, $str, PRIMARY KEY (`ID`)) AUTO_INCREMENT=1;");
		else
			return $this->query("CREATE TABLE `{$this->prefix}$table` ($str);");
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
		
		return $this->query("INSERT INTO `{$this->prefix}$table` ($fields) VALUES ($values);");
	}
	
	function fetch($table, $value)
	{
		$result = $this->query("SELECT * FROM `{$this->prefix}$table` WHERE `ID` = $value;");
		
		return $result->fetch_array(MYSQLI_ASSOC);
	}
	
	function fetchall($table, $opts = "")
	{
		$result = $this->query("SELECT * FROM `{$this->prefix}$table`  $opts;");
		
		$row = array();
		$i = 0;
		
		while ($res = $result->fetch_array(MYSQLI_ASSOC))
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