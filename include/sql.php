<?php

require_once("sql-sqlite.php");
require_once("sql-mysql.php");

global $sql;

function sql_install()
{
	global $sql;
	
	_sql_init();
	
	$sql->create("amxxversions", array('Name' => 'TEXT', 'Folder' => 'TEXT', 'Display' => 'INTEGER', 'Active' => 'INTEGER'));
	$sql->create("smversions", array('Name' => 'TEXT', 'Folder' => 'TEXT', 'Display' => 'INTEGER', 'Active' => 'INTEGER'));
	$sql->create("compile", array('Program' => 'TEXT', 'VerID' => 'TEXT'));
	$sql->create("stats", array('Program' => 'TEXT', 'VerID' => 'INTEGER', 'Success' => 'INTEGER', 'Failure' => 'INTEGER'));
	
}

function _sql_init()
{
	global $sqlite;
	global $mysql;
	global $db_type;
	global $sql;
	
	switch ($db_type)
	{
		case "sqlite":
		{
			$sql = new DB_SQLite3($sqlite['db']);
			
			break;
		}
		case "mysql":
		{
			$sql = new DB_MySQL($mysql['server'], $mysql['user'], $mysql['pass'], $mysql['db'], $mysql['prefix']);
			
			break;
		}
	}
}

?>