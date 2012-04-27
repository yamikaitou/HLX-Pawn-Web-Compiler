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
			$str .= ", $f $v";
		
		return $this->exec("CREATE TABLE $prefix$table (ID INTEGER PRIMARY KEY$str);");
	}
}

?>