<?php

/* General Settings */
// Web Settings Key
//   The key used to access the additional settings from the web
//   Does not grant access to any of the settings found in this file
$general['key'] = "NHzwGmAggt3e";
// AMXModX Compiler Location
//    Location where all the usable compilers are stored, must be absolute path
$general['amxxcomp'] = "/home/user/compilers/amxx";
// SourceMod Compiler Location
//   Location where all the usable compilers are stored, must be absolute path
$general['smcomp'] = "/home/user/compilers/sm";
// Compiled Files Path
//   Location where to store the compiled files
$general['compiled'] = "/home/user/compilers/compiled";
// Temp Upload Path
//   Location where to store the uploaded files temporarly
$general['temp'] = "/home/user/compilers/temp";
// vBulletin Upload Path
//   Location where the vBulletin Uploads are stored, optional
$general['vbupload'] = "";
// IPB Upload Path
//   Location where the IPB Uploads are stored, optional
$general['ipbupload'] = "";
// The Database type.
//  sqlite = Uses SQLite. This is the default, database is stored locally, no username/password required
//	mysql = Uses MySQL. Use either a local or remote MySQL server.
//	dynamodb = Uses Amazon AWS DynamoDB. You must already have an Amazon AWS account, you are responsible for all charges
$db_type = "sqlite";


/* SQLite Settings */
// The location of where to save the SQLite database. If location doesn't exist, it will be created.
$sqlite['db'] = "configs/data";


/* MySQL Settings */
// Database Server
$mysql['server'] = "localhost";
// Username
$mysql['user'] = "root";
// Password
$mysql['pass'] = "";
// Database
$mysql['db'] = "compiler";
// Table Prefix
$mysql['prefix'] = "";


/* Amazon DynamoDB Settings 
	Caution: You are responsible for any and all charges you incur by using this method.
	The tables are required to be unique, recommend setting a prefix and/or suffix or using the random feature */
// Access Key ID
$dynamodb['access'] = "accessid";
// Secret Access Key
$dynamodb['secret'] = "secretid";
// Availability Zone
//	Values: us-east-1, ap-northeast-1, eu-west-1
$dynamodb['zone'] = "us-east-1";
// Table Prefix
$dynamodb['prefix'] = "";
// Table Suffix
$dynamodb['suffix'] = "";
// Table Prefix/Suffix Randomizer
//  Bit Value, add the ones you want
//    0 = No Randomizer
//    1 = Randomize Prefix
//    2 = Randomize Suffix
$dynamodb['fixrandom'] = 0;
// Randomizer Length
//   The number of characters to use for the above randomizer
$dynamodb['randomlen'] = 0;

?>