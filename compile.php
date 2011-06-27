<?php

$sql = sqlite_open("configs/data");

$info_results = sqlite_query($sql, "SELECT * FROM info");
$info = sqlite_fetch_all($info_results);
$amxx_results = sqlite_query($sql, "SELECT * FROM amxxversions");
$amxx = sqlite_fetch_all($amxx_results);
$sm_results = sqlite_query($sql, "SELECT * FROM smversions");
$sm = sqlite_fetch_all($sm_results);
$stats_results = sqlite_query($sql, "SELECT * FROM stats");
$stats = sqlite_fetch_all($stats_results);

if (!isset($_GET['id']))
	die ("Illegal attempt to access compiler");
else if (!is_numeric($_GET['id']))
	die ("Invalid File ID");

$id = $_GET['id'];

$compile_results = sqlite_query($sql, "SELECT * FROM compile WHERE ID = $id");
$compile = sqlite_fetch_array($compile_results);

if ($compile === FALSE)
    die ("File ID not found");

if ($compile['Program'] == 'amxx')
{
    $amxx_results = sqlite_query($sql, "SELECT * FROM amxxversions WHERE Folder = '".$compile['Version']."'");
    $amxx = sqlite_fetch_all($amxx_results);
    
    if (sqlite_num_rows($amxx_results) == 1)
        $folder = $compile['Version'];
    else
        $folder = ".";
    
    @mkdir($info[3]['Value']."/$id");
    $files = scandir($info[4]['Value']."/$id/");
    foreach ($files as $file)
        if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_FILENAME) == "sma")
        {
            touch($info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "Compiling ".$file."\n", FILE_APPEND);
            exec("cd ".$info[1]['Value']."/$folder; ./amxxpc \"".$info[4]['Value']."/$id/$file\" -o".$info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".amxx"." >> ".$info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "\n", FILE_APPEND);
        }
//    $fail = explode("\n", file_get_contents($info[3]['Value']."/$id/temp.txt"));
//	for ($k = 0; $k < sizeof($fail); $k++)
//		echo $fail[$k]."<br />";
}
else if ($compile['Program'] == 'sm')
{
    $sm_results = sqlite_query($sql, "SELECT * FROM smversions");
    $sm = sqlite_fetch_all($sm_results);
    
    if (sqlite_num_rows($sm_results) == 1)
        $folder = $compile['Version'];
    else
        $folder = ".";
    
    @mkdir($info[3]['Value']."/$id");
    $files = scandir($info[4]['Value']."/$id/");
    foreach ($files as $file)
        if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_FILENAME) == "sp")
        {
            touch($info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "Compiling ".$file."\n", FILE_APPEND);
            exec("cd ".$info[2]['Value']."/$folder; ./spcomp \"".$info[4]['Value']."/$id/$file\" -o".$info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".smx"." >> ".$info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt");
            file_put_contents($info[3]['Value']."/$id/".pathinfo($file, PATHINFO_FILENAME).".txt", "\n", FILE_APPEND);
        }
//    $fail = explode("\n", file_get_contents($info[3]['Value']."/$id/temp.txt"));
//	for ($k = 0; $k < sizeof($fail); $k++)
//		echo $fail[$k]."<br />";
}


?>