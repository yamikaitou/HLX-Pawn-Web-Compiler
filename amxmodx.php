<html>
<head>
<title>SuperCentral - Compiler</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="bluebliss.css" />
</head>
<body>
<div id="mainContentArea">
<div id="contentBox">
<div id="title">SuperCentral Compiler</div>

<div id="linkGroup">
<div class="link"><a href="index.html">Home</a></div>
<div class="link"><a href="amxmodx.php">AMXModX</a></div>
<div class="link"><a href="index.html">SourceMod</a></div>
<div class="link"><a href="index.html">Stats</a></div>
</div>

<div id="blueBox"> 
<div id="header"></div>
<div class="contentTitle">AMXModX Compiler</div>
<div class="pageContent">
<?php

$sql = sqlite_open("configs/data");

$info_results = sqlite_query($sql, "SELECT * FROM info");
$info = sqlite_fetch_all($info_results);
$amxx_results = sqlite_query($sql, "SELECT * FROM amxxversions ORDER BY Display");
$amxx = sqlite_fetch_all($amxx_results);

if (isset($_POST['compile']))
{
    do
    {
        $rand = "";
        for ($k = 0; $k < 6; $k++)
            $rand .= mt_rand(1,9);
    }
    while (sqlite_num_rows(sqlite_query($sql, "SELECT * FROM compile WHERE ID = $rand")) > 0);
    mkdir($info[4]['Value']."/$rand");
    
    if ($_POST['boxcode'] != "")
    {
        file_put_contents($info[4]['Value']."/$rand/".$_POST['boxname'].".sma", stripslashes($_POST['boxcode']));
    }
    else
    {
        switch (pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION))
        {
            case "sma":
            {
                move_uploaded_file($_FILES['file']['tmp_name'], $info[4]['Value']."/$rand/".$_FILES['file']['name']);
                break;
            }
            case "zip":
            {
                $zip = new ZipArchive;
                $res = $zip->open($_FILES['file']['tmp_name']);
                if ($res === TRUE)
                {
                    $zip->extractTo($info[4]['Value']."/$rand");
                    $zip->close();
                }
                break;
            }
            case "gz":
            {
                move_uploaded_file($_FILES['file']['tmp_name'], $info[4]['Value']."/$rand/".$_FILES['file']['name']);
                exec("cd {$info[4]['Value']}/$rand; tar xvfz ".$_FILES['file']['name']);
                unlink($info[4]['Value']."/$rand/".$_FILES['file']['name']);
                break;
            }
        }
        
        
        
    }
    
    
    
    sqlite_exec($sql, "INSERT INTO compile VALUES('$rand', 'amxx', '{$_POST['ver']}', '".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)."');");

    $curl = curl_init("http://".$_SERVER["SERVER_NAME"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME)."/compile.php?id=$rand");
    curl_exec($curl);
    curl_close($curl);
    
    if (!count(scandir($info[4]['Value']."/$rand"))%2)
    {
        echo "Compile failed. See the compiler output below.<br><br>";
    }
    else
    {
?>
Use the link below to download your plugin. It will expire after 1 hour<br>
<a href="http://<?php echo $_SERVER["SERVER_NAME"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME); ?>/download.php?id=<?php echo $rand; ?>">http://<?php echo $_SERVER["SERVER_NAME"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME); ?>/download.php?id=<?php echo $rand; ?></a><br>
<br>
The compiler's output is shown below for reference.<br>
<br>
<?

    }
    
    $files = scandir($info[3]['Value']."/$rand");
    foreach ($files as $object)
    {
        if ($object != "." && $object != "..")
        {
            if (pathinfo($info[3]['Value']."/$rand/".$object, PATHINFO_EXTENSION) == "txt")
            {
                $fail = explode("\n", file_get_contents($info[3]['Value']."/$rand/$object"));
                for ($k = 0; $k < sizeof($fail); $k++)
                    echo $fail[$k]."<br>";
            }
        }
    }
}
else
{
    $versions = "<select name=\"ver\">";
    $count = 0;
    
    while ($count < count($amxx))
    {
        if ($amxx[$count]['Name'] == "" AND $count == 0)
            $versions .= "<option value=\".\" selected>N/A";
        else if ($count == 0)
            $versions .= "<option value=\"{$amxx[$count]['Folder']}\" selected>{$amxx[$count]['Name']}";
        else if ($amxx[$count]['Name'] == "")
            break;
        else
            $versions .= "<option value=\"{$amxx[$count]['Folder']}\">{$amxx[$count]['Name']}";
        
        $count++;
    }
    
    $versions .= "</select>";
    
?>
<form method="post" enctype="multipart/form-data" action="amxmodx.php">
You can use this to compile plugins online.<br>
Once you upload a file, you will receive the compiler output and a link to the compiled plugin.<br>
<br>
Select the Compiler Version: <?php echo $versions; ?><br>
<br>
Select a file to upload (*.sma, *.zip, *.tar.gz ONLY):<br>
<input type="file" name="file"><br>
<br>
Or, you can paste your plugin's source code in the box below.<br>
Plugin File Name: <input type="text" name="boxname"><br>
<textarea name="boxcode" rows="25" cols="70"></textarea><br>
<br>
<input type="submit" name="compile" value="Compile"><br>
</form>
<?php

}

?>
<br>
</div>
<div id="footer">design by <a href="http://www.bryantsmith.com">bryant smith</a> | script by <a href="https://github.com/yamikaitou/Supercentral-Compiler">ryan leblanc</a> </div>
</div>
</div>
</div>
</body>
</html>
<?php

sqlite_close($sql);

?>