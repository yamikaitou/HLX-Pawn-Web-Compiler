<?php

require_once("functions.php");

style_top("Compiler Stats");

_sql_init();

$amxx = $sql->fetchall("amxxversions");
$sm = $sql->fetchall("smversions");

$successamxx = $failureamxx = $successsm = $failuresm = 0;

for ($count = 0; $count < count($amxx); $count++)
{
    $successamxx += $amxx[$count]['Success'];
	$failureamxx += $amxx[$count]['Failure'];
}

for ($count = 0; $count < count($sm); $count++)
{
    $successsm += $sm[$count]['Success'];
	$failuresm += $sm[$count]['Failure'];
}



?>
<table>
<tr><th colspan="3">AMXModX Stats</th></tr>
<tr><th>Version</th><th>Success</th><th>Failed</th></tr>
<?php

for ($count = 0; $count < count($amxx); $count++)
{
    echo "<tr><td>".$amxx[$count]['Name']."</td><td align=\"right\">".$amxx[$count]['Success']."</td><td align=\"right\">".$amxx[$count]['Failure']."</td></tr>";
}

?>
<tr><td>Total</td><td align="right"><?php echo $successamxx; ?></td><td align="right"><?php echo $failureamxx; ?></td></tr>
</table>
<br>
<table>
<tr><th colspan="3">Sourcemod Stats</th></tr>
<tr><th>Version</th><th>Success</th><th>Failed</th></tr>
<?php

for ($count = 0; $count < count($sm); $count++)
{
    echo "<tr><td>".$sm[$count]['Name']."</td><td align=\"right\">".$sm[$count]['Success']."</td><td align=\"right\">".$sm[$count]['Failure']."</td></tr>";
}

?>
<tr><td>Total</td><td align="right"><?php echo $successsm; ?></td><td align="right"><?php echo $failuresm; ?></td></tr>
</table>
<br>
<?php

style_bot();

?>