<?php

$connect = mysqli_connect('localhost', 'root', 'gkgustn32', 'DIY') or die('MYSQL Server 연결에 실패했습니다');

$input = json_decode(file_get_contents("php://input"));

$name=$input->space_name;
$locked = $input->locked;
$agency=$input->agency;
$longitude=$input->longitude;
$latitude=$input->latitude;
$img=$input->image;

$longitude=round($longitude, 4);
$latitude = round($latitude, 4);

$query = "select wifiID from DIY_wifi where name = '$name';";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

if($row[0] >= 1)
	$query = "insert into DIY_wifi values ('$row[0]', '$name','$longitude','$latitude','$agency','$locked');";
else
	
	$query = "insert into DIY_wifi values ('', '$name','$longitude','$latitude','$agency','$locked');";

mysqli_query($connect, $query);

$query = "select wifiID from DIY_wifi where name = '$name';";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

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
	$query = "insert into DIY_wifi_url values ('$row[0]', '$url');";
	print_r($row[0]);
	mysqli_query($connect, $query);
	mysqli_close($connect);

}else{
	echo "<h2>There's a Problem</h2>";
	echo $pms['data']['error'];  
} 

?>


