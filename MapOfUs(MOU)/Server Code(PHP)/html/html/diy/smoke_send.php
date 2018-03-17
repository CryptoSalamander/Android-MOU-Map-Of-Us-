<?php

$array = array("smokeID" => urlencode($_GET[smokeID]), "url"=>urlencode($_GET[url]));

print_r(urldecode(json_encode($array)));

mysqli_close($connect);

?>
