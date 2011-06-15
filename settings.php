<html>
<head>
<title>Compiler Settings</title>
<script language="javascript">

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
    
    // Delete cell
    var cellDelete = row.insertCell(2);
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
<?php

$sql = sqlite_open("configs/data");

$key = sqlite_query($sql, "SELECT * FROM info");
$info = sqlite_fetch_all($key);

if ($_GET['key'] != $info[0]['Value'])
{
    echo "Hacking attempt detected, halting....";
    exit();
}

?>
View/Alter various System Settings below<br/>
<br/>
<table>
<tr><td>Change the Key:</td><td><input type="password" name="key" /></td></tr>
</table>
<br/><br/>
<table>
<tr><th colspan="2">Path Settings</th></tr>
<tr><td>AMXx Compiler:</td><td><input type="text" name="compamxx" value="<?php echo $info[1]['Value']; ?>" /></td></tr>
<tr><td>SM Compiler:</td><td><input type="text" name="compsm" value="<?php echo $info[2]['Value']; ?>" /></td></tr>
<tr><td>Compiled Files:</td><td><input type="text" name="compfiles" value="<?php echo $info[3]['Value']; ?>" /></td></tr>
<tr><td>Temp Upload:</td><td><input type="text" name="tempupload" value="<?php echo $info[4]['Value']; ?>" /></td></tr>
<tr><td>vBulletin Uploads:</td><td><input type="text" name="vbupload" value="<?php echo $info[5]['Value']; ?>" /></td></tr>
<tr><td>IPB Uploads:</td><td><input type="text" name="ipbupload" value="<?php echo $info[6]['Value']; ?>" /></td></tr>
</table>
<br/><br/>
<table id="amxx">
<tr><th colspan="3">AMXx Compiler Versions</th></tr>
<tr><td>Version</td><td>Folder</td><td></td></tr>
<tr><td><input type="text" name="amxxver[]" id="amxxver1" /></td><td><input type="text" name="amxxfold[]" id="amxxfold1" /></td><td><input type="button" value="Remove" id="amxxdel1" onclick="removeRowFromTable('amxx', 1);" /></td></tr>
</table>
<input type="button" value="Add" onclick="addRowToTable('amxx');" />
<br/><br/>
<table id="sm">
<tr><th colspan="3">SM Compiler Versions</th></tr>
<tr><td>Version</td><td>Folder</td><td></td></tr>
<tr><td><input type="text" name="smver[]" id="smver1" /></td><td><input type="text" name="smfold[]" id="smfold1" /></td><td><input type="button" value="Remove" id="smdel1" onclick="removeRowFromTable('sm', 1);" /></td></tr>
</table>
<input type="button" value="Add" onclick="addRowToTable('sm');" />
</body>
</html>
<?php

sqlite_close($sql);

?>