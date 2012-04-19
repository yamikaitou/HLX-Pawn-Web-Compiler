<?php

$db_type = NULL;
$general = array('key'=>NULL, 'amxxcomp'=>NULL, 'smcomp'=>NULL, 'compiled'=>NULL, 'temp'=>NULL, 'vbupload'=>NULL, 'ipbupload'=>NULL);
$sqlite = array('db'=>NULL);
$mysql = array('server'=>NULL, 'user'=>NULL, 'pass'=>NULL, 'db'=>NULL, 'prefix'=>NULL);
$dynamodb = array('sdk'=>NULL, 'zone'=>NULL, 'prefix'=>NULL, 'suffix'=>NULL);

require_once("config.php");
require_once("template.php");


function _init()
{
	require_once("sql.php");
	
}


?>