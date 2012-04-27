<?php

$db_type = NULL;
$general = array('key'=>NULL, 'amxxcomp'=>NULL, 'smcomp'=>NULL, 'compiled'=>NULL, 'temp'=>NULL, 'vbupload'=>NULL, 'ipbupload'=>NULL);
$sqlite = array('db'=>NULL);
$mysql = array('server'=>NULL, 'user'=>NULL, 'pass'=>NULL, 'db'=>NULL, 'prefix'=>NULL);
$sql = NULL;

require_once("config.php");
require_once("template.php");
require_once("sql-sqlite.php");
require_once("sql-mysql.php");


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
			$sql = new DB_SQLite($sqlite['db']);
			
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