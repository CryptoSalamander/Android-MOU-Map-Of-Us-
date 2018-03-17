<?php

$connect = mysqli_connect('localhost', 'root', 'gkgustn32', 'DIY') or die('MYSQL Server 연결에 실패했습니다');

$input = json_decode(file_get_contents("php://input"));

$name=$input->space_name;
$ashtray = $input->ashtray;
$booth=$input->booth;
$longitude=$input->longitude;
$latitude=$input->latitude;
$img=$input->image;

$longitude = round($longitude, 4); // 소수점을 줄임으로써 비슷한 위치의 좌표가 있으면 해당 좌표에 등록
$latitude = round($latitude, 4);



$query = "select smokeID from DIY_smoke where latitude = '$latitude' and longitude = '$longitude';";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

if($row[0] >= 1)
	$query = "update DIY_smoke set ashtray = $ashtray, booth = $booth where smokeID=$row[0];";
else
	$query = "insert into DIY_smoke values ('', '$longitude','$latitude','$name','$ashtray','$booth');";
	
mysqli_query($connect, $query);


$query = "select smokeID from DIY_smoke where latitude = '$latitude' and longitude = '$longitude';";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
$smokeID = $row[0]; //안드로이드에 smokeID를 보내주기 위해 변수로 설정

//그림 등록 후 URL 받아오기
$client_id="f84056b2097514c";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $img);
$out = curl_exec($curl);
curl_close ($curl);
$pms = json_decode($out,true);
$url=$pms['data']['link'];
if($url!=""){
	$query = "insert into DIY_smoke_url values ('$row[0]', '$url');";
	mysqli_query($connect, $query);
	mysqli_close($connect);
	

}else{
	echo "<h2>There's a Problem</h2>";
	echo $pms['data']['error'];  
}

http_response_code(200);
?>

<meta htt-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
	<body>
	<form action="smoke_send.php" method="post">
		<input type = text name = smokeID value=<?=$row[0]?>>
		<input type = text name = url value=<?=$url?>>
	</form>
	</body>
</html>

<?php
mysqli_close($connect);

?>


