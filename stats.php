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
<div class="contentTitle">Compiler Stats</div>
<div class="pageContent">
<?php

$sql = sqlite_open("configs/data");
$amxx_results = sqlite_query($sql, "SELECT * FROM amxxversions");
$amxx = sqlite_fetch_all($amxx_results);
$sm_results = sqlite_query($sql, "SELECT * FROM smversions");
$sm = sqlite_fetch_all($sm_results);
$stats_results = sqlite_query($sql, "SELECT * FROM stats");
$stats = sqlite_fetch_all($stats_results, SQLITE_ASSOC);

for ($count = 0; $count < count($stats); $count++)
{
    if ($stats[$count]['Program'] == "amxx")
    {
        $compiledamxx += $stats[$count]['Success'];
        $failedamxx += $stats[$count]['Fail'];
    }
    else if ($stats[$count]['Program'] == "sm")
    {
        $compiledsm += $stats[$count]['Success'];
        $failedsm += $stats[$count]['Fail'];
    }
}




?>
<table>
<tr><th colspan="3">AMXModX Stats</th></tr>
<tr><th>Version</th><th>Success</th><th>Failed</th></tr>
<?php

for ($count = 0; $count < count($stats); $count++)
{
    if ($stats[$count]['Program'] == "amxx")
        echo "<tr><td>".sqlite_fetch_single(sqlite_query($sql, "SELECT Name FROM amxxversions WHERE Folder = '{$stats[$count]['Folder']}'"))."</td><td align=\"right\">".$stats[$count]['Success']."</td><td align=\"right\">".$stats[$count]['Fail']."</td></tr>";
}

?>
<tr><td>Total</td><td align="right"><?php echo $compiledamxx; ?></td><td align="right"><?php echo $failedamxx; ?></td></tr>
</table>
<br>
<table>
<tr><th colspan="3">Sourcemod Stats</th></tr>
<tr><th>Version</th><th>Success</th><th>Failed</th></tr>
<?php

for ($count = 0; $count < count($stats); $count++)
{
    if ($stats[$count]['Program'] == "sm")
        echo "<tr><td>".sqlite_fetch_single(sqlite_query($sql, "SELECT Name FROM smversions WHERE Folder = '{$stats[$count]['Folder']}'"))."</td><td align=\"right\">".$stats[$count]['Success']."</td><td align=\"right\">".$stats[$count]['Fail']."</td></tr>";
}

?>
<tr><td>Total</td><td align="right"><?php echo $compiledsm; ?></td><td align="right"><?php echo $failedsm; ?></td></tr>
</table>
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