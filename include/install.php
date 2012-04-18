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
		<i>Web Settings Key</i>: **masked**<br/>
		<i>Database Type</i>: ";
		switch ($db_type)
		{
			case "sqlite":
			{
				echo "SQLite";
				break;
			}
			case "mysql":
			{
				echo "MySQL";
				break;
			}
			case "dynamodb":
			{
				echo "Amazon AWS DynamoDB";
				break;
			}
			default:
				echo "<span class=\"error\">Unknown Database Type, valid options are 'sqlite', 'mysql', or 'dynamodb'</span>";
		}
		
		echo "<br/>
		<i>AMXModX Compiler Path</i>: ";
		if (is_dir($general['amxxcomp']))
			echo $general['amxxcomp'];
		else
			echo $general['amxxcomp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		<i>SourceMod Compiler Path</i>: ";
		if (is_dir($general['smcomp']))
			echo $general['smcomp'];
		else
			echo $general['smcomp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		<i>Compiled Files Storage Path</i>: ";
		if (is_dir($general['compiled']))
			echo $general['compiled'];
		else
			echo $general['compiled']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		<i>Temporary Compiler Files Path</i>: ";
		if (is_dir($general['temp']))
			echo $general['temp'];
		else
			echo $general['temp']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		<i>vBulletin Upload Path (optional)</i>: ";
		if (is_dir($general['vbupload']))
			echo $general['vbupload'];
		else
			echo $general['vbupload']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		<i>IPB Upload Path (optional)</i>: ";
		if (is_dir($general['ipbupload']))
			echo $general['ipbupload'];
		else
			echo $general['ipbupload']." <span class=\"error\">**DIR NOT FOUND**</span>";
		
		echo "<br/>
		<br/>
		<b>Database Settings</b><br/>
		<br/>
		";
		
		switch ($db_type)
		{
			case "sqlite":
			{
				echo "Using SQLite<br/>
				<i>Database Location</i>: {$sqlite['db']}<br/>";
				break;
			}
			case "mysql":
			{
				echo "Using MySQL<br/>
				<i>Server</i>: {$mysql['server']}<br/>
				<i>Username</i>: {$mysql['user']}<br/>
				<i>Password</i>: **masked**<br/>
				<i>Database</i>: {$mysql['db']}<br/>
				<i>Table Prefix</i>: {$mysql['prefix']}<br/>";
				break;
			}
			case "dynamodb":
			{
				echo "Using Amazon AWS DynamoDB<br/>
				<i>Access Key ID</i>: {$dynamodb['access']}<br/>
				<i>Secret Access Key</i>: **masked**<br/>
				<i>Availability Zone</i>: {$dynamodb['zone']}<br/>
				<i>Table Prefix</i>: {$dynamodb['prefix']}<br/>
				<i>Table Suffix</i>: {$dynamodb['suffix']}<br/>";
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