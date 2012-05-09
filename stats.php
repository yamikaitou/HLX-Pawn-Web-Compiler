<?php

require_once("functions.php");

style_top("Compiler Stats");

_sql_init();

$amxx = $sql->fetchall("amxxversions");
$sm = $sql->fetchall("smversions");

echo "<pre>";
var_dump($amxx);
var_dump($sm);
echo "</pre>";


/*
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
*/
?>