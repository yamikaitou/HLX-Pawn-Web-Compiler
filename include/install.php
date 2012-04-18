<?php

require_once("functions.php");
_init(TRUE);
require_once("sql.php");

style_top("Installation Process");

switch (@$_GET['s'])
{
	default:
	case 1:
	{
		echo "Displaying configuration details from the include/config.php file<br/>
		<br/>
		<br/>
		General Settings<br/>
		<br/>
		Web Settings Key: **masked**<br/>
		Database Type: ";
		switch ($db_type)
		{
			case "sqlite":
				echo "SQLite";
			case "mysql":
				echo "MySQL";
			case "dynamodb":
				echo "Amazon AWS DynamoDB";
			default:
				echo "<span class=\"error\">Unknown Database Type, valid options are 'sqlite', 'mysql', or 'dynamodb'</span>";
		}
		
		echo "<br/>
		AMXModX Compiler Path: ";
		if (is_dir($general['amxxcomp']))
			echo $general['amxxcomp'];
		else
			echo $general['amxxcomp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		SourceMod Compiler Path: ";
		if (is_dir($general['smcomp']))
			echo $general['smcomp'];
		else
			echo $general['smcomp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		Compiled Files Storage Path: ";
		if (is_dir($general['compiled']))
			echo $general['compiled'];
		else
			echo $general['compiled']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		Temporary Compiler Files Path: ";
		if (is_dir($general['temp']))
			echo $general['temp'];
		else
			echo $general['temp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		vBulletin Upload Path (optional): ";
		if (is_dir($general['vbupload']))
			echo $general['vbupload'];
		else
			echo $general['vbupload']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		IPB Upload Path (optional): ";
		if (is_dir($general['ipbupload']))
			echo $general['ipbupload'];
		else
			echo $general['ipbupload']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		<br/>
		Database Settings<br/>
		<br/>
		";
		
		switch ($db_type)
		{
			case "sqlite":
			{
				echo "Using SQLite<br/>
				Database Location: {$sqlite['db']}<br/>";
			}
			case "mysql":
			{
				echo "Using MySQL<br/>
				Server: {$mysql['server']}<br/>
				Username: {$mysql['user']}<br/>
				Password: **masked**<br/>
				Database: {$mysql['db']}<br/>
				Table Prefix: {$mysql['prefix']}<br/>";
			}
			case "dynamodb":
			{
				echo "Using Amazon AWS DynamoDB<br/>
				Access Key ID: {$dynamodb['access']}<br/>
				Secret Access Key: **masked**<br/>
				Availability Zone: {$dynamodb['zone']}<br/>
				Table Prefix: {$dynamodb['prefix']}<br/>
				Table Suffix: {$dynamodb['suffix']}<br/>";
			}
			default:
				echo "<span class=\"error\">Unknown Database Type!!!</span><br/>";
		}
		
		echo "
		<br/>
		Passwords were masked for your protection. Please verify the settings above are correct.<br/>
		<br/>
		If all settings are correct, please click the button below<br/>
		<form action=\"install.php\" method=\"get\"><input type=\"hidden\" name=\"s\" value=\"1\"><input type=\"submit\" value=\"Proceed to Step 2\"></form><br/>";
		
	}

}

style_bot();

?>