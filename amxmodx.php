<?php

require_once("functions.php");

style_top("AMXX Compiler");

$amxx = $sql->fetchall("amxxversions", "ORDER BY `Display`");
$validated = TRUE;
$row = 0;

if (isset($_POST['compile']))
{
    if ($_FILES['file']['error'] == UPLOAD_ERR_OK)
    {
        if (!in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), array('sma', 'zip', 'gz')))
        {
            echo "<div class=\"error\">Unable to proceed, invalid file type</div>";
            $validated = FALSE;
        }
    }
    else if ($_FILES['file']['error'] == UPLOAD_ERR_NO_FILE)
    {
        if ($_POST['boxname'] == "")
        {
            echo "<div class=\"error\">Unable to proceed, Plugin File Name missing</div>";
            $validated = FALSE;
        }
        if ($_POST['boxcode'] == "")
        {
            echo "<div class=\"error\">Unable to proceed, Plugin Code missing</div>";
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
                echo "<div class=\"error\">Unable to proceed, File Size Limit Exceeded</div>";
                $validated = FALSE;
                break;
            }
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
            {
                echo "<div class=\"error\">Unable to proceed, Cannot write temporary file</div>";
                $validated = FALSE;
                break;
            }
            default:
            {
                echo "<div class=\"error\">Unable to proceed, Unknown File related error</div>";
                $validated = FALSE;
                break;
            }
        }
    }
    
    if ($_POST['ver'] != ".")
    {
        $count = 0;
        $temp = FALSE;
        while ($count < count($amxx) AND !$temp)
        {
            if ($amxx[$count]['ID'] == $_POST['ver'])
			{
				$row = $count;
                $temp = TRUE;
				break;
			}
        }
        
        if (!$temp)
        {
            echo "<div class=\"error\">Unable to proceed, Compiler Version missing</div>";
            $validated = FALSE;
        }
    }
}
else
	$validated = FALSE;

if ($validated)
{
    $rand = sprintf("%09d", mt_rand(1, 99999999));
    mkdir($general['temp']."/$rand");
    
    if ($_POST['boxcode'] != "")
    {
        file_put_contents($general['temp']."/$rand/".$_POST['boxname'].".sma", stripslashes($_POST['boxcode']));
    }
    else
    {
        switch (pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION))
        {
            case "sma":
            {
                move_uploaded_file($_FILES['file']['tmp_name'], $general['temp']."/$rand/".$_FILES['file']['name']);
                break;
            }
            case "zip":
            {
                $zip = new ZipArchive;
                $res = $zip->open($_FILES['file']['tmp_name']);
                if ($res === TRUE)
                {
                    $zip->extractTo($general['temp']."/$rand");
                    $zip->close();
                }
                break;
            }
            case "gz":
            {
                move_uploaded_file($_FILES['file']['tmp_name'], $general['temp']."/$rand/".$_FILES['file']['name']);
                exec("cd {$general['temp']}/$rand; tar xvfz ".$_FILES['file']['name']);
                unlink($general['temp']."/$rand/".$_FILES['file']['name']);
                break;
            }
        }
        
        
        
    }
    
    
    $sql->insert("compile", array("ID" => "$rand", "Program" => "amxx", "VerID" => "{$_POST['ver']}"));
    
    $curl = curl_init("http://".$_SERVER["SERVER_NAME"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME)."compile.php?id=$rand");
    curl_exec($curl);
    curl_close($curl);
    
    if (count(scandir($general['compiled']."/$rand"))&1)
    {
		$sql->update("amxxversions", $_POST['ver'], array("Failure" => $amxx[$row]['Failure']+1));
        echo "Compile failed. See the compiler output below.<br><br>";
    }
    else
    {
        $sql->update("amxxversions", $_POST['ver'], array("Success" => $amxx[$row]['Success']+1));
?>
Use the link below to download your plugin. It will expire after 1 hour<br>
<a href="http://<?php echo $_SERVER["SERVER_NAME"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME); ?>download.php?id=<?php echo $rand; ?>">http://<?php echo $_SERVER["SERVER_NAME"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME); ?>download.php?id=<?php echo $rand; ?></a><br>
<br>
The compiler's output is shown below for reference.<br>
<br>
<?

    }
    
    $files = scandir($general['compiled']."/$rand");
    foreach ($files as $object)
    {
        if ($object != "." && $object != "..")
        {
            if (pathinfo($general['compiled']."/$rand/".$object, PATHINFO_EXTENSION) == "txt")
            {
                $fail = explode("\n", file_get_contents($general['compiled']."/$rand/$object"));
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
            $versions .= "<option value=\"{$amxx[$count]['ID']}\" selected>{$amxx[$count]['Name']}";
        else if ($amxx[$count]['Name'] == "")
            break;
        else
            $versions .= "<option value=\"{$amxx[$count]['ID']}\">{$amxx[$count]['Name']}";
        
        $count++;
    }
    
    $versions .= "</select>";

?>
<form method="post" enctype="multipart/form-data" action="amxmodx.php">
You can use this to compile plugins online.<br>
Once you upload a file, you will receive the compiler output and a link to the compiled plugin.<br>
<a href="https://github.com/yamikaitou/HLX-Pawn-Web-Compiler/wiki/Upload-Guide">Guide to understanding the Upload System</a><br>
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
<?php

style_bot();

?>