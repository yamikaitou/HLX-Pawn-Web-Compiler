<?php

$sql = sqlite_open("configs/data");

sqlite_exec($sql, "CREATE TABLE versions (ID INTEGER PRIMARY KEY, Name TEXT, Folder TEXT, Program TEXT)");
sqlite_exec($sql, "CREATE TABLE info (ID INTEGER PRIMARY KEY, Name TEXT, Value TEXT);");
sqlite_exec($sql, "INSERT INTO info VALUES(1, 'Key', 'NHzwGmAggt3e');");
sqlite_exec($sql, "INSERT INTO info VALUES(2, 'AMXXComp', '.');");
sqlite_exec($sql, "INSERT INTO info VALUES(3, 'SMComp', '.');");
sqlite_exec($sql, "INSERT INTO info VALUES(4, 'Compiled', '.');");
sqlite_exec($sql, "INSERT INTO info VALUES(5, 'TempUpload', '.');");
sqlite_exec($sql, "INSERT INTO info VALUES(6, 'vBUpload', '.');");
sqlite_exec($sql, "INSERT INTO info VALUES(7, 'IPBUpload', '.');");

sqlite_close($sql);

?>