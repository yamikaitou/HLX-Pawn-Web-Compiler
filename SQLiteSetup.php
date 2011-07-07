<?php

if (!file_exists("configs"))
    mkdir("configs", 0775);

if (!file_exists("configs/data"))
{
    $sql = sqlite_open("configs/data");
    sqlite_exec($sql, "CREATE TABLE amxxversions (ID INTEGER PRIMARY KEY, Name TEXT, Folder TEXT, Display INTEGER, Active INTEGER)");
    sqlite_exec($sql, "CREATE TABLE smversions (ID INTEGER PRIMARY KEY, Name TEXT, Folder TEXT, Display INTEGER, Active INTEGER)");
    sqlite_exec($sql, "CREATE TABLE info (ID INTEGER PRIMARY KEY, Name TEXT, Value TEXT);");
    sqlite_exec($sql, "INSERT INTO info VALUES(1, 'Key', 'NHzwGmAggt3e');");
    sqlite_exec($sql, "INSERT INTO info VALUES(2, 'AMXXComp', '.');");
    sqlite_exec($sql, "INSERT INTO info VALUES(3, 'SMComp', '.');");
    sqlite_exec($sql, "INSERT INTO info VALUES(4, 'Compiled', '.');");
    sqlite_exec($sql, "INSERT INTO info VALUES(5, 'TempUpload', '.');");
    sqlite_exec($sql, "INSERT INTO info VALUES(6, 'vBUpload', '.');");
    sqlite_exec($sql, "INSERT INTO info VALUES(7, 'IPBUpload', '.');");
    sqlite_exec($sql, "CREATE TABLE compile (ID INTEGER, Program TEXT, Version TEXT, Type TEXT)");
    sqlite_exec($sql, "CREATE TABLE stats (ID INTEGER, Program TEXT, Folder TEXT, Success INTEGER, Fail INTEGER)");
    sqlite_close($sql);
    echo "Setup complete";
}
else
    echo "Database already exists, unable to run";

?>