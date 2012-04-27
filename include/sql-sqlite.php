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
			$str .= ", $f $v";
		
		return $this->exec("CREATE TABLE $table (ID INTEGER PRIMARY KEY$str);");
	}
}

?>