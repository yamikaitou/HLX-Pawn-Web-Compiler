<?php

require_once("sql-sqlite.php");
require_once("sql-mysql.php");

global $sql;

function sql_install()
{
	global $sql;
	
	_sql_init();
	
	$sql->create("amxxversions", array('Name' => 'TEXT', 'Folder' => 'TEXT', 'Display' => 'INTEGER', 'Active' => 'INTEGER')) OR return FALSE;
	$sql->create("smversions", array('Name' => 'TEXT', 'Folder' => 'TEXT', 'Display' => 'INTEGER', 'Active' => 'INTEGER')) OR return FALSE;
	$sql->create("compile", array('Program' => 'TEXT', 'VerID' => 'TEXT')) OR return FALSE;
	$sql->create("stats", array('Program' => 'TEXT', 'VerID' => 'INTEGER', 'Success' => 'INTEGER', 'Failure' => 'INTEGER')) OR return FALSE;
	
	return TRUE;
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