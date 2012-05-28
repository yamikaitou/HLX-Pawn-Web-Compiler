<?php

function style_top($title)
{
?>
<html>
<head>
<title>HLx Pawn Web Compiler</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="bluebliss.css" />
</head>
<body>
<div id="mainContentArea">
<div id="contentBox">
<div id="title"></div>

<div id="linkGroup">
<div class="link"><a href="index.php">Home</a></div>
<div class="link"><a href="amxmodx.php">AMXModX</a></div>
<div class="link"><a href="sourcemod.php">SourceMod</a></div>
<div class="link"><a href="stats.php">Stats</a></div>
</div>

<div id="blueBox"> 
<div id="header"></div>
<div class="contentTitle"><?php echo $title; ?></div>
<br/>
<div class="pageContent">
<?php
}

function style_bot()
{
?>
</div>
<br/>
<div id="footer">design by <a href="http://www.bryantsmith.com">bryant smith</a> | script by <a href="https://github.com/yamikaitou/HLX-Pawn-Web-Compiler">ryan leblanc</a> </div>
</div>
</div>
</div>
</body>
</html>
<?php
}


?>