<?php
	
	$connect = mysqli_connect("localhost", "root", "Jeong0908!", "usemap") or die("MYSQL Server 연결에 실패했습니다");

	$url = $_POST['url'];

	$query = "insert into public_url values ('0', '$url')";

	mysqli_query($connect, $query);

	mysqli_close($connect);

?>
