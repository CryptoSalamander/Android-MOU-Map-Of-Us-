<?php
	$smokeID = $_GET[smokeID];
	$url = $_GET[url];
	echo exec("php /diy/smoke_send.php?smokeID='$smokeID'&url='$url'");
?>
<!--
<meta htt-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
	<body>
	<form action="smoke_send.php" method="GET">
		<input type = text name = smokeID value=<?=$smokeID?>>
		<input type = text name = url value=<?=$url?>>
	</form>
	</body>
</html>
-->



