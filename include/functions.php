<?php

function _init($install=FALSE)
{
	$db_type = NULL;
	$general = array('key'=>NULL, 'amxxcomp'=>NULL, 'smcomp'=>NULL, 'compiled'=>NULL, 'temp'=>NULL, 'vbupload'=>NULL, 'ipbupload'=>NULL);
	$sqlite = array('db'=>NULL);
	$mysql = array('server'=>NULL, 'user'=>NULL, 'pass'=>NULL, 'db'=>NULL, 'prefix'=>NULL);
	$dynamodb = array('access'=>NULL, 'secret'=>NULL, 'zone'=>NULL, 'prefix'=>NULL, 'suffix'=>NULL);
	
	require_once("config.php");
	
	if ($install) break;
	
	require_once("sql.php");
	sql_init();
}


?>