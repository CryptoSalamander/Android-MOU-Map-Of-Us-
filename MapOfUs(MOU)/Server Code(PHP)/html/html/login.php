<?php


$connect = mysqli_connect("localhost", "root", "gkgustn32","people") or die("MYSQL Server 연결에 실패했습니다");

$json_obj = json_decode(file_get_contents("php://input"));

$id = $json_obj->ID;
$pw = $json_obj->PW;

$query = "insert into test values('$id','$pw')";

mysqli_query($connect, $query);

$query = "select id from account_info where id='$id' and pwd='$pw'";

$result = mysqli_query($connect, $query);

$count = mysqli_num_rows($result);

if($count >= 1){
	http_response_code(200);
}
else{
	http_response_code(204);
}

mysqli_close($connect);

?>
