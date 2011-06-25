<html>
<head>
<title>SuperCentral - Compiler</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="bluebliss.css" />
<script language="javascript" type="text/javascript">

function addRowToTable(comp)
{
    var tbl = document.getElementById(comp);
    var lastRow = tbl.rows.length;
    // if there's no header row in the table, then iteration = lastRow + 1
    var iteration = lastRow-1;
    var row = tbl.insertRow(lastRow);
    
    // Version cell
    var cellVersion = row.insertCell(0);
    var version = document.createElement('input');
    version.type = 'text';
    version.name = comp + 'ver[]';
    version.id = comp + 'ver' + iteration;
    cellVersion.appendChild(version);
    
    // Folder cell
    var cellFolder = row.insertCell(1);
    var folder = document.createElement('input');
    folder.type = 'text';
    folder.name = comp + 'fold[]';
    folder.id = comp + 'fold' + iteration;
    cellFolder.appendChild(folder);
    
    // Order cell
    var cellOrder = row.insertCell(2);
    var order = document.createElement('input');
    order.type = 'text';
    order.name = comp + 'order[]';
    order.id = comp + 'order' + iteration;
    cellOrder.appendChild(order);
    
    // Delete cell
    var cellDelete = row.insertCell(3);
    var del = document.createElement('input');
    del.type = 'button';
    del.id = comp + 'del' + iteration;
    del.value = 'Remove';
    del.onclick = function() {removeRowFromTable(comp, iteration);};
    cellDelete.appendChild(del);
}
function removeRowFromTable(comp, id)
{
    var tbl = document.getElementById(comp);
    if (tbl.rows.length > 3) tbl.deleteRow(id+1);
}
</script>
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
<div class="contentTitle">System Settings</div>
<div class="pageContent">
<?php

$sql = sqlite_open("configs/data");

$info_results = sqlite_query($sql, "SELECT * FROM info");
$info = sqlite_fetch_all($info_results);
$amxx_results = sqlite_query($sql, "SELECT * FROM amxxversions");
$amxx = sqlite_fetch_all($amxx_results);
$sm_results = sqlite_query($sql, "SELECT * FROM smversions");
$sm = sqlite_fetch_all($sm_results);

if ($_GET['key'] != $info[0]['Value'])
{
    echo "Hacking attempt detected";
    exit();
}

if (isset($_POST['submit']))
{
    if ($info[1]['Value'] != $_POST['compamxx'])
        sqlite_exec($sql, "UPDATE info SET Value = '{$_POST['compamxx']}' WHERE ID = 2");
    if ($info[2]['Value'] != $_POST['compsm'])
        sqlite_exec($sql, "UPDATE info SET Value = '{$_POST['compsm']}' WHERE ID = 3");
    if ($info[3]['Value'] != $_POST['compfiles'])
        sqlite_exec($sql, "UPDATE info SET Value = '{$_POST['compfiles']}' WHERE ID = 4");
    if ($info[4]['Value'] != $_POST['tempupload'])
        sqlite_exec($sql, "UPDATE info SET Value = '{$_POST['tempupload']}' WHERE ID = 5");
    if ($info[5]['Value'] != $_POST['vbupload'])
        sqlite_exec($sql, "UPDATE info SET Value = '{$_POST['vbupload']}' WHERE ID = 6");
    if ($info[6]['Value'] != $_POST['ipbupload'])
        sqlite_exec($sql, "UPDATE info SET Value = '{$_POST['ipbupload']}' WHERE ID = 7");
    
    sqlite_exec($sql, "DELETE FROM amxxversions");
    $count = 0;
    while ($count < count($_POST['amxxver']))
        sqlite_exec($sql, "INSERT INTO amxxversions VALUES (NULL, '". $_POST['amxxver'][$count] ."', '". $_POST['amxxfold'][$count] ."', '". $_POST['amxxorder'][$count++] ."')");
    
    sqlite_exec($sql, "DELETE FROM smversions");
    $count = 0;
    while ($count < count($_POST['smver']))
        sqlite_exec($sql, "INSERT INTO smversions VALUES (NULL, '". $_POST['smver'][$count] ."', '". $_POST['smfold'][$count] ."', '". $_POST['smorder'][$count++] ."')");
    
    
    $amxx_results = sqlite_query($sql, "SELECT * FROM amxxversions");
    $amxx = sqlite_fetch_all($amxx_results);
    $sm_results = sqlite_query($sql, "SELECT * FROM smversions");
    $sm = sqlite_fetch_all($sm_results);
    
    
    echo "Settings have been updated.<br><br>";
    
    
    if ($_POST['key'] != NULL AND $_POST['key'] != "" AND $info[0]['Value'] != $_POST['key'])
    {
        sqlite_exec($sql, "UPDATE info SET Value = '{$_POST['key']}' WHERE ID = 1");
        echo "Key has been updated, please reload the page with the correct key";
        exit();
    }
    
    $info_results = sqlite_query($sql, "SELECT * FROM info");
    $info = sqlite_fetch_all($info_results);
}

?>
<form method="post" action="settings.php?key=<?php echo $info[0]['Value']; ?>">
<table>
<tr><td>Change the Key:</td><td><input type="password" name="key"></td></tr>
</table>
<br><br>
<table>
<tr><th colspan="2">Path Settings</th></tr>
<tr><td>AMXx Compiler:</td><td><input type="text" name="compamxx" value="<?php echo $info[1]['Value']; ?>"></td></tr>
<tr><td>SM Compiler:</td><td><input type="text" name="compsm" value="<?php echo $info[2]['Value']; ?>"></td></tr>
<tr><td>Compiled Files:</td><td><input type="text" name="compfiles" value="<?php echo $info[3]['Value']; ?>"></td></tr>
<tr><td>Temp Upload:</td><td><input type="text" name="tempupload" value="<?php echo $info[4]['Value']; ?>"></td></tr>
<tr><td>vBulletin Uploads:</td><td><input type="text" name="vbupload" value="<?php echo $info[5]['Value']; ?>"></td></tr>
<tr><td>IPB Uploads:</td><td><input type="text" name="ipbupload" value="<?php echo $info[6]['Value']; ?>"></td></tr>
</table>
<br><br>
<table id="amxx">
<tr><th colspan="4">AMXx Compiler Versions</th></tr>
<tr><td>Version</td><td>Folder</td><td>Order</td><td></td></tr>
<?php

for ($k = 0; $k < count($amxx); $k++)
{
    echo "<tr><td><input type=\"text\" name=\"amxxver[]\" id=\"amxxver1\" value=\"{$amxx[$k]['Name']}\"></td><td><input type=\"text\" name=\"amxxfold[]\" id=\"amxxfold1\" value=\"{$amxx[$k]['Folder']}\"></td><td><input type=\"text\" name=\"amxxorder[]\" id=\"amxxorder1\" value=\"{$amxx[$k]['Display']}\"></td><td><input type=\"button\" value=\"Remove\" id=\"amxxdel1\" onclick=\"removeRowFromTable('amxx', 1);\"></td></tr>";
}

?>
</table>
<input type="button" value="Add" onclick="addRowToTable('amxx');">
<br><br>
<table id="sm">
<tr><th colspan="4">SM Compiler Versions</th></tr>
<tr><td>Version</td><td>Folder</td><td>Order</td><td></td></tr>
<?php

for ($k = 0; $k < count($sm); $k++)
{
    echo "<tr><td><input type=\"text\" name=\"smver[]\" id=\"smver1\" value=\"{$sm[$k]['Name']}\"></td><td><input type=\"text\" name=\"smfold[]\" id=\"smfold1\" value=\"{$sm[$k]['Folder']}\"></td><td><input type=\"text\" name=\"smorder[]\" id=\"smorder1\" value=\"{$sm[$k]['Display']}\"></td><td><input type=\"button\" value=\"Remove\" id=\"smdel1\" onclick=\"removeRowFromTable('sm', 1);\"></td></tr>";
}

?>
</table>
<input type="button" value="Add" onclick="addRowToTable('sm');">
<br><br><br>
<input type="submit" name="submit" value="Submit">
</form>
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