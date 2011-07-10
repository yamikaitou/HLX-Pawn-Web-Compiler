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
<div class="link"><a href="sourcemod.php">SourceMod</a></div>
<div class="link"><a href="stats.php">Stats</a></div>
</div>

<div id="blueBox"> 
<div id="header"></div>
<div class="contentTitle">SourceMod Compiler</div>
<div class="pageContent">
<?php

$sql = sqlite_open("configs/data");

$info_results = sqlite_query($sql, "SELECT * FROM info");
$info = sqlite_fetch_all($info_results);
$sm_results = sqlite_query($sql, "SELECT * FROM smversions ORDER BY Display");
$sm = sqlite_fetch_all($sm_results);

if (isset($_POST['compile']))
{
    $validated = TRUE;
    if ($_FILES['file']['error'] == UPLOAD_ERR_OK)
    {
        if (!in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), array('sp', 'zip', 'gz')))
        {
            echo "<div class=\"alerterror\">Unable to proceed, invalid file type</div>";
            $validated = FALSE;
        }
    }
    else if ($_FILES['file']['error'] == UPLOAD_ERR_NO_FILE)
    {
        if ($_POST['boxname'] == "")
        {
            echo "<div class=\"alerterror\">Unable to proceed, Plugin File Name missing</div>";
            $validated = FALSE;
        }
        if ($_POST['boxcode'] == "")
        {
            echo "<div class=\"alerterror\">Unable to proceed, Plugin Code missing</div>";
            $validated = FALSE;
        }
    }
    else
    {
        switch ($_FILES['file']['error'])
        {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
            {
                echo "<div class=\"alerterror\">Unable to proceed, File Size Limit Exceeded</div>";
                $validated = FALSE;
                break;
            }
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
            {
                echo "<div class=\"alerterror\">Unable to proceed, Cannot write temporary file</div>";
                $validated = FALSE;
                break;
            }
            default:
            {
                echo "<div class=\"alerterror\">Unable to proceed, Unknown File related error</div>";
                $validated = FALSE;
                break;
            }
        }
    }
    
    if ($_POST['ver'] != ".")
    {
        $count = 0;
        $temp = FALSE;
        while ($count < count($sm) AND !$temp)
        {
            if ($sm[$count]['Folder'] == $_POST['ver'])
                $temp = TRUE;
        }
        
        if (!$temp)
        {
            echo "<div class=\"alerterror\">Unable to proceed, Compiler Version missing</div>";
            $validated = FALSE;
        }
    }
}

if ($validated)
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
        file_put_contents($info[4]['Value']."/$rand/".$_POST['boxname'].".sp", stripslashes($_POST['boxcode']));
    }
    else
    {
        switch (pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION))
        {
            case "sp":
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
    
    
    
    sqlite_exec($sql, "INSERT INTO compile VALUES('$rand', 'sm', '{$_POST['ver']}', '".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)."');");

    $curl = curl_init("http://".$_SERVER["SERVER_NAME"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME)."/compile.php?id=$rand");
    curl_exec($curl);
    curl_close($curl);
    
    if (count(scandir($info[3]['Value']."/$rand"))&1)
    {
        sqlite_exec($sql, "UPDATE stats SET Fail = Fail + 1 WHERE Program = 'sm' AND Folder = '{$_POST['ver']}'");
        echo "Compile failed. See the compiler output below.<br><br>";
    }
    else
    {
        sqlite_exec($sql, "UPDATE stats SET Success = Success + 1 WHERE Program = 'sm' AND Folder = '{$_POST['ver']}'");
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
    
    while ($count < count($sm))
    {
        if ($sm[$count]['Name'] == "" AND $count == 0)
            $versions .= "<option value=\".\" selected>N/A";
        else if ($count == 0)
            $versions .= "<option value=\"{$sm[$count]['Folder']}\" selected>{$sm[$count]['Name']}";
        else if ($sm[$count]['Name'] == "")
            break;
        else
            $versions .= "<option value=\"{$sm[$count]['Folder']}\">{$sm[$count]['Name']}";
        
        $count++;
    }
    
    $versions .= "</select>";
    
?>
<form method="post" enctype="multipart/form-data" action="sourcemod.php">
You can use this to compile plugins online.<br>
Once you upload a file, you will receive the compiler output and a link to the compiled plugin.<br>
<a href="https://github.com/yamikaitou/Supercentral-Compiler/wiki/Upload-Guide">Guide to understanding the Upload System</a><br>
<br>
Select the Compiler Version: <?php echo $versions; ?><br>
<br>
Select a file to upload (*.sp, *.zip, *.tar.gz ONLY):<br>
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