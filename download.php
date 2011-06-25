<?php

$sql = sqlite_open("configs/data");
$info_results = sqlite_query($sql, "SELECT * FROM info");
$info = sqlite_fetch_all($info_results);

if (!isset($_GET['id']))
	die ("Illegal attempt to access downloader");
else if (!is_numeric($_GET['id']))
	die ("Invalid File ID");

$id = $_GET['id'];

$compile_results = sqlite_query($sql, "SELECT * FROM compile WHERE ID = $id");
$compile = sqlite_fetch_array($compile_results);

if ($compile === FALSE)
    die ("File ID not found or has expired");

$files = scandir($info[3]['Value']."/$id");

if (count($files) == 4)
{
    $file = $files[2];
}


$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
    $browser_agent = 'opera';
else if (ereg('MSIE ([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
    $browser_agent = 'ie';
else 
    $browser_agent = 'other';
$mimetype = ($browser_agent == 'ie' || $browser_agent == 'opera') ? 'application/octetstream' : 'application/octet-stream';
@ob_end_clean();
@ini_set('zlib.output_compression', 'Off');
header("Pragma: public");
header("Content-Transfer-Encoding: none");
header("Content-Type: $mimetype; name=\"$file\"");
header("Content-Disposition: inline; filename=\"$file\"");
$size = @filesize($info[3]['Value']."/$id/$file");
if ($size)
    header("Content-length: $size");
readfile($info[3]['Value']."/$id/$file");


sqlite_close($sql);

?>