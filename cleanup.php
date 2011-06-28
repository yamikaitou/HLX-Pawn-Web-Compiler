<?php

function rrmdir($dir)
{
    if (is_dir($dir))
    {
        $objects = scandir($dir); 
        foreach ($objects as $object)
        {
            if ($object != "." && $object != "..")
            {
                if (filetype($dir."/".$object) == "dir")
                    rrmdir($dir."/".$object);
                else
                    unlink($dir."/".$object); 
            }
        }
    reset($objects); 
    rmdir($dir); 
   }
}

$sql = sqlite_open("configs/data");
$info_results = sqlite_query($sql, "SELECT * FROM info");
$info = sqlite_fetch_all($info_results);

$dirs = scandir($info[3]['Value']);
foreach ($dirs as $dir)
{
    if ($dir != "." && $dir != "..")
    {
        if (time()-filectime($info[3]['Value']."/$dir") > 3600) // 1 hour
        {
            rrmdir($info[3]['Value']."/$dir");
        }
    }
}

$dirs = scandir($info[4]['Value']);
foreach ($dirs as $dir)
{
    if ($dir != "." && $dir != "..")
    {
        if (time()-filectime($info[4]['Value']."/$dir") > 3600) // 1 hour
        {
            rrmdir($info[4]['Value']."/$dir");
        }
    }
}

$compile_results = sqlite_query($sql, "SELECT * FROM compile");
$compile = sqlite_fetch_all($compile_results);

foreach ($compile as $id)
{
    if (!is_dir($info[4]['Value']."/".$id['ID']))
    {
        sqlite_exec($sql, "DELETE FROM compile WHERE ID = ".$id['ID']);
    }
}

sqlite_close($sql);

?>