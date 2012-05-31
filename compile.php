<?php

if (!isset($_GET['id']))
	die ("Illegal attempt to access compiler");
else if (!is_numeric($_GET['id']))
	die ("Invalid File ID");

require_once("functions.php");

$id = $_GET['id'];

$compile = $sql->fetch("compile", $id);
$version = $sql->fetch($compile['Program']."versions", $compile['VerID']);

if ($compile === FALSE OR $compile === NULL)
    die ("File ID not found");

if ($compile['Program'] == 'amxx')
{
    if (count($version) == 7)
        $folder = $version['Folder'];
    else
        $folder = ".";
    
    @mkdir($general['compiled']."/$id");
    $files = scandir($general['temp']."/$id/");
    foreach ($files as $file)
        if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) == "sma")
        {
            touch($general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "Compiling ".$file."\n", FILE_APPEND);
			exec("cd ".$general['amxxcomp']."/$folder; ./amxxpc \"".$general['temp']."/$id/$file\" -o".$general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".amxx"." >> ".$general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "\n", FILE_APPEND);
        }
}
else if ($compile['Program'] == 'sm')
{
    if (count($version) == 7)
        $folder = $version['Folder'];
    else
        $folder = ".";
    
    @mkdir($general['compiled']."/$id");
    $files = scandir($general['temp']."/$id/");
    foreach ($files as $file)
        if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) == "sp")
        {
            touch($general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "Compiling ".$file."\n", FILE_APPEND);
            exec("cd ".$general['smcomp']."/$folder; ./spcomp \"".$general['temp']."/$id/$file\" -o".$general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".smx"." >> ".$general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($general['compiled']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "\n", FILE_APPEND);
        }
}

?>