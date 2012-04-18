<?php

require_once("functions.php");
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
		<b>General Settings</b><br/>
		<br/>
		Web Settings Key: <i>**masked**</i><br/>
		Database Type: ";
		switch ($db_type)
		{
			case "sqlite":
			{
				echo "<i>SQLite</i>";
				break;
			}
			case "mysql":
			{
				echo "<i>MySQL</i>";
				break;
			}
			case "dynamodb":
			{
				echo "<i>Amazon AWS DynamoDB</i>";
				break;
			}
			default:
				echo "<span class=\"error\">Unknown Database Type, valid options are 'sqlite', 'mysql', or 'dynamodb'</span>";
		}
		
		echo "<br/>
		AMXModX Compiler Path: <i>";
		if (is_dir($general['amxxcomp']))
			echo $general['amxxcomp'];
		else
			echo $general['amxxcomp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "</i><br/>
		SourceMod Compiler Path: <i>";
		if (is_dir($general['smcomp']))
			echo $general['smcomp'];
		else
			echo $general['smcomp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "</i><br/>
		Compiled Files Storage Path: <i>";
		if (is_dir($general['compiled']))
			echo $general['compiled'];
		else
			echo $general['compiled']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "</i><br/>
		Temporary Compiler Files Path: <i>";
		if (is_dir($general['temp']))
			echo $general['temp'];
		else
			echo $general['temp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "</i><br/>
		vBulletin Upload Path (optional): <i>";
		if (is_dir($general['vbupload']))
			echo $general['vbupload'];
		else
			echo $general['vbupload']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "</i><br/>
		IPB Upload Path (optional): <i>";
		if (is_dir($general['ipbupload']))
			echo $general['ipbupload'];
		else
			echo $general['ipbupload']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "</i><br/>
		<br/>
		<b>Database Settings</b><br/>
		<br/>
		";
		
		switch ($db_type)
		{
			case "sqlite":
			{
				echo "Using SQLite<br/>
				Database Location: <i>{$sqlite['db']}</i><br/>";
				break;
			}
			case "mysql":
			{
				echo "Using MySQL<br/>
				Server: <i>{$mysql['server']}</i><br/>
				Username: <i>{$mysql['user']}</i><br/>
				Password: <i>**masked**</i><br/>
				Database: <i>{$mysql['db']}</i><br/>
				Table Prefix: <i>{$mysql['prefix']}</i><br/>";
				break;
			}
			case "dynamodb":
			{
				echo "Using Amazon AWS DynamoDB<br/>
				Access Key ID: <i>{$dynamodb['access']}</i><br/>
				Secret Access Key: <i>**masked**</i><br/>
				Availability Zone: <i>{$dynamodb['zone']}</i><br/>
				Table Prefix: <i>{$dynamodb['prefix']}</i><br/>
				Table Suffix: <i>{$dynamodb['suffix']}</i><br/>";
				break;
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