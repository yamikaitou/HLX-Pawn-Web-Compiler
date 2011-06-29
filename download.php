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

foreach ($files as $object)
{
    if ($object != "." && $object != "..")
    {
        if (pathinfo($info[3]['Value']."/$id/".$object, PATHINFO_EXTENSION) == "amxx" OR pathinfo($info[3]['Value']."/$id/".$object, PATHINFO_EXTENSION) == "smx")
        {
            $file[] = $object;
        }
    }
}

if (count($file) == 1)
{
    $filename = $file[0];
}
else
{
    switch ($compile['Type'])
    {
        case "zip":
        {
            $count = 0;
            $zip = new ZipArchive;
            $res = $zip->open($info[3]['Value']."/$id/$id.zip", ZIPARCHIVE::OVERWRITE);
            if ($res === TRUE)
            {
                while (count($file) > $count)
                    $zip->addFile($info[3]['Value']."/$id/".$file[$count], $file[$count++]);
                
                $zip->close();
            }
            
            $filename = "$id.zip";
            break;
        }
        case "gz":
        {
            $count = 0;
            $filelist = "";
            while (count($file) > $count)
                $filelist .= $file[$count++]." ";
            
            exec("cd {$info[3]['Value']}/$id; tar cvzf $id.tar.gz $filelist");
            $filename = "$id.tar.gz";
            break;
        }
    }
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
header("Content-Type: $mimetype; name=\"$filename\"");
header("Content-Disposition: inline; filename=\"$filename\"");
$size = @filesize($info[3]['Value']."/$id/$filename");
if ($size)
    header("Content-length: $size");
readfile($info[3]['Value']."/$id/$filename");


sqlite_close($sql);

?>