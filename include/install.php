<?php

require_once("functions.php");
require_once("sql.php");

style_top("Installation Process");

switch (@$_GET['s'])
{
	default:
	case 1:
	{
		echo "Install - Step 1<br/>
		Displaying configuration details from the include/config.php file<br/>
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
			default:
				echo "<span class=\"error\">Unknown Database Type!!!</span><br/>";
		}
		
		echo "
		<br/>
		Passwords were masked for your protection. Please verify the settings above are correct.<br/>
		<br/>
		If all settings are correct, please click the button below<br/>
		<br/>
		<form action=\"install.php\" method=\"get\"><input type=\"hidden\" name=\"s\" value=\"2\"><input type=\"submit\" value=\"Proceed to Step 2\"></form><br/>";
		
		break;
	}
	case 2:
	{
		echo "Install - Step 2<br/>
		Validating settings.....<br/>
		<br/>";
		
		clearstatcache();
		$error = FALSE;
		$warning = FALSE;
		
		if (!is_dir($general['amxxcomp']))
		{
			$error = TRUE;
			echo "<span class=\"error\">Error: AMXModX Compiler Path not found!</span><br/>";
		}
		
		if (!is_dir($general['smcomp']))
		{
			$error = TRUE;
			echo "<span class=\"error\">Error: SourceMod Compiler Path not found!</span><br/>";
		}
		
		if (!is_dir($general['compiled']))
		{
			$error = TRUE;
			echo "<span class=\"error\">Error: Compiled Files Path not found!</span><br/>";
		}
		
		if (!is_writable($general['compiled']))
		{
			$error = TRUE;
			echo "<span class=\"error\">Error: Compiled Files Path is not writable!</span><br/>";
		}
		
		if (!is_dir($general['temp']))
		{
			$error = TRUE;
			echo "<span class=\"error\">Error: Temporary Files Path not found!</span><br/>";
		}
		
		if (!is_writable($general['temp']))
		{
			$error = TRUE;
			echo "<span class=\"error\">Error: Temporary Files Path is not writable!</span><br/>";
		}
		
		if (!is_dir($general['vbupload']))
		{
			$warning = TRUE;
			echo "<span class=\"error\">Warning: vBulletin Upload Path not found!</span><br/>";
		}
		
		if (!is_dir($general['ipbupload']))
		{
			$warning = TRUE;
			echo "<span class=\"error\">Warning: IPB Upload Path not found!</span><br/>";
		}
		
		echo "<br/>";
		
		switch ($db_type)
		{
			case "sqlite":
			{
				if (!extension_loaded("sqlite") AND !extension_loaded("sqlite3"))
				{
					$error = TRUE;
					echo "<span class=\"error\">Error: SQLite Extension is not loaded!</span><br/>";
				}
				
				if (file_exists($sqlite['db']))
				{
					$warning = TRUE;
					echo "<span class=\"error\">Warning: SQLite Database already exists!</span><br/>";
				}
				
				break;
			}
			case "mysql":
			{
				if (!extension_loaded("mysql") AND !extension_loaded("mysqli"))
				{
					$error = TRUE;
					echo "<span class=\"error\">Error: MySQL Extension is not loaded!</span><br/>";
				}
				
				if ($mysql['server'] == "" OR $mysql['user'] == "" OR $mysql['db'] == "")
				{
					$error = TRUE;
					echo "<span class=\"error\">Error: Some Required MySQL Settings are missing!</span><br/>";
				}
				
				if ($mysql['pass'] == "")
				{
					$warning = TRUE;
					echo "<span class=\"error\">Warning: MySQL Password is blank!</span><br/>";
				}
				
				break;
			}
			default:
			{
				$error = TRUE;
				echo "<span class=\"error\">Error: Database Type is not valid!</span><br/>";
				break;
			}
		}
		
		if ($warning)
		{
			echo "<br/>
			Warnings were displayed. While these are only warnings, please review them before continuing.<br/>";
		}
		
		if ($error)
		{
			echo "<br/>
			Errors were displayed. These must be corrected before proceeding.<br/>";
			break;
		}
		
		echo "All Good? Click the button to proceed to Step 3<br/>
		<form action=\"install.php\" method=\"get\"><input type=\"hidden\" name=\"s\" value=\"3\"><br/>
		<input type=\"submit\" value\"Proceed to Step 3\"></form><br/>";
		
		break;
	}
	case 3:
	{
	
	}
}

style_bot();

?>